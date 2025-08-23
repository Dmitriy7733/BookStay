<?php
// /index.php
session_start();

require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/app/controllers/CategoryController.php';
require_once __DIR__ . '/app/controllers/SearchAjaxController.php';
require_once __DIR__ . '/app/controllers/HomeController.php';
require_once __DIR__ . '/app/controllers/UploadController.php';
require_once __DIR__ . '/app/controllers/ComplaintController.php';
require_once __DIR__ . '/app/controllers/AdminController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/RegisterController.php';
require_once __DIR__ . '/app/controllers/UserManagementController.php';

$role = $_SESSION['role'] ?? null;
$is_authenticated = isset($_SESSION['is_authenticated']) && $_SESSION['is_authenticated'];
$is_blocked = isset($_SESSION['is_blocked']) && $_SESSION['is_blocked']; // Предполагается, что вы храните информацию о блокировке в сессии

/*if ($is_blocked) {
    // Если пользователь заблокирован, перенаправляем на страницу с сообщением о блокировке
    header('Location: ?page=blocked');
    exit;
}*/
$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'search_instructions':
        $ajaxController = new SearchAjaxController($db);
        $ajaxController->search(); 
        break;
    case 'fetch_instructions':
        $ajaxController = new SearchAjaxController($db);
        $ajaxController->fetchInstructions(); 
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
    case 'submit_complaint':
        $complaintController = new ComplaintController($db);
        $complaintController->submitComplaint();
        break;
    case 'approve_instruction': 
        $adminController = new AdminController($db); 
        $adminController->approve(); 
        break; 
    case 'delete_instruction': 
        $adminController = new AdminController($db); 
        $adminController->delete(); 
        break;
    case 'block_user':
        $adminController = new AdminController($db);
        $adminController->blockUser();
        break;
    case 'unblock_user':
        $adminController = new AdminController($db);
        $adminController->unblockUser();
        break;
    case 'delete_user':
        $adminController = new AdminController($db);
        $adminController->deleteUser();
        break;
    case 'viewInstruction':
        $adminController = new AdminController($db);
        $adminController->viewInstruction();
        break;
    case 'user_management':
        $userManagementController = new UserManagementController($db);
        $userManagementController->manageUsers();
        break;
    case 'admin_form':
        $adminController = new AdminController($db);
        $adminController->admin();
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