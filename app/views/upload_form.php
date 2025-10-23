<!-- app/views/upload_form.php -->
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
    <title>Курортик</title>
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

<!-- Навигационная панель -->
<div class="container">
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="/app/includes/free-icon-appliances.png" alt="Логотип" style="height: 40px; margin-right: 10px;">
            Курортик
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Переключить навигацию">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
    <li class="nav-item"><a class="nav-link" href="?page=home">Главная</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=home#about">О сайте</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=hotelier_dashboard">Личный кабинет</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=upload_form">Добавить объявление</a></li>
    <li class="nav-item"><a class="nav-link" href="?page=logout">Выход </a></li>
</ul>
        </div>
    </div>
</nav>
</div>
<main>
<div class="container mt-4">
    <h2>Добавить новое объявление</h2>
    <?php
    // Отображение сообщений об ошибках и успехах
    if (isset($_SESSION['error'])) {
        echo "<div id='error-message' class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<div id='success-message' class='alert alert-success'>" . $_SESSION['success'] . "</div>";
        unset($_SESSION['success']);
    }
    ?>
    
    <!-- Предпросмотр -->
    <div class="card mb-4" id="previewCard" style="display: none;">
        <div class="card-header">Предпросмотр объявления</div>
        <div class="card-body" id="previewContent"></div>
    </div>

    <form id="listingForm" enctype="multipart/form-data">
        <!-- <input type="hidden" name="hotelier_id" value="<?= $_SESSION['user_id'] ?>"> -->
        
        <!-- Секция 1: Основная информация -->
        <div class="form-section">
            <h4 class="section-title">Основная информация</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categorySelect" class="required-field">Выберите категорию</label>
                        <select class="form-control" id="categorySelect" name="category_id" required>
                            <option value="">-- Выберите категорию --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="subcategorySelect" class="required-field">Выберите подкатегорию</label>
                        <select class="form-control" id="subcategorySelect" name="subcategory_id" required>
                            <option value="">-- Выберите подкатегорию --</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="required-field">Название отеля</label>
                        <input type="text" name="title" class="form-control" required oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="required-field">Адрес</label>
                        <textarea name="address" class="form-control" rows="2" required oninput="updatePreview()"></textarea>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Описание</label>
                        <textarea name="description" class="form-control" rows="4" oninput="updatePreview()"></textarea>
                    </div>

                    <div class="form-group">
                        <label class="required-field">Телефон</label>
                        <input type="text" name="phone" class="form-control" required oninput="updatePreview()">
                    </div>

                    <div class="form-group">
                        <label class="required-field">Расстояние до моря</label>
                        <input type="text" name="distance_to_sea" class="form-control" required oninput ="updatePreview()">
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
                                <input type="number" name="max_adults" class="form-control" min="0" value="0" oninput="updatePreview()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Максимум детей</label>
                                <input type="number" name="max_children" class="form-control" min="0" value="0" oninput="updatePreview()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Максимум гостей всего</label>
                                <input type="number" name="max_guests_total" class="form-control" min="0" value="0" oninput="updatePreview()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Время заезда</label>
                                <input type="time" name="check_in_time" class="form-control" value="14:00" oninput="updatePreview()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Время выезда</label>
                                <input type="time" name="check_out_time" class="form-control" value="12:00" oninput="updatePreview()">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Минимальное количество ночей</label>
                                <input type="number" name="min_stay_nights" class="form-control" min="1" value="1" oninput="updatePreview()">
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
                        <input type="checkbox" name="wifi_free" class="form-check-input" onchange="updatePreview()">
                        <label class="form-check-label">Бесплатный Wi-Fi</label>
                    </div>

                    <div class="form-check mb-2">
                        <input type="checkbox" name="has_parking" class="form-check-input" onchange="updatePreview()">
                        <label class="form-check-label">Парковка</label>
                    </div>

                    <div class="form-group">
                        <label>Питание</label>
                        <select name="food_options" class="form-control" onchange="updatePreview()">
                            <option value="Без питания">Без питания</option>
                            <option value="Завтрак">Завтрак</option>
                            <option value="Полупансион">Полупансион</option>
                            <option value="Полный пансион">Полный пансион</option>
                        </select>
                    </div>
                </div>
                
                <div class="col-md-6">
    <div class="form-group">
    <label class="required-field">Главное фото</label>
    <div class="input-group">
        <input type="file" name="main_photo" class="form-control" accept="image/*" required 
               onchange="previewMainPhoto(this)">
        <div class="input-group-append">
            <button class="btn btn-outline-danger" type="button" 
                    onclick="removeMainPhoto()" 
                    id="removeMainPhotoBtn" 
                    style="display: none;">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <small class="form-text text-muted">Рекомендуемый размер: 800x600px</small>
    <div id="mainPhotoPreview" class="mt-2" style="display: none;">
        <img src="" class="img-thumbnail" style="max-height: 150px;">
    </div>
</div>

    <div class="form-group">
        <label>Дополнительные фото (максимум 10)</label>
        <input type="file" name="photos[]" class="form-control" accept="image/*" multiple 
               onchange="previewAdditionalPhotos(this)">
        <small class="form-text text-muted">Можно выбрать несколько файлов (до 10)</small>
        
        <!-- Контейнер для предпросмотра дополнительных фото -->
        <div id="additionalPhotosPreview" class="mt-3" style="display: none;">
            <div class="d-flex flex-wrap gap-2" id="additionalPhotosContainer"></div>
        </div>
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
                foreach ($months as $month): ?>
                <div class="col-md-3 mb-2">
                    <label><?= $month ?></label>
                    <input type="number" name="prices[<?= $month ?>]" class="form-control price-input" 
                           min="0" placeholder="0" oninput="updatePreview()">
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Секция 4: Юридическая информация -->
        <div class="form-section">
            <h4 class="section-title">Юридическая информация</h4>
            <div class="legal-section">
                <div class="form-group">
                    <label>Номер в едином реестре объектов классификации</label>
                    <input type="text" name="registry_number" class="form-control" 
                           placeholder="Если имеется">
                    <small class="form-text text-muted">Номер присваивается при добровольной классификации</small>
                </div>

                <div class="form-group">
                    <label class="required-field">Организационно-правовая форма</label>
                    <select name="legal_form" class="form-control" required>
                        <option value="">-- Выберите форму --</option>
                        <option value="self_employed">Самозанятый</option>
                        <option value="individual_entrepreneur">Индивидуальный предприниматель (ИП)</option>
                        <option value="legal_entity">Юридическое лицо</option>
                    </select>
                </div>

                <div class="consent-checkbox">
                    <div class="form-check">
                        <input type="checkbox" name="privacy_policy_accepted" 
                               class="form-check-input" id="privacyPolicy" required>
                        <label class="form-check-label consent-label" for="privacyPolicy">
                            Я ознакомлен(а) и согласен(на) с <a href="#" data-toggle="modal" data-target="#privacyModal">Политикой конфиденциальности</a>
                        </label>
                    </div>
                </div>

                <div class="consent-checkbox">
                    <div class="form-check">
                        <input type="checkbox" name="personal_data_consent" 
                               class="form-check-input" id="dataConsent" required>
                        <label class="form-check-label consent-label" for="dataConsent">
                            Даю согласие на обработку моих персональных данных в соответствии с 
                            <a href="#" data-toggle="modal" data-target="#dataProcessingModal">Политикой обработки персональных данных</a>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg-lg mt-3">
            <i class="fas fa-paper-plane"></i> Отправить на модерацию
        </button>
    </form>
</div>
</main>
<!-- Модальные окна для политик -->
<div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="privacyModalLabel">Политика конфиденциальности</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>1. Общие положения</h6>
                <p>Настоящая Политика конфиденциальности регулирует порядок обработки и использования персональных данных пользователей сайта...</p>
                
                <h6>2. Собираемая информация</h6>
                <p>Мы собираем информацию, которую вы предоставляете при регистрации и размещении объявлений...</p>
                
                <h6>3. Использование информации</h6>
                <p>Предоставленная информация используется для создания и публикации объявленийлений...</p>
                
                <h6>4. Защита информации</h6>
                <p>Мы принимаем необходимые меры для защиты ваших персональных данных...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="dataProcessingModal" tabindex="-1" role="dialog" aria-labelledby="dataProcessingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataProcessingModalLabel">Согласие на обработку персональных данных</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Я даю свое согласие на обработку моих персональных данных, предоставленных при регистрации и размещении объявлений, включая:</p>
                <ul>
                    <li>Сбор, запись, систематизацию, накопление, хранение</li>
                    <li>Уточнение (обновление, изменение), извлечение</li>
                    <li>Использование, передачу (распространение, предоставление, доступ)</li>
                    <li>Обезличивание, блокирование, удаление, уничтожение</li>
                </ul>
                <p>Обработка персональных данных осуществляется в целях предоставления услуг сайта...</p>
                <p>Настоящее согласие действует бессрочно и может быть отозвано путем подачи письменного заявления...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<footer class="bg-secondary text-black text-center py-2">
    <div class="container">
        <p class="mb-0">&copy; 2025 Отдых на курортах России без посредников. Дмитрий Попов.</p>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.querySelectorAll('input, select, textarea').forEach(element => {
    element.addEventListener('input', updatePreview);
    element.addEventListener('change', updatePreview);
});
// Глобальная переменная для хранения всех выбранных фото
let allAdditionalPhotos = [];

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация карусели если нужно
    if (typeof $ !== 'undefined') {
        $('.carousel').carousel();
    }
    
    // Добавляем обработчики событий для всех элементов формы
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('input', updatePreview);
        element.addEventListener('change', updatePreview);
    });
});

// Предпросмотр главного фото
function previewMainPhoto(input) {
    const preview = document.getElementById('mainPhotoPreview');
    const removeBtn = document.getElementById('removeMainPhotoBtn');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.style.display = 'block';
            removeBtn.style.display = 'block'; // Показываем кнопку удаления
        }
        
        reader.readAsDataURL(input.files[0]);
        updatePreview();
    } else {
        preview.style.display = 'none';
        removeBtn.style.display = 'none'; // Скрываем кнопку удаления
    }
}
// Удаление главного фото
function removeMainPhoto() {
    const mainPhotoInput = document.querySelector('input[name="main_photo"]');
    const preview = document.getElementById('mainPhotoPreview');
    
    // Очищаем input
    mainPhotoInput.value = '';
    
    // Скрываем превью
    preview.style.display = 'none';
    preview.querySelector('img').src = '';
    
    updatePreview();
}
// Предпросмотр дополнительных фото
function previewAdditionalPhotos(input) {
    const container = document.getElementById('additionalPhotosContainer');
    const previewSection = document.getElementById('additionalPhotosPreview');
    
    // Добавляем новые файлы к существующим
    const newFiles = Array.from(input.files);
    
    // Проверяем общее количество файлов
    if (allAdditionalPhotos.length + newFiles.length > 10) {
        alert('Максимальное количество фото - 10!');
        input.value = ''; // Очищаем input
        return;
    }
    
    // Добавляем новые файлы
    allAdditionalPhotos = [...allAdditionalPhotos, ...newFiles];
    
    if (allAdditionalPhotos.length > 0) {
        previewSection.style.display = 'block';
        container.innerHTML = ''; // Очищаем контейнер
        
        allAdditionalPhotos.forEach((file, index) => {
            if (file.type.match('image.*')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className = 'position-relative';
                    imgWrapper.style.width = '100px';
                    imgWrapper.style.height = '100px';
                    imgWrapper.style.margin = '5px';
                    
                    imgWrapper.innerHTML = `
                        <img src="${e.target.result}" class="img-thumbnail" 
                             style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
                             onclick="viewPhoto(${index})">
                        <button type="button" class="btn btn-sm btn-danger position-absolute" 
                                style="top: -5px; right: -5px; border-radius: 50%; width: 25px; height: 25px; padding: 0; font-size: 14px;"
                                onclick="removeAdditionalPhoto(${index})">
                            ×
                        </button>
                    `;
                    
                    container.appendChild(imgWrapper);
                }
                
                reader.readAsDataURL(file);
            }
        });
    } else {
        previewSection.style.display = 'none';
    }
    
    updatePreview();
}


// Удаление фото из предпросмотра
function removeAdditionalPhoto(index) {
    // Удаляем файл из массива
    allAdditionalPhotos.splice(index, 1);
    
    // Обновляем предпросмотр
    const input = document.querySelector('input[name="photos[]"]');
    input.value = ''; // Очищаем input
    previewAdditionalPhotos(input);
}

// Функция для просмотра фото в увеличенном виде
function viewPhoto(index) {
    // Создаем модальное окно для просмотра фото
    if (!document.getElementById('photoModal')) {
        const modalHtml = `
            <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Просмотр фото</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="" id="modalPhoto" style="max-width: 100%; max-height: 70vh;">
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
    }
    
    // Показываем выбранное фото
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('modalPhoto').src = e.target.result;
        $('#photoModal').modal('show');
    };
    reader.readAsDataURL(allAdditionalPhotos[index]);
}

    // Функция для загрузки родительских категорий
async function loadParentCategories() {
    try {
        const response = await fetch('../index.php?page=get_parent_categories');
        const categories = await response.json();
        
        const categorySelect = document.getElementById('categorySelect');
        categorySelect.innerHTML = '<option value="">-- Выберите категорию --</option>';
        
        categories.forEach(category => {
            const option = document.createElement('option');
            option.value = category.id;
            option.textContent = category.name;
            categorySelect.appendChild(option);
        });
    } catch (error) {
        console.error('Ошибка загрузки категорий:', error);
    }
}

// Загрузка подкатегорий при выборе категории
document.getElementById('categorySelect').addEventListener('change', async function() {
    const categoryId = this.value;
    const subcategorySelect = document.getElementById('subcategorySelect');
    
    subcategorySelect.innerHTML = '<option value="">-- Выберите подкатегорию --</option>';
    
    if (!categoryId) return;
    
    try {
        const response = await fetch(`../index.php?page=get_subcategories&category_id=${categoryId}`);
        const subcategories = await response.json();
        
        // Проверяем, есть ли ошибка в ответе
        if (subcategories.error) {
            console.error('Ошибка:', subcategories.error);
            return;
        }
        
        subcategories.forEach(subcategory => {
            const option = document.createElement('option');
            option.value = subcategory.id;
            option.textContent = subcategory.name;
            subcategorySelect.appendChild(option);
        });
    } catch (error) {
        console.error('Ошибка загрузки под подкатегорий:', error);
    }
});

// Загрузка категорий при загрузке страницы
document.addEventListener('DOMContentLoaded', loadParentCategories);

// Обработка отправки формы (оставить только этот обработчик)
document.getElementById('listingForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Проверка согласий
    const privacyPolicy = document.getElementById('privacyPolicy');
    const dataConsent = document.getElementById('dataConsent');
    
    if (!privacyPolicy.checked || !dataConsent.checked) {
        alert('Пожалуйста, примите условия политики конфиденциальности и согласие на обработку данных');
        return;
    }
    
    const formData = new FormData(this);
    
    // Добавляем дополнительные фото в FormData
    allAdditionalPhotos.forEach((file, index) => {
        formData.append(`photos[]`, file);
    });
    
    try {
        const response = await fetch('../index.php?page=submit_listing', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            showNotification('Объявление отправлено на модерацию!', 'success');
            
            // Полная очистка формы
            this.reset();
            
            // Очищаем фото
            removeMainPhoto();
            allAdditionalPhotos = [];
            document.getElementById('additionalPhotosPreview').style.display = 'none';
            document.getElementById('additionalPhotosContainer').innerHTML = '';
            
            // Скрываем превью
            document.getElementById('previewCard').style.display = 'none';
            
            // Сбрасываем селекторы категорий
            document.getElementById('categorySelect').selectedIndex = 0;
            document.getElementById('subcategorySelect').innerHTML = '<option value="">-- Выберите подкатегорию --</option>';
            
            // Сбрасываем чекбоксы
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
        } else {
            alert('Ошибка: ' + result.message);
        }
    } catch (error) {
        alert('Ошибка отправки формы: ' + error.message);
    }
});
// Показ уведомлений с автоскрытием
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show`;
    notification.style.position = 'fixed';
    notification.style.top = '20px';
    notification.style.right = '20px';
    notification.style.zIndex = '9999';
    notification.style.minWidth = '300px';
    
    notification.innerHTML = `
        ${message}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    `;
    
    document.body.appendChild(notification);
    
    // Автоскрытие через 5 секунд
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
function updatePreview() {
    const form = document.getElementById('listingForm');
    const preview = document.getElementById('previewContent');
    const previewCard = document.getElementById('previewCard');
    
    if (!form.title.value) {
        previewCard.style.display = 'none';
        return;
    }
    
    // Получаем все фото (главное + дополнительные)
    const allPhotos = [];
    
    // Добавляем главное фото
    if (form.main_photo.files[0]) {
        allPhotos.push(URL.createObjectURL(form.main_photo.files[0]));
    }
    
    // Добавляем дополнительные фото из нашего массива
    allAdditionalPhotos.forEach(file => {
        allPhotos.push(URL.createObjectURL(file));
    });
    
    // Создаем карусель если есть хотя бы одно фото
    let imageHtml = '';
    if (allPhotos.length > 0) {
        imageHtml = `
            <div id="previewCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">`;
        allPhotos.forEach((photoUrl, index) => {
            imageHtml += `
                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                    <img src="${photoUrl}" class="d-block w-100" style="height: 200px; object-fit: cover;">
                </div>`;
        });
        
        imageHtml += `</div>`;
        
        // Добавляем стрелки управления если фото больше 1
        if (allPhotos.length > 1) {
            imageHtml += `
                <a class="carousel-control-prev" href="#previewCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Предыдущее</span>
                </a>
                <a class="carousel-control-next" href="#previewCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Следующее</span>
                </a>
                <ol class="carousel-indicators">`;
            
            // Добавляем индикаторы
            allPhotos.forEach((_, index) => {
                imageHtml += `<li data-target="#previewCarousel" data-slide-to="${index}" 
                    class="${index === 0 ? 'active' : ''}"></li>`;
            });
            
            imageHtml += `</ol>`;
        }
        
        imageHtml += `</div>`;
    } else {
        imageHtml = '<div style="height: 200px; background: #f0f0f0; display: flex; align-items: center; justify-content: center;"><i class="fas fa-image fa-3x text-muted"></i></div>';
    }
    
    let html = `
        <div class="goods">
            <div class="goods__image">
                ${imageHtml}
            </div>
            <div class="goods__content">
                <div class="goods__title">
                    <strong>${form.title.value}</strong>
                </div>
                <div class="goods__content_row">
                    <div class="goods__detail">
                        <ul>
                            ${form.wifi_free.checked ? '<li><font color="#FF0000">Wi-Fi бесплатно</font></li>' : ''}
                            <li style="max-width: 400px;border: 1px solid rgb(198, 230, 246);background: rgb(205, 240, 246);border-radius: 4px;color: rgba(8, 15, 23, 0.78);">
                                <strong>До моря:</strong> <span>${form.distance_to_sea.value}</span>
                            </li>
                            <li><strong>Адрес:</strong> <span>${form.address.value}</span></li>
                            ${form.has_parking.checked ? '<li><strong>Автостоянка:</strong> <span>на территории (бесплатно)</span></li>' : ''}
                            <li><strong>Питание:</strong> <span>${form.food_options.value}</span></li>
                            <li><strong>Телефоны:</strong> <span>${form.phone.value}</span></li>
                        </ul>
                    </div>
                    <div class="goods__info">
                        <div class="goods__price">
                            <div class="goods__price_title">Цены за номер:</div>
                            <ul class="goods__price_value">`;
    
    // Добавляем цены
    document.querySelectorAll('.price-input').forEach(input => {
        if (input.value) {
            html += `<li>${input.previousElementSibling.textContent}: от ${input.value} руб.</li>`;
        }
    });
    
    html += `</ul></div></div></div></div></div>`;
    
    preview.innerHTML = html;
    previewCard.style.display = 'block';
    
    // Инициализируем карусель Bootstrap
    if (allPhotos.length > 0 && typeof $ !== 'undefined') {
        $('#previewCarousel').carousel();
    }
}
</script>
</body>