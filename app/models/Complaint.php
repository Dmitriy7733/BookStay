<?php
// app/models/Complaint.php
class Complaint {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function submitComplaint($instructionId, $userId, $complaintText) {
        // Проверка существования инструкции
        $stmtCheck = $this->db->prepare("SELECT COUNT(*) FROM instructions WHERE id = :instruction_id");
        $stmtCheck->execute([':instruction_id' => $instructionId]);
        $exists = $stmtCheck->fetchColumn();
        if ($exists == 0) {
            return ['success' => false, 'message' => 'Инструкция не найдена.'];
        }

        // Проверка существования пользователя
        $stmtUserCheck = $this->db->prepare("SELECT COUNT(*) FROM users WHERE id = :user_id");
        $stmtUserCheck->execute([':user_id' => $userId]);
        $userExists = $stmtUserCheck->fetchColumn();
        if ($userExists == 0) {
            return ['success' => false, 'message' => 'Пользователь не найден.'];
        }

        try {
            $stmt = $this->db->prepare("INSERT INTO complaints (instruction_id, user_id, complaint_text) VALUES (:instruction_id, :user_id, :complaint_text)");
            $stmt->execute([
                ':instruction_id' => $instructionId,
                ':user_id' => $userId,
                ':complaint_text' => $complaintText
            ]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Ошибка базы данных: ' . $e->getMessage()];
        }
    }
}
