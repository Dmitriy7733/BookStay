<?php
// app/controllers/SearchController.php

require_once __DIR__ . '/../models/SearchListingModel.php';
require_once __DIR__ . '/../models/BookingModel.php';

class SearchController {
    private $db;
    
    public function __construct($db) {
        $this->db = $db;
    }
    
    public function search() {
        try {
            // Получаем данные из POST запроса
            $cityId = $_POST['cityId'] ?? null;
            $dateFrom = $_POST['dateFrom'] ?? null;
            $dateTo = $_POST['dateTo'] ?? null;
            $adults = $_POST['adult'] ?? 2;
            $children = $_POST['child'] ?? 0;
            
            // Валидация
            if (!$cityId) {
                echo json_encode(['success' => false, 'message' => 'Выберите направление']);
                return;
            }
            
            // Преобразуем даты
            $checkinDate = $dateFrom ? DateTime::createFromFormat('d.m.Y', $dateFrom) : null;
            $checkoutDate = $dateTo ? DateTime::createFromFormat('d.m.Y', $dateTo) : null;
            
            // SQL запрос для поиска
            $query = "
                SELECT l.*, 
                       (SELECT photo_path FROM listing_photos WHERE listing_id = l.id LIMIT 1) as main_photo,
                       (SELECT COUNT(*) FROM reviews WHERE listing_id = l.id) as reviews_count,
                       c.name as category_name,
                       sc.name as subcategory_name
                FROM listings l
                LEFT JOIN categories c ON l.category_id = c.id
                LEFT JOIN categories sc ON l.subcategory_id = sc.id
                WHERE l.subcategory_id = :cityId
                AND l.is_approved = 1
            ";
            
            $params = [':cityId' => $cityId];
            
            // Добавляем фильтр по датам, если они указаны
            if ($checkinDate && $checkoutDate) {
                $query .= " AND l.id NOT IN (
                    SELECT listing_id FROM blocked_dates 
                    WHERE date BETWEEN :checkinDate AND :checkoutDate
                    AND reason = 'booked'
                )";
                $params[':checkinDate'] = $checkinDate->format('Y-m-d');
                $params[':checkoutDate'] = $checkoutDate->format('Y-m-d');
            }
            
            // Фильтр по количеству гостей
            $totalGuests = $adults + $children;
            $query .= " AND l.max_guests_total >= :totalGuests";
            $params[':totalGuests'] = $totalGuests;
            
            $stmt = $this->db->prepare($query);
            $stmt->execute($params);
            $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Форматируем результат
            $formattedListings = [];
            foreach ($listings as $listing) {
                $formattedListings[] = $this->formatListing($listing);
            }
            
            echo json_encode([
                'success' => true,
                'listings' => $formattedListings,
                'searchParams' => [
                    'cityId' => $cityId,
                    'cityName' => $this->getCityName($cityId),
                    'dateFrom' => $dateFrom,
                    'dateTo' => $dateTo,
                    'adults' => $adults,
                    'children' => $children
                ]
            ]);
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Ошибка поиска']);
        }
    }
    
    private function formatListing($listing) {
        // Здесь преобразуем данные в нужный формат
        return [
            'id' => $listing['id'],
            'title' => $listing['title'],
            'main_photo' => $listing['main_photo'] ?: '/default-photo.jpg',
            'address' => $listing['address'],
            'distance_to_sea' => $listing['distance_to_sea'],
            'has_parking' => (bool)$listing['has_parking'],
            'food_options' => $listing['food_options'],
            'phone' => $listing['phone'],
            'reviews_count' => $listing['reviews_count'],
            'prices' => $this->getPrices($listing['id'])
        ];
    }
    
    private function getPrices($listingId) {
        // Логика получения цен
        return [
            ['month' => 'Январь', 'amount' => 2500],
            ['month' => 'Февраль', 'amount' => 2700],
            // ... другие месяцы
        ];
    }
    
    private function getCityName($cityId) {
        $stmt = $this->db->prepare("SELECT name FROM categories WHERE id = :id");
        $stmt->execute([':id' => $cityId]);
        return $stmt->fetchColumn();
    }
        public function autocompleteCities() {
    $query = $_POST['query'] ?? '';
    
    if (strlen($query) < 2) {
        echo json_encode([]);
        return;
    }
    
    $stmt = $this->db->prepare("
        SELECT id, name 
        FROM categories 
        WHERE parent_id IS NOT NULL 
        AND name LIKE :query 
        LIMIT 10
    ");
    $stmt->execute([':query' => '%' . $query . '%']);
    $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($cities);
}
}