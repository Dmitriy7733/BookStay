<!-- app/views/hotelier_dashboard.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="noindex, nofollow">
    <title>Личный кабинет - Курортик</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>

      * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }  
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
            flex-wrap: wrap;
            gap: 15px;
            align-items: flex-end;
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
            height: 45px;
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
/*для календаря*/
.calendar-input {
    border: none;
    background: transparent;
    width: 100%;
    padding: 0;
    margin: 0;
    font-size: inherit;
    color: inherit;
    outline: none;
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    opacity: 0; /* Скрываем input, но оставляем кликабельным */
    cursor: pointer;
    z-index: 2;
}

.search-field {
    position: relative; /* Для абсолютного позиционирования input */
    display: flex;
    align-items: center;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    cursor: pointer;
}

.field-text {
    flex-grow: 1;
    position: relative;
    z-index: 1; /* Текст под input */
}
.selected-value {
    font-weight: 500;
    color: #2c3e50;
}

.placeholder {
    color: #6c757d;
}
    /* Основные стили для карточки объявления */
.goods {
    display: flex;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: box-shadow 0.3s ease;
}

.goods:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.goods__image {
    width: 280px;
    min-width: 280px;
    position: relative;
}

.goods__image a {
    display: block;
    width: 100%;
    height: 200px;
    background-size: cover;
    background-position: center;
    text-decoration: none;
}

.goods__content {
    flex: 1;
    padding: 15px;
    display: flex;
    flex-direction: column;
}

.goods__title {
    margin-bottom: 12px;
}

.goods__title a {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
    text-decoration: none;
}

.goods__title a:hover {
    color: #e74c3c;
}

.goods__content_row {
    display: flex;
    gap: 20px;
    flex: 1;
}

.goods__detail {
    flex: 2;
}

.goods__detail ul {
    list-style: none;
    padding: 0;
    margin: 0 0 10px 0;
}

.goods__detail li {
    margin-bottom: 8px;
    padding: 4px 8px;
    font-size: 14px;
    color: #555;
}

.goods__detail li strong {
    color: #2c3e50;
    font-weight: 600;
}

.goods__price {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.goods__price_title {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 14px;
    white-space: nowrap;
}

.goods__price_value {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.goods__price_value li {
    font-size: 13px;
    color: #666;
    white-space: nowrap;
    line-height: 1.4;
}

.goods__info {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-width: 180px;
}
.goods__views {
    text-align: right;
}

.goods__views a {
    color: #3498db;
    text-decoration: none;
    font-size: 13px;
}

.goods__views a:hover {
    text-decoration: underline;
}

.goods__views_lg {
    display: block;
}

.goods__views_sm {
    display: none;
}

/* Адаптивность */
@media (max-width: 768px) {
    .goods {
        flex-direction: column;
    }
    
    .goods__image {
        width: 100%;
        min-width: 100%;
    }
    
    .goods__image a {
        height: 200px;
    }
    
    .goods__content_row {
        flex-direction: column;
        gap: 15px;
    }
    
    .goods__views_lg {
        display: none;
    }
    
    .goods__views_sm {
        display: block;
        margin-top: 10px;
    }
}
.carousel-control-prev, .carousel-control-next {
    width: 5%;
}

.carousel-item img {
    border-radius: 5px;
    height: 200px;
    object-fit: cover;
}

#additionalPhotosContainer img {
    transition: transform 0.2s;
}

#additionalPhotosContainer img:hover {
    transform: scale(1.05);
}

.position-relative {
    transition: opacity 0.3s;
}

.position-relative:hover {
    opacity: 0.8;
}

.goods__image {
    position: relative;
}

.goods__image .carousel {
    height: 200px;
}

.goods__image .carousel-item {
    height: 200px;
}
/* Стили для заголовков и контейнеров */
.mb-4 {
    margin-bottom: 1.5rem !important;
}

.hide_xs {
    display: inline;
}

@media (max-width: 480px) {
    .hide_xs {
        display: none;
    }
}

/* Стили для специальных элементов */
.slide_hover {
    position: relative;
}

.slide_hover:hover::after {
    content: "Еще фото";
    position: absolute;
    bottom: 10px;
    right: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}
#listingsContainer, #categoriesContainer {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

#listingsContent h3 {
    color: #2c3e50;
    font-size: 24px;
    font-weight: 600;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

#backToCategories {
    background: #3498db;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-bottom: 20px;
    transition: background 0.3s ease;
}

#backToCategories:hover {
    background: #2980b9;
}
#previewCarousel {
    height: 200px;
    position: relative;
}

#previewCarousel .carousel-inner {
    height: 100%;
    border-radius: 5px;
}

#previewCarousel .carousel-item {
    height: 100%;
}

#previewCarousel .carousel-item img {
    height: 100%;
    object-fit: cover;
    border-radius: 5px;
}

/* Убедимся, что стрелки видны */
#previewCarousel .carousel-control-prev,
#previewCarousel .carousel-control-next {
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.7;
    transition: opacity 0.3s;
}

#previewCarousel .carousel-control-prev:hover,
#previewCarousel .carousel-control-next:hover {
    opacity: 1;
}

#previewCarousel .carousel-control-prev {
    left: 10px;
}

#previewCarousel .carousel-control-next {
    right: 10px;
}

#additionalPhotosContainer img {
    transition: transform 0.2s;
}

#additionalPhotosContainer img:hover {
    transform: scale(1.05);
}

.position-relative {
    transition: opacity 0.3s;
}

.position-relative:hover {
    opacity: 0.8;
}
    </style>
</head>
<body>

<ul class="navbar-nav ml-auto">
    <li class="nav-item"><a class="nav-link" href="?page=home">Главная</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=home#about">О сайте</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=hotelier_dashboard">Личный кабинет</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=hotelier_bookings">Управление бронированиями</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=upload_form">Добавить объявление</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=logout">Выход (<?= htmlspecialchars($_SESSION['username']) ?>)</a></li>
</ul>

<main class="container mt-4">
    <h1>Личный кабинет отельера</h1>
    <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['username']) ?>!</p>

    <div class="row mb-4">
        <!-- Карточка со статистикой -->
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Всего объявлений</h5>
                    <p class="card-text display-4"><?= $totalListings ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Опубликовано</h5>
                    <p class="card-text display-4"><?= $publishedListings ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">На модерации</h5>
                    <p class="card-text display-4"><?= $moderationListings ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Отклонено</h5>
                    <p class="card-text display-4"><?= $rejectedListings ?></p>
                </div>
            </div>
        </ </div>
    </div>

    <div class="list-group">
        <a href="?page=upload_form" class="list-group-item list-group-item-action">
            <i class="fas fa-plus-circle"></i> Добавить новое объявление
        </a>
        <a href="?page=hotelier_listings&status=all" class="list-group-item list-group-item-action">
            <i class="fas fa-list"></i> Управление всеми объявлениями
        </a>
        <a href="?page=hotelier_listings&status=published" class="list-group-item list-group-item-action">
            <i class="fas fa-check-circle"></i> Опубликованные объявления
        </a>
        <a href="?page=hotelier_listings&status=moderation" class="list-group-item list-group-item-action">
            <i class="fas fa-hourglass-half"></i> Объявления на модерации
        </a>
        <a href="?page=hotelier_listings&status=rejected" class="list-group-item list-group-item-action">
            <i class="fas fa-times-circle"></i> Отклоненные объявления
        </a>
        <a href="?page=hotelier_bookings" class="list-group-item list-group-item-action">
        <i class="fas fa-calendar-alt"></i> Управление бронированиями
        </a>
    </div>

</main>

<footer class="bg-secondary text-black text-center py-2">
    <div class="container">
        <p class="mb-0">&copy; 2025 Отдых на курортах России без посредников. Дмитрий Попов.</p>
    </div>
</footer>


</body>
</html>