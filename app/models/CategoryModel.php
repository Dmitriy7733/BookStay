<?php
// app/models/CategoryModel.php
class CategoryModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllCategoriesWithSubcategories() {
        // Получаем все родительские категории
        $parentCategories = $this->db->query("SELECT * FROM categories WHERE parent_id IS NULL")->fetchAll(PDO::FETCH_ASSOC);
        
        // Для каждой родительской категории получаем подкатегории
        foreach ($parentCategories as &$category) {
            $stmt = $this->db->prepare("SELECT * FROM categories WHERE parent_id = :parent_id");
            $stmt->execute([':parent_id' => $category['id']]);
            $category['subcategories'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $parentCategories;
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