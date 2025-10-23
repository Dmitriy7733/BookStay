<?php
// /app/controllers/SearchController.php
require_once __DIR__ . '/../models/SearchModel.php';
require_once __DIR__ . '/../models/CategoryModel.php';
class SearchController {
    private $db;
    private $categoryModel;
    private $searchModel;

    public function __construct($db) {
        $this->db = $db;
        $this->categoryModel = new CategoryModel($db);
        $this->searchModel = new SearchModel($db);
    }

    public function autocompleteCities() {
        header('Content-Type: application/json');
        
        $query = $_POST['query'] ?? '';
        
        if (empty($query)) {
            echo json_encode([]);
            return;
        }

        try {
            $cities = $this->searchModel->autocompleteCities($query);
            echo json_encode($cities);
        } catch (Exception $e) {
            error_log("Autocomplete error: " . $e->getMessage());
            echo json_encode(['error' => 'Ошибка поиска городов']);
        }
    }

    public function search() {
        header('Content-Type: application/json');
        
        try {
            $params = [
                'cityId' => $_POST['cityId'] ?? null,
                'dateFrom' => $_POST['dateFrom'] ?? null,
                'dateTo' => $_POST['dateTo'] ?? null,
                'adults' => $_POST['adult'] ?? 2,
                'children' => $_POST['child'] ?? 0,
                'priceMin' => !empty($_POST['priceMin']) ? (float)$_POST['priceMin'] : null,
                'priceMax' => !empty($_POST['priceMax']) ? (float)$_POST['priceMax'] : null
            ];

            error_log("Search params: " . print_r($params, true));

            $result = $this->searchModel->searchListings($params);
            
            echo json_encode([
                'success' => true,
                'listings' => $result['listings'],
                'searchParams' => $result['searchParams']
            ]);
            
        } catch (Exception $e) {
            error_log("Search error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Ошибка поиска: ' . $e->getMessage()
            ]);
        }
    }
}