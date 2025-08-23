<?php
// /app/controllers/AuthController.php
require_once __DIR__ . '/../models/AuthModel.php';

class AuthController {
    private $model;

    public function __construct($db) {
        $this->model = new AuthModel($db);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''));
            $password = $_POST['password'] ?? '';

            $user = $this->model->authenticate($username, $password);

            if ($user) {
                // Успешная аутентификация
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $username;
                $_SESSION['is_authenticated'] = true;
                $_SESSION['is_blocked'] = false;

                // Перенаправление в зависимости от роли
                if ($user['role'] === 'admin') {
                    header('Location: index.php?page=admin_form');
                } elseif ($user['role'] === 'manager_tmz') {
                    header('Location: index.php?page=user_management');
                } elseif ($user['role'] === 'admin_tmz') {
                    header('Location: index.php?page=admin_tmz');
                } elseif ($user['role'] === 'editor_tmz') {
                    header('Location: index.php?page=editor_tmz');
                } elseif ($user['role'] === 'user_tmz') {
                    header('Location: index.php?page=home_tmz');
                } elseif ($user['role'] === 'user') {
                    header('Location: index.php');
                }
                exit();
            } else {
                $_SESSION['error'] = "Неправильное имя пользователя или пароль.";
            }
        }

        // Если пользователь уже аутентифицирован, перенаправляем на соответствующую страницу
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] === 'admin') {
                header('Location: index.php?page=admin_form');
            } elseif ($_SESSION['role'] === 'user') {
                header('Location: index.php');
            } elseif ($_SESSION['role'] === 'admin_tmz') {
                header('Location: index.php?page=admin_tmz');
            } elseif ($_SESSION['role'] === 'editor_tmz') {
                header('Location: index.php?page=editor_tmz');
            } elseif ($_SESSION['role'] === 'user_tmz') {
                header('Location: index.php?page=home_tmz');
            } elseif ($_SESSION['role'] === 'superuser_tmz') {
                header('Location: index.php?page=user_management');
            }
            exit();
        }
        if (isset($_SESSION['is_blocked']) && $_SESSION['is_blocked'] === true) {
            header('Location: index.php?page=blocked');
            exit();
        }

        // Отображаем представление
        require_once __DIR__ . '/../views/auth/login.php';
    } 
    
    public function changePassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars(trim($_POST['username'] ?? ''));
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
    
            $errors = []; // Массив для сбора ошибок
    
            // Найдите пользователя по имени
            $user = $this->model->getUserByUsername($username); // Предполагаем, что у вас есть метод для получения пользователя по имени
    
            // Проверяем, найден ли пользователь
            if (!$user) {
                $errors[] = "Пользователь не найден.";
            } else {
                // Проверяем правильность текущего пароля
                if (!password_verify($currentPassword, $user['password'])) {
                    $errors[] = "Неправильный текущий пароль.";
                }
    
                // Проверяем совпадение нового пароля и подтверждения
                if ($newPassword !== $confirmPassword) {
                    $errors[] = "Новые пароли не совпадают.";
                }
    
                // Если ошибок нет, обновляем пароль
                if (empty($errors)) {
                    $this->model->updatePassword($user['id'], $newPassword); 
                    $_SESSION['success'] = "Пароль успешно изменен."; // Устанавливаем сообщение об успехе
                }
            }
    
            // Если есть ошибки, сохраняем их в сессии
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
            }
        }
    
        // Включаем представление с сообщениями
        require_once __DIR__ . '/../views/auth/change_password.php';
    }
    public function logout() {
        // Уничтожаем все данные сессии
        $_SESSION = array();
        // Очищаем массив сессии
        session_destroy();
        // Перенаправляем пользователя на страницу входа или главную страницу
        header("Location: index.php");
        exit();
    }
}