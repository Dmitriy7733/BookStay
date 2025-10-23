<?php
// /app/controllers/HotelierController.php
class HotelierController {
    private $db;
    private $listingModel;

    public function __construct($db) {
        $this->db = $db;
        $this->listingModel = new ListingModel($db);
    }

    // Метод для отображения личного кабинета с объявлениями
    public function dashboard() {
    if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated'] || $_SESSION['role'] !== 'hotelier') {
        header('Location: ?page=login');
        exit;
    }

        $userId = $_SESSION['user_id'];
        
        // Получаем статус из GET-параметра
        $status = $_GET['status'] ?? 'all';
        
        // Получаем объявления в соответствии с выбранным статусом
        // Исправлено: правильное преобразование статусов
        $statusMap = [
            'all' => null,
            'published' => 'published',
            'pending' => 'pending',
            'rejected' => 'rejected',
            'expired' => 'expired'
        ];
        
        $actualStatus = $statusMap[$status] ?? null;
        $userListings = $this->listingModel->getUserListings($userId, $actualStatus);
        $stats = $this->listingModel->getListingStats($userId);
        
        $data = [
            'userListings' => $userListings,
            'stats' => $stats,
            'username' => $_SESSION['username'],
            'currentStatus' => $status,
            'totalListings' => $stats['total'] ?? 0,
            'publishedListings' => $stats['published'] ?? 0,
            'moderationListings' => $stats['pending'] ?? 0,
            'rejectedListings' => $stats['rejected'] ?? 0,
            'expiredListings' => $stats['expired'] ?? 0
        ];
    extract($data);
    include __DIR__ . '/../views/hotelier_dashboard.php';
}
// Обработка POST-запроса редактирования
    public function saveListing() {
        if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated'] || $_SESSION['role'] !== 'hotelier') {
            header('Location: ?page=login');
            exit;
        }
        $listingId = $_POST['id'] ?? null;
        if (!$listingId) {
            $_SESSION['error'] = "Объявление не найдено";
            header('Location: ?page=hotelier_dashboard');
            exit;
        }
        // Получение данных из формы
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'address' => $_POST['address'],
            'distance_to_sea' => $_POST['distance_to_sea'],
            'has_wifi' => isset($_POST['has_wifi']),
            'has_parking' => isset($_POST['has_parking']),
            'food_options' => $_POST['food_options'],
            'phone' => $_POST['phone']
        ];

        $result = $this->listingModel->updateListing($listingId, $_SESSION['user_id'], $data);
        if ($result) {
            $_SESSION['success'] = "Объявление успешно обновлено";
        } else {
            $_SESSION['error'] = "Ошибка при обновлении объявления";
        }
        header('Location: ?page=hotelier_dashboard');
        exit;
    }
    public function updateListing() {
        // Обработка формы редактирования
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Валидация данных
            $listingId = $_POST['id'] ?? null;
            $data = [
                'title' => trim($_POST['title']),
                'description' => trim($_POST['description']),
                // ... остальные поля
            ];
            
            if ($this->listingModel->updateListing($listingId, $_SESSION['user_id'], $data)) {
                $_SESSION['success'] = "Объявление обновлено";
            } else {
                $_SESSION['errorerror'] = "Ошибка обновления";
            }
            
            header('Location: ?page=hotelier_dashboard');
            exit;
        }
    }
    // Удаление объявления
    public function deleteListing() {
        if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated'] || $_SESSION['role'] !== 'hotelier') {
            header('Location: ?page=login');
            exit;
        }
        $listingId = $_GET['id'] ?? null;
        if (!$listingId) {
            $_SESSION['error'] = "Объявление не найдено";
            header('Location: ?page=hotelier_dashboard');
            exit;
        }
        $result = $this->listingModel->deleteListing($listingId, $_SESSION['user_id']);
        if ($result) {
            $_SESSION['success'] = "Объявление успешно удалено";
        } else {
            $_SESSION['error'] = "Ошибка при удалении объявления";
        }
        header('Location: ?page=hotelier_dashboard');
        exit;
    }
    public function editListing() {
    if (!isset($_SESSION['is_authenticated']) || !$_SESSION['is_authenticated'] || $_SESSION['role'] !== 'hotelier') {
        header('Location: ?page=login');
        exit;
    }
    $listingId = $_GET['id'] ?? null;
    if (!$listingId) {
        $_SESSION['error'] = "Объявление не найдено";
        header('Location: ?page=hotelier_dashboard');
        exit;
    }
    $userId = $_SESSION['user_id'];
    $listing = $this->listingModel->getListingByIdForUser($listingId, $userId);
    if (!$listing) {
        $_SESSION['error'] = "Объявление не найдено или доступ запрещен";
        header('Location: ?page=hotelier_dashboard');
        exit;
    }
    include __DIR__ . '/../views/edit_listing.php';
}
}