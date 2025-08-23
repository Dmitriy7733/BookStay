<?php
 /*ini_set('display_errors', 1);
 ini_set('display_startup_errors', 1);
 error_reporting(E_ALL);*/
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Проверка на аутентификацию и роль редактора
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'editor_tmz') {
    // Перенаправить на страницу входа или вывести сообщение об ошибке
    header('Location: index.php?page=login');
    exit();
}

include 'app/includes/header_editor.php';

//$userId=1;//1 для теста
/*if (isset($_SESSION['user_id'])) {
    echo "User ID доступен: " . $_SESSION['user_id'];
} else {
    echo "User ID не установлен.";
}  //для отладки работы сессии*/

?>

<div class="container">
    <div class="container">
    <h3 class="text-center text-3d mt-5">Поиск документации</h3>

    <!-- Форма поиска -->
    <form class="mt-4" id="searchForm">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Введите название или обозначение документа" aria-label="Название документа" required>
            <div class="input-group-append">
    <!--<button class="btn btn-primary" type="submit">Поиск</button>для расширения функционала на перспективу-->
    <button class="btn btn-secondary" type="button" id="clearButton">Очистить</button>
</div>
        </div>
    </form>
    <div class="table-responsive">
        <h3 class="text-center">Результаты поиска</h3>
        <table class="table table-bordered table-hover mt-3" id="searchResultsTable">
        <thead>
            <tr>
                <th>Название</th>
                <th>Обозначение</th>
                <th>Категория</th>
                <th>Подкатегория</th>
            </tr>
        </thead>
        <tbody id="searchResults">
            <!-- Результаты поиска будут загружены здесь -->
            <tr>
                <td colspan="4" class="text-center">Здесь отобразятся документы, найденные с помощью поисковой строки выше</td>
            </tr>
        </tbody>
        </table>
    </div>

    <div class="container mt-3">
    <h2 class="text-center">Инструкции и руководства ОГТ</h2>

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

<!-- Раздел "Памятка" -->
    <div id="memo_tmz">
        <h2 class="text-center">Памятка</h2>
        <p>Данный веб-сайт является закрытым, доступным только для зарегистрированных сотрудников ОАО "ТМЗ им. В.В.Воровского". 
            Вы являетесь редактором. 
            Вы видите документацию так же, как видят ее пользователи. 
            Добавить документ Вы можете через кнопку "Добавить", 
            расположенную в меню. Удалить документ Вы можете через кнопку "Удалить" в списке документов, 
            который появляется при клике (выборе) подкатегории. 
        Посмотреть документ Вы можете, нажав на наименование документа 
        в списке документов или в строке поиска. Для смены роли не забывайте нажать на кнопку "Выход" в меню.</p>
    </div>
</div>
    <!-- Modal окно для отображения списка инструкций к выбранной подкатегории-->
<div class="modal fade" id="instructionsListModal" tabindex="-1" role="dialog" aria-labelledby="instructionsListModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionsListModalLabel">Документы</h5>
                <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Обозначение</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="instructionListModal">
                    <!-- Список инструкций будет загружен сюда -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для просмотра инструкций -->
<div class="modal fade" id="instructionViewModal" tabindex="-1" role="dialog" aria-labelledby="instructionViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content" style="border: 2px solid #007bff; border-radius: 10px;">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionModalLabel">Наименование документа</h5>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Закрыть"> 
                        <span>&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div id="instructionContent">
                    <iframe id="instructionIframe" src="" width="100%" height="800px" style="border:none;"></iframe>
                </div>
                <a href="#" class="btn btn-success" id="downloadButton">Скачать инструкцию</a>
            </div>
        </div>
    </div>
</div>
<?php include 'app/includes/footer_tmz.php'; ?>
<script src="../assets/search_editor_tmz.js"></script>

<script>
    var currentFileUrl = ''; // Переменная для хранения URL текущего файла
    var currentInstructionId; // Переменная для хранения ID инструкции
    var openInstructionModals = 0; // Объявляем переменную openInstructionModals

    // Обработчик для клика на ссылки в списке инструкций
    $(document).on('click', '.instruction-link', function(e) {
        e.preventDefault();
        console.log("Instruction link clicked."); // Лог для проверки
        currentFileUrl = $(this).data('file').replace('http://', 'https://');
        currentInstructionId = $(this).data('id'); // Получаем ID инструкции
        $('#instructionViewModal').modal('show');
        openInstructionModals++; // Увеличиваем счетчик открытых модальных окон

        // Обновляем содержимое iframe
        $('#instructionIframe').attr('src', currentFileUrl);
    });

// Обработчик для клика на кнопку "Скачать инструкцию"
$(document).on('click', '#downloadButton', function(e) {
    e.preventDefault();
    
    if (currentFileUrl) {
        // Создаем временную ссылку и инициируем скачивание
        var link = document.createElement('a');
        link.href = currentFileUrl; // Используем сохраненный URL
        link.download = ''; 
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    } else {
        alert('Файл для скачивания недоступен.');
    }
});
    //удаление выбранной инструкции
    $(document).on('click', '.delete-instruction', function() {
    var instructionId = $(this).data('id');
    var row = $(this).closest('tr'); // Сохраняем ссылку на строку, которую нужно удалить

    if (confirm('Вы уверены, что хотите удалить эту инструкцию?')) {
        $.ajax({
            url: '../index.php?page=delete_instruction_tmz',
            type: 'POST',
            data: { id: instructionId},
            dataType: 'json',
            success: function(response) {
                    if (response.success) {
                        row.remove();
                        alert(response.success);
                    } else {
                    alert(response.error);
                    }
            },
            error: function() {
                alert('Произошла ошибка при удалении инструкции.');
            }
        });
    }
});
</script>
