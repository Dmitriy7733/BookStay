<?php
// app/models/InstructionForAdmin.php

class InstructionForAdmin {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAdminInstructions($approved = 0) {
        $stmt = $this->db->prepare("SELECT i.*, u.username, c1.name AS category_name, c2.name AS subcategory_name 
                FROM instructions AS i 
                LEFT JOIN users AS u ON i.user_id = u.id 
                LEFT JOIN categories AS c1 ON i.category_id = c1.id 
                LEFT JOIN categories AS c2 ON i.subcategory_id = c2.id 
                WHERE i.approved = :approved");
        $stmt->bindParam(':approved', $approved, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllInstructions() {
        $stmt = $this->db->query("SELECT * FROM instructions");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function approveInstruction($id) { 
        $stmt = $this->db->prepare("UPDATE instructions SET approved = 1 WHERE id = :id"); 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        return $stmt->execute(); 
    }

    public function deleteInstruction($id) { 
        // Получаем информацию о инструкции для последующего удаления файла 
        $stmt = $this->db->prepare("SELECT filename FROM instructions WHERE id = :id"); 
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
        $stmt->execute(); 
        $instruction = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($instruction) {
            // Удаляем файл из папки uploads
            $filePath = __DIR__ . '/../../uploads/' . $instruction['filename'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Удаляем запись из базы данных
            $deleteStmt = $this->db->prepare("DELETE FROM instructions WHERE id = :id");
            $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
            return $deleteStmt->execute();
        }
        return false;
    }
    public function getInstructionById($id) {
        $stmt = $this->db->prepare("SELECT filename FROM instructions WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
