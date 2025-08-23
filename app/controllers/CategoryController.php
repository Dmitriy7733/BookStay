<?php
// /app/controllers/CategoryController.php
require_once __DIR__ . '/../models/Category.php';
class CategoryController {
    private $categoryModel;

    public function __construct($db) {
        $this->categoryModel = new Category($db);
    }

    public function getParentCategories() {
        $categories = $this->categoryModel->getParentCategories();
        header('Content-Type: application/json');
        echo json_encode($categories);
    }

    public function getSubcategories($categoryId) {
        if ($categoryId) {
            $subcategories = $this->categoryModel->getSubcategories($categoryId);
            header('Content-Type: application/json');
            echo json_encode($subcategories);
        } else {
            echo json_encode(['error' => 'Не передан идентификатор категории.']);
        }
    }
}