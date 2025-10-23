<!-- app/views/listing_view.php -->
<?php 
/*if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Проверка на аутентификацию и роль admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}*/

?> 
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель - Управление объявлениями</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    
<style>
/* Кастомные скроллбары */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background: var(--primary-gradient);
    border-radius: 10px;
}

::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}
body {
    font-size: 0.875rem;
    padding-top: 70px;
    background: #f8fafc;
    font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
}

.feather {
    width: 16px;
    height: 16px;
    vertical-align: text-bottom;
}

.sidebar {
    position: fixed;
    top: 70px;
    bottom: 0;
    left: 0;
    z-index: 100;
    padding: 20px 0 0;
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
    height: calc(100vh - 70px);
    overflow-y: auto;
    width: 250px;
    background-color: #f8f9fa;
    transition: transform 0.3s ease-in-out;
}

.sidebar-sticky {
    position: relative;
    top: 0;
    height: calc(100vh - 120px);
    padding-top: .5rem;
    overflow-x: hidden;
    overflow-y: auto;
}

.sidebar .nav-link {
    font-weight: 500;
    color: #333;
    padding: 0.75rem 1.5rem;
}

.sidebar .nav-link.active {
    color: #007bff;
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
    padding: 0.75rem 1.5rem;
    color: #6c757d;
}

.navbar-brand {
    padding-top: .75rem;
    padding-bottom: .75rem;
    font-size: 1rem;
    background-color: rgba(0, 0, 0, .25);
    box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
}

.navbar {
    height: 70px;
    z-index: 1030;
}

.navbar .form-control {
    padding: .75rem 1rem;
    border-width: 0;
    border-radius: 0;
}

.form-control-dark {
    color: #fff;
    background-color: rgba(255, 255, 255, .1);
    border-color: rgba(255, 255, 255, .1);
}

.form-control-dark:focus {
    border-color: transparent;
    box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
}

.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }

main {
    margin-left: 250px;
    margin-top: 20px;
    width: calc(100% - 250px);
    padding: 20px;
    transition: margin-left 0.3s ease-in-out;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    margin-bottom: 1.5rem;
}

.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-secondary { border-left: 0.25rem solid #6c757d !important; }
.text-xs { font-size: 0.7rem; }
.text-gray-800 { color: #5a5c69 !important; }
.text-gray-300 { color: #dddfeb !important; }

.table-responsive {
    overflow-x: auto;
}

.btn-group .btn {
    margin-right: 2px;
}

/* Кнопка для мобильных устройств */
.sidebar-toggle {
    display: none;
    background: none;
    border: none;
    font-size: 1.5rem;
    color: #fff;
    margin-right: 15px;
}

/* Адаптивность для мобильных устройств */
@media (max-width: 767.98px) {
    body {
        padding-top: 60px;
    }
    
    .sidebar-toggle {
        display: block;
    }
    
    .sidebar {
        top: 60px;
        height: calc(100vh - 60px);
        width: 280px;
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
        box-shadow: 2px 0 10px rgba(0,0,0,0.1);
    }
    
    .navbar {
        height: 60px;
    }
    
    main {
        margin-left: 0;
        width: 100%;
        padding: 15px;
        transition: margin-left 0.3s ease-in-out;
    }
    
    /* Затемнение фона при открытом сайдбаре */
    .sidebar-backdrop {
        display: none;
        position: fixed;
        top: 60px;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0,0,0,0.5);
        z-index: 99;
    }
    
    .sidebar-backdrop.show {
        display: block;
    }
}

/* Дополнительные стили */
.login-body {
    background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
    height: 100vh;
    display: flex;
    align-items: center;
}

.login-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.card-link .card {
    transition: all 0.3s ease;
}

.card-link:hover .card {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
}

.map-container {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 15px 0;
}

.map-container iframe {
    width: 100%;
    border: none;
}

.map-preview {
    max-height: 300px;
    overflow-y: auto;
}

.photo-thumbnail {
    position: relative;
    cursor: pointer;
    transition: transform 0.2s;
}

.photo-thumbnail:hover {
    transform: scale(1.05);
}

.star-rating {
    font-size: 0.9em;
}

.amenities-list .badge {
    margin-right: 5px;
    margin-bottom: 5px;
    display: inline-block;
}
/* Стили для кнопок действий */
.action-buttons {
    display: grid;
    gap: 0.75rem;
}

.btn-modern {
    border: none;
    border-radius: 12px;
    padding: 0.875rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-gradient {
    background: var(--primary-gradient);
    color: white;
}

.btn-gradient:hover {
    color: white;
    background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
}
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --dark-gradient: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
    --card-shadow: 0 10px 30px rgba(0,0,0,0.1);
    --card-hover-shadow: 0 20px 40px rgba(0,0,0,0.15);
    --border-radius: 16px;
    --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <a class="navbar-brand ml-2" href="index.php?page=admin_dashboard">
                    <i class="fas fa-crown"></i> Админ-панель
                </a>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-shield"></i> Администратор
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="profile.php">
                                    <i class="fas fa-user"></i> Мой профиль
                                </a>
                                <a class="dropdown-item" href="settings.php">
                                    <i class="fas fa-cog"></i> Настройки
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="logout.php">
                                    <i class="fas fa-sign-out-alt"></i> Выйти
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="index.php?page=admin_dashboard">
                                <i class="fas fa-tachometer-alt"></i>
                                Панель управления
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=user_management">
                                <i class="fas fa-users"></i>
                                Отельеры / Гости
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=manage_listings">
                                <i class="fas fa-hotel"></i>
                                Объявления
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?page=categories_management">
                                <i class="fas fa-tags"></i>
                                Категории
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="reviews.php">
                                <i class="fas fa-star"></i>
                                Отзывы
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Система</span>
                    </h6>
                    
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="settings.php">
                                <i class="fas fa-cog"></i>
                                Настройки
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="backup.php">
                                <i class="fas fa-database"></i>
                                Резервные копии
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="logs.php">
                                <i class="fas fa-file-alt"></i>
                                Логи системы
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- Хлебные крошки -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php?page=admin_dashboard">Главная</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=manage_listings">Управление объявлениями</a></li>
        <li class="breadcrumb-item active">Просмотр объявления</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Просмотр объявления</h1>
    <a href="index.php?page=manage_listings" class="btn btn-modern btn-gradient">
        <i class="fas fa-arrow-left"></i> Назад к списку
    </a>
</div>

<!-- Сообщения -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['error_message'] ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<div class="row">
    <!-- Основная информация -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Основная информация</h5>
            </div>
            <div class="card-body">
                <div class="row mb mb-3">
                    <div class="col-md-6">
                        <strong>ID:</strong> <?= $listing['id'] ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Статус:</strong>
                        <span class="badge badge-<?= $listing['status_class'] ?>">
                            <?= $listing['status_label'] ?>
                        </span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Название:</strong>
                        <h4 class="mt-1"><?= htmlspecialchars($listing['title']) ?></h4>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-12">
                        <strong>Описание:</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            <?= nl2br(htmlspecialchars($listing['description'])) ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <strong>Адрес:</strong>
                        <p class="mt-1"><?= htmlspecialchars($listing['address']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Расстояние до моря:</strong>
                        <p class="mt-1"><?= $listing['distance_to_sea'] ? htmlspecialchars($listing['distance_to_sea']) : 'Не указано' ?></p>
                    </div>
                </div>
            </div>
        </div>
<!-- Цены по месяцам -->
    <div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Цены по месяцам</h5>
    </div>
    <div class="card-body">
        <?php if (!empty($listing['prices'])): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Месяц</th>
                            <th>Цена за ночь</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($listing['prices'] as $price): ?>
                            <tr>
                                <td><?= ucfirst(htmlspecialchars($price['month'])) ?></td>
                                <td class="text-primary font-weight-bold">
                                    <?= number_format($price['amount'], 0, ',', ' ') ?> ₽
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">Цены не указаны</p>
        <?php endif; ?>
    </div>
    </div>
        <!-- Фотографии -->
        <div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            Фотографии 
            <?php if (!empty($listing['display_photos'])): ?>
                (<?= count($listing['display_photos']) ?>)
            <?php endif; ?>
        </h5>
    </div>
    <div class="card-body">
        <?php if (!empty($listing['display_photos'])): ?>
            <div class="row">
                <?php foreach ($listing['display_photos'] as $index => $photo): ?>
                <div class="col-md-4 mb-3">
                    <div class="photo-thumbnail">
                        <img src="<?= htmlspecialchars($photo) ?>" 
                             alt="Фото <?= $index + 1 ?>" 
                             class="img-fluid rounded"
                             style="max-height: 200px; object-fit: cover; width: 100%;"
                             onerror="this.src='/default-image.jpg'">
                        <?php if ($photo === $listing['display_main_photo']): ?>
                            <span class="badge badge-primary position-absolute" style="top: 10px; right: 10px;">
                                Главная
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">Фотографии отсутствуют</p>
            <!-- Покажите все доступные фото из разных источников -->
            <?php if (!empty($listing['photos'])): ?>
                <div class="alert alert-warning">
                    <strong>Фото в photos массиве:</strong>
                    <div class="row">
                        <?php foreach ($listing['photos'] as $index => $photo): ?>
                        <div class="col-md-4 mb-3">
                            <img src="<?= htmlspecialchars($photo['full_url'] ?? $photo['photo_url']) ?>" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px; object-fit: cover; width: 100%;"
                                 onerror="this.src='/default-image.jpg'">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
        </div>

        <!-- Отзывы -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Отзывы</h5>
                <?php if ($listing['average_rating'] > 0): ?>
                    <span class="badge badge-warning">
                        Средний рейтинг: <?= $listing['average_rating'] ?>/5
                    </span>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($listing['reviews'])): ?>
                    <p class="text-muted">Отзывов пока нет</p>
                <?php else: ?>
                    <?php foreach ($listing['reviews'] as $review): ?>
                    <div class="review-item border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <strong><?= htmlspecialchars($review['username'] ?? 'Аноним') ?></strong>
                                <div class="star-rating small text-warning">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star<?= $i > $review['rating'] ? '-half-alt' : '' ?>"></i>
                                    <?php endfor; ?>
                                    <span class="ml-1">(<?= $review['rating'] ?>/5)</span>
                                </div>
                            </div>
                            <small class="text-muted">
                                <?= date('d.m.Y H:i', strtotime($review['created_at'])) ?>
                            </small>
                        </div>
                        <?php if (!empty($review['comment'])): ?>
                            <p class="mt-2 mb-0"><?= nl2br(htmlspecialchars($review['comment'])) ?></p>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Боковая панель -->
        <div class="col-lg-4">
        <!-- Информация об авторе -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Автор объявления</h5>
            </div>
            <div class="card-body">
                <p><strong>Имя пользователя:</strong><br><?= htmlspecialchars($listing['username']) ?></p>
                <p><strong>Email:</strong><br><?= htmlspecialchars($listing['email']) ?></p>
                <p><strong>Телефон:</strong><br><?= htmlspecialchars($listing['user_phone'] ?? 'Не указан') ?></p>
                
                <div class="mt-3">
                    <a href="index.php?page=user_management&search=<?= urlencode($listing['email']) ?>" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-user"></i> Управление пользователем
                    </a>
                </div>
            </div>
        </div>
            <!-- Блок с картой -->
        <?php if (!empty($listing['yandex_map_code'])): ?>
<div class="form-group">
    <h2>Расположение на карте</h2>
    <div class="map-container border p-3 bg-light">
        <?= $listing['yandex_map_code'] ?>
    </div>
    <div class="mt-2">
        <strong>Адрес:</strong> <?= htmlspecialchars($listing['address']) ?>
    </div>
</div>
        <?php endif; ?>
</div>



        <!-- Категории -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Категории</h5>
            </div>
            <div class="card-body">
                <p><strong>Основная категория:</strong><br><?= htmlspecialchars($listing['category_name']) ?></p>
                <p><strong>Подкатегория:</strong><br>
                    <?= $listing['subcategory_name'] ? htmlspecialchars($listing['subcategory_name']) : 'Не указана' ?>
                </p>
            </div>
        </div>

        <!-- Детали размещения -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Детали размещения</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 mb-2">
                        <small class="text-muted">Гостей всего</small><br>
                        <strong><?= $listing['max_guests_total'] ?></strong>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted">Взрослых</small><br>
                        <strong><?= $listing['max_adults'] ?></strong>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted">Детей</small><br>
                        <strong><?= $listing['max_children'] ?></strong>
                    </div>
                    <div class="col-6 mb-2">
                        <small class="text-muted">Мин. ночей</small><br>
                        <strong><?= $listing['min_stay_nights'] ?></strong>
                    </div>
                </div>
                
                <hr>
                
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Заезд</small><br>
                        <strong><?= substr($listing['check_in_time'], 0, 5) ?></strong>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Выезд</small><br>
                        <strong><?= substr($listing['check_out_time'], 0, 5) ?></strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- Удобства -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Удобства</h5>
            </div>
            <div class="card-body">
                <div class="amenities-list">
                    <?php if ($listing['has_wifi']): ?>
                        <span class="badge badge-success mb-1">Wi-Fi</span>
                    <?php endif; ?>
                    
                    <?php if ($listing['has_parking']): ?>
                        <span class="badge badge-success mb-1">Парковка</span>
                    <?php endif; ?>
                    
                    <?php if (!empty($listing['food_options'])): ?>
                        <span class="badge badge-info mb-1">Питание: <?= htmlspecialchars($listing['food_options']) ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Юридическая информация -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Юридическая информация</h5>
            </div>
            <div class="card-body">
                <p><strong>Форма деятельности:</strong><br><?= $listing['legal_form_label'] ?></p>
                
                <?php if (!empty($listing['registry_number'])): ?>
                    <p><strong>Рег. номер:</strong><br><?= htmlspecialchars($listing['registry_number']) ?></p>
                <?php endif; ?>
                
                <?php if (!empty($listing['admin_phone'])): ?>
                    <p><strong>Телефон администратора:</strong><br><?= htmlspecialchars($listing['admin_phone']) ?></p>
                <?php endif; ?>
                
                <div class="mt-2">
                    <?php if ($listing['privacy_policy_accepted']): ?>
                        <span class="badge badge-success">Политика конфиденциальности принята</span>
                    <?php endif; ?>
                    
                    <?php if ($listing['personal_data_consent']): ?>
                        <span class="badge badge-success">Согласие на обработку данных</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Даты -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Даты</h5>
            </div>
            <div class="card-body">
                <p><strong>Создано:</strong><br><?= $listing['created_at_formatted'] ?></p>
                <p><strong>Обновлено:</strong><br><?= $listing['updated_at_formatted'] ?></p>
            </div>
        </div>

        <!-- Действия -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Действия</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <!-- Изменение статуса -->
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" data-toggle="dropdown">
                            <i class="fas fa-cog"></i> Изменить статус
                        </button>
                        <div class="dropdown-menu w-100">
                            <form method="POST" action="index.php?page=update_listing_status">
                                <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                <button type="submit" name="status" value="published" 
                                        class="dropdown-item <?= $listing['status'] === 'published' ? 'active' : '' ?>">
                                    Опубликовать
                                </button>
                                <button type="submit" name="status" value="pending" 
                                        class="dropdown-item <?= $listing['status'] === 'pending' ? 'active' : '' ?>">
                                    На модерацию
                                </button>
                                <button type="submit" name="status" value="rejected" 
                                        class="dropdown-item <?= $listing['status'] === 'rejected' ? 'active' : '' ?>">
                                    Отклонить
                                </button>
                                <button type="submit" name="status" value="archived" 
                                        class="dropdown-item <?= $listing['status'] === 'archived' ? 'active' : '' ?>">
                                    В архив
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Редактирование -->
                    <a href="index.php?page=edit_listing_admin&id=<?= $listing['id'] ?>" 
                       class="btn btn-outline-warning">
                        <i class="fas fa-edit"></i> Редактировать
                    </a>
                    
                    <!-- Удаление -->
                    <form method="POST" action="index.php?page=delete_listing_admin" 
                          onsubmit="return confirm('Вы уверены, что хотите удалить это объявление?')">
                        <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash"></i> Удалить
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/ru.js"></script>
<script>
    // Обработка мобильного меню
$(document).ready(function() {
    // Переключение сайдбара на мобильных устройствах
    $('.navbar-toggler').click(function() {
        $('.sidebar').toggleClass('show');
    });
    
    // Закрытие сайдбара при клике на основной контент на мобильных
    $('main').click(function() {
        if ($(window).width() <= 767.98) {
            $('.sidebar').removeClass('show');
        }
    });
    
    // Обновление макета при изменении размера окна
    $(window).resize(function() {
        if ($(window).width() > 767.98) {
            $('.sidebar').removeClass('show');
        }
    });
});
// всплывающие подсказки Bootstrap
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

        // Обработка модального окна статуса
        $('#statusModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var listingId = button.data('id');
            var currentStatus = button.data('status');
            
            var modal = $(this);
            modal.find('#modalListingId').val(listingId);
            modal.find('#modalStatus').val(currentStatus);
        });
    </script>
</body>
</html>