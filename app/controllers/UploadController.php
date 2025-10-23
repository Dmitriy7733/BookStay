<?php
// app/controllers/UploadController.php
require_once __DIR__ . '/../models/UploadModel.php';
class UploadController {
    private $db;
    private $uploadModel;

    public function __construct($db) {
        $this->db = $db;
        $this->uploadModel = new UploadModel($db);
    }

    public function upload() {
// Проверка аутентификации
    if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated']) {
        $_SESSION['error'] = 'Для добавления объявления необходимо авторизоваться';
        header('Location: ?page=login');
        exit;
    }
    
    // Проверка роли пользователя
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'hotelier') {
        $_SESSION['error'] = 'У вас нет прав для добавления объявлений';
        header('Location: index.php');
        exit;
    }
        // Отображение формы
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include __DIR__ . '/../views/upload_form.php';
            return;
        }

        // Обработка AJAX-запроса
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['page']) && $_GET['page'] === 'submit_listing') {
            $this->handleFormSubmission();
        }
    }

    private function handleFormSubmission() {
        header('Content-Type: application/json');
        
        try {
            // Валидация данных
            $this->validateFormData();

            // Обработка загрузки файлов
            $mainPhoto = $this->handleFileUpload('main_photo');
            $additionalPhotos = $this->handleMultipleFileUpload('photos');

            // Подготовка данных для сохранения
            $listingData = [
                'user_id' => $_SESSION['user_id'],
                'category_id' => $_POST['category_id'],
                'subcategory_id' => $_POST['subcategory_id'],
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'address' => $_POST['address'],
                'phone' => $_POST['phone'],
                'distance_to_sea' => $_POST['distance_to_sea'],
                'max_adults' => $_POST['max_adults'] ?? 0,
                'max_children' => $_POST['max_children'] ?? 0,
                'max_guests_total' => $_POST['max_guests_total'] ?? 0,
                'check_in_time' => $_POST['check_in_time'] ?? '14:00:00',
                'check_out_time' => $_POST['check_out_time'] ?? '12:00:00',
                'min_stay_nights' => $_POST['min_stay_nights'] ?? 1,
                'has_wifi' => isset($_POST['wifi_free']) ? 1 : 0,
                'has_parking' => isset($_POST['has_parking']) ? 1 : 0,
                'food_options' => $_POST['food_options'],
                'registry_number' => $_POST['registry_number'] ?? '',
                'legal_form' => $_POST['legal_form'],
                'privacy_policy_accepted' => isset($_POST['privacy_policy_accepted']) ? 1 : 0,
                'personal_data_consent' => isset($_POST['personal_data_consent']) ? 1 : 0,
                'status' => 'pending'
            ];

            // Сохранение через модель
            $listingId = $this->uploadModel->saveMainListing($listingData, $mainPhoto);
            
            // Сохранение дополнительных фото
            if (!empty($additionalPhotos)) {
                $this->uploadModel->saveAdditionalPhotos($listingId, $additionalPhotos);
            }
            
            // Сохранение цен по месяцам
            if (isset($_POST['prices'])) {
                $this->uploadModel->savePrices($listingId, $_POST['prices']);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Объявление успешно отправлено на модерацию!'
            ]);

        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    private function validateFormData() {
        $requiredFields = [
            'category_id', 'subcategory_id', 'title', 'address', 
            'phone', 'distance_to_sea', 'legal_form'
        ];

        foreach ($requiredFields as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Поле '{$field}' обязательно для заполнения");
            }
        }

        if (!isset($_POST['privacy_policy_accepted']) || !isset($_POST['personal_data_consent'])) {
            throw new Exception("Необходимо принять условия политики конфиденциальности");
        }

        // Валидация файлов
        if (empty($_FILES['main_photo']['name'])) {
            throw new Exception("Главное фото обязательно");
        }
    }

    private function handleFileUpload($fieldName) {
        if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Ошибка загрузки файла {$fieldName}");
        }

        $file = $_FILES[$fieldName];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/bmp'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Недопустимый тип файла. Разрешены только JPEG, PNG, BMP и GIF");
        }

        if ($file['size'] > $maxSize) {
            throw new Exception("Размер файла не должен превышать 5MB");
        }

        $uploadDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Ошибка при сохранении файла");
        }

        return $fileName;
    }

    private function handleMultipleFileUpload($fieldName) {
    $uploadedFiles = [];
    
    if (!isset($_FILES[$fieldName]) || empty($_FILES[$fieldName]['name'][0])) {
        return $uploadedFiles;
    }

    $files = $_FILES[$fieldName];
    $fileCount = count($files['name']);
    
    // Ограничение на количество файлов (максимум 10)
    $maxFiles = 10;
    if ($fileCount > $maxFiles) {
        throw new Exception("Максимальное количество дополнительных фото: {$maxFiles}");
    }

    for ($i = 0; $i < min($fileCount, $maxFiles); $i++) {
        if ($files['error'][$i] === UPLOAD_ERR_OK) {
            $file = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i]
            ];

            try {
                $uploadedFiles[] = $this->handleFileUploadFromArray($file);
            } catch (Exception $e) {
                // Пропускаем файлы с ошибками, но продолжаем обработку
                continue;
            }
        }
    }

    return $uploadedFiles;
}
    private function handleFileUploadFromArray($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif','image/jpg', 'image/bmp'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Недопустимый тип файла: " . $file['name']);
        }

        if ($file['size'] > $maxSize) {
            throw new Exception("Размер файла превышает допустимый лимит: " . $file['name']);
        }

        $uploadDir = __DIR__ . '/../../uploads/';
        $fileName = uniqid() . '_' . basename($file['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new Exception("Ошибка при сохранении файла: " . $file['name']);
        }

        return $fileName;
    }
}
