<?php
// /app/controllers/AdminController.php
require_once __DIR__ . '/../models/ListingModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
require_once __DIR__ . '/../models/UserModel.php';
class AdminController {
    private $db;
    private $categoryModel;
    private $userModel;
    private $listingModel;
    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
        $this->categoryModel = new CategoryModel($db);
        $this->listingModel = new ListingModel($db);
    }

    public function admin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit();
        }

        // Получаем статистику по пользователям
        $users_count = $this->userModel->getUsersCount();
        // Получаем статистику по объявлениям
        $listings_stats = $this->listingModel->getListingsStats();
        $recent_listings = $this->listingModel->getRecentListings(10);

        // Получаем статистику по категориям через CategoryModel
        $categories_count = $this->categoryModel->getParentCategoriesCount();
        $subcategories_count = $this->categoryModel->getSubcategoriesCount();
        
        require_once __DIR__ . '/../views/admin_dashboard.php';
    }
}