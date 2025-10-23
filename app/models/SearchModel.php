<?php
// /app/models/SearchModel.php
require_once __DIR__ . '/ListingModel.php';
require_once __DIR__ . '/CategoryModel.php';
class SearchModel {
    private $db;
    private $categoryModel;
    private $listingModel;

    public function __construct($db) {
        $this->db = $db;
        $this->categoryModel = new CategoryModel($db);
        $this->listingModel = new ListingModel($db);
    }

    // Автозаполнение городов с подсказками
    public function autocompleteCities($query) {
        $searchTerm = '%' . $query . '%';
    $stmt = $this->db->prepare("
        SELECT id, name, parent_id 
        FROM categories 
        WHERE parent_id IS NOT NULL
          AND name LIKE ?
        ORDER BY 
            CASE 
                WHEN name LIKE ? THEN 1  -- Точное совпадение в начале
                WHEN name LIKE ? THEN 2  -- Совпадение в начале слова
                ELSE 3                   -- Совпадение в любом месте
            END,
            name
        LIMIT 10
    ");
    // Параметры для подготовленного выражения
    $exactMatch = $query; // например, для точного совпадения
    $startsWith = $query . '%'; // для совпадения в начале слова
    $contains = '%' . $query . '%'; // для любого вхождения

    $stmt->execute([$contains, $exactMatch, $startsWith]);
        $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Добавляем информацию о родительской категории
        foreach ($cities as & $city) {
            if ($city['parent_id']) {
                $parentStmt = $this->db->prepare("SELECT name FROM categories WHERE id = ?");
                $parentStmt->execute([$city['parent_id']]);
                $parent = $parentStmt->fetch(PDO::FETCH_ASSOC);
                $city['region'] = $parent ? $parent['name'] : '';
            }
        }
        
        return $cities;
    }

    public function searchListings($params) {
    $cityId = $params['cityId'] ?? null;
    $dateFrom = $params['dateFrom'] ?? null;
    $dateTo = $params['dateTo'] ?? null;
    $adults = $params['adults'] ?? 2;
    $children = $params['children'] ?? 0;
    $priceMin = $params['priceMin'] ?? null;
    $priceMax = $params['priceMax'] ?? null;

    if (!$cityId) {
        throw new Exception('Выберите направление');
    }

    // Валидация дат
    if ($dateFrom && !$dateTo) {
        throw new Exception('Укажите дату выезда');
    }
    if ($dateTo && !$dateFrom) {
        throw new Exception('Укажите дату заезда');
    }

    $checkinDate = $dateFrom ? DateTime::createFromFormat('d.m.Y', $dateFrom) : null;
    $checkoutDate = $dateTo ? DateTime::createFromFormat('d.m.Y', $dateTo) : null;

    if ($checkinDate && $checkoutDate) {
        if ($checkinDate >= $checkoutDate) {
            throw new Exception('Дата выезда должна быть позже даты заезда');
        }
    }

    // Начальный запрос
    $query = "
        SELECT l.*, 
           (SELECT photo_url FROM listing_photos WHERE listing_id = l.id AND is_main = 1 LIMIT 1) as main_photo,
           (SELECT GROUP_CONCAT(photo_url) FROM listing_photos WHERE listing_id = l.id) as all_photos,
           COUNT(DISTINCT r.id) as reviews_count,
           AVG(r.rating) as average_rating,
           c.name as category_name,
           sc.name as subcategory_name,
           (SELECT MIN(amount) FROM listing_prices WHERE listing_id = l.id) as min_price
        FROM listings l
        LEFT JOIN categories c ON l.category_id = c.id
        LEFT JOIN categories sc ON l.subcategory_id = sc.id
        LEFT JOIN reviews r ON l.id = r.listing_id
        WHERE l.subcategory_id = :cityId 
          AND l.status = 'published'
    ";

    $queryParams = [':cityId' => $cityId];

    // Фильтр по датам
    if ($checkinDate && $checkoutDate) {
        $query .= " AND l.id NOT IN (
            SELECT listing_id 
            FROM blocked_dates 
            WHERE date BETWEEN :checkinDate AND :checkoutDate 
              AND reason = 'booked'
        )";
        $queryParams[':checkinDate'] = $checkinDate->format('Y-m-d');
        $queryParams[':checkoutDate'] = $checkoutDate->format('Y-m-d');
    }

    // Фильтр по гостям
    $totalGuests = $adults + $children;
    $query .= " AND l.max_guests_total >= :totalGuests";
    $queryParams[':totalGuests'] = $totalGuests;

    // Фильтр по ценам
    if ($priceMin !== null && $priceMin !== '') {
        $query .= " AND (SELECT MIN(amount) FROM listing_prices WHERE listing_id = l.id) >= :priceMin";
        $queryParams[':priceMin'] = (float)$priceMin;
    }

    if ($priceMax !== null && $priceMax !== '') {
        $query .= " AND (SELECT MIN(amount) FROM listing_prices WHERE listing_id = l.id) <= :priceMax";
        $queryParams[':priceMax'] = (float)$priceMax;
    }

    // Итоговые группировка и сортировка
    $query .= " GROUP BY l.id ORDER BY l.created_at DESC";

    // Подготовка и выполнение
    $stmt = $this->db->prepare($query);
    $stmt->execute($queryParams);
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $formattedListings = [];
    foreach ($listings as $listing) {
        $formattedListings[] = $this->listingModel->formatListing($listing);
    }

    return [
        'listings' => $formattedListings,
        'searchParams' => [
            'cityId' => $cityId,
            'cityName' => $this->categoryModel->getCityName($cityId),
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'adults' => $adults,
            'children' => $children,
            'priceMin' => $priceMin,
            'priceMax' => $priceMax
        ]
    ];
}
}