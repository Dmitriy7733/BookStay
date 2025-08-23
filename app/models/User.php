<?php
// /app/models/User.php


class User {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function register($username, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (username, password, status, created_at, role) VALUES (:username, :password, 'active', datetime('now'), 'user')");
        return $stmt->execute([':username' => $username, ':password' => $hashed_password]);
    }

    public function userExists($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch() !== false;
    }

    public function getUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role IN ('user')");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function blockUser($id, $reason) {
        $stmt = $this->db->prepare("UPDATE users SET status = 'blocked', block_reason = :reason WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function unblockUser($id) {
        $stmt = $this->db->prepare("UPDATE users SET status = 'active', block_reason = NULL WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteUser($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}