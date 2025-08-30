<?php
// /app/models/BookingModel.php
class BookingModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function isListingAvailable($listingId, $checkInDate, $checkOutDate) {
        $query = "
            SELECT COUNT(*) as count
            FROM bookings 
            WHERE listing_id = ? 
            AND status = 'confirmed'
            AND (
                (check_in_date < ? AND check_out_date > ?) OR
                (check_in_date < ? AND check_out_date > ?) OR
                (check_in_date >= ? AND check_out_date <= ?)
            )
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "issssss",
            $listingId,
            $checkOutDate, $checkInDate,
            $checkInDate, $checkOutDate,
            $checkInDate, $checkOutDate
        );

        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result['count'] == 0;
    }

    public function getBookBookedDates($listingId) {
        $query = "
            SELECT check_in_date, check_out_date
            FROM bookings 
            WHERE listing_id = ? 
            AND status = 'confirmed'
            AND check_out_date >= CURDATE()
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $listingId);
        $stmt->execute();
        
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}