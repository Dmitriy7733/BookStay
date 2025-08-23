<!-- app/views/home.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <title>Инструкции для техники</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        
        body {
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Это позволит футеру оставаться внизу */
    min-height: 100vh;
    background-color: #f8f9fa;
    color: #333;
    padding: 20px;
    background-image: url('app/includes/front2.png'); /* Укажите путь к вашему изображению */
    background-size: cover; /* Изображение будет покрывать весь доступный фон */
    background-position: center; /* Центрируем изображение */
    background-repeat: no-repeat; /* Не повторяем изображение */
    overflow-x: hidden; /* Скрыть горизонтальный скроллинг */
}
/* Стили для навигационного меню */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .header p {
            color: #7f8c8d;
            font-size: 18px;
        }
        
        /* Основной контейнер меню */
        .nav {
            color: #fff;
            display: block;
            z-index: 1000;
            position: relative;
            background: #0792fe;
        }
        /*Контейнер для элементов навигации*/
        .nav__container {
            height: 50px;
            position: relative;
        }
        
        /*Гибкий контейнер для выравнивания элементов*/
        .nav__fluid {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: absolute;
            display: flex;
            align-items: center;
        }
        /*Контейнер для слайдера с категориями*/
        .nav__fluid_slider {
            flex-grow: 1;
            overflow: visible;
            height: 50px;
        }
        /*Стили для ссылок в меню*/
        .nav__fluid_slider a {
            color: #fff;
            padding: 15px 5px;
            position: relative;
            white-space: nowrap;
            display: inline-block;
            text-decoration: none;
        }
        
        .nav__fluid_slider a i {
            margin-left: 8px;
        }
        
        .nav__fluid_slider a:hover {
            color: #fff;
            text-decoration: none;
        }
        
        .nav__fluid_slider a:hover span {
            text-decoration: underline;
        }
        /*Стили для стрелок навигации*/
        .nav__arrow {
            top: 0;
            color: #fff;
            width: 50px;
            height: 50px;
            z-index: 300;
            padding: 10px 0;
            display: block;
            font-size: 0;
            line-height: 0;
            position: absolute;
        }
        
        .nav__arrow a {
            padding: 8px 0;
            width: 30px;
            height: 30px;
            color: #0792fe;
            cursor: pointer;
            font-size: 14px;
            line-height: 14px;
            background: #fff;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            border-radius: 50%;
        }
        
        .nav__arrow a:hover {
            color: #0792fe;
            text-decoration: none;
        }
        
        .nav__arrow_prev {
            left: 0px;
            text-align: left;
            background: #0792fe;
        }
        
        .nav__arrow_next {
            right: -1px;
            text-align: right;
            background: #0792fe;
        }
        
        /* Стили для выпадающих подменю */
        .ul_second_nav {
            display: none !important;
            position: absolute;
            top: 33px;
            background-color: #fff;
            border: 1px solid rgb(100, 139, 183);
            z-index: 99999999;
            list-style-type: none;
            padding: 10px 0;
            width: 200px;
            border-radius: 4px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .parent1:hover .ul_second_nav {
            display: block !important;
            top: 49px;
        }
        
        .swiper-slide:hover .ul_second_nav {
            display: block !important;
        }
        /*Стили для ссылок в подменю*/
        .link_in_nav {
            color: #2656a2 !important;
            padding: 8px 15px !important;
            text-transform: none;
            display: block;
            text-decoration: none;
        }
        
        .link_in_nav:hover {
            color: #051b62 !important;
            background-color: #f0f5ff;
        }
        
        /* Административная панель */
        .admin-panel {
            background-color: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        
        .admin-panel h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ecf0f1;
        }
        
        .admin-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #2c3e50;
            font-weight: 500;
        }
        
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        
        .form-group input:focus, .form-group select:focus {
            border-color: #3498db;
            outline: none;
        }
        
        .btn {
            padding: 12px 20px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: background-color 0.3s ease;
        }
        
        .btn:hover {
            background-color: #2980b9;
        }
        
        .code-block {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
            overflow-x: auto;
            font-family: 'Courier New', monospace;
        }
        
        .code-block h3 {
            margin-bottom: 15px;
            color: #3498db;
        }
        
        /* Стили для Swiper слайдов */
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        
        .swiper-slide {
            width: auto;
            display: flex;
            align-items: center;
            position: relative;
        }
        /*Адаптивные стили для мобильных устройств для навигационного меню*/
        @media (max-width: 768px) {
            .parent1, .swiper-slide {
        position: relative;
    }
            .admin-form {
                grid-template-columns: 1fr;
            }
            
            .nav__fluid {
                padding: 0 20px;
            }
            
            .ul_second_nav {
        position: absolute !important;
        top: 100%;
        left: 0;
        right: 0;
        max-width: 100%;
        width: auto;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        border-radius: 4px;
        border: 1px solid rgb(100, 139, 183);
        padding: 10px 0;
        background-color: #fff;
        z-index: 9999;
        /* Обеспечить адаптивность и перенос текста */
        word-wrap: break-word;
        word-break: break-word;

        /* Добавить горизонтальную прокрутку, если содержимое шире */
        overflow-x: auto;
    }
            /* Для текста внутри подменю, чтобы он переносился корректно */
    .ul_second_nav li {
        white-space: normal; /* разрешить перенос строк */
    }
            .mobile-submenu-open {
                display: block !important;
            }
            
            .swiper-slide a.parent.active i {
                transform: rotate(180deg);
            }
        }
.dropdown-item {
    transition: background-color 0.3s, color 0.3s; /* Плавный переход */
}

.dropdown-item:hover {
    background-color: rgba(0, 123, 255, 0.7); /* Полупрозрачный синий цвет фона при наведении */
    color: rgba(255, 255, 255, 0.9); /* Полупрозрачный белый цвет текста при наведении */
}

.container {
    max-width: 1200px; /* Ограничиваем ширину как у примера */
    margin: 20px auto; /* Центрируем по горизонтали */
    padding: 20px;
    background-color: #fff; /* Белый фон для контента */
    border-radius: 8px; /* Слегка скругляем углы */
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); /* Легкая тень для объема */
}
/* Small devices (landscape phones, 576px and up) */
@media (min-width: 576px) {
  .container {
    max-width: 540px;
  }
}

/* Medium devices (tablets, 768px and up) */
@media (minmin-width: 768px) {
  .container {
    max-width: 720px;
  }
}

/* Large devices (desktops, 992px and up) */
@media (min-width: 992px) {
  .container {
    max-width: 960px;
  }
}

/* X-Large devices (large desktops, 1200px and up) */
@media (min-width: 1200px) {
  .container {
    max-width: 1140px;
  }
}

/* XX-Large devices (larger desktops, 1400px and up) */
@media (min-width: 1400px) {
  .container {
    max-width: 1320px;
  }
}
.table th {
    background: linear-gradient(135deg, #001f4d, #003366); /* Градиент темно-синего цвета - цвет заголовка */
    color: white; /* Цвет текста заголовка */
}
.table td {
    vertical-align: middle; /* Центрирование текста в ячейках */
}
.table-responsive {
    overflow-x: auto; /* Позволяет прокрутку таблицы, если она слишком широка */
    margin-top: 20px; /* Отступ сверху для отделения от заголовка */
}
.table-hover tbody tr:hover {
    background-color: #f1f1f1; /* Цвет фона при наведении на строку */
}
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .change-password-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .register-container {
            max-width: 400px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        nav {
            width: 100%;
        }
        footer {
            width: 100%;
            position: relative;
            bottom: 0;
        }
        @media (max-width: 500px) {
    .modal-dialog {
        margin: 0%; /* Убираем отступы для мобильных устройств */
        width: 100%; /* Устанавливаем ширину на 100% */
        max-width: 100%; /* Ограничиваем ширину до 100% */
    }
    
    .modal-content {
        border-radius: 0; /* Убираем закругления для мобильных устройств */
    }

    .btn {
        width: 100%; /* Кнопки занимают всю ширину */
        margin-bottom: 10px; /* Отступ между кнопками */
    }
    .modal-content .btn {
    width: auto; /* Изменяем ширину для кнопок в модальном окне */
}

    .modal-body {
        overflow-y: auto; /* Позволяет прокручивать содержимое */
        max-height: 70vh; /* Ограничиваем высоту модального окна */
    }
}
@media (min-width: 501px) and (max-width: 1366px) { 
    .modal-dialog { 
        margin: 0; /* Убираем отступы для больших экранов */
        width: 100%; /* Устанавливаем ширину на 100% */
        max-width: 100%; /* Ограничиваем ширину до 100% */
        height: 100%; /* Устанавливаем высоту на 100% */
        margin-top: 0; /* Убираем верхний отступ */
    }

    .modal-content {
        border-radius: 0; /* Убираем закругления для больших экранов */
        height: 100%; /* Устанавливаем высоту на 100% */
    }
    
    .modal-body {
        overflow-y: auto; /* Позволяет прокручивать содержимое */
        max-height: calc(100vh - 56px); /* Ограничиваем высоту модального окна */
    }
}
.modal-dialog {
    width: 95%; /* Устанавливаем ширину на 90% */
    max-width: 800px; /* Максимальная ширина */
    margin: auto; /* Центрируем модальное окно */
}

.modal-content {
    border: 2px solid #007bff; /* Установка границы */
    border-radius: 10px; /* Закругление углов */
    height: auto; /* Авто высота */
}

.modal-body {
    overflow-y: auto; /* Позволяет прокручивать содержимое */
    max-height: 70vh; /* Ограничиваем высоту модального окна */
}
@media (max-width: 768px) {
    .navbar-brand {
        font-size: 14px; /* Уменьшает размер шрифта на мобильных устройствах */
    }
}
        /* Стили для формы поиска */
        .search-container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 20px;
            margin: 30px 0;
        }
        
        .search-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .search-row {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        
        .search-field {
            flex: 1;
            min-width: 250px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px 15px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .search-field:hover {
            border-color: #007bff;
            background: #fff;
        }
        
        .search-field i {
            margin-right: 10px;
            color: #6c757d;
        }
        
        .search-field input {
            border: none;
            background: transparent;
            outline: none;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }
        
        .search-field .field-text {
            flex: 1;
            color: #495057;
        }
        
        .search-field .placeholder {
            color: #6c757d;
        }
        
        .search-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.3s;
            margin-top: 10px;
            align-self: flex-start;
        }
        
        .search-btn:hover {
            background: #0056b3;
        }
        
        /* Стили для выпадающих меню */
        .dropdown-menu-custom {
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: none;
            min-width: 300px;
        }
        
        .calendar-container {
            padding: 15px;
        }
        
        .people-selector {
            padding: 15px;
        }
        
        .counter {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        
        .counter-label {
            font-weight: 500;
        }
        
        .counter-controls {
            display: flex;
            align-items: center;
        }
        
        .counter-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 1px solid #ddd;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        
        .counter-value {
            margin: 0 10px;
            min-width: 30px;
            text-align: center;
        }
        
        /* Адаптивность */
        @media (max-width: 768px) {
            .search-row {
                flex-direction: column column;
            }
            
            .search-field {
                min-width: 100%;
            }
        }
        /* Стили для позиционирования выпадающих меню */
.search-field {
    position: relative;
}

.dropdown-menu-custom {
    position: absolute;
    top: 100%;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1000;
    display: none;
    margin-top: 5px;
    min-width: 300px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: none;
}

.calendar-dropdown {
    min-width: 350px;
}

.people-dropdown {
    min-width: 250px;
}

/* Адаптивное позиционирование для мобильных устройств */
@media (max-width: 768px) {
    .dropdown-menu-custom {
        left: 0;
        right: 0;
        transform: none;
        width: 95%;
        margin-left: auto;
        margin-right: auto;
    }
}

/* Показывать выпадающее меню при активации */
.show-dropdown {
    display: block !important;
}
    </style>
</head>
<body>

<!-- Навигационная панель -->
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="/app/includes/free-icon-appliances.png" alt="Логотип" style="height: 40px; margin-right: 10px;">
            Инструкции для техники
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="?page=home">Главная</a></li>
                <li class="nav-item"><a class="nav-link" href="?page=home#about">О сайте</a></li>
                <li class="nav-item"><a class="nav-link" href="?page=logout">Выход</a></li>
                <li class="nav-item"><a class="nav-link" href="?page=register">Регистрация</a></li>
                <li class="nav-item"><a class="nav-link" href="?page=login">Вход</a></li>
                <li class="nav-item"><a class="nav-link" href="?page=upload_form">Добавить инструкцию</a></li>
            </ul>
        </div>
    </div>
</nav>
</div>
<main>

<!-- Навигационное меню с категориями -->
    <div class="container">
        <div class="nav">
            <div class="nav__container">
                <div class="nav__fluid">
                    <div class="nav__arrow nav__arrow_prev">
                        <a href="#" class="nav_prev" tabindex="0" role="button" aria-label="Previous slide">
                            <i class="fas fa-angle-left"></i>
                        </a>
                    </div>

                    <div itemscope itemtype="http://www.schema.org/SiteNavigationElement" class="nav__fluid_slider swiper-container">
                        <div class="swiper-wrapper">
                            <?php foreach ($navCategories as $category): ?>
                                <div itemprop="name" class="swiper-slide" data-id="<?= htmlspecialchars($category['id']) ?>">
                                    <a itemprop="url" class="parent" href="?category=<?= htmlspecialchars($category['id']) ?>">
                                        <span><?= htmlspecialchars($category['name']) ?></span>
                                        
                                        <?php if (!empty($category['subcategories'])): ?>
                                            <i class="fas fa-caret-down"></i>
                                        <?php endif; ?>
                                    </a>
                                    
                                    <?php if (!empty($category['subcategories'])): ?>
                                        <ul class="ul_second_nav">
                                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                                                <li itemprop="name">
                                                    <a itemprop="url" class="link_in_nav" href="?subcategory=<?= htmlspecialchars($subcategory['id']) ?>">
                                                        <?= htmlspecialchars($subcategory['name']) ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    
                    <div class="nav__arrow nav__arrow_next">
                        <a href="#" class="nav_next" tabindex="0" role="button" aria-label="Next slide">
                            <i class="fas fa-angle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- НАЧАЛО ВСТАВКИ НОВОГО БЛОКА ПОИСКА -->
<div class="container">
    <!-- Форма поиска -->
    <div class="search-container">
        <form class="search-form" id="searchMainForm">
            <div class="search-row">
                <!-- Поле для поиска города/направления -->
                <div class="search-field" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="destinationField">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="field-text">
                        <span class="placeholder" id="destinationPlaceholder">Куда вы хотите поехать?</span>
                        <span class="selected-value" id="destinationValue" style="display:none"></span>
                    </div>
                    <input type="hidden" id="city-input" name="city">
                    <input type="hidden" id="city-id-input" name="cityId">
                </div>
                
                <!-- Поле для выбора даты заезда -->
                <div class="search-field" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="checkinField">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="field-text">
                        <span class="placeholder" id="checkinPlaceholder">Дата заезда</span>
                        <span class="selected-value" id="checkinValue" style="display:none"></span>
                    </div>
                    <input type="hidden" id="dateFrom-input" name="dateFrom" value="">
                </div>
                
                <!-- Поле для выбора даты выезда -->
                <div class="search-field" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="checkoutField">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="field-text">
                        <span class="placeholder" id="checkoutPlaceholder">Дата выезда</span>
                        <span class="selected-value" id="checkoutValue" style="display:none"></span>
                    </div>
                    <input type="hidden" id="dateTo-input" name="dateTo" value="">
                </div>
                
                <!-- Поле для выбора количества людей -->
                <div class="search-field" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="peopleField">
                    <i class="fas fa-users"></i>
                    <div class="field-text">
                        <span class="placeholder" id="peoplePlaceholder">2 взрослых, 0 детей</span>
                        <span class="selected-value" id="peopleValue" style="display:none"></span>
                    </div>
                    <input type="hidden" id="adult-input" name="adult" value="2">
                    <input type="hidden" id="child-input" name="child" value="0">
                </div>
            </div>
            
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Найти
            </button>
        </form>
    </div>
</div>
<!-- Выпадающее меню для выбора дат -->
<div class="dropdown-menu dropdown-menu-custom calendar-dropdown" id="calendarDropdown">
    <div class="calendar-container">
        <h5>Выберите даты</h5>
        <p>Здесь будет календарь для выбора дат</p>
        <button class="btn btn-primary btn-sm" id="applyDates">Применить</button>
    </div>
</div>

<!-- Выпадающее меню для выбора количества людей -->
<div class="dropdown-menu dropdown-menu-custom people-dropdown" id="peopleDropdown">
    <div class="people-selector">
        <h5>Количество гостей</h5>
        
        <div class="counter">
            <span class="counter-label">Взрослые</span>
            <div class="counter-controls">
                <button class="counter-btn" id="decreaseAdults">-</button>
                <span class="counter-value" id="adultsCount">2</span>
                <button class="counter-btn" id="increaseAdults">+</button>
            </div>
        </div>
        
        <div class="counter">
            <span class="counter-label">Дети</span>
            <div class="counter-controls">
                <button class="counter-btn" id="decreaseChildren">-</button>
                <span class="counter-value" id="childrenCount">0</span>
                <button class="counter-btn" id="increaseChildren">+</button>
            </div>
        </div>
        
        <button class="btn btn-primary btn-sm mt-3" id="applyPeople">Применить</button>
    </div>
</div>
</div>
<!-- КОНЕЦ ВСТАВКИ НОВОГО БЛОКА ПОИСКА -->

<div class="container">
    <h2 class="text-center">Инструкции и руководства по эксплуатации техники</h2>

    <div class="row">
        <?php
        // Отображаем категории и подкатегории
        foreach ($categoryGroups as $category) {
            echo "<div class='col-md-6 mb-4'>"; // Используем col-md-6 для двух столбцов
            echo "<div class='card shadow-sm'>"; // Добавляем карточку с тенью
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>{$category['name']}</h5>";
            echo "<div class='dropdown'>";
            echo "<button class='btn btn-primary dropdown-toggle btn-block' type='button' id='categoryDropdown{$category['id']}' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Выбрать подкатегорию</button>";
            echo "<div class='dropdown-menu' aria-labelledby='categoryDropdown{$category['id']}'>";

            // Проверяем, есть ли подкатегории
            if (!empty($category['subcategories'])) {
                foreach ($category['subcategories'] as $subcategory) {
                    echo "<a class='dropdown-item' href='#' data-toggle='modal' data-target='#instructionsListModal' data-subcategory-id='{$subcategory['id']}'>{$subcategory['name']}</a>";
                }
            } else {
                echo "<a class='dropdown-item disabled' href='#'>Нет подкатегорий</a>";
            }

            echo "</div></div>"; // Закрываем dropdown
            echo "</div>"; // Закрываем card-body
            echo "</div>"; // Закрываем card
            echo "</div>"; // Закрываем div.col-md-6
        }
        ?>
    </div>
</div>
    
</div>

</main>
<!-- footer.php -->
    
<footer class="bg-secondary text-white text-center py-2">
    <div class="container">
        <p class="mb-0">&copy; 2025 Инструкции для техники. Дмитрий Попов.</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/search.js"></script>
<script src="../assets/instructions.js"></script>
<script src="../assets/download.js"></script>
<script src="../assets/complaint.js"></script>
    <script>
    $(document).ready(function() {
    // Переменные для хранения текущего активного поля
    let activeField = null;
    
    // Функция для позиционирования выпадающего меню
    function positionDropdown(field, dropdown) {
        const rect = field.getBoundingClientRect();
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        dropdown.style.position = 'absolute';
        dropdown.style.top = (rect.bottom + scrollTop + 5) + 'px';
        dropdown.style.left = '50%';
        dropdown.style.transform = 'translateX(-50%)';
    }
    
    // Обработка выбора дат
    $('#checkinField, #checkoutField').click(function(e) {
        e.stopPropagation();
        
        // Скрыть другие выпадающие меню
        $('#peopleDropdown').removeClass('show-dropdown');
        
        // Показать/скрыть календарь
        const calendar = $('#calendarDropdown');
        if (calendar.hasClass('show-dropdown')) {
            calendar.removeClass('show-dropdown');
        } else {
            calendar.addClass('show-dropdown');
            activeField = this;
            positionDropdown(this, calendar[0]);
        }
    });
    
    // Обработка выбора количества людей
    $('#peopleField').click(function(e) {
        e.stopPropagation();
        
        // Скрыть другие выпадающие меню
        $('#calendarDropdown').removeClass('show-dropdown');
        
        // Показать/скрыть меню выбора людей
        const people = $('#peopleDropdown');
        if (people.hasClass('show-dropdown')) {
            people.removeClass('show-dropdown');
        } else {
            people.addClass('show-dropdown');
            activeField = this;
            positionDropdown(this, people[0]);
        }
    });
    
    $('#applyDates').click(function() {
        // Здесь будет логика применения выбранных дат
        $('#checkinValue').text('01.01.2023').show();
        $('#checkinPlaceholder').hide();
        $('#checkoutValue').text('10.01.2023').show();
        $('#checkoutPlaceholder').hide();
        $('#calendarDropdown').removeClass('show-dropdown');
    });
    
    // Обработка выбора количества людей
    $('#applyPeople').click(function() {
        const adults = $('#adultsCount').text();
        const children = $('#childrenCount').text();
        $('#peopleValue').text(adults + ' взрослых, ' + children + ' детей').show();
        $('#peoplePlaceholder').hide();
        $('#adult-input').val(adults);
        $('#child-input').val(children);
        $('#peopleDropdown').removeClass('show-dropdown');
    });
    
    // Управление счетчиками
    $('#increaseAdults').click(function() {
        let count = parseInt($('#adultsCount').text());
        $('#adultsCount').text(count + 1);
    });
    
    $('#decreaseAdults').click(function() {
        let count = parseInt($('#adultsCount').text());
        if (count > 1) $('#adultsCount').text(count - 1);
    });
    
    $('#increaseChildren').click(function() {
        let count = parseInt($('#childrenCount').text());
        $('#childrenCount').text(count + 1);
    });
    
    $('#decreaseChildren').click(function() {
        let count = parseInt($('#childrenCount').text());
        if (count > 0) $('#childrenCount').text(count - 1);
    });
    
    // Закрытие dropdown при клике вне его
    $(document).click(function(e) {
        if (!$(e.target).closest('.search-field, .dropdown-menu-custom').length) {
            $('.dropdown-menu-custom').removeClass('show-dropdown');
        }
    });
    
    // Репозиционирование при изменении размера окна
    $(window).resize(function() {
        if (activeField) {
            const activeDropdown = $('.dropdown-menu-custom.show-dropdown');
            if (activeDropdown.length) {
                positionDropdown(activeField, activeDropdown[0]);
            }
        }
    });
    
    // Предотвращаем закрытие при клике внутри выпадающего меню
    $('.dropdown-menu-custom').click(function(e) {
        e.stopPropagation();
    });
});
        document.addEventListener('DOMContentLoaded', function() {
    // Инициализация Swiper с настройками для бесконечной прокрутки
    const swiper = new Swiper('.nav__fluid_slider', {
        slidesPerView: 'auto',
        spaceBetween: 0,
        loop: true,
        speed: 800,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        navigation: {
            nextEl: '.nav_next',
            prevEl: '.nav_prev',
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 5
            },
            480: {
                slidesPerView: 3,
                spaceBetween:  10
            },
            768: {
                slidesPerView: 4,
                spaceBetween: 15
            },
            1024: {
                slidesPerView: 6,
                spaceBetween: 20
            },
            1200: {
                slidesPerView: 8,
                spaceBetween: 25
            }
        }
    });

    // Обработка кликов для открытия/закрытия подменю
    const categoryItems = document.querySelectorAll('.swiper-slide');

    categoryItems.forEach(item => {
        const link = item.querySelector('a.parent');
        const submenu = item.querySelector('.ul_second_nav');
        
        if (submenu) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Останавливаем автопрокрутку при открытии подменю
                swiper.autoplay.stop();
                
                // Закрываем все открытые подменю
                document.querySelectorAll('.ul_second_nav').forEach(ul => {
                    if (ul !== submenu) {
                        ul.style.display = 'none';
                    }
                });
                
                // Переключаем текущее подменю
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    // Возобновляем автопрокрутку при закрытии подменюю
                    swiper.autoplay.start();
                } else {
                    submenu.style.display = 'block';
                }
            });
        }
    });

    // Обработка кликов вне меню для закрытия подменю
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.swiper-slide')) {
            document.querySelectorAll('.ul_second_nav').forEach(ul => {
                if (ul.style.display === 'block') {
                    ul.style.display = 'none';
                    // Возобновляем автопрокрутку при закрытии подменю
                    swiper.autoplay.start();
                }
            });
        }
    });

    // Адаптация для мобильных устройств
    function handleMobileView() {
        if (window.innerWidth < 768) {
            document.querySelectorAll('.swiper-slide a.parent').forEach(link => {
                const submenu = link.parentElement.querySelector('.ul_second_nav');
                if (submenu) {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        // Останавливаем автопрокрутку при открытии подменю
                        swiper.autoplay.stop();
                        
                        document.querySelectorAll('.ul_second_nav').forEach(menu => {
                            if (menu !== submenu) {
                                menu.classList.remove('mobile-submenu-open');
                            }
                        });
                        
                        if (subsubmenu.classList.contains('mobile-submenu-open')) {
                            submenu.classList.remove('mobile-submenu-open');
                            // Возобновляем автопрокруттку при закрытии подменю
                            swiper.autoplay.start();
                        } else {
                            submenu.classList.add('mobile-submenu-open');
                        }
                    });
                }
            });
        }
    }

    handleMobileView();
    window.addEventListener('resize', handleMobileView);
});     
    </script>
    </body>
</html>