<?php
// /app/models/UserModel.php
class UserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
    public function register($username, $password_hash, $role = 'guest') {
    // Проверяем, существует ли пользователь с таким логином
    if ($this->userExists($username)) {
        throw new Exception("Пользователь с таким логином уже существует");
        // или return false;
    }
    
    // Генерируем временный email на основе username
    $temp_email = $username . '@temp.temp';
    
    // Проверяем, существует ли пользователь с таким email (на всякий случай)
    if ($this->emailExists($temp_email)) {
        // Если временный email уже существует, генерируем уникальный
        $temp_email = $username . '_' . uniqid() . '@temp.temp';
    }
    
    $stmt = $this->db->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (:username, :email, :password_hash, :role)");
    return $stmt->execute([
        ':username' => $username,
        ':email' => $temp_email,
        ':password_hash' => $password_hash,
        ':role' => $role
    ]);
}

public function userExists($username) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    return $stmt->fetch() !== false;
}

// Добавляем метод для проверки email
public function emailExists($email) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch() !== false;
}

    // Получение всех пользователей (гости и отельеры)
    public function getUsers() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role IN ('guest', 'hotelier') ORDER BY registration_date DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получение количества пользователей
    public function getUsersCount() {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM users WHERE role IN ('guest', 'hotelier')");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }

    // Получение количества пользователей по ролям
    public function getUsersCountByRole() {
        $stmt = $this->db->prepare("SELECT role, COUNT(*) as count FROM users WHERE role IN ('guest', 'hotelier') GROUP BY role");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $counts = ['guest' => 0, 'hotelier' => 0];
        foreach ($result as $row) {
            $counts[$row['role']] = $row['count'];
        }
        return $counts;
    }

public function blockUser($id, $reason, $blockedBy) {
        try {
            // Проверяем, не пытаемся ли заблокировать администратора
            $user = $this->getUserById($id);
            if (!$user) {
                throw new Exception("Пользователь не найден");
            }
            
            if ($user['role'] === 'admin') {
                throw new Exception("Нельзя заблокировать администратора");
            }

            $this->db->beginTransaction();

            // Блокируем пользователя
            $stmt = $this->db->prepare("
                UPDATE users 
                SET is_active = 0, 
                    block_reason = :reason,
                    blocked_at = NOW(),
                    blocked_by = :blocked_by
                WHERE id = :id AND role != 'admin'
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':reason', $reason, PDO::PARAM_STR);
            $stmt->bindParam(':blocked_by', $blockedBy, PDO::PARAM_INT);
            
            $result = $stmt->execute();

            // Логируем действие
            if ($result) {
                $this->logAdminAction($blockedBy, 'block_user', $id, $reason);
            }

            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error blocking user {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function unblockUser($id, $unblockedBy) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("
                UPDATE users 
                SET is_active = 1, 
                    block_reason = NULL,
                    blocked_at = NULL,
                    blocked_by = NULL
                WHERE id = :id
            ");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            // Логируем действие
            if ($result) {
                $this->logAdminAction($unblockedBy, 'unblock_user', $id);
            }

            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error unblocking user {$id}: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id, $deletedBy) {
        try {
            $user = $this->getUserById($id);
            if (!$user) {
                throw new Exception("Пользователь не найден");
            }

            if ($user['role'] === 'admin') {
                throw new Exception("Нельзя удалить администратора");
            }

            $this->db->beginTransaction();

            // Сначала логируем
            $this->logAdminAction($deletedBy, 'delete_user', $id);

            // Затем удаляем
            $stmt = $ $this->db->prepare("DELETE FROM users WHERE id = :id AND role != 'admin'");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $result = $stmt->execute();

            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error deleting user {$id}: " . $e->getMessage());
            return false;
        }
    }

    private function logAdminAction($adminId, $action, $targetUserId, $details = null) {
        $stmt = $this->db->prepare("
            INSERT INTO admin_logs (admin_id, action, target_user_id, details, ip_address, user_agent) 
            VALUES (:admin_id, :action, :target_user_id, :details, :ip_address, :user_agent)
        ");
        
        return $stmt->execute([
            ':admin_id' => $adminId,
            ':action' => $action,
            ':target_user_id' => $targetUserId,
            ':details' => $details,
            ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
            ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    }

    // Получение пользователя по ID
    public function getUserById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}