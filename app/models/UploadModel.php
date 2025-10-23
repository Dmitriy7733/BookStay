<?php
// app/models/UploadModel.php
class UploadModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function saveMainListing($data, $mainPhoto) {
        $sql = "INSERT INTO listings (
            user_id, category_id, subcategory_id, title, description, 
            address, phone, distance_to_sea, max_adults, max_children,
            max_guests_total, check_in_time, check_out_time, min_stay_nights,
            has_wifi, has_parking, food_options, registry_number, 
            legal_form, privacy_policy_accepted, personal_data_consent, status
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);
        
        $stmt->execute([
            $data['user_id'],
            $data['category_id'],
            $data['subcategory_id'],
            $data['title'],
            $data['description'],
            $data['address'],
            $data['phone'],
            $data['distance_to_sea'],
            $data['max_adults'],
            $data['max_children'],
            $data['max_guests_total'],
            $data['check_in_time'],
            $data['check_out_time'],
            $data['min_stay_nights'],
            $data['has_wifi'],
            $data['has_parking'],
            $data['food_options'],
            $data['registry_number'],
            $data['legal_form'],
            $data['privacy_policy_accepted'],
            $data['personal_data_consent'],
            $data['status']
        ]);

        $listingId = $this->db->lastInsertId();

        // Сохраняем главное фото
        if ($mainPhoto) {
            $this->saveMainPhoto($listingId, $mainPhoto);
        }

        return $listingId;
    }

    private function saveMainPhoto($listingId, $photoPath) {
        $sql = "INSERT INTO listing_photos (listing_id, photo_url, is_main, upload_order) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$listingId, $photoPath, 1, 0]);
    }

    public function saveAdditionalPhotos($listingId, $photos) {
        $sql = "INSERT INTO listing_photos (listing_id, photo_url, is_main, upload_order) VALUES ";
        $values = [];
        $params = [];
        $order = 0;

        foreach ($photos as $photo) {
            $values[] = "(?, ?, ?, ?)";
            $params[] = $listingId;
            $params[] = $photo;
            $params[] = 0; // не главное фото
            $params[] = $order++;
        }

        $sql .= implode(", ", $values);
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }

    public function savePrices($listingId, $prices) {
        $sql = "INSERT INTO listing_prices (listing_id, month, amount) VALUES ";
        $values = [];
        $params = [];

        foreach ($prices as $month => $amount) {
            if (!empty($amount)) {
                $values[] = "(?, ?, ?)";
                $params[] = $listingId;
                $params[] = $month;
                $params[] = $amount;
            }
        }

        if (!empty($values)) {
            $sql .= implode(", ", $values);
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
        }
    }
// Методы для получения данных
public function getListingById($id) {
        $sql = "SELECT l.*, 
                       (SELECT COUNT(*) FROM reviews WHERE listing_id = l.id) as reviews_count
                FROM listings l WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserListings($userId) {
        $sql = "SELECT l.*, 
                       (SELECT COUNT(*) FROM reviews WHERE listing_id = l.id) as reviews_count
                FROM listings l WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListingPhotos($listingId) {
        $sql = "SELECT * FROM listing_photos WHERE listing_id = ? ORDER BY is_main DESC, upload_order ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$listingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getListingPrices($listingId) {
        $sql = "SELECT * FROM listing_prices WHERE listing_id = ? ORDER BY FIELD(month, 
                'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
                'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь')";
        $stmt = $this->db->prepareprepare($sql);
        $stmt->execute([$listingId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}