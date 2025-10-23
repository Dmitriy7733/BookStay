<!-- app/views/admin_category.php -->
<?php

/*if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin_tmz') {
    // Перенаправить на страницу входа или вывести сообщение об ошибке
    header('Location: index.php?page=login');
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
                    <h1 class="h22">Панель управления категориями</h1>
                </div> 
                
<div class="container mt-5">
    <div class="mt-5">
        <h2 class="text-center">Добавить категорию</h2>
        <form id="addCategoryForm">
            <div class="form-group">
                <label for="categoryName">Название категории</label>
                <input type="text" name="name" class="form-control" id="categoryName" required>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>

    <div class="mt-5">
        <h2 class="text-center">Добавить подкатегорию</h2>
        <form id="addSubcategoryForm">
            <div class="form-group">
                <label for="categorySelect">Родительская категория</label>
                <select name="parent_id" class="form-control" id="categorySelect" required>
                    <option value="">Выберите категорию</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subcategoryName">Название подкатегории</label>
                <input type="text" name="name" class="form-control" id="subcategoryName" required>
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>

    <div class="mt-5">
        <h2 class="text-center">Удалить категорию</h2>
        <form id="deleteCategoryForm">
            <div class="form-group">
                <label for="deleteCategorySelect">Выберите категорию для удаления</label>
                <select name="id" class="form-control" id="deleteCategorySelect" required>
                    <option value="">Выберите категорию</option>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
    </div>

    <div class="mt-5">
        <h2 class="text-center">Удалить подкатегорию</h2>
        <form id="deleteSubcategoryForm">
            <div class="form-group">
                <label for="deleteSubcategoryCategorySelect">Выберите категорию для подкатегории</label>
                <select name="category_id" class="form-control" id="deleteSubcategoryCategorySelect" onchange="loadSubcategories(this.value)" required>
                    <option value="">Выберите категорию</option>
                </select>
            </div>
            <div class="form-group">
                <label for="subcategorySelect">Выберите подкатегорию для удаления</label>
                <select name="id" class="form-control" id="subcategorySelect" required>
                    <option value="">Сначала выберите категорию</option>
                </select>
            </div>
            <button type="submit" class="btn btn-danger">Удалить</button>
        </form>
    </div>
</div>
<footer class="mt-5 bg-secondary text-black text-center py-2">
    <div class="container">
        <p class="mb-0">&copy; 2025 Отдых на курортах России без посредников. Дмитрий Попов.</p>
    </div>
</footer>
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
    
    
    function loadSubcategories(categoryId) {
    if (!categoryId) return;

    $.ajax({
        url: '../index.php?page=get_subcategories',
        method: 'GET',
        data: { category_id: categoryId },
        dataType: 'json',
        success: function(data) {
            if (data.error) {
                console.error(data.error);
                alert(data.error);
                return;
            }
            var subcategorySelect = $('#subcategorySelect');
            subcategorySelect.empty();
            subcategorySelect.append($('<option>', { value: '', text: '-- Выберите подкатегорию --' }));
            $.each(data, function(index, subcategory) {
                subcategorySelect.append($('<option>', { value: subcategory.id, text: subcategory.name }));
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching subcategories:', error);
            alert('Ошибка при загрузке подкатегорий');
        }
    });
}
$(document).ready(function() {
    // Удаление сообщений через 10 секунд
    setTimeout(function() {
        $('#error-message').fadeOut(500);
        $('#success-message').fadeOut(500);
    }, 10000);
// Инициализация категорий
loadCategories();
    // Загрузка категорий
    function loadCategories() {
        $.ajax({
            url: '../index.php?page=get_parent_categories',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    console.error(data.error);
                    alert(data.error);
                    return;
                }
                var categorySelect = $('#categorySelect, #deleteCategorySelect, #deleteSubcategoryCategorySelect');
                categorySelect.empty();
                categorySelect.append($('<option>', { value: '', text: '-- Выберите категорию --' }));
                $.each(data, function(index, category) {
                    categorySelect.append($('<option>', { value: category.id, text: category.name }));
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching categories:', xhr.responseText);
                alert('Ошибка при загрузке категорий');
            }
        });
    }

// Обработка добавления категории
$('#addCategoryForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../index.php?page=add_category',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#categoryName').val('');
                    loadCategories();
                } else {
                    alert('Ошибка: ' + (response.error || 'Неизвестная ошибка'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.log('Response:', xhr.responseText);
                alert('Ошибка при добавлении категории. Проверьте, что сервер возвращает JSON.');
            }
        });
    });

    // Обработка добавления подкатегории
    $('#addSubcategoryForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../index.php?page=add_subcategory',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    $('#subcategoryName').val('');
                    // Обновляем список подкатегорий если выбрана категория
                    var categoryId = $('#categorySelect').val();
                    if (categoryId) {
                        loadSubcategories(categoryId);
                    }
                } else {
                    alert('Ошибка: ' + (response.error || 'Неизвестная ошибка'));
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', status, error);
                console.log('Response:', xhr.responseText);
                alert('Ошибка при добавлении подкатегории. Проверьте, что сервер возвращает JSON.');
            }
        });
    });

    // Обработка удаления категории
    $('#deleteCategoryForm').on('submit', function(e) {
    e.preventDefault();
    
    var categoryId = $('#deleteCategorySelect').val();
    var categoryName = $('#deleteCategorySelect option:selected').text();
    
    if (!confirm(`Вы уверены, что хотите удалить категорию "${categoryName}"? Это действие удалит все подкатегории, объявления и связанные данные. Действие необратимо!`)) {
        return;
    }

    $.ajax({
        url: '../index.php?page=delete_category',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                loadCategories();
                // Очищаем форму удаления подкатегорий
                $('#deleteSubcategoryCategorySelect').val('');
                $('#subcategorySelect').empty().append('<option value="">Сначала выберите категорию</option>');
            } else {
                alert(response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Ошибка при удалении категории');
        }
    });
});
    // Обработка удаления подкатегории
    $('#deleteSubcategoryForm').on('submit', function(e) {
    e.preventDefault();
    
    var subcategoryId = $('#subcategorySelect').val();
    var categoryId = $('#deleteSubcategoryCategorySelect').val();
    
    if (!subcategoryId) {
        alert('Пожалуйста, выберите подкатегорию для удаления.');
        return;
    }
    
    if (!confirm('Вы уверены, что хотите удалить эту подкатегорию? Все связанные объявления будут отвязаны.')) {
        return;
    }
    
    $.ajax({
        url: '../index.php?page=delete_subcategory',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                loadSubcategories(categoryId);
                $('#subcategorySelect').empty().append('<option value="">-- Выберите подкатегорию --</option>');
            } else {
                alert(response.error);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Ошибка при удалении подкатегории');
        }
    });
});
});
</script>
</body> 
</html>