<?php
// app/models/AuthModel.php
class AuthModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    // Метод для получения пользователя по имени
    public function getUserByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user) {
            // Проверка статуса
            if ($user['status'] === 'blocked') {
                $_SESSION['is_blocked'] = true; // Установка статуса блокировки в сессию
                return null; // Пользователь заблокирован
            }
            if (password_verify($password, $user['password'])) {
                $_SESSION['is_blocked'] = false; // Установка статуса активного пользователя в сессию
                return $user; // Успешная аутентификация
            }
        }
        return false; // Неправильное имя пользователя или пароль
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $this->db->prepare("UPDATE users SET password = :password WHERE id = :id");
        $updateStmt->bindParam(':password', $hashedPassword);
        $updateStmt->bindParam(':id', $id);
        return $updateStmt->execute();
    }
}