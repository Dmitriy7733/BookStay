<?php
// /app/controllers/UserManagementController.php

class UserManagementController {
    private $userModel;

    public function __construct($db) {
        session_start(); // Начинаем сессию
    }

    public function manageUsers() {
        $message = '';
        $users = $this->userModel->getAllUsers();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? null;

            if (isset($_POST['user_id'])) {
                $userId = $_POST['user_id'];
                if ($action === 'block') {
                    $success = $this->userModel->blockUserById($userId);
                    $message = $success ? "Пользователь с ID $userId заблокирован." : "Ошибка при блокировке пользователя.";
                } elseif ($action === 'unblock') {
                    $success = $this->userModel->unblockUserById($userId);
                    $message = $success ? "Пользователь с ID $userId разблокирован." : "Ошибка при разблокировке пользователя.";
                }
                $_SESSION['message'] = $message; // Сохраняем сообщение в сессии
                header("Location: index.php?page=user_management");
                exit();
            }

            $userRoles = $_POST['user_roles'] ?? [];
            foreach ($userRoles as $role) {
                if (in_array($role, $this->userModel->getRoles())) {
                    if ($action === 'block') {
                        $success = $this->userModel->blockUsersByRole($role);
                        $message .= $success ? "Пользователи с ролью $role заблокированы. " : "Ошибка при блокировке пользователей с ролью $role. ";
                    } elseif ($action === 'unblock') {
                        $success = $this->userModel->unblockUsersByRole($role);
                        $message .= $success ? "Пользователи с ролью $role разблокированы. " : "Ошибка при разблокировке пользователей с ролью $role. ";
                    }
                }
            }
            $_SESSION['message'] = $message; // Сохраняем сообщение в сессии
            header("Location: index.php?page=user_management");
            exit();
        }

        // Отображение сообщения из сессии
        $message = htmlspecialchars($_SESSION['message'] ?? '', ENT_QUOTES, 'UTF-8');
        unset($_SESSION['message']); // Очистка сообщения после отображения
        require_once __DIR__ . '/../views/user_management.php';
    }
}