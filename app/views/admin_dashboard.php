<!-- app/views/admin_dashboard.php -->
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
    <title>Админ-панель - Главная</title>
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
                    <h1 class="h22">Панель управления</h1>
                </div>

                <!-- Статистика -->
                <div class="row">

                    <!-- Карточка Отельеры / Гости -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <a href="index.php?page=user_management" class="card-link text-decoration-none">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Отельеры / Гости</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                                            <?= htmlspecialchars($users_count ?? 0) ?>
                                        </div>
                                        <?php 
                                        $roleCounts = $this->userModel->getUsersCountByRole();
                                        ?>
                                        <small class="text-muted">
                                            Отельеры: <?= $roleCounts['hotelier'] ?> | 
                                            Гости: <?= $roleCounts['guest'] ?>
                                        </small>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-users fa-2xx text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                    <div class="col-xl-3 col-md-6 mb-4">
    <a href="index.php?page=manage_listings" class="card-link text-decoration-none">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Объявления</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?= htmlspecialchars($listings_stats['total'] ?? 0) ?>
                        </div>
                        <small class="text-muted">
                            Опубликовано: <?= $listings_stats['published'] ?? 0 ?> | 
                            На модерации: <?= $listings_stats['pending'] ?? 0 ?> | 
                            Истекли: <?= $listings_stats['expired'] ?? 0 ?>
                        </small>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-hotel fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <a href="index.php?page=categories_management" class="card-link">
        <div class="card border-left-secondary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">
                            Категории/Подкатегории</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800800">
                            <?= htmlspecialchars($categories_count ?? 0) ?> / <?= htmlspecialchars($subcategories_count ?? 0) ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tags fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>
                    
<div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Отзывы</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $reviews_count ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-star fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
                    </div>
                </div>


                <!-- Последние объявления -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Последние объявления</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="recentListingsTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Автор</th>
                                        <th>Статус</th>
                                        <th>Дата создания</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_listings as $listing): ?>
                                    <tr>
                                        <td><?= $listing['id'] ?></td>
                                        <td><?= htmlspecialchars($listing['title']) ?></td>
                                        <td><?= htmlspecialchars($listing['username']) ?></td>
                                        <td>
                                            <span class="badge badge-<?= 
                                                $listing['status'] === 'published' ? 'success' : 
                                                ($listing['status'] === 'pending' ? 'warning' : 'secondary')
                                            ?>">
                                                <?= $listing['status'] ?>
                                            </span>
                                        </td>
                                        <td><?= date('d.m.Y H:i', strtotime($listing['created_at'])) ?></td>
                                        <td>
                                            <a href="listings.php?action=edit&id=<?= $listing['id'] ?>" class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
</script>
</body>
</html>