<?php
// app/models/ListingModel.php
class ListingModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Получает объявления по ID подкатегории
     */
    public function getListingsBySubcategory($subcategoryId) {
        $stmt = $this->db->prepare("
            SELECT l.*, 
                   (SELECT photo_url FROM listing_photos WHERE listing_id = l.id AND is_main = 1 LIMIT 1) as main_photo,
                   (SELECT GROUP_CONCAT(photo_url) FROM listing_photos WHERE listing_id = l.id) as all_photos,
                   COUNT(DISTINCT r.id) as reviews_count
            FROM listings l
            LEFT JOIN reviews r ON l.id = r.listing_id
            WHERE l.subcategory_id = ? AND l.is_approved = 1
            GROUP BY l.id
            ORDER BY l.created_at DESC
        ");
        
        $stmt->execute([$subcategoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Получает цены для объявления
     */
    public function getListingPrices($listingId) {
        $stmt = $this->db->prepare("
            SELECT month, amount FROM listing_prices 
            WHERE listing_id = ? ORDER BY FIELD(month, 'май', 'июнь', 'июль', 'август', 'сентябрь')
        ");
        $stmt->execute([$listingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Форматирует данные объявлений для ответа
     */
    public function formatListings($listings) {
        $formattedListings = [];
        
        foreach ($listings as $listing) {
            $formattedListings[] = [
                'id' => $listing['id'],
                'title' => $listing['title'],
                'main_photo' => $listing['main_photo'] ?: '/default-image.jpg',
                'photos' => $listing['all_photos'] ? explode(',', $listing['all_photos']) : [],
                'distance_to_sea' => $listing['distance_to_sea'],
                'address' => $listing['address'],
                'has_parking' => (bool)$listing['has_parking'],
                'food_options' => $listing['food_options'],
                'phone' => $listing['phone'],
                'wifi_free' => true,
                'reviews_count' => $listing['reviews_count'],
                'prices' => $this->getListingPrices($listing['id'])
            ];
        }
        
        return $formattedListings;
    }
}