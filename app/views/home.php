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
    <meta name="description" content="Широкий выбор механических клавиатур с доставкой по Москве. Гарантия 2 года, отзывы покупателей. Подберите идеальную клавиатуру для игр и работы!">
    <title>Курортик-отдых</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
/* Специфичные стили для price dropdown */
.price-dropdown {
    min-width: 300px;
    padding: 0;
}

.price-presets .btn {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border: 1px solid #dee2e6;
}

.price-presets .btn.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}

.price-selector .form-control {
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 0.875rem;
}

.price-selector .form-label {
    color: #6c757d;
    font-weight: 500;
    margin-bottom: 0.25rem;
}

/* Убедимся, что dropdown правильно позиционируется */
.search-field.dropdown {
    position: relative;
}

.dropdown-menu.price-dropdown {
    transform: translateX(-50%) !important;
    left: 50% !important;
    top: 100% !important;
}


/* Стили для карт */
.map-container {
    position: relative;
    border-radius: 8px;
    overflow: hidden; /* Убираем скроллбары */
    background: #f8f9fa;
}

/* На мобильных устройствах */
@media (max-width: 768px) {
    .map-container {
        height: 400px !important; /* Достаточная высота для скролла */
    }
    
    /* Убедитесь, что iframe не блокирует события */
    .map-container iframe {
        pointer-events: auto !important;
        touch-action: auto !important;
    }
}

/* Улучшение скролла для iOS */
.map-container {
    scroll-behavior: smooth;
}



/* Кнопка карты */
.toggle-map-btn {
    transition: all 0.3s ease;
    font-size: 0.875rem;
}

.map-icon-btn {
    padding: 0.25rem 0.5rem;
}
      
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
@media (min-width: 768px) {
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
.status-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 10;
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 4px;
    opacity: 0.9;
}

/* Обертка для стрелок карусели, чтобы располагать их по центру по вертикали */
.carousel {
    position: relative;
}
.carousel-controls {
    position: absolute;
    top: 50%; /* Расположить по вертикали по центру изображения */
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 10px;
    transform: translateY(-50%); /* Центрировать по вертикали */
    z-index: 5;
}
.carousel-control-prev-custom,
.carousel-control-next-custom {
    background-color: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    transition: background-color 0.3s;
}
.carousel-control-prev-custom:hover,
.carousel-control-next-custom:hover {
    background-color: rgba(0, 0, 0, 0.7);
}

/* Убираем стандартные стрелки Bootstrap, чтобы оставить только наши */
.carousel-control-prev,
.carousel-control-next {
    display: none;
}
/* Стили для inline-подсказок*/
.inline-suggestions {
    position: absolute;
    top: 100%;
    left: 40px; /* Отступ под иконку */
    right: 0;
    background: white;
    border: 1px solid #e0e0e0;
    border-top: none;
    border-radius: 0 0 8px 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: 1000;
    max-height: 220px;
    overflow-y: auto;
    margin-top: -1px;
}

.inline-suggestion-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    cursor: pointer;
    border-bottom: 1px solid #f5f5f5;
    transition: background-color 0.2s;
}

.inline-suggestion-item:hover {
    background-color: #f8f9fa;
}

.inline-suggestion-item:last-child {
    border-bottom: none;
}

.suggestion-icon {
    color: #6c757d;
    margin-right: 10px;
    font-size: 14px;
}

.suggestion-text {
    flex: 1;
    font-size: 14px;
}

.suggestion-text strong {
    color: #333;
    font-weight: 600;
}

.region-text {
    color: #6c757d;
    font-size: 12px;
    margin-left: 8px;
}

/* Адаптация для поля поиска */
.search-field {
    position: relative;
}

.search-field:focus-within {
    z-index: 1001; /* Поднимаем поле при фокусе */
}

/* Плавное появление */
.inline-suggestions {
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-5px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
/* Стили для новой структуры */
.container-fluid {
    padding: 0 15px;
}

/* Боковая панель */
.sidebar-categories {
    background: #f8f9fa;
    border-right: 1px solid #e9ecef;
    min-height: calc(100vh - 200px);
    padding: 20px 0;
    position: relative;
}

.sidebar-sticky {
    position: sticky;
    top: 20px;
}

.s.sidebar-header {
    padding: 0 20px 15px;
    border-bottom: 2px solid #007bff;
    margin-bottom: 15px;
}

.sidebar-header h5 {
    color: #2c3e50;
    font-weight: 600;
    margin: 0;
}

/* Основной контент */
.main-content {
    padding: 0 0 0 25px;
    min-height: 600px;
}

/* Адаптация сетки карточек */
#categoriesContainer .col-xl-4 {
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
}

#categoriesContainer .col-lg-6 {
    flex: 0 0 50%;
    max-width: 50%;
}

#categoriesContainer .col-md-6 {
    flex: 0 0 50%;
    max-width: 50%;
}

/* Стили для навигации боковой панели */
.sidebar-nav {
    padding: 0 15px;
}

.nav-category {
    margin-bottom: 8px;
    border-radius: 6px;
    overflow: hidden;
}

.nav-category-header {
    background: #fff;
    padding: 12px 15px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border: 1px solid #e9ecef;
    transition: all 0.3s ease;
    font-weight: 500;
}

.nav-category-header:hover {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

.nav-category-header.active {
    background: #007bff;
    color: white;
}

.toggle-icon {
    transition: transform 0.3s ease;
    font-size: 12px;
}

.nav-category-header.active .toggle-icon {
    transform: rotate(180deg);
}

.nav-subcategories {
    background: white;
    border: 1px solid #e9ecef;
    border-top: none;
    border-radius: 0 0 6px 6px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.3s ease;
}

.nav-subcategories.expanded {
    max-height: 500px;
}

.nav-subcategory-link {
    display: block;
    padding: 10px 15px 10px 25px;
    color: #495057;
    text-decoration: none;
    border-bottom: 1px solid #f8f9fa;
    transition: all 0.2s ease;
    font-size: 14px;
}

.nav-subcategory-link:hover {
    background: #e3f2fd;
    color: #007bff;
    padding-left: 30px;
}

/* Мобильная версия */
.sidebar-mobile-toggle {
    display: none;
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    margin-bottom: 15px;
    width: 100%;
}

@media (max-width: 768px) {
    .sidebar-mobile-toggle {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .sidebar-categories {
        position: fixed;
        top: 0;
        left: -100%;
        width: 280px;
        height: 100vh;
        z-index: 1050;
        background: white;
        transition: left 0.3s ease;
        overflow-y: auto;
        padding: 20px 0;
    }
    
    .sidebar-categories.mobile-open {
    left: 0;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
}
    
    .main-content {
        padding: 0;
    }
    
    #categoriesContainer .col-md-6,
    #categoriesContainer .col-lg-6,
    #categoriesContainer .col-xl-4 {
        flex: 0 0 100%;
        max-width: 100%;
    }
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
            <h1> Курортик </h1>
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
                <li class="nav-item"><a class="nav-link" href="?page=upload_form">Добавить объявление</a></li>
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
                                <a itemprop="url" class="parent category-link" href="#" 
                                   data-category-id="<?= htmlspecialchars($category['id']) ?>"
                                   data-category-name="<?= htmlspecialchars($category['name']) ?>">
                                    <span><?= htmlspecialchars($category['name']) ?></span>
                                    
                                    <?php if (!empty($category['subcategories'])): ?>
                                        <i class="fas fa-caret-down"></i>
                                    <?php endif; ?>
                                </a>
                                
                                <?php if (!empty($category['subcategories'])): ?>
                                    <ul class="ul_second_nav">
                                        <?php foreach ($category['subcategories'] as $subcategory): ?>
                                            <li itemprop="name">
                                                <a itemprop="url" class="link_in_nav subcategory-link" href="#" 
   data-subcategory-id="<?= htmlspecialchars($subcategory['id']) ?>"
   data-subcategory-name="<?= htmlspecialchars($subcategory['name']) ?>">
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

<!-- БЛОК ПОИСКА -->
<div class="container">
    <!-- Форма поиска -->
    <div class="search-container">
        <form class="search-form" id="searchMainForm">
            <div class="search-row">
                <!-- Поле для поиска города/направления -->
                <div class="search-field" style="position: relative;">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="field-text">
                        <input type="text" id="city-input" name="city" 
                               placeholder="Введите направление (например, Ялта)" 
                               class="city-autocomplete-input"
                               autocomplete="off">
                        <input type="hidden" id="city-id-input" name="cityId">
                    </div>
                    <!-- Контейнер для подсказок добавлен через JS -->
                </div>
                
                <!-- Поле для выбора даты заезда -->
<div class="search-field date-field" id="checkinField">
    <i class="fas fa-calendar-alt"></i>
    <div class="field-text">
        <span class="placeholder" id="checkinPlaceholder">Дата заезда</span>
        <span class="selected-value" id="checkinValue" style="display:none"></span>
    </div>
    <input type="text" id="dateFrom-input" name="dateFrom" class="calendar-input" 
    placeholder="" aria-label="Дата заезда">
</div>

<!-- Поле для выбора даты выезда -->
<div class="search-field date-field" id="checkoutField">
    <i class="fas fa-calendar-alt"></i>
    <div class="field-text">
        <span class="placeholder" id="checkoutPlaceholder">Дата выезда</span>
        <span class="selected-value" id="checkoutValue" style="display:none"></span>
    </div>
    <input type="text" id="dateTo-input" name="dateTo" class="calendar-input" 
    placeholder="" aria-label="Дата выезда">
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
                <!-- Поле для выбора цены с выпадающим окном -->
<div class="dropdown search-field" id="priceDropdownContainer">
    <input type="hidden" id="price-min-input" name="priceMin">
  <input type="hidden" id="price-max-input" name="priceMax">
  <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="priceDropdownButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="placeholder" id="pricePlaceholder">Любая цена</span>
    <span class="selected-value" id="priceValue" style="display:none"></span>
  </button>
  <div class="dropdown-menu" aria-labelledby="priceDropdownButton" id="priceDropdownMenu">
    <div class="p-3">
      <h5>Диапазон цен за ночь</h5>
      <div class="row mb-3">
        <div class="col-6">
          <label class="form-label small">От, руб.</label>
          <input type="number" class="form-control form-control-sm" id="priceMinInput" placeholder="0" min="0">
        </div>
        <div class="col-6">
          <label class="form-label small">До, руб.</label>
          <input type="number" class="form-control form-control-sm" id="priceMaxInput" placeholder="Любая" min="0">
        </div>
      </div>
      <div class="price-presets mb-3">
        <div class="btn-group btn-group-sm w-100" role="group" aria-label="Быстрые пресеты цен">
          <button type="button" class="btn btn-outline-secondary price-preset" data-min="0" data-max="2000">до 2 000</button>
          <button type="button" class="btn btn-outline-secondary price-preset" data-min="2000" data-max="5000">2-5 тыс.</button>
          <button type="button" class="btn btn-outline-secondary price-preset" data-min="5000" data-max="10000">5-10 тыс.</button>
        </div>
      </div>
      <button class="btn btn-primary btn-sm w-100" id="applyPrice">Применить</button>
      <button class="btn btn-outline-secondary btn-sm w-100 mt-2" id="resetPrice">Сбросить</button>
    </div>
  </div>
</div>


</div>
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i> Найти
            </button>
        </form>
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
<!-- БЛОК ПОИСКА конец-->
<div class="container d-md-none">
    <button class="sidebar-mobile-toggle">
        <i class="fas fa-bars"></i> 
        <span>Показать категории</span>
    </button>
    <div class="sidebar-overlay"></div>
</div>
<div class="container">
    <div class="row">
        <!-- БОКОВАЯ ПАНЕЛЬ СЛЕВА -->
        <aside class="col-lg-3 col-md-4 d-none d-md-block sidebar-categories">
            <div class="sidebar-sticky">
                <div class="sidebar-header">
                    <h5><i class="fas fa-list-alt"></i> Все категории</h5>
                </div>
                <nav class="sidebar-nav">
                    <?php foreach ($categoryGroups as $category): ?>
                    <div class="nav-category">
                        <div class="nav-category-header" 
                             data-category-id="<?= $category['id'] ?>">
                            <span><?= htmlspecialchars($category['name']) ?></span>
                            <?php if (!empty($category['subcategories'])): ?>
                            <i class="fas fa-chevron-down toggle-icon"></i>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($category['subcategories'])): ?>
                        <div class="nav-subcategories">
                            <?php foreach ($category['subcategories'] as $subcategory): ?>
                            <a href="#" 
                               class="nav-subcategory-link"
                               data-subcategory-id="<?= $subcategory['id'] ?>"
                               data-subcategory-name="<?= htmlspecialchars($subcategory['name']) ?>">
                                <i class="fas fa-angle-right"></i>
                                <?= htmlspecialchars($subcategory['name']) ?>
                            </a>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>

        <!-- ОСНОВНОЙ КОНТЕНТ СПРАВА -->
        <main class="col-lg-9 col-md-8 main-content">
            <!-- Заголовок -->
            <h2 id="mainTitle" class="text-center mb-4">Популярные направления направления для отдыха</h2>
            
            <!-- КОНТЕЙНЕР КАРТОЧЕК КАТЕГОРИЙ -->
            <div id="categoriesContainer" class="row">
                <?php foreach ($categoryGroups as $category): ?>
                <div class='col-xl-4 col-lg-6 col-md-6 mb-4'>
                    <div class='card shadow-sm h-100'>
                        <div class='card-body d-flex flex-column'>
                            <h5 class='card-title'><?= $category['name'] ?></h5>
                            <div class='dropdown mt-auto'>
                                <button class='btn btn-primary dropdown-toggle btn-block' 
                                        type='button' 
                                        id='categoryDropdown<?= $category['id'] ?>' 
                                        data-toggle='dropdown' 
                                        aria-haspopup='true' 
                                        aria-expanded='false'>
                                    Выбрать подкатегорию
                                </button>
                                <div class='dropdown-menu' aria-labelledby='categoryDropdown<?= $category['id'] ?>'>
                                    <?php if (!empty($category['subcategories'])): ?>
                                        <?php foreach ($category['subcategories'] as $subcategory): ?>
                                            <a class='dropdown-item subcategory-link' 
                                               href='#' 
                                               data-subcategory-id='<?= $subcategory['id'] ?>' 
                                               data-subcategory-name='<?= $subcategory['name'] ?>'>
                                                <?= $subcategory['name'] ?>
                                            </a>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <a class='dropdown-item disabled' href='#'>Нет подкатегорий</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        
    <!-- Контейнер для объявлений с кнопкой возврата -->
        <div id="listingsContainer" class="row listings-container" style="display: none;">
    <!-- Кнопка возврата к категориям -->
    <div class="col-12 mb-4">
        <button id="backToCategories" class="btn btn-secondary back-to-categories">
            <i class="fas fa-arrow-left"></i> Назад к категориям
        </button>
    </div>
    
    <!-- Заголовок для подкатегорий -->
    <div id="subcategoryTitle" class="col-12 mb-4" style="display: none; text-align: center;">
        <h3>Где остановиться:</h3>
    </div>
    
    <!-- Заголовок для результатов поиска -->
    <div id="searchResultsTitle" class="col-12 mb-4" style="display: none; text-align: center;">
        <h3>Результаты поиска</h3>
    </div>
    
    <!-- Здесь будут появляться объявления -->
    <div id="listingsContent" class="col-12"></div>
    
    <!-- Пагинация для результатов поиска -->
    <div id="searchPagination" class="col-12 mt-4" style="display: none;"></div>
        </div>
        </main>
    </div>
</div>

<!-- footer.php -->  
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
<script src="../assets/search.js"></script>
<script src="../assets/sidebar.js"></script>
<script src="../assets/correct.js"></script>
<script>

// Функция отображения объявлений для подкатегорий
function displaySubcategoryListings(listings, subcategoryName) {
    // Скрываем категории и показываем контейнер объявлений
    $('#categoriesContainer').hide();
    $('#listingsContainer').show();
    
    // Показываем заголовок подкатегорий, скрываем заголовок поиска
    $('#subcategoryTitle').show();
    $('#searchResultsTitle').hide();
    $('#searchPagination').hide();
    
    // Обновляем основной заголовок
    const correctForm = getCorrectPrepositionForm(subcategoryName);
    $('#mainTitle').text(`Отдых в ${correctForm}`);
    
    // Отображаем объявления
    displayListings(listings, subcategoryName);
}
// Обработчик клика по подкатегории в навигационном меню
$(document).on('click', '.nav .subcategory-link', function(e) {
    e.preventDefault();
    e.stopPropagation(); // останавливаем всплытие
    
    const subcategoryId = $(this).data('subcategory-id');
    const subcategoryName = $(this).data('subcategory-name');
    
    // Закрываем все открытые подменю
    $('.ul_second_nav').hide();
    
    // Меняем заголовок
    const correctForm = getCorrectPrepositionForm(subcategoryName);
    $('#mainTitle').text(`Отдых в ${correctForm}`);
    
    // Показываем контейнер с объявлениями, скрываем категории
    $('#categoriesContainer').hide();
    $('#listingsContainer').show();
    $('#searchResultsTitle').hide();
    
    // Загружаем объявления для выбранной подкатегории
    loadListingsBySubcategory(subcategoryId, subcategoryName);
});
// Обработчик клика по подкатегории в карточках
$(document).on('click', '.card .subcategory-link', function(e) {
    e.preventDefault();
    
    const subcategoryId = $(this).data('subcategory-id');
    const subcategoryName = $(this).data('subcategory-name');
    
    // Меняем заголовок
    const correctForm = getCorrectPrepositionForm(subcategoryName);
    $('#mainTitle').text(`Отдых в ${correctForm}`);
    
    // Показываем контейнер с объявлениями, скрываем категории
    $('#categoriesContainer').hide();
    $('#listingsContainer').show();
    $('#searchResultsTitle').hide(); // Скрываем заголовок поиска
    
    // Загружаем объявления для выбранной подкатегории
    loadListingsBySubcategory(subcategoryId, subcategoryName);
});

// Обработчик кнопки "Назад к категориям"
$('#backToCategories').on('click', function() {
    // Возвращаем исходный заголовок
    $('#mainTitle').text('Популярные направления для отдыха');
    
    // Показываем категории, скрываем объявления и результаты поиска
    $('#categoriesContainer').show();
    $('#listingsContainer').hide();
    $('#searchResultsTitle').hide();
});

// Функция загрузки объявлений
function loadListingsBySubcategory(subcategoryId, subcategoryName) {
    $.ajax({
        url: '../index.php?page=fetch_listings',
        type: 'POST',
        data: { subcategory_id: subcategoryId },
               dataType: 'json',
        success: function(response) {
            if (response.success) {
                displaySubcategoryListings(response.listings, subcategoryName);
            } else {
                $('#listingsContent').html('<div class="col-12"><p class="text-center">Объявления не найдены</p></div>');
            }
        },
        error: function() {
            $('#listingsContent').html('<div class="col-12"><p class="text-center">Ошибка загрузки данных</p></div>');
        }
    });
}

// Функция отображения пагинации
function displayPagination(pagination) {
    let html = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    
    // Кнопка "Назад"
    if (pagination.currentPage > 1) {
        html += `<li class="page-item">
                    <a class="page-link" href="#" data-page="${pagination.currentPage - 1}">Назад</a>
                 </li>`;
    }
    
    // Номера страниц
    for (let i = 1; i <= pagination.totalPages; i++) {
        html += `<li class="page-item ${i === pagination.currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                 </li>`;
    }
    
    // Кнопка "Вперед"
    if (pagination.currentPage < pagination.totalPages) {
        html += `<li class="page-item">
                    <a class="page-link" href="#" data-page="${pagination.currentPage + 1}">Вперед</a>
                 </li>`;
    }
    
    html += '</ul></nav>';
    $('#searchPagination').html(html).show();
}


// Универсальная функция отображения объявлений
function displayListings(listings, title) {
    let html = '';
    
    if (listings.length === 0) {
        html = '<div class="col-12"><p class="text-center">Объявления не найдены</p></div>';
    } else {
        listings.forEach(listing => {
            const carouselId = `carouselListing${listing.id}`;
            const mapId = `mapContainer${listing.id}`;
            const photoCount = listing.all_photos.length;
            html += `
            <div class="goods mb-4">
                <div class="goods__image">
                    <div id="${carouselId}" class="carousel slide" data-ride="carousel">
                        <!-- Индикаторы -->
                        ${photoCount > 1 ? `
                        <ol class="carousel-indicators">
                            ${listing.all_photos.map((photo, index) => `
                                <li data-target="#${carouselId}" data-slide-to="${index}" class="${index === 0 ? 'active' : ''}"></li>
                            `).join('')}
                        </ol>` : ''}

                        <!-- Слайды -->
                        <div class="carousel-inner">
                            ${listing.all_photos.map((photo, index) => `
                                <div class="carousel-item ${index === 0 ? 'active' : ''}">
                                    <img src="${photo}" class="d-block w-100" alt="Фото объекта ${index + 1}" style="height: 200px; object-fit: cover;">
                                </div>
                            `).join('')}
                        </div>

                        <!-- Пользовательские стрелки -->
                        ${photoCount > 1 ? `
                        <div class="carousel-controls">
                            <div class="carousel-control-prev-custom" data-target="#${carouselId}" data-slide="prev" role="button" aria-label="Предыдущий" style="position:absolute; top:50%; left:10px; transform:translateY(-50%); cursor:pointer; z-index:10;">
                                <i class="fas fa-chevron-left"></i>
                            </div>
                            <div class="carousel-control-next-custom" data-target="#${carouselId}" data-slide="next" role="button" aria-label="Следующий" style="position:absolute; top:50%; right:10px; transform:translateY(-50%); cursor:pointer; z-index:10;">
                                <i class="fas fa-chevron-right"></i>
                            </div>
                        </div>` : ''}
                    </div>
                </div>
                <div class="goods__content">
                    <div class="goods__title">
                        <h2><a href="/listing/${listing.id}/">${listing.title}</a></h2>
                    </div>
                    <div class="goods__content_row">
                        <div class="goods__detail">
                            <ul>
                                ${listing.has_wifi ? '<li><font color="#FF0000">Wi-Fi бесплатно</font></li>' : ''}
                                <li style="max-width: 400px;border: 1px solid rgb(198, 230, 246);background: rgb(205, 240, 246);border-radius: 4px;color: rgba(8, 15, 23, 0.78);">
                                    <strong>До моря:</strong> <span>${listing.distance_to_sea}</span>
                                </li>
                                <li><strong>Адрес:</strong> <span>${listing.address}</span></li>
                                ${listing.has_parking ? '<li class="goods__views_lg"><strong>Автостоянка:</strong> <span>на территории (бесплатно)</span></li>' : ''}
                                <li><strong>Питание:</strong> <span>${listing.food_options}</span></li>
                                <li><strong>Телефоны:</strong> <span>${listing.phone}</span></li>
                            </ul>
                            
                            <!-- Кнопка показа карты -->
                            <div class="mt-2">
                                <button class="btn btn-outline-primary btn-sm toggle-map-btn" 
                                        data-listing-id="${listing.id}"
                                        data-map-code="${escapeHtml(listing.yandex_map_code || '')}"
                                        data-map-loaded="false">
                                    <i class="fas fa-map-marker-alt"></i> Показать на карте
                                </button>
                            </div>

                            <div class="goods__views goods__views_lg">
                                <span class="hide_xs">
                                    <a href="/listing/${listing.id}/">
                                        <i class="fas fa-comments"></i> Отзывов: (${listing.reviews_count})
                                    </a>
                                </span>
                            </div>

                        </div>
                        <div class="goods__info">
                            <div class="goods__price">
                                <div class="goods__price_title">Цены за номер:</div>
                                <ul class="goods__price_value">
                                    ${listing.prices.map(price => {
                                        const cleanAmount = price.amount.toString().replace(/\.00$/, '');
                                        return `<li class="hide_xs">${price.month}: от ${cleanAmount} руб.</li>`;
                                    }).join('')}
                                </ul>
                            </div>
                            <div class="goods__views goods__views_sm">
                                <span class="hide_xs">
                                    <a href="/listing/${listing.id}/">Отзывы (${listing.reviews_count})</a>
                                </span> 
                            </div>
                        </div>
                    </div>
                    
                    <!-- Контейнер для карты (скрыт по умолчанию) -->
                    <div id="${mapId}" class="map-container mt-3" style="display: none; height: 250px; border-radius: 8px; overflow: hidden;"
                         data-initialized="false">
                        
                    </div>
                </div>
            </div>`;
        });
    }

    $('#listingsContent').html(html);
    initMapButtons();
}

function escapeHtml(unsafe) {
    if (!unsafe) return '';
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

// Функция для инициализации кнопок карты
function initMapButtons() {
    $('.toggle-map-btn').off('click').on('click', function() {
        const listingId = $(this).data('listing-id');
        const mapCode = $(this).data('map-code');
        const mapContainer = $(`#mapContainer${listingId}`);
        const button = $(this);
        const isMapLoaded = button.data('map-loaded');

        if (mapContainer.is(':visible')) {
            // Скрываем карту и сбрасываем флаг
            hideMap(mapContainer, button);
        } else {
            // Показываем карту
            showMap(mapContainer, button, mapCode, listingId, isMapLoaded);
        }
    });
}

// Функция для показа карты
function showMap(mapContainer, button, mapCode, listingId, isMapLoaded) {
    if (!isMapLoaded) {
        if (mapCode && mapCode.trim() !== '') {
            try {
                const decodedMapCode = mapCode
                    .replace(/&amp;/g, '&')
                    .replace(/&lt;/g, '<')
                    .replace(/&gt;/g, '>')
                    .replace(/&quot;/g, '"')
                    .replace(/&#039;/g, "'");
                
                // Устанавливаем высоту для ВСЕХ устройств
                const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
                
                // Для десктопов - одна высота, для мобильных - другая
                if (isMobile) {
                    mapContainer.css('height', '400px');
                } else {
                    mapContainer.css('height', '300px'); // Высота для десктопов
                }
                
                // УБЕРИТЕ overflow: hidden - это критично!
                mapContainer.css('overflow', 'visible');
                
                const optimizedMapCode = optimizeMapForMobile(decodedMapCode);
                const iframeHtml = createMapIframe(optimizedMapCode, listingId);
                
                mapContainer.html(iframeHtml);
                button.data('map-loaded', true);
                
            } catch (error) {
                console.error('Ошибка при вставке карты:', error);
                mapContainer.html(createMapErrorHTML());
                button.data('map-loaded', true);
            }
        } else {
            mapContainer.html(createMapUnavailableHTML());
            button.data('map-loaded', true);
        }
    }
    
    mapContainer.slideDown(300, function() {
        initMobileMapHandlers(mapContainer, listingId);
    });
    
    button.html('<i class="fas fa-times"></i> Скрыть карту');
    button.removeClass('btn-outline-primary').addClass('btn-primary');
}
// Функция для скрытия карты
function hideMap(mapContainer, button) {
    mapContainer.slideUp(300, function() {
        cleanupMapResources(mapContainer);
    });
    
    // Сбрасываем флаг загрузки карты
    button.data('map-loaded', false);
    
    button.html('<i class="fas fa-map-marker-alt"></i> Показать на карте');
    button.removeClass('btn-primary').addClass('btn-outline-primary');
}

// Оптимизация карты для мобильных устройств
function optimizeMapForMobile(mapCode) {
    const viewportMeta = '<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">';
    
    // УНИВЕРСАЛЬНЫЕ стили для ВСЕХ устройств
    const universalCSS = `
        <style>
            body, html { 
                margin: 0; 
                padding: 0; 
                width: 100%;
                height: 100%;
                overflow: visible !important;
            }
            
            .ymaps-2-1-79-map,
            .ymaps-2-1-79-inner-panes,
            .ymaps-2-1-79-ground-pane,
            .ymaps-2-1-79-copyright,
            .ymaps-2-1-79-controls,
            .ymaps-2-1-79-controls__control,
            .ymaps-2-1-79-copyright__wrap,
            .ymaps-2-1-79-copyright__promo,
            .ymaps-2-1-79-copyright__promo-link,
            .map-widget-in-maps-button,
            .button._view_air._size_small._link,
            [class*="button"],
            [class*="copyright"],
            [class*="promo"] {
                pointer-events: auto !important;
                touch-action: auto !important;
                -webkit-user-select: auto !important;
                user-select: auto !important;
                cursor: pointer !important;
            }
            
            /* Разрешаем скролл и зуминг для всей карты */
            .ymaps-2-1-79-map {
                touch-action: pan-x pan-y pinch-zoom !important;
                -webkit-overflow-scrolling: touch !important;
            }
            
            /* Убираем любые блокировки событий */
            .ymaps-2-1-79-events-pane,
            .ymaps-2-1-79-user-selection-none,
            .ymaps-2-1-79-islets__panes,
            .ymaps-2-1-79-controls__control-toolbar,
            .ymaps-2-1-79-controls__control {
                pointer-events: auto !important;
                -webkit-user-select: auto !important;
                user-select: auto !important;
                touch-action: auto !important;
            }
            
            /* Гарантируем, что iframe не блокирует события */
            iframe {
                pointer-events: auto !important;
            }
        </style>
    `;
    
    return mapCode.replace(/<head>/, `<head>${viewportMeta}${universalCSS}`);
}
// Создание iframe для карты с оптимизацией для мобильных
function createMapIframe(mapCode, listingId) {
    const blob = new Blob([mapCode], { type: 'text/html;charset=utf-8' });
    const blobUrl = URL.createObjectURL(blob);
    
    return `
        <iframe 
            id="mapFrame${listingId}"
            src="${blobUrl}"
            style="width: 100%; height: 100%; border: none; display: block;"
            loading="lazy"
            allow="geolocation"
            title="Карта объекта"
            sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
            referrerpolicy="no-referrer-when-downgrade"
            scrolling="no"
        ></iframe>
    `;
}

// Создание HTML для ошибки загрузки карты
function createMapErrorHTML() {
    return `
        <div class="h-100 d-flex align-items-center justify-content-center bg-light">
            <div class="text-center text-muted">
                <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                <p>Ошибка загрузки карты</p>
                <small>Попробуйте обновить страницу</small>
            </div>
        </div>
    `;
}

// Создание HTML для недоступной карты
function createMapUnavailableHTML() {
    return `
        <div class="h-100 d-flex align-items-center justify-content-center bg-light">
            <div class="text-center text-muted">
                <i class="fas fa-map-marked-alt fa-2x mb-2"></i>
                <p>Карта недоступна</p>
            </div>
        </div>
    `;
}

// Инициализация обработчиков для мобильных устройств
function initMobileMapHandlers(mapContainer, listingId) {
    const iframe = mapContainer.find('iframe');
    
    if (iframe.length > 0) {
        iframe.on('load', function() {
            try {
                // Добавляем небольшую задержку для полной загрузки карты
                setTimeout(() => {
                    console.log('Карта загружена, кнопка должна быть доступна');
                    
                }, 1000);
                
            } catch (e) {
                // Игнорируем ошибки CORS, но логируем
                console.log('Карта загружена (CORS ограничения):', e);
            }
        });
        
        // Дополнительная проверка через 3 секунды
        setTimeout(() => {
            console.log('Проверка доступности кнопки карты для listing:', listingId);
        }, 3000);
    }
}

// Очистка ресурсов карты
function cleanupMapResources(mapContainer) {
    const iframe = mapContainer.find('iframe');
    
    if (iframe.length > 0) {
        const src = iframe.attr('src');
        if (src && src.startsWith('blob:')) {
            URL.revokeObjectURL(src);
        }
        
        // Очищаем содержимое iframe для освобождения памяти
        iframe.attr('src', 'about:blank');
    }
    
    mapContainer.empty();
}

// Глобальная очистка при уходе со страницы
$(window).on('beforeunload', function() {
    $('.map-container:visible').each(function() {
        cleanupMapResources($(this));
    });
});

// Обработка изменения ориентации на мобильных устройствах
$(window).on('orientationchange', function() {
    // Перезагружаем видимые карты при изменении ориентации
    $('.map-container:visible').each(function() {
        const mapContainer = $(this);
        const iframe = mapContainer.find('iframe');
        
        if (iframe.length > 0) {
            // Небольшая задержка для завершения анимации поворота
            setTimeout(() => {
                const currentSrc = iframe.attr('src');
                iframe.attr('src', currentSrc); // Перезагружаем iframe
            }, 300);
        }
    });
});
// Обработчик кнопки "Назад к категориям"
$('#backToCategories').on('click', function() {
    // Возвращаем исходный заголовок
    $('#mainTitle').text('Популярные направления для отдыха');
    
    // Показываем категории, скрываем всё остальное
    $('#categoriesContainer').show();
    $('#listingsContainer').hide();
    $('#searchResultsTitle').hide();
    $('#subcategoryTitle').hide();
    $('#searchPagination').hide();
    
    // Очищаем контент
    $('#listingsContent').empty();
});


   //строка поиска
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
    
    // Обработка выбора количества людей
    $('#peopleField').click(function(e) {
        e.stopPropagation();
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
document.addEventListener('DOMContentLoaded', function() {
    // Проверяем наличие flatpickr
    if (typeof flatpickr === 'undefined') {
        console.error('Flatpickr не загружен');
        return;
    }

    // Инициализация календарей
    window.checkinCalendar = null;
    window.checkoutCalendar = null;
    const today = new Date();
    
    try {
        checkinCalendar = flatpickr("#dateFrom-input", {
            dateFormat: "d.m.Y",
            locale: "ru",
            minDate: "today",
            defaultDate: "today",
            onChange: function(selectedDates, dateStr) {
                updateFieldValue('checkin', dateStr);
                
                // Обновляем минимальную дату для checkout
                if (selectedDates[0]) {
                    const nextDay = new Date(selectedDates[0]);
                    nextDay.setDate(nextDay.getDate() + 1);
                    
                    if (checkoutCalendar) {
                        checkoutCalendar.set('minDate', nextDay);
                        
                        // Если дата выезда раньше новой минимальной даты, сбрасываем её
                        const checkoutDate = checkoutCalendar.selectedDates[0];
                        if (checkoutDate && checkoutDate <= selectedDates[0]) {
                            checkoutCalendar.clear();
                            updateFieldValue('checkout', '');
                        }
                    }
                }
            }
        });
        
        checkoutCalendar = flatpickr("#dateTo-input", {
            dateFormat: "d.m.Y",
            locale: "ru",
            minDate: new Date(today.getTime() + 86400000), // Завтра
            onChange: function(selectedDates, dateStr) {
                updateFieldValue('checkout', dateStr);
            }
        });
        
    } catch (error) {
        console.error('Ошибка инициализации календарей:', error);
    }
    
    // функция обновления значений
    function updateFieldValue(type, value) {
        try {
            const valueElement = document.getElementById(`${type}Value`);
            const placeholder = document.getElementById(`${type}Placeholder`);
            const input = document.getElementById(`${type === 'checkin' ? 'dateFrom' : 'dateTo'}-input`);
            
            if (!valueElement || !placeholder || !input) {
                throw new Error(`Элементы для ${type} не найдены`);
            }
            
            if (value) {
                valueElement.textContent = value;
                valueElement.style.display = 'block';
                placeholder.style.display = 'none';
            } else {
                valueElement.style.display = 'none';
                placeholder.style.display = 'block';
                valueElement.textContent = '';
            }
            
            input.value = value;
            
        } catch (error) {
            console.error(`Ошибка обновления поля ${type}:`, error);
        }
    }
    
    addFieldClickHandlers();
});

// Обработчики кликов по полям
function addFieldClickHandlers() {
    const fields = document.querySelectorAll('.search-field');
    
    fields.forEach(field => {
        field.addEventListener('click', function(e) {
            if (!e.target.closest('input')) {
                const input = this.querySelector('input');
                if (input) {
                    input.focus();
                    // Программно открываем календарь
                    if (input.id === 'dateFrom-input' && window.checkinCalendar) {
                        window.checkinCalendar.open();
                    } else if (input.id === 'dateTo-input' && window.checkoutCalendar) {
                        window.checkoutCalendar.open();
                    }
                }
            }
        });
    });
}
    document.addEventListener('DOMContentLoaded', function() {
    // Инициализация Swiper с настройками для бесконечной прокрутки
    const swiper = new Swiper('.nav__fluid_slider', {
        slidesPerView: 'auto',
        spaceBetween: 0,
        loop: true,
        speed: 800,
        /*autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },*/
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
                //swiper.autoplay.stop();
                
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
                    //swiper.autoplay.start();
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
                    //swiper.autoplay.start();
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
                        
                        if (submenu.classList.contains('mobile-submenu-open')) {
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