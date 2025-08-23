<?php
// /app/controllers/ComplaintController.php
require_once __DIR__ . '/../models/Complaint.php';
class ComplaintController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function submitComplaint() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['instruction_id'], $_POST['complaint_text'])) {
                $instructionId = intval($_POST['instruction_id']);
                $complaintText = htmlspecialchars($_POST['complaint_text']);
                $userId = $_SESSION['user_id'] ?? null;
    
                if ($userId === null) {
                    echo json_encode(['success' => false, 'message' => 'Для отправки жалобы авторизуйтесь, пожалуйста!']);
                    exit;
                }  //лишнее, но оставлю для себя
    
                $complaintModel = new Complaint($this->db);
                $result = $complaintModel->submitComplaint($instructionId, $userId, $complaintText);
                echo json_encode($result);
            } else {
                echo json_encode(['success' => false, 'message' => 'Недостаточно данных.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неверный метод запроса.']);
        }
    }
}
