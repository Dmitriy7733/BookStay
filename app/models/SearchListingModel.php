<?php
class SearchListingModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function searchListings($cityId, $checkInDate, $checkOutDate, $adults, $children, $page = 1, $limit = 12) {
        $offset = ($page - 1) * $limit;
        $totalGuests = $adults + $children;

        // Основной запрос поиска
        $query = "
            SELECT 
                l.*,
                c.name as city_name,
                cat.name as category_name,
                (SELECT GROUP_CONCAT(li.filename) 
                 FROM listing_images li 
                 WHERE li.listing_id = l.id 
                 LIMIT 1) as main_image,
                COALESCE((
                    SELECT lp.price_per_night 
                    FROM listing_prices lp 
                    WHERE lp.listing_id = l.id 
                    AND lp.start_date <= ? 
                    AND lp.end_date >= ? 
                    LIMIT 1
                ), l.price_per_night) as current_price,
                DATEDIFF(?, ?) as nights_count
            FROM listings l
            JOIN categories c ON l.city_id = c.id
            JOIN categories cat ON l.category_id = cat.id
            WHERE l.is_approved = 1
            AND l.city_id = ?
            AND l.max_guests_total >= ?
            AND l.max_adults >= ?
            AND l.id NOT IN (
                SELECT DISTINCT b.listing_id 
                FROM bookings b 
                WHERE b.status = 'confirmed'
                AND (
                    (b.check_in_date < ? AND b.check_out_date > ?) OR
                    (b.check_in_date < ? AND b.check_out_date > ?) OR
                    (b.check_in_date >= ? AND b.check_out_date <= ?)
                )
            )
            ORDER BY l.created_at DESC
            LIMIT ? OFFSET ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "ssssiiissssssii",
            $checkInDate, $checkInDate,
            $checkOutDate, $checkInDate,
            $cityId,
            $totalGuests,
            $adults,
            $checkOutDate, $checkInDate,
            $checkInDate, $checkOutDate,
            $checkInDate, $checkOutDate,
            $limit, $offset
        );

        $stmt->execute();
        $result = $stmt->get_result();
        $listings = $result->fetch_all(MYSQLI_ASSOC);

        // Получаем общее количество
        $countQuery = "
            SELECT COUNT(*) as total 
            FROM listings l
            WHERE l.is_approved = 1
            AND l.city_id = ?
            AND l.max_guests_total >= ?
            AND l.max_adults >= ?
            AND l.id NOT IN (
                SELECT DISTINCT b.listing_id 
                FROM bookings b 
                WHERE b.status = 'confirmed'
                AND (
                    (b.check_in_date < ? AND b.check_out_date > ?) OR
                    (b.check_in_date < ? AND b.check_out_date > ?) OR
                    (b.check_in_date >= ? AND b.check_out_date <= ?)
                )
            )
        ";

        $countStmt = $this->db->prepare($countQuery);
        $countStmt->bind_param(
            "iiissssss",
            $cityId,
            $totalGuests,
            $adults,
            $checkOutDate, $checkInDate,
            $checkInDate, $checkOutDate,
            $checkInDate, $checkOutDate
        );

        $countStmt->execute();
        $totalResult = $countStmt->get_result();
        $total = $totalResult->fetch_assoc()['total'];

        return [
            'listings' => $listings,
            'total' => $total
        ];
    }

    public function getListingById($id) {
        $query = "
            SELECT l.*, c.name as city_name, cat.name as category_name
            FROM listings l
            JOIN categories c ON l.city_id = c.id
            JOIN categories cat ON l.category_id = cat.id
            WHERE l.id = ? AND l.is_approved = 1
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_assoc();
    }
}