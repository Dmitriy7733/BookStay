<?php
// /app/views/admin_edit_listing.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование объявления - Админ-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        .map-container {
    border-radius: 8px;
    overflow: hidden;
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
body {
    font-size: 0.875rem;
    padding-top: 70px;
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
    width: 250px; /* Добавляем фиксированную ширину */
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
}

.sidebar .nav-link.active {
    color: #007bff;
}

.sidebar-heading {
    font-size: .75rem;
    text-transform: uppercase;
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
    margin-left: 250px; /* Отступ равен ширине сайдбара */
    margin-top: 20px;
    width: calc(100% - 250px); /* Ширина минус сайдбар */
    padding: 20px;
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

/* Адаптивность для мобильных устройств */
@media (max-width: 767.98px) {
    body {
        padding-top: 60px;
    }
    
    .sidebar {
        top: 60px;
        height: calc(100vh - 60px);
        width: 100%; /* На мобильных сайдбар занимает всю ширину */
        transform: translateX(-100%); /* Скрываем за экраном */
        transition: transform 0.3s ease;
    }
    
    .sidebar.show {
        transform: translateX(0); /* Показываем сайдбар */
    }
    
    .navbar {
        height: 60px;
    }
    
    /* На мобильных основной контент занимает всю ширину */
    main {
        margin-left: 0;
        width: 100%;
        padding: 15px;
    }
}

/* Дополнительные стили для лучшего отображения */
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
 .required-field::after {
            content: " *";
            color: red;
        }
        .form-section {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #007bff;
        }
        .section-title {
            color: #495057;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .photo-preview {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
        }
        .photo-item {
            position: relative;
            display: inline-block;
            margin: 5px;
        }
        .delete-photo-btn {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            font-size: 14px;
            cursor: pointer;
        }
    </style>
    
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Верхняя навигационная панель -->
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
                                <a class="dropdown-item text-danger" href="index.php?page=logout">
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
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Редактирование объявления</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="index.php?page=manage_listings" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left"></i> Назад к списку
                </a>
                <a href="index.php?page=view_listing&id=<?= $listing['id'] ?>" class="btn btn-info">
                    <i class="fas fa-eye"></i> Просмотр
                </a>
            </div>
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

        <form id="editListingForm" method="POST" action="index.php?page=update_listing_admin" enctype="multipart/form-data">
            <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
            
            <!-- Секция статуса -->
            <div class="form-section">
                <h4 class="section-title">Статус объявления</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Статус</label>
                            <select name="status" class="form-control">
                                <option value="published" <?= $listing['status'] === 'published' ? 'selected' : '' ?>>Опубликовано</option>
                                <option value="pending" <?= $listing['status'] === 'pending' ? 'selected' : '' ?>>На модерации</option>
                                <option value="rejected" <?= $listing['status'] === 'rejected' ? 'selected' : '' ?>>Отклонено</option>
                                <option value="archived" <?= $listing['status'] === 'archived' ? 'selected' : '' ?>>В архиве</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Автор</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($listing['username']) ?> (<?= htmlspecialchars($listing['email']) ?>)" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Секция 1: Основная информация -->
            <div class="form-section">
                <h4 class="section-title">Основная информация</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="categorySelect" class="required-field">Категория</label>
                            <select class="form-control" id="categorySelect" name="category_id" required>
                                <option value="">-- Выберите категорию --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" 
                                        <?= $category['id'] == $listing['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="subcategorySelect" class="required-field">Подкатегория</label>
                            <select class="form-control" id="subcategorySelect" name="subcategory_id" required>
                                <option value="">-- Выберите подкатегорию --</option>
                                <?php foreach ($subcategories as $subcategory): ?>
                                    <option value="<?= $subcategory['id'] ?>" 
                                        <?= $subcategory['id'] == $listing['subcategory_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($subcategory['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="required-field">Название отеля</label>
                            <input type="text" name="title" class="form-control" 
                                   value="<?= htmlspecialchars($listing['title']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="required-field">Адрес</label>
                            <textarea name="address" class="form-control" rows="2" required><?= htmlspecialchars($listing['address']) ?></textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Описание</label>
                            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($listing['description']) ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="required-field">Телефон</label>
                            <input type="text" name="phone" class="form-control" 
                                   value="<?= htmlspecialchars($listing['phone']) ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="required-field">Расстояние до моря</label>
                            <input type="text" name="distance_to_sea" class="form-control" 
                                   value="<?= htmlspecialchars($listing['distance_to_sea']) ?>" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Секция 2: Вместимость и время заезда -->
            <div class="form-section">
                <h4 class="section-title">Вместимость и время заезда</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Максимум взрослых</label>
                            <input type="number" name="max_adults" class="form-control" min="0" 
                                   value="<?= $listing['max_adults'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Максимум детей</label>
                            <input type="number" name="max_children" class="form-control" min="0" 
                                   value="<?= $listing['max_children'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Максимум гостей всего</label>
                            <input type="number" name="max_guests_total" class="form-control" min="0" 
                                   value="<?= $listing['max_guests_total'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Время заезда</label>
                            <input type="time" name="check_in_time" class="form-control" 
                                   value="<?= $listing['check_in_time'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Время выезда</label>
                            <input type="time" name="check_out_time" class="form-control" 
                                   value="<?= $listing['check_out_time'] ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Минимальное количество ночей</label>
                            <input type="number" name="min_stay_nights" class="form-control" min="1" 
                                   value="<?= $listing['min_stay_nights'] ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Секция 3: Удобства -->
            <div class="form-section">
                <h4 class="section-title">Удобства и услуги</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check mb-2">
                            <input type="checkbox" name="wifi_free" class="form-check-input" 
                                   <?= $listing['has_wifi'] ? 'checked' : '' ?>>
                            <label class="form-check-label">Бесплатный Wi-Fi</label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="checkbox" name="has_parking" class="form-check-input" 
                                   <?= $listing['has_parking'] ? 'checked' : '' ?>>
                            <label class="form-check-label">Парковка</label>
                        </div>

                        <div class="form-group">
                            <label>Питание</label>
                            <select name="food_options" class="form-control">
                                <option value="Без питания" <?= $listing['food_options'] === 'Без питания' ? 'selected' : '' ?>>Без питания</option>
                                <option value="Завтрак" <?= $listing['food_options'] === 'Завтрак' ? 'selected' : '' ?>>Завтрак</option>
                                <option value="Полупансион" <?= $listing['food_options'] === 'Полупансион' ? 'selected' : '' ?>>Полупансион</option>
                                <option value="Полный пансион" <?= $listing['food_options'] === 'Полный пансион' ? 'selected' : '' ?>>Полный пансион</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <!-- Существующие фото -->
                        <div class="form-group">
                            <label>Текущие фотографии</label>
                            <div id="currentPhotos" class="mt-2">
                                <?php if (!empty($listing['photos'])): ?>
                                    <?php foreach ($listing['photos'] as $photo): ?>
                                        <div class="photo-item">
                                            <img src="<?= $photo['full_url'] ?>" class="photo-preview img-thumbnail">
                                            <button type="button" class="delete-photo-btn" 
                                                    onclick="markPhotoForDeletion(<?= $photo['id'] ?>)">
                                                ×
                                            </button>
                                            <input type="hidden" name="delete_photos[]" value="" id="delete_photo_<?= $photo['id'] ?>">
                                            <?php if ($photo['is_main']): ?>
                                                <small class="d-block text-center text-success">Главное</small>
                                            <?php endif; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">Фотографии отсутствуют</p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Новое главное фото -->
                        <div class="form-group">
                            <label>Новое главное фото</label>
                            <input type="file" name="main_photo" class="form-control" accept="image/*">
                            <small class="form-text text-muted">Заменит текущее главное фото</small>
                        </div>

                        <!-- Дополнительные фото -->
                        <div class="form-group">
                            <label>Дополнительные фото</label>
                            <input type="file" name="photos[]" class="form-control" accept="image/*" multiple>
                            <small class="form-text text-muted">Можно выбрать несколько файлов</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Секция 4: Цены по месяцам -->
            <div class="form-section">
                <h4 class="section-title">Цены за номер (руб.)</h4>
                <div class="row">
                    <?php
                    $months = [
                        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
                        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
                    ];
                    $currentPrices = [];
                    foreach ($listing['prices'] as $price) {
                        $currentPrices[$price['month']] = $price['amount'];

                    }
                    
                    foreach ($months as $month): ?>
                    <div class="col-md-3 mb-2">
                        <label><?= $month ?></label>
                        <input type="number" name="prices[<?= $month ?>]" class="form-control price-input" 
                               min="0" placeholder="0" 
                               value="<?= $currentPrices[$month] ?? '' ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

<!-- Секция 6: Яндекс Карты -->
<div class="form-section">
    <h4 class="section-title">Интеграция с Яндекс Картами</h4>
    
    <div class="alert alert-info">
        <strong>Инструкция:</strong>
        <ol class="mb-0">
            <li>Перейдите на <a href="yabrowser://yandex.ru/map-constructor/" target="_blank">Конструктор Яндекс Карт</a></li>
            <li>В случае невозможности перехода по прямой ссылке для открытия ссылки в Яндекс.Браузере, 
                скопируйте ссылку https://yandex.ru/map-constructor/ и откройте ее в Яндекс.Браузере вручную</li>
            <li>Найдите адрес/введите в поиске: <strong><?= htmlspecialchars($listing['address']) ?></strong></li>
            <li>Нажмите "Добавить метку" и разместите её на карте</li>
            <li>В правой панели настройте размер карты (рекомендуется 600x400)</li>
            <li>Нажмите "Сохранить и получить код"</li>
            <li>Выберите "JavaScript API" и скопируйте весь код</li>
            <li>Вставьте скопированный код в поле ниже</li>
        </ol>
    </div>

    <div class="form-group">
        <label for="yandexMapCode">Код Яндекс Карты</label>
        <textarea name="yandex_map_code" class="form-control" rows="8" 
                  placeholder="Вставьте сюда JavaScript код из конструктора Яндекс Карт"
                  id="yandexMapCode"><?= htmlspecialchars($listing['yandex_map_code'] ?? '') ?></textarea>
        <small class="form-text text-muted">
            Код будет отображаться на странице объявления после публикации
        </small>
    </div>

    <!-- Предпросмотр карты (если код уже есть) -->
    <?php if (!empty($listing['yandex_map_code'])): ?>
    <div class="form-group">
        <label>Предпросмотр карты:</label>
        <div class="map-preview border p-3 bg-light">
            <small class="text-muted">Предпросмотр (полная функциональность будет на странице объявления):</small>
            <div class="mt-2">
                <?= $listing['yandex_map_code'] ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
            <!-- Секция 5: Юридическая информация -->
            <div class="form-section">
                <h4 class="section-title">Юридическая информация</h4>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Номер в едином реестре объектов классификации</label>
                            <input type="text" name="registry_number" class="form-control" 
                                   value="<?= htmlspecialchars($listing['registry_number'] ?? '') ?>" 
                                   placeholder="Если имеется">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Организационно-правовая форма форма</label>
                            <select name="legal_form" class="form-control">
                                <option value="">-- Выберите форму --</option>
                                <option value="self_employed" <?= $listing['legal_form'] === 'self_employed' ? 'selected' : '' ?>>Самозанятый</option>
                                <option value="individual_entrepreneur" <?= $listing['legal_form'] === 'individual_entrepreneur' ? 'selected' : '' ?>>Индивидуальный предприниматель (ИП)</option>
                                <option value="legal_entity" <?= $listing['legal_form'] === 'legal_entity' ? 'selected' : '' ?>>Юридическое лицо</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-save"></i> Сохранить изменения
                </button>
                <a href="index.php?page=edit_listing_admin" class="btn btn-secondary btn-lg">
                    <i class="fas fa-times"></i> Отмена
                </a>
            </div>
        </form>
    </main>
</div>
</div>
<footer class="bg-secondary text-black text-center py-2">
    <div class="container">
        <p class="mb-0">&copy; 2025 Отдых на курортах России без посредников. Дмитрий Попов.</p>
    </div>
</footer>
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
    // Загрузка подкатегорий при изменении категории
    $('#categorySelect').change(function() {
        const categoryId = $(this).val();
        const subcategorySelect = $('#subcategorySelect');
        
        subcategorySelect.html('<option value="">-- Выберите подкатегорию --</option>');
        
        if (!categoryId) return;
        
        $.get(`index.php?page=get_subcategories&category_id=${categoryId}`, function(subcategories) {
            if (subcategories.error) {
                console.error('Ошибка:', subcategories.error);
                return;
            }
            
            subcategories.forEach(function(subcategory) {
                subcategorySelect.append(
                    $('<option>', {
                        value: subcategory.id,
                        text: subcategory.name
                    })
                );
            });
        }).fail(function(error) {
            console.error('Ошибка загрузки подкатегорий:', error);
        });
    });

    // Отметка фото для удаления
    function markPhotoForDeletion(photoId) {
        const input = $(`#delete_photo_${photoId}`);
        const photoItem = input.closest('.photo-item');
        
        if (input.val() === '') {
            // Помечаем для удаления
            input.val(photoId);
            photoItem.find('img').css('opacity', '0.5');
            photoItem.find('.delete-photo-btn').html('✓').removeClass('btn-danger').addClass('btn-success');
        } else {
            // Снимаем отметку
            input.val('');
            photoItem.find('img').css('opacity', '1');
            photoItem.find('.delete-photo-btn').html('×').removeClass('btn-success').addClass('btn-danger');
        }
    }

    // Валидация формы
    $('#editListingForm').submit(function(e) {
        let isValid = true;
        
        // Проверка обязательных полей
        $('[required]').each(function() {
            if (!$(this).val().trim()) {
                isValid = false;
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Пожалуйста, заполните все обязательные поля');
        }
    });
    </script>
</body>
</html>