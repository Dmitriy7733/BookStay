<?php
// /app/controllers/AdminController.php
require_once __DIR__ . '/../models/InstructionForAdmin.php';
require_once __DIR__ . '/../models/User.php';
class AdminController {
    private $db;
    private $instructionModel;
    private $userModel;

    public function __construct($db) {
        $this->db = $db;
        $this->instructionModel = new InstructionForAdmin($db);
        $this->userModel = new User($db);
    }

    public function admin() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php');
            exit();
        }

        $instructions = $this->instructionModel->getAdminInstructions();
        $users = $this->userModel->getUsers();
        
        require_once __DIR__ . '/../views/admin_form.php';
    }
    public function approve() { 
        if (isset($_POST['id'])) { 
            $id = intval($_POST['id']); 
            if ($this->instructionModel->approveInstruction($id)) { 
                echo json_encode(['success' => 'Инструкция одобрена.']); 
            } else { 
                echo json_encode(['error' => 'Ошибка.Попробуйте снова.']); 
            } 
        } else { 
            echo json_encode(['error' => 'Invalid request.']); 
        } 
    }

    public function delete() { 
        if (isset($_POST['id'])) { 
            $id = intval($_POST['id']); 
            if ($this->instructionModel->deleteInstruction($id)) { 
                echo json_encode(['success' => 'Инструкция успешно удалена']); 
            } else { 
                echo json_encode(['error' => 'Произошла ошибка при удалении инструкции']); 
            } 
        } else { 
            echo json_encode(['error' => 'Ошибка  возврата json']); 
        } 
    }
    public function blockUser() {
        if (isset($_POST['id']) && isset($_POST['reason'])) {
            $id = intval($_POST['id']);
            $reason = $_POST['reason'];
            if ($this->userModel->blockUser($id, $reason)) {
                echo json_encode(['success' => 'Пользователь успешно заблокирован.']);
            } else {
                echo json_encode(['error' => 'Ошибка при попытке блокировки пользователя. Повторите попытку позже']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request.']);
        }
    }

    public function unblockUser() {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            if ($this->userModel->unblockUser($id)) {
                echo json_encode(['success' => 'Пользователь успешно разблокирован.']);
            } else {
                echo json_encode(['error' => 'Ошибка при попытке разблокировки пользователя, повторите попытку позже.']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request.']);
        }
    }

    public function deleteUser() {
        if (isset($_POST['id'])) {
            $id = intval($_POST['id']);
            if ($this->userModel->deleteUser($id)) {
                echo json_encode(['success' => 'Пользователь успешно удален.']);
            } else {
                echo json_encode(['error' => 'Ошибка при попытке удаления пользователя. Повторите попытку позже']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request.']);
        }
    }
    public function viewInstruction() {
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $instruction = $this->instructionModel->getInstructionById($id); // Метод для получения инструкции по ID
    
            if ($instruction) {
                $filePath = __DIR__ . '/../../uploads/' . $instruction['filename'];
                if (file_exists($filePath)) {
                    echo json_encode(['filePath' => '/uploads/' . htmlspecialchars($instruction['filename'])]);
                } else {
                    echo json_encode(['error' => 'File not found']);
                }
            } else {
                echo json_encode(['error' => 'Instruction not found']);
            }
        } else {
            echo json_encode(['error' => 'Invalid request.']);
        }
    }

}