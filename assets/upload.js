$(document).ready(function() {
    // Удаление сообщений через 10 секунд
    setTimeout(function() {
        $('#error-message').fadeOut(500);  // Скрываем сообщение об ошибке
        $('#success-message').fadeOut(500); // Скрываем сообщение об успехе
    }, 10000); // 10000 мс = 10 секунд
});
$(document).ready(function() {
    // Загрузка категорий
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
            var categorySelect = $('#categorySelect');
            categorySelect.empty();
            categorySelect.append($('<option>', { value: '', text: '-- Выберите категорию --' }));
            $.each(data, function(index, category) {
                categorySelect.append($('<option>', { value: category.id, text: category.name }));
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching categories:', xhr.responseText); // Логируем ответ сервера
            alert('Ошибка при загрузке категорий');
        }
    });
});

    // Получение подкатегорий при изменении категории
    $('#categorySelect').off('change').on('change', function() {
    var categoryId = $(this).val();
    if (!categoryId) return; // Если не выбрана категория, выходим

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
});