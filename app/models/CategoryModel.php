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
}