<?php
// app/models/UploadModel.php
class UploadModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function saveListing($data) {
        try {
            $sql = "INSERT INTO listings_draft (
                user_id, category_id, subcategory_id, title, description, 
                address, phone, distance_to_sea, has_wifi, has_parking, 
                food_options, main_photo, photos, prices, registry_number, 
                legal_form, privacy_policy_accepted, personal_data_consent, status
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                $data['user_id'],
                $data['category_id'],
                $data['subcategory_id'],
                $data['title'],
                $data['description'],
                $data['address'],
                $data['phone'],
                $data['distance_to_sea'],
                $data['has_wifi'],
                $data['has_parking'],
                $data['food_options'],
                $data['main_photo'],
                $data['photos'],
                $data['prices'],
                $data['registry_number'],
                $data['legal_form'],
                $data['privacy_policy_accepted'],
                $data['personal_data_consent'],
                $data['status']
            ]);

        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function getListingById($id) {
        $sql = "SELECT * FROM listings_draft WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserListings($userId) {
        $sql = "SELECT * FROM listings_draft WHERE user_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}