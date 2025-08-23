<?php
// app/models/InstructionModel.php

class InstructionModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function searchInstructions($searchTerm) {
        $stmt = $this->db->prepare("SELECT * FROM instructions WHERE (title LIKE ? OR description LIKE ?) AND approved = 1");
        $stmt->execute(['%' . $searchTerm . '%', '%' . $searchTerm . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories() {
        $stmt = $this->db->query("SELECT * FROM categories");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getInstructionsBySubcategoryId($subcategoryId) {
        $stmt = $this->db->prepare("SELECT id, filename, title, description FROM instructions WHERE subcategory_id = :subcategory_id AND approved = 1");
        $stmt->execute([':subcategory_id' => $subcategoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function save($data)
    {
        $stmt = $this->db->prepare("INSERT INTO instructions (user_id, filename, category_id, subcategory_id, title, description) VALUES (:user_id, :filename, :category_id, :subcategory_id, :title, :description)");

        try {
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }
    public function getParentCategories() {
        $stmt = $this->db->query("SELECT id, name FROM categories WHERE parent_id IS NULL");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSubcategories($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = :category_id");
        $stmt->execute([':category_id' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
