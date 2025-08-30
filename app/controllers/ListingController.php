<?php
// /app/controllers/ListingController.php
require_once __DIR__ . '/../models/ListingModel.php';
class ListingController {
    private $model;
    private $db;

    public function __construct($db) {
        $this->db = $db;
        $this->model = new ListingModel($db);
    }

    /**
     * Получение списка объявлений по подкатегории
     */
    public function fetchListingsBySubcategory() {
        header('Content-Type: application/json');
        
        $subcategoryId = $_POST['subcategory_id'] ?? null;
        
        // Валидация входных данных
        if (!$subcategoryId) {
            echo json_encode(['success' => false, 'message' => 'Subcategory ID required']);
            exit;
        }

        if (!is_numeric($subcategoryId)) {
            echo json_encode(['success' => false, 'message' => 'Invalid subcategory ID']);
            exit;
        }
        
        try {
            // Получаем данные через модель
            $listings = $this->model->getListingsBySubcategory($subcategoryId);
            
            // Форматируем данные
            $formattedListings = $this->model->formatListings($listings);
            
            // Отправляем успешный ответ
            echo json_encode([
                'success' => true, 
                'listings' => $formattedListings,
                'count' => count($formattedListings)
            ]);
            
        } catch (PDOException $e) {
            // Логируем ошибку (в реальном приложении)
            error_log("Database error: " . $e->getMessage());
            
            // Отправляем ошибку клиенту
            echo json_encode([
                'success' => false, 
                'message' => 'Database error',
                'error_code' => 'DB_ERROR'
            ]);
        } catch (Exception $e) {
            // Обработка других ошибок
            error_log("General error: " . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Server error',
                'error_code' => 'SERVER_ERROR'
            ]);
        }
        
        exit;
    }
}