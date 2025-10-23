<?php
// /app/models/ListingModel.php
class ListingModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }
public function getPrices($listingId) {
        $stmt = $this->db->prepare("
            SELECT month, amount 
            FROM listing_prices 
            WHERE listing_id = ? 
            ORDER BY FIELD(month, 
                'январь', 'февраль', 'март', 'апрель', 'май', 'июнь',
                'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'
            )
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListingPhotos($listingId) {
        $stmt = $this->db->prepare("
            SELECT photo_url, is_main 
            FROM listing_photos 
            WHERE listing_id = ? 
            ORDER BY is_main DESC, upload_order ASC
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
/**
 * Получить все фотографии объявления
 */
public function getAdminListingPhotos($listingId) {
    $stmt = $this->db->prepare("
        SELECT id, photo_url, is_main, upload_order 
        FROM listing_photos 
        WHERE listing_id = ? 
        ORDER BY is_main DESC, upload_order ASC
    ");
    $stmt->execute([$listingId]);
    $photos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Добавляем полный путь к фото
    $baseUploadPath = '/uploads/';
    foreach ($photos as &$photo) {
        $photo['full_url'] = $baseUploadPath . ltrim($photo['photo_url'], '/');
    }
    
    return $photos;
}
    public function getReviewsCount($listingId) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM reviews 
            WHERE listing_id = ?
        ");
        $stmt->execute([$listingId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
    public function formatListing($listing) {
        $photos = $this->getListingPhotos($listing['id']);
        $mainPhoto = '';
        $allPhotos = [];
        
        $baseUploadPath = '/uploads/';

foreach ($photos as $photo) {
    $fullPath = $baseUploadPath . ltrim($photo['photo_url'], '/');
    if ($photo['is_main']) {
        $mainPhoto = $fullPath;
    }
    $allPhotos[] = $fullPath;
}
        error_log("Listing ID: " . $listing['id'] . ", Map code: " . ($listing['yandex_map_code'] ? 'EXISTS' : 'NULL'));
        return [
            'id' => $listing['id'],
            'title' => $listing['title'],
            'main_photo' => $mainPhoto ?: '/default-image.jpg',
            'all_photos' => $allPhotos,
            'distance_to_sea' => $listing['distance_to_sea'],
            'address' => $listing['address'],
            'has_parking' => (bool)$listing['has_parking'],
            'food_options' => $listing['food_options'],
            'phone' => $listing['phone'],
            'has_wifi' => (bool)$listing['has_wifi'],
            'reviews_count' => $this->getReviewsCount($listing['id']),
            'prices' => $this->getPrices($listing['id']),
            'status' => $listing['status'],
            'yandex_map_code' => $listing['yandex_map_code'] ?? null
        ];
    }
     //Получает объявления по ID подкатегории
    public function getListingsBySubcategory($subcategoryId) {
        $stmt = $this->db->prepare("
            SELECT l.id, l.title, l.distance_to_sea, l.address, 
                   l.has_parking, l.food_options, l.phone, l.has_wifi, l.status,
                   l.created_at, l.updated_at,l.yandex_map_code
            FROM listings l
            WHERE l.subcategory_id = ? AND l.status = 'published'
            ORDER BY l.created_at DESC
        ");
        
        $stmt->execute([$subcategoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
public function formatListings($listings) {
    return array_map([$this, 'formatListing'], $listings);
}
// Получить все объявления пользователя по статусу
    public function getUserListings($userId, $status = null) {
        $sql = "SELECT l.* 
                FROM listings l
                WHERE l.user_id = :user_id";
        
        $params = [':user_id' => $userId];
        
        if ($status !== null) {
            $sql .= " AND l.status = :status";
            $params[':status'] = $status;
        }
        
        $sql .= " ORDER BY l.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Форматируем каждое объявление
        $formattedListings = [];
        foreach ($listings as $listing) {
            $formattedListings[] = $this->formatListing($listing);
        }
        
        return $formattedListings;
    }
function sanitizeMapCode($code) {
    if (empty($code)) return null;
    
    // Разрешаем только определенные теги и атрибуты
    $allowedTags = '<script><iframe><div><style>';
    $code = strip_tags($code, $allowedTags);
    
    // Дополнительная проверка для script тегов
    if (strpos($code, '<script') !== false) {
        // Проверяем, что это действительно код Яндекс Карт
        if (strpos($code, 'api-maps.yandex.ru') === false && 
            strpos($code, 'yandex.ru/map-constructor') === false &&
            strpos($code, 'yandex.st') === false) {
            // Если это не Яндекс Карты, очищаем
            $code = null;
        } else {
            // Добавляем атрибут async для правильной загрузки
            $code = str_replace('<script', '<script async', $code);
        }
    }
    
    return $code;
}
    public function getListingStats($userId) {
        $sql = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN status = 'published' THEN 1 ELSE 0 END) as published,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
            SUM(CASE WHEN status = 'expired' THEN 1 ELSE 0 END) as expired
            FROM listings 
            WHERE user_id = :user_id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    // Получить объявление по ID и ID пользователя
    public function getListingByIdForUser($listingId, $userId) {
        $stmt = $this->db->prepare("SELECT * FROM listings WHERE id = :id AND user_id = :user_id");
        $stmt->execute([':id' => $listingId, ':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Обновить объявление
    public function updateListing($listingId, $userId, $data) {
        $sql = "UPDATE listings SET 
                title = :title, 
                description = :description, 
                address = :address, 
                distance_to_sea = :distance_to_sea, 
                has_wifi = :has_wifi, 
                has_parking = :has_parking, 
                food_options = :food_options, 
                phone = :phone, 
                updated_at = NOW() 
                WHERE id = :id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'],
            ':address' => $data['address'],
            ':distance_to_sea' => $data['distance_to_sea'],
            ':has_wifi' => $data['has_wifi'] ? 1 : 0,
            ':has_parking' => $data['has_parking'] ? 1 : 0,
            ':food_options' => $data['food_options'],
            ':phone' => $data['phone'],
            ':id' => $listingId,
            ':user_id' => $userId
        ]);
    }

    // Удалить объявление
    public function deleteListing($listingId, $userId) {
        $sql = "DELETE FROM listings WHERE id = :id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $listingId, ':user_id' => $userId]);
    }
    // Получение статистики по статусам объявлений
    public function getListingsStats() {
        $sql = "SELECT 
                    status,
                    COUNT(*) as count
                FROM listings 
                GROUP BY status";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Преобразуем в удобный формат
        $stats = [
            'publishedpublished' => 0,
            'pending' => 0,
            'expired' => 0,
            'total' => 0
        ];
        
        foreach ($result as $row) {
            $stats[$row['status']] = (int)$row['count'];
            $stats['total'] += (int)$row['count'];
        }
        
        return $stats;
    }

    // Получение последних объявлений для админ-панели
    public function getRecentListings($limit = 10) {
        $sql = "SELECT 
                    l.*,
                    u.username,
                    c.name as category_name
                FROM listings l
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN categories c ON l.category_id = c.id
                ORDER BY l.created_at DESC 
                LIMIT :limit";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получение всех объявлений для страницы управления
    public function getAllListings($filters = []) {
        $sql = "SELECT 
                    l.*,
                    u.username,
                    u.email,
                    c.name as category_name,
                    sc.name as subcategory_name
                FROM listings l
                LEFT JOIN users u ON l.user_id = u.id
                LEFT JOIN categories c ON l.category_id = c.id
                LEFT JOIN categories sc ON l.subcategory_id = sc.id
                WHERE 1=1";
        
        $params = [];
        
        // Фильтр по статусу
        if (!empty($filters['status'])) {
            $sql .= " AND l.status = :status";
            $params[':status'] = $filters['status'];
        }
        
        // Фильтр по пользователю
        if (!empty($filters['user_id'])) {
            $sql .= " AND l.user_id = :user_id";
            $params[':user_id'] = $filters['user_id'];
        }
        
        $sql .= " ORDER BY l.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Обновление статуса объявления
    public function updateListingStatus($listingId, $status) {
        $sql = "UPDATE listings 
                SET status = :status, updated_at = NOW() 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':status' => $status,
            ':id' => $listingId
        ]);
    }

    // Удаление объявления
    public function deleteListingAdmin($listingId) {
        $sql = "DELETE FROM listings WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $listingId]);
    }

    public function getListingDetails($listingId) {
    // Сначала получаем основную информацию об объявлении
    $sql = "SELECT 
                l.*, 
                u.username, 
                u.email, 
                u.phone as user_phone,
                c.name as category_name, 
                sc.name as subcategory_name
            FROM listings l 
            LEFT JOIN users u ON l.user_id = u.id 
            LEFT JOIN categories c ON l.category_id = c.id 
            LEFT JOIN categories sc ON l.subcategory_id = sc.id 
            WHERE l.id = ?";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute([$listingId]);
    $listing = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($listing) {
        // Получаем фотографии отдельным запросом
        $listing['photos'] = $this->getAdminListingPhotos($listingId);
        $listing['main_photo'] = $this->getMainPhoto($listing['photos']);
        
        // Получение цен по месяцам
        $listing['prices'] = $this->getPrices($listingId);
        
        // Получение отзывов
        $listing['reviews'] = $this->getListingReviews($listingId);
    }
    
    return $listing;
}

/**
 * Получить главную фотографию из массива фото
 */
private function getMainPhoto($photos) {
    foreach ($photos as $photo) {
        if ($photo['is_main']) {
            return $photo['full_url'];
        }
    }
    
    // Если нет главной, возвращаем первую или дефолтную
    if (!empty($photos)) {
        return $photos[0]['full_url'];
    }
    
    return '/default-image.jpg';
}
    
    /**
     * Получить отзывы для объявления
     */
    private function getListingReviews($listingId) {
        $sql = "SELECT r.*, u.username 
                FROM reviews r 
                LEFT JOIN users u ON r.user_id = u.id 
                WHERE r.listing_id = ? 
                ORDER BY r.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$listingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Проверить существование объявления
     */
    public function listingExists($listingId) {
        $sql = "SELECT COUNT(*) FROM listings WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$listingId]);
        return $stmt->fetchColumn() > 0;
    }

    /**
 * Обновление объявления администратором
 */
public function updateListingAdmin($listingId, $data) {
    $sql = "UPDATE listings SET 
            title = :title,
            category_id = :category_id,
            subcategory_id = :subcategory_id,
            description = :description,
            address = :address,
            distance_to_sea = :distance_to_sea,
            phone = :phone,
            has_wifi = :has_wifi,
            has_parking = :has_parking,
            food_options = :food_options,
            max_adults = :max_adults,
            max_children = :max_children,
            max_guests_total = :max_guests_total,
            check_in_time = :check_in_time,
            check_out_time = :check_out_time,
            min_stay_nights = :min_stay_nights,
            registry_number = :registry_number,
            legal_form = :legal_form,
            status = :status,
            yandex_map_code = :yandex_map_code, 
            updated_at = NOW()
            WHERE id = :id";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        ':title' => $data['title'],
        ':category_id' => $data['category_id'],
        ':subcategory_id' => $data['subcategory_id'],
        ':description' => $data['description'],
        ':address' => $data['address'],
        ':distance_to_sea' => $data['distance_to_sea'],
        ':phone' => $data['phone'],
        ':has_wifi' => $data['has_wifi'],
        ':has_parking' => $data['has_parking'],
        ':food_options' => $data['food_options'],
        ':max_adults' => $data['max_adults'],
        ':max_children' => $data['max_children'],
        ':max_guests_total' => $data['max_guests_total'],
        ':check_in_time' => $data['check_in_time'],
        ':check_out_time' => $data['check_out_time'],
        ':min_stay_nights' => $data['min_stay_nights'],
        ':registry_number' => $data['registry_number'],
        ':legal_form' => $data['legal_form'],
        ':status' => $data['status'],
        ':yandex_map_code' => $data['yandex_map_code'],
        ':id' => $listingId
    ]);
}

/**
 * Удаление цен объявления
 */
public function deleteListingPrices($listingId) {
    $sql = "DELETE FROM listing_prices WHERE listing_id = ?";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$listingId]);
}

/**
 * Добавление цены
 */
public function addPrice($listingId, $month, $amount) {
    $sql = "INSERT INTO listing_prices (listing_id, month, amount) VALUES (?, ?, ?)";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([$listingId, $month, $amount]);
}

}
