<?php
// /app/models/Category.php
class Category {
    private $db;

    public function __construct($db) {
        $this->db = $db;
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

