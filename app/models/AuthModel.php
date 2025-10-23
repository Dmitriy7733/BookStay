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
    try {
        if (empty($password) || strlen(trim($password)) === 0) {
            return false;
        }
        
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return false;
        }
        
        if (empty($user['password_hash']) || !password_verify($password, $user['password_hash'])) {
            return false;
        }
        
        if ($user['is_active'] === 0 || $user['is_active'] === false) {
            $_SESSION['is_blocked'] = true;
            $_SESSION['block_reason'] = $user['block_reason'] ?? 'не указана';
            return false;
        }
        
        $_SESSION['is_blocked'] = false;
        return $user;
        
    } catch (Exception $e) {
        error_log("Auth error: " . $e->getMessage());
        return false;
    }
}
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($id, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $this->db->prepare("UPDATE users SET password_hash = :password WHERE id = :id");
        $updateStmt->bindParam(':password', $hashedPassword);
        $updateStmt->bindParam(':id', $id);
        return $updateStmt->execute();
    }
}