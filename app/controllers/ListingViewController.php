<?php
// /app/controllers/ListingViewController.php

require_once __DIR__ . '/../models/ListingModel.php';

class ListingViewController {
    private $db;
    private $listingModel;
    
    public function __construct($db) {
        $this->db = $db;
        $this->listingModel = new ListingModel($db);
    }
    
    /**
     * Просмотр детальной информации об объявлении
     */
    public function viewListing() {
        // Проверка прав доступа (только для администраторов)
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            $_SESSION['error_message'] = 'Доступ запрещен';
            header('Location: index.php');
            exit;
        }
        
        // Получение ID объявления
        $listingId = $_GET['id'] ?? null;
        
        if (!$listingId) {
            $_SESSION['error_message'] = 'ID объявления не указан';
            header('Location: index.php?page=manage_listings');
            exit;
        }
        
        // Проверка существования объявления
        if (!$this->listingModel->listingExists($listingId)) {
            $_SESSION['error_message'] = 'Объявление не найдено';
            header('Location: index.php?page=manage_listings');
            exit;
        }
        
        // Получение детальной информации
        $listing = $this->listingModel->getListingDetails($listingId);
        
        if (!$listing) {
            $_SESSION['error_message'] = 'Ошибка при загрузке данных объявления';
            header('Location: index.php?page=manage_listings');
            exit;
        }
        
        // Подготовка данных для отображения
        $viewData = $this->prepareViewData($listing);
        
        // Отображение страницы
        $this->renderView($viewData);
    }
    
    /**
     * Подготовка данных для отображения
     */
    private function prepareViewData($listing) {
    // Форматирование статуса
    $statusLabels = [
        'published' => ['label' => 'Опубликовано', 'class' => 'success'],
        'pending' => ['label' => 'На модерации', 'class' => 'warning'],
        'draft' => ['label' => 'Черновик', 'class' => 'secondary'],
        'rejected' => ['label' => 'Отклонено', 'class' => 'danger'],
        'expired' => ['label' => 'Истек срок', 'class' => 'dark'],
        'archived' => ['label' => 'В архиве', 'class' => 'info']
    ];
    
    $listing['status_label'] = $statusLabels[$listing['status']]['label'] ?? $listing['status'];
    $listing['status_class'] = $statusLabels[$listing['status']]['class'] ?? 'secondary';
    
    // Форматирование юридической формы
    $legalForms = [
        'self_employed' => 'Самозанятый',
        'legal_entity' => 'Юридическое лицо',
        'individual_entrepreneur' => 'Индивидуальный предприниматель'
    ];
    
    $listing['legal_form_label'] = $legalForms[$listing['legal_form']] ?? 'Не указано';
    
    // Форматирование времени
    $listing['created_at_formatted'] = date('d.m.Y H:i', strtotime($listing['created_at']));
    $listing['updated_at_formatted'] = $listing['updated_at'] ? 
        date('d.m.Y H:i', strtotime($listing['updated_at'])) : 'Не обновлялось';
    
    // Расчет среднего рейтинга
    $totalRating = 0;
    $reviewCount = count($listing['reviews']);
    foreach ($listing['reviews'] as $review) {
        $totalRating += $review['rating'];
    }
    $listing['average_rating'] = $reviewCount > 0 ? round($totalRating / $reviewCount, 1) : 0;
    
    // Обработка фотографий
    $listing['display_photos'] = [];
    if (!empty($listing['photos'])) {
        foreach ($listing['photos'] as $photo) {
            $listing['display_photos'][] = $photo['full_url'];
        }
    }
    
    // Главная фото для отображения
    $listing['display_main_photo'] = $listing['main_photo'] ?? '';
    
    return [
        'listing' => $listing,
        'page_title' => 'Просмотр объявления: ' . htmlspecialchars($listing['title'])
    ];
}
    
    /**
     * Отображение страницы
     */
    private function renderView($data) {
        extract($data);
        require_once __DIR__ . '/../views/listing_view.php';
    }
}