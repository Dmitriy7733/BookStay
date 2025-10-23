<?php
// /app/controllers/UserManagementController.php
require_once __DIR__ . '/../models/UserModel.php';
class UserManagementController {
    private $db;
    private $userModel;
    public function __construct($db) {
        $this->db = $db;
        $this->userModel = new UserModel($db);
    }

    private function validateAdminAccess() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Доступ запрещен']);
            exit();
        }
    }

    private function validateCsrfToken() {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(419);
            echo json_encode(['error' => 'Недействительный CSRF-токен']);
            exit();
        }
    }

    public function manageUsers() {
        $this->validateAdminAccess();

        // Генерация CSRF-токена
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        $users = $this->userModel->getUsers();
        require_once __DIR__ . '/../views/user_management.php';
    }

    public function blockUser() {
        $this->validateAdminAccess();
        $this->validateCsrfToken();

        if (isset($_POST['id']) && isset($_POST['reason'])) {
            $id = intval($_POST['id']);
            $reason = trim($_POST['reason']);
            $adminId = $_SESSION['user_id'];

            // Валидация причины
            if (empty($reason) || strlen($reason) < 5) {
                echo json_encode(['error' => 'Причина блокировки должна содержать не менее 5 символов']);
                return;
            }

            if ($this->userModel->blockUser($id, $reason, $adminId)) {
                echo json_encode(['success' => 'Пользователь успешно заблокирован']);
            } else {
                echo json_encode(['error' => 'Ошибка при блокировке пользователя']);
            }
        } else {
            echo json_encode(['error' => 'Неверный запрос']);
        }
    }

    public function unblockUser() {
        $this->validateAdminAccess();
        $this->validateCsrfToken();

        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $adminId = $_SESSION['user_id'];

            if ($this->userModel->unblockUser($id, $adminId)) {
                echo json_encode(['success' => 'Пользователь успешно разблокирован']);
            } else {
                echo json_encode(['error' => 'Ошибка при разблокировке пользователя']);
            }
        } else {
            echo json_encode(['error' => 'Неверный запрос']);
        }
    }

    public function deleteUser() {
        $this->validateAdminAccess();
        $this->validateCsrfToken();

        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $adminId = $_SESSION['user_id'];

            if ($this->userModel->deleteUser($id, $adminId)) {
                echo json_encode(['success' => 'Пользователь успешно удален']);
            } else {
                echo json_encode(['error' => 'Ошибка при удалении пользователя']);
            }
        } else {
            echo json_encode(['error' => 'Неверный запрос']);
        }
    }
}