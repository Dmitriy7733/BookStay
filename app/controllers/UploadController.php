<?php
// app/controllers/UploadController.php
require_once __DIR__ . '/../models/InstructionModel.php';
class UploadController
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
    
}