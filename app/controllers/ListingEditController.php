<?php
// /app/controllers/ListingEditController.php
require_once __DIR__ . '/../models/ListingModel.php';
require_once __DIR__ . '/../models/PhotoModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
class ListingEditController {
    private $listingModel;
    private $categoryModel;
    private $photoModel;
    private $db;
    public function __construct($db) {
        $this->db = $db;
        $this->listingModel = new ListingModel($db);
        $this->categoryModel = new CategoryModel($db);
        $this->photoModel = new PhotoModel($db);
    }

    public function editListing() {
        // Проверка прав администратора
        /*if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = 'Доступ запрещен';
            header('Location: index.php?page=admin_dashboard');
            exit;
        }*/

        $listingId = $_GET['id'] ?? null;
        
        if (!$listingId) {
            $_SESSION['error_message'] = 'ID объявления не указан';
            header('Location: index.php?page=manage_listings');
            exit;
        }

        // Получение данных объявления
        $listing = $this->listingModel->getListingDetails($listingId);
        
        if (!$listing) {
            $_SESSION['error_message'] = 'Объявление не найдено';
            header('Location: index.php?page=manage_listings');
            exit;
        }

        // Получение категорий для формы
        $categories = $this->categoryModel->getParentCategories();
        $subcategories = $this->categoryModel->getSubcategories($listing['category_id']);

        // Отображение формы редактирования
        require_once __DIR__ . '/../views/admin_edit_listing.php';
    }

    public function updateListing() {
        // Проверка прав администратора
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = 'Доступ запрещен';
            header('Location: index.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['error_message'] = 'Неверный метод запроса';
            header('Location: index.php?page=manage_listings');
            exit;
        }

        $listingId = $_POST['listing_id'] ?? null;
        
        if (!$listingId) {
            $_SESSION['error_message'] = 'ID объявления не указан';
            header('Location: index.php?page=edit_listing_admin');
            exit;
        }

        try {
            // Валидация данных
            $this->validateFormData($_POST);

            // Подготовка данных для обновления
            $listingData = $this->prepareListingData($_POST);
            
            // Обновление объявления
            $success = $this->listingModel->updateListingAdmin($listingId, $listingData);
            
            if ($success) {
                // Обновление цен по месяцам
                $this->updatePrices($listingId, $_POST['prices'] ?? []);
                
                // Обработка фотографий
                $this->handlePhotos($listingId);
                
                $_SESSION['success_message'] = 'Объявление успешно обновлено';
            // Исправленный редирект - на страницу редактирования
            header('Location: index.php?page=edit_listing_admin&id=' . $listingId);
        } else {
            throw new Exception('Ошибка при обновлении объявления');
        }
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = $e->getMessage();
        // Редирект обратно на страницу редактирования при ошибке
        header('Location: index.php?page=edit_listing_admin&id=' . $listingId);
    }
    exit;
    }
private function sanitizeMapCode($code) {
    if (empty($code)) return null;
    
    // Разрешаем только определенные теги и атрибуты
    $allowedTags = '<script><iframe><div><style>';
    $code = strip_tags($code, $allowedTags);
    
    // Дополнительная проверка для script тегов
    if (strpos($code, '<script') !== false) {
        // Проверяем, что это действительно код Яндекс Карт
        if (strpos($code, 'api-maps.yandex.ru') === false && 
            strpos($code, 'yandex.ru/map-constructor') === false) {
            // Если это не Яндекс Карты, очищаем
            $code = null;
        }
    }
    
    return $code;
}
    private function validateFormData($data) {
        $requiredFields = [
            'title', 'category_id', 'subcategory_id', 
            'address', 'phone', 'distance_to_sea'
        ];

        foreach ($requiredFields as $field) {
            if (empty(trim($data[$field] ?? ''))) {
                throw new Exception("Поле '{$field}' обязательно для заполнения");
            }
        }

        // Валидация телефона
        if (!preg_match('/^[\d\s\-\+$$$$]+$/', $data['phone'])) {
            throw new Exception('Некорректный формат телефона');
        }

        // Валидация числовых полей
        $numericFields = ['max_adults', 'max_children', 'max_guests_total', 'min_stay_nights'];
        foreach ($numericFields as $field) {
            if (isset($data[$field]) && !is_numeric($data[$field]) && $data[$field] !== '') {
                throw new Exception("Поле '{$field}' должно быть числом");
            }
        }
    }

    private function prepareListingData($postData) {
        return [
            'title' => trim($postData['title']),
            'category_id' => (int)$postData['category_id'],
            'subcategory_id' => !empty($postData['subcategory_id']) ? (int)$postData['subcategory_id'] : null,
            'description' => trim($postData['description'] ?? ''),
            'address' => trim($postData['address']),
            'distance_to_sea' => trim($postData['distance_to_sea']),
            'phone' => trim($postData['phone']),
            'has_wifi' => isset($postData['wifi_free']) ? 1 : 0,
            'has_parking' => isset($postData['has_parking']) ? 1 : 0,
            'food_options' => $postData['food_options'] ?? 'Без питания',
            'max_adults' => (int)($postData['max_adults'] ?? 0),
            'max_children' => (int)($postData['max_children'] ?? 0),
            'max_guests_total' => (int)($postData['max_guests_total'] ?? 0),
            'check_in_time' => $postData['check_in_time'] ?? '14:00',
            'check_out_time' => $postData['check_out_time'] ?? '12:00',
            'min_stay_nights' => (int)($postData['min_stay_nights'] ?? 1),
            'registry_number' => trim($postData['registry_number'] ?? ''),
            'legal_form' => $postData['legal_form'] ?? null,
            'status' => $postData['status'] ?? 'pending',
            'yandex_map_code' => $this->sanitizeMapCode($postData['yandex_map_code'] ?? null)
        ];
    }

    private function updatePrices($listingId, $prices) {
        // Удаляем старые цены
        $this->listingModel->deleteListingPrices($listingId);
        
        // Добавляем новые цены
        foreach ($prices as $month => $amount) {
            if (!empty($amount) && is_numeric($amount)) {
                $this->listingModel->addPrice($listingId, $month, (float)$amount);
            }
        }
    }

    private function handlePhotos($listingId) {
        // Обработка главного фото
        if (!empty($_FILES['main_photo']['name'])) {
            $this->uploadMainPhoto($listingId);
        }

        // Обработка дополнительных фото
        if (!empty($_FILES['photos']['name'][0])) {
            $this->uploadAdditionalPhotos($listingId);
        }

        // Удаление отмеченных фото
        if (!empty($_POST['delete_photos'])) {
            $this->deletePhotos($_POST['delete_photos']);
        }
    }

    private function uploadMainPhoto($listingId) {
        $uploadDir = __DIR__ . '/../../uploads/'; // Исправленный путь
        
        // Удаляем текущее главное фото
        $this->photoModel->removeMainPhoto($listingId, $uploadDir);
        
        // Загружаем новое главное фото
        $this->photoModel->uploadMainPhoto($listingId, $_FILES['main_photo'], $uploadDir);
    }

    private function uploadAdditionalPhotos($listingId) {
        $uploadDir = __DIR__ . '/../../uploads/'; // Исправленный путь
        
        foreach ($_FILES['photos']['tmp_name'] as $key => $tmpName) {
            if ($_FILES['photos']['error'][$key] === UPLOAD_ERR_OK) { // Добавлена проверка ошибок
                $file = [
                    'name' => $_FILES['photos']['name'][$key],
                    'type' => $_FILES['photos']['type'][$key],
                    'tmp_name' => $tmpName,
                    'error' => $_FILES['photos']['error'][$key],
                    'size' => $_FILES['photos']['size'][$key]
                ];
                
                $this->photoModel->uploadAdditionalPhoto($listingId, $file, $uploadDir);
            }
        }
    }

    private function deletePhotos($photoIds) {
        foreach ($photoIds as $photoId) {
            $this->photoModel->deletePhoto($photoId);
        }
    }
}