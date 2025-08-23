<?php
// app/controllers/SearchAjaxController.php

require_once __DIR__ . '/../models/InstructionModel.php';

class SearchAjaxController {
    private $model;

    public function __construct($db) {
        $this->model = new InstructionModel($db);
    }

    public function search() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $searchTerm = isset($_POST['search_term']) ? trim($_POST['search_term']) : '';
            error_log("Searching for: " . $searchTerm);
            if (empty($searchTerm)) {
                echo json_encode(['error' => 'Пустой запрос']);
                exit;
            }
    
            try {
                $results = $this->model->searchInstructions($searchTerm);
                echo json_encode($results);
            } catch (Exception $e) {
                error_log("Error during search: " . $e->getMessage());
                echo json_encode(['error' => 'Ошибка выполнения запроса']);
            }
            exit;
        }
    }

    public function fetchInstructions() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subcategory_id'])) {
            $subcategoryId = (int)$_POST['subcategory_id'];
            if ($subcategoryId <= 0) {
                echo json_encode(['success' => false, 'message' => 'Некорректный ID подкатегории.']);
                exit;
            }
    
            try {
                $instructions = $this->model->getInstructionsBySubcategoryId($subcategoryId);
                echo json_encode(['success' => true, 'instructions' => $instructions]);
            } catch (Exception $e) {
                error_log($e->getMessage());
                echo json_encode(['success' => false, 'message' => 'Ошибка при выполнении запроса.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Неверный метод запроса.']);
        }
    }
}
    