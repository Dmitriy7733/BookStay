<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor_tmz') {
    // Перенаправить на страницу входа или вывести сообщение об ошибке
    header('Location: index.php?page=login');
    exit();
}
include 'app/includes/header_editor.php';
?>

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

<?php include 'app/includes/footer_tmz.php'; ?>
<script>
    function loadSubcategories(categoryId) {
    if (!categoryId) return;

    $.ajax({
        url: '../index.php?page=get_subcategories_tmz',
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
            url: '../index.php?page=get_parent_categories_tmz',
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
        url: '../index.php?page=addTmzCategory',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json', // Убедитесь, что ожидаете JSON-ответ
        success: function(response) {
            if (response.success) {
                alert(response.message); // Успешное сообщение
                $('#categoryName').val(''); // Очистка поля ввода
                loadCategories(); // Обновляем список категорий
            } else {
                alert(response.error); // Ошибка
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Ошибка при добавлении категории');
        }
    });
});

// Обработка добавления подкатегории
$('#addSubcategoryForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '../index.php?page=addTmzSubcategory',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json', // Убедитесь, что ожидаете JSON-ответ
        success: function(response) {
            if (response.success) {
                alert(response.message); // Успешное сообщение
                $('#subcategoryName').val(''); // Очистка поля ввода
                loadSubcategories($('#categorySelect').val()); // Обновляем список подкатегорий
            } else {
                alert(response.error); // Ошибка
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Ошибка при добавлении подкатегории');
        }
    });
});
    // Обработка удаления категории
    $('#deleteCategoryForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../index.php?page=deleteTmzCategory',
            method: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    loadCategories(); // Обновляем список категорий
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
    
    // Получаем значение выбранной подкатегории
    var subcategoryId = $('#subcategorySelect').val();
    
    if (!subcategoryId) {
        alert('Пожалуйста, выберите подкатегорию для удаления.');
        return; // Остановить выполнение, если подкатегория не выбрана
    }
    
    $.ajax({
        url: '../index.php?page=deleteTmzSubcategory',
        method: 'POST',
        data: $(this).serialize(), // Убедитесь, что здесь передаются все данные
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                loadSubcategories($('#deleteSubcategoryCategorySelect,#subcategorySelect').val()); // Обновляем список подкатегорий
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