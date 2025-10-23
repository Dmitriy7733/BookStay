<?php
// /app/views/admin_listings_management.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление объявлениями - Админ-панель</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
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
    </style>
</head>
<body>
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
                            <a class="nav-link text-danger" href="index.php?page=logout">
                                <i class="fas fa-sign-out-alt"></i>
                                Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Управление объявлениями</h1>
        </div>

        <!-- Сообщения об успехе/ошибке -->
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

        <!-- Фильтры -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Фильтры</h6>
            </div>
            <div class="card-body">
                <form method="GET" class="form-inline">
                    <input type="hidden" name="page" value="manage_listings">
                    
                    <div class="form-group mr-3 mb-2">
                        <label for="status" class="mr-2">Статус:</label>
                        <select name="status" id="status" class="form-control form-control-sm">
                            <option value="">Все статусы</option>
                            <option value="published" <?= (isset($_GET['status']) && $_GET['status'] === 'published') ? 'selected' : '' ?>>Опубликовано</option>
                            <option value="pending" <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'selected' : '' ?>>На модерации</option>
                            <option value="rejected" <?= (isset($_GET['status']) && $_GET['status'] === 'rejected') ? 'selected' : '' ?>>Отклонено</option>
                            <option value="expired" <?= (isset($_GET['status']) && $_GET['status'] === 'expired') ? 'selected' : '' ?>>Истек срок</option>
                            <option value="archived" <?= (isset($_GET['status']) && $_GET['status'] === 'archived') ? 'selected' : '' ?>>В архиве</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-sm mb-2">
                        <i class="fas fa-filter"></i> Применить
                    </button>
                    <a href="index.php?page=manage_listings" class="btn btn-secondary btn-sm mb-2 ml-2">
                        <i class="fas fa-times"></i> Сбросить
                    </a>
                </form>
            </div>
        </div>

        <!-- Статистика -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">Всего</h6>
                        <h4><?= $stats['total'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">Опубликовано</h6>
                        <h4><?= $stats['published'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">На модерации</h6>
                        <h4><?= $stats['pending'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <h6 class="card-title">Истекли</h6>
                        <h4><?= $stats['expired'] ?? 0 ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Таблица объявлений -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Список объявлений</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Автор</th>
                                <th>Категория</th>
                                <th>Подкатегория</th>
                                <th>Статус</th>
                                <th>Дата создания</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                    <?php if (empty($listings)): ?>
                        <tr>
                            <td colspan="8" class="text-center">Объявления не найдены</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listings as $listing): ?>
                        <tr>
                            <td><?= $listing['id'] ?></td>
                            <td>
                                <strong><?= htmlspecialchars($listing['title']) ?></strong>
                            </td>
                            <td>
                                <?= htmlspecialchars($listing['username']) ?>
                                <br><small class="text-muted"><?= htmlspecialchars($listing['email']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($listing['category_name']) ?></td>
                            <td>
                                <?= !empty($listing['subcategory_name']) ? htmlspecialchars($listing['subcategory_name']) : '<span class="text-muted">—</span>' ?>
                            </td>
                            <td>
                                <span class="badge badge-<?= 
                                    $listing['status'] === 'published' ? 'success' : 
                                    ($listing['status'] === 'pending' ? 'warning' : 
                                    ($listing['status'] === 'draft' ? 'secondary' : 
                                    ($listing['status'] === 'rejected' ? 'danger' : 
                                    ($listing['status'] === 'expired' ? 'dark' : 'info'))))
                                ?> status-badge">
                                    <?= $listing['status'] ?>
                                </span>
                            </td>
                            <td><?= date('d.m.Y H:i', strtotime($listing['created_at'])) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <!-- Изменение статуса -->
                                    <div class="dropdown">
                                        <button class="btn btn-outline-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                            <i class="fas fa-cog"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <form method="POST" action="index.php?page=update_listing_status" style="display: inline;">
                                                <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                                <button type="submit" name="status" value="published" class="dropdown-item <?= $listing['status'] === 'published' ? 'active' : '' ?>">
                                                    Опубликовать
                                                </button>
                                                <button type="submit" name="status" value="pending" class="dropdown-item <?= $listing['status'] === 'pending' ? 'active' : '' ?>">
                                                    На модерацию
                                                </button>
                                                <button type="submit" name="="status" value="rejected" class="dropdown-item <?= $listing['status'] === 'rejected' ? 'active' : '' ?>">
                                                    Отклонить
                                                </button>
                                                <button type="submit" name="status" value="archived" class="dropdown-item <?= $listing['status'] === 'archived' ? 'active' : '' ?>">
                                                    В архив
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Просмотр -->
                                    <a href="index.php?page=view_listing&id=<?= $listing['id'] ?>" class="btn btn-outline-info" title="Просмотр">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    <!-- Редактирование -->
                                    <a href="index.php?page=edit_listing_admin&id=<?= $listing['id'] ?>" class="btn btn-outline-warning" title="Редактировать">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Удаление -->
                                    <form method="POST" action="index.php?page=delete_listing_admin" style="display: inline;" onsubmit="return confirm('Вы уверены, что хотите удалить это объявление?')">
                                        <input type="hidden" name="listing_id" value="<?= $listing['id'] ?>">
                                        <button type="submit" class="btn btn-outline-danger" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                    </table>
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
</script>
</body>
</html>