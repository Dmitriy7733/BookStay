<?php
// /index.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/assets/cookies.php';
require_once __DIR__ . '/app/controllers/CategoryController.php';
require_once __DIR__ . '/app/controllers/SearchController.php';
require_once __DIR__ . '/app/controllers/HomeController.php';
require_once __DIR__ . '/app/controllers/ListingController.php';
require_once __DIR__ . '/app/controllers/UploadController.php';
require_once __DIR__ . '/app/controllers/AdminController.php';
require_once __DIR__ . '/app/controllers/CategoryManagementController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/RegisterController.php';
require_once __DIR__ . '/app/controllers/UserManagementController.php';
require_once __DIR__ . '/app/controllers/HotelierController.php';
require_once __DIR__ . '/app/controllers/ListingManagementController.php';
require_once __DIR__ . '/app/controllers/ListingViewController.php';
require_once __DIR__ . '/app/controllers/ListingEditController.php';


$role = $_SESSION['role'] ?? null;
$is_authenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
$is_blocked = isset($_SESSION['is_blocked']) && $_SESSION['is_blocked'];

// Если пользователь заблокирован, перенаправляем на страницу blocked
if ($is_blocked && $_GET['page'] !== 'blocked') {
    header('Location: ?page=blocked');
    exit;
}

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'hotelier_dashboard':
    $controller = new HotelierController($db);
    $controller->dashboard();
    break;
    
case 'edit_listing':
    $controller = new HotelierController($db);
    $controller->editListing();
    break;
    
case 'update_listing':
    $controller = new HotelierController($db);
    $controller->updateListing();
    break;
    
case 'delete_listing':
    $controller = new HotelierController($db);
    $controller->deleteListing();
    break;
    
    case 'save_listing':
        $controller = new HotelierController($db);
        $controller->saveListing();
        break;

    case 'search':
        $searchController = new SearchController($db);
        $searchController->search();
        break;

    case 'autocomplete_cities':
        $searchController = new SearchController($db);
        $searchController->autocompleteCities();
        break;

    case 'get_parent_categories':
        $categoryController = new CategoryController($db);
        $categoryController->getParentCategories();
        break;

    case 'get_subcategories':
        $categoryController = new CategoryController($db);
        $categoryId = $_GET['category_id'] ?? null;
        $categoryController->getSubcategories($categoryId);
        break;

    case 'upload_form':
        $uploadController = new UploadController($db);
        $uploadController->upload();
        break;
        
    case 'submit_listing':
        $uploadController = new UploadController($db);
        $uploadController->upload(); // Вызываем тот же метод, но он обработает POST
        break;

    case 'fetch_listings':
        $listingController = new ListingController($db);
        $listingController->fetchListingsBySubcategory();
        break;
case 'edit_listing_admin':
    $controller = new ListingEditController($db);
    $controller->editListing();
    break;

case 'update_listing_admin':
    $controller = new ListingEditController($db);
    $controller->updateListing();
    break;

    case 'block_user':
        $controller = new UserManagementController($db);
        $controller->blockUser();
        break;
    case 'unblock_user':
        $controller = new UserManagementController($db);
        $controller->unblockUser();
        break;
    case 'delete_user':
        $controller = new UserManagementController($db);
        $controller->deleteUser();
        break;
    case 'admin_dashboard':
        $adminController = new AdminController($db);
        $adminController->admin();
        break;
    case 'categories_management':
    $controller = new CategoryManagementController($db);
    $controller->manageCategories();
    break;
case 'user_management':
    $controller = new UserManagementController($db);
    $controller->manageUsers();
    break;
case 'add_category':
    $controller = new CategoryManagementController($db);
    $controller->addCategory();
    break;

case 'add_subcategory':
    $controller = new CategoryManagementController($db);
    $controller->addSubcategory();
    break;

case 'delete_category':
    $controller = new CategoryManagementController($db);
    $controller->deleteCategory();
    break;

case 'delete_subcategory':
    $controller = new CategoryManagementController($db);
    $controller->deleteSubcategory();
    break;

case 'manage_listings':
    $controller = new ListingManagementController($db);
    $controller->manageListings();
    break;
    
case 'update_listing_status':
    $controller = new ListingManagementController($db);
    $controller->updateStatus();
    break;
    
case 'delete_listing_admin':
    $controller = new ListingManagementController($db);
    $controller->deleteListing();
    break;
case 'view_listing':
    $controller = new ListingViewController($db);
    $controller->viewListing();
    break;
    
    case 'register':
        if (!$is_authenticated) {
            $registerController = new RegisterController($db);
            $registerController->register();
        } else {
            header('Location: index.php');
            exit;
        }
        break;
    case 'login':
        $authController = new AuthController($db);
        $authController->login();
        break;
    case 'change_password':
        $authController = new AuthController($db);
        $authController->changePassword();
        break;
    case 'logout':
        $authController = new AuthController($db);
        $authController->logout();
        break;
    case 'blocked':
        require_once __DIR__ . '/app/views/auth/blocked.php';
        break;
    case 'home':
    default:
        $controller = new HomeController($db);
        $controller->index();
        break;
}