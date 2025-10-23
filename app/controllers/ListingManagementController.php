<?php
// /app/controllers/ListingManagementController.php
require_once __DIR__ . '/../models/ListingModel.php';
require_once __DIR__ . '/../models/UserModel.php';

class ListingManagementController {
    private $db;
    private $listingModel;
    private $userModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->listingModel = new ListingModel($db);
        $this->userModel = new UserModel($db);
    }

    public function manageListings() {
        // Проверка прав администратора
        
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit();
        }


        // Обработка фильтров
        $filters = [];
        if (isset($_GET['status']) && !empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
            $filters['user_id'] = (int)$_GET['user_id'];
        }

        // Получаем данные
        $listings = $this->listingModel->getAllListings($filters);
        $users = $this->userModel->getUsers(); // Для фильтра по пользователям
        $stats = $this->listingModel->getListingsStats();

        require_once __DIR__ . '/../views/admin_listings_management.php';
    }

    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $listingId = (int)$_POST['listing_id'];
            $status = $_POST['status'];
            
            if ($this->listingModel->updateListingStatus($listingId, $status)) {
                $_SESSION['success_message'] = 'Статус объявления успешно обновлен';
            } else {
                $_SESSION['error_message'] = 'Ошибка при обновлении статуса';
            }
            
            header('Location: index.php?page=manage_listings');
            exit();
        }
    }

    public function deleteListing() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $listingId = (int)$_POST['listing_id'];
            
            if ($this->listingModel->deleteListingAdmin($listingId)) {
                $_SESSION['success_message'] = 'Объявление успешно удалено';
            } else {
                $_SESSION['error_message'] = 'Ошибка при удалении объявления';
            }
            
            header('Location: index.php?page=manage_listings');
            exit();
        }
    }
}