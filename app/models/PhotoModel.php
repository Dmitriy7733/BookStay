<?php
// /app/models/PhotoModel.php

class PhotoModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Загрузка главного фото
     */
        public function uploadMainPhoto($listingId, $file, $uploadDir) {
        // Создаем директорию если не существует
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Валидация файла
        if (!$this->validateFile($file)) {
            throw new Exception('Недопустимый файл');
        }

        // Удаляем старое главное фото
        $this->removeMainPhoto($listingId, $uploadDir);

        // Загружаем новое
        $fileName = $this->generateFileName($file['name']);
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $sql = "INSERT INTO listing_photos (listing_id, photo_url, is_main, upload_order) VALUES (?, ?, 1, 0)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$listingId, $fileName]);
        }
        return false;
    }

    public function uploadAdditionalPhoto($listingId, $file, $uploadDir) {
        // Создаем директорию если не существует
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Валидация файла
        if (!$this->validateFile($file)) {
            throw new Exception('Недопустимый файл');
        }

        $fileName = $this->generateFileName($file['name']);
        $filePath = $uploadDir . $fileName;
        
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $order = $this->getNextPhotoOrder($listingId);
            $sql = "INSERT INTO listing_photos (listing_id, photo_url, is_main, upload_order) VALUES (?, ?, 0, ?)";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$listingId, $fileName, $order]);
        }
        return false;
    }

    public function removeMainPhoto($listingId, $uploadDir = null) {
        if ($uploadDir === null) {
            $uploadDir = __DIR__ . '/../../uploads/';
        }

        $sql = "SELECT photo_url FROM listing_photos WHERE listing_id = ? AND is_main = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$listingId]);
        $photo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($photo) {
            $filePath = $uploadDir . $photo['photo_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $sql = "DELETE FROM listing_photos WHERE listing_id = ? AND is_main = 1";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$listingId]);
        }
        return true;
    }

    public function deletePhoto($photoId, $uploadDir = null) {
        if ($uploadDir === null) {
            $uploadDir = __DIR__ . '/../../uploads/';
        }

        $sql = "SELECT photo_url FROM listing_photos WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$photoId]);
        $photo = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($photo) {
            $filePath = $uploadDir . $photo['photo_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            $sql = "DELETE FROM listing_photos WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$photoId]);
        }
        return false;
    }

    private function validateFile($file) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg', 'image/bmp'];
        $maxSize = 5 * 1024 * 1024;

        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        if ($file['size'] > $maxSize) {
            return false;
        }

        return true;
    }

    private function generateFileName($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        return uniqid() . '_' . time() . '.' . $extension;
    }

    private function getNextPhotoOrder($listingId) {
        $sql = "SELECT MAX(upload_order) as max_order FROM listing_photos WHERE listing_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$listingId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['max_order'] ?? 0) + 1;
    }
}