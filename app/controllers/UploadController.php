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
        // ВРЕМЕННО ДЛЯ ТЕСТИРОВАНИЯ - установка user_id вручную
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['user_id'] = 1; // ID тестового пользователя
        $_SESSION['is_authenticated'] = true;
    }
        // Проверка аутентификации
        if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated']) {
            $_SESSION['error'] = 'Для добавления объявления необходимо авторизоваться';
            header('Location: ?page=login');
            exit;
        }
        // Проверка наличия user_id_id в сессии
        if (!isset($_SESSION['user_id'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Ошибка авторизации. Пожалуйста, войдите снова'
            ]);
            exit;
        }

        // Отображение формы
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            include '../app/views/upload_form.php';
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
                'check_in_time' => $_POST['check_in_time'] ?? '14:00',
                'check_out_time' => $_POST['check_out_time'] ?? '12:00',
                'min_stay_nights' => $_POST['min_stay_nights'] ?? 1,
                'has_wifi' => isset($_POST['has_wifi']) ? 1 : 0,
                'has_parking' => isset($_POST['has_parking']) ? 1 : 0,
                'food_options' => $_POST['food_options'],
                'main_photo' => $mainPhoto,
                'photos' => json_encode($additionalPhotos),
                'prices' => json_encode($_POST['prices']),
                'registry_number' => $_POST['registry_number'] ?? '',
                'legal_form' => $_POST['legal_form'],
                'privacy_policy_accepted' => isset($_POST['privacy_policy_accepted']) ? 1 : 0,
                'personal_data_consent' => isset($_POST['personal_data_consent']) ? 1 : 0,
                'status' => 'pending'
            ];

            // Сохранение в базу данных
            $result = $this->uploadModel->saveListing($listingData);

            if ($result) {
                echo json_encode([
                    'success' => true,
                    'message' => 'Объявление успешно отправлено на модерацию!'
                ]);
            } else {
                throw new Exception('Ошибка при сохранении объявления в базу данных');
            }

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
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception("Недопустимый тип файла. Разрешены только JPEG, PNG и GIF");
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
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif','image/jpg'];
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
/*class UploadController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Проверяем, загрузился ли файл без ошибок
            if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
                $this->handleFileUpload();
            } else {
                $_SESSION['error'] = "Ошибка при загрузке файла.";
                header('Location: index.php?page=upload_form');
                exit;
            }
        } else {
            // Если не POST, показываем форму
            require_once __DIR__ . '/../views/upload_form.php';
        }
    }

    private function handleFileUpload()
    {
        // Проверяем размер файла (например, ограничение в 5 МБ)
        $maxFileSize = 5 * 1024 * 1024; // 5 МБ
        if ($_FILES['file']['size'] > $maxFileSize) {
            $_SESSION['error'] = "Ошибка: Файл превышает максимальный размер 5 МБ.";
            header('Location: index.php?page=upload_form');
            exit;
        }

        // Получаем информацию о загружаемом файле
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Проверяем допустимые расширения файлов
        $allowedfileExtensions = array('pdf', 'doc', 'docx', 'jpg', 'jpeg', 'bmp');
        if (!in_array($fileExtension, $allowedfileExtensions)) {
            $_SESSION['error'] = "Недопустимый тип файла. Допустимые форматы: " . implode(', ', $allowedfileExtensions);
            header('Location: index.php?page=upload_form');
            exit;
        }

        // Создаем директорию uploads, если она не существует
        $uploadFileDir = __DIR__ . '/../../uploads/';
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        // Уникальное имя файла
        $newFileName = uniqid() . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        // Перемещаем файл в указанную директорию
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $this->saveFileData($newFileName);
        } else {
            $_SESSION['error'] = "Ошибка при перемещении файла.";
            header('Location: index.php?page=upload_form');
            exit;
        }
    }

    private function saveFileData($newFileName)
    {
        // Получаем данные из формы
        $title = $_POST['title'];
        $description = $_POST['description'];
        $categoryId = $_POST['category_id'];
        $userId = $_SESSION['user_id'] ?? null;
        $subcategoryId = $_POST['subcategory_id'];

        // Создаем модель
        $instruction = new InstructionModel($this->db);
        $data = [
            ':user_id' => $userId,
            ':filename' => $newFileName,
            ':category_id' => $categoryId,
            ':subcategory_id' => $subcategoryId,
            ':title' => $title,
            ':description' => $description
        ];

        if ($instruction->save($data)) {
            $_SESSION['success'] = "Файл успешно загружен на одобрение.";
        } else {
            $_SESSION['error'] = "Ошибка базы данных.";
        }

        header('Location: index.php?page=upload_form');
        exit;
    }
    
}*/