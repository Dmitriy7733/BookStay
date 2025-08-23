<?php
// app/controllers/RegisterController.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../models/User.php';

class RegisterController {
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $confirm_password = trim($_POST['confirm_password']);
            $captcha = trim($_POST['captcha']);

            $errors = [];
            if (strlen($username) < 3 || strlen($username) > 20) {
                $errors[] = "Логин должен содержать от 3 до 20 символов.";
            }
            if (!preg_match('/^[a-zA-Zа-яА-Я0-9_]+$/u', $username)) {
                $errors[] = "Логин может содержать только буквы, цифры и символ '_'.";
            }
            if (strlen($password) < 6 || strlen($password) > 20) {
                $errors[] = "Пароль должен содержать от 6 до 20 символов.";
            }
            if ($password !== $confirm_password) {
                $errors[] = "Пароли не совпадают.";
            }
            if ($this->userModel->userExists($username)) {
                $errors[] = "Пользователь с таким логином уже существует.";
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: index.php?page=register");
                exit();
            } else {
                if ($this->userModel->register($username, $password)) {
                    $_SESSION['success'] = "Регистрация прошла успешно! Войдите в систему!";
                    header("Location: index.php?page=login");
                    exit();
                } else {
                    $_SESSION['errors'][] = "Ошибка при регистрации. Попробуйте снова.";
                    header("Location: index.php?page=register");
                    exit();
                }
            }
        } else {
            require_once __DIR__ . '/../views/auth/register.php'; 
            exit(); 
        }
    }
}