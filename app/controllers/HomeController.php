<?php
// /app/controllers/HomeController.php
require_once __DIR__ . '/../models/PropertyModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';

class HomeController {
    private $propertyModel;
    private $categoryModel;

    public function __construct($db) {
        $this->propertyModel = new PropertyModel($db);
        $this->categoryModel = new CategoryModel($db);
    }

    public function index() {
        // Fetch categories for navigation
        $navCategories = $this->categoryModel->getAllCategoriesWithSubcategories();
        
        // Fetch categories for cards
        $categories = $this->propertyModel->getCategories();
        $categoryGroups = $this->groupCategories($categories);
        
        include __DIR__ . '/../../app/views/home.php';
    }

    private function groupCategories($categories) {
        $categoryGroups = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] === null) {
                $categoryGroups[$category['id']] = [
                    'id' => $category['id'],
                    'name' => $category['name'],
                    'subcategories' => []
                ];
            } else {
                if (isset($categoryGroups[$category['parent_id']])) {
                    $categoryGroups[$category['parent_id']]['subcategories'][] = $category;
                }
            }
        }
        return $categoryGroups;
    }
}