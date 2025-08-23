<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Проверка на аутентификацию и роль admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

?> 
<!-- app/views/admin_form.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Управление пользователями и инструкциями</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2 class="text-dark text-center">Управление пользователями и инструкциями</h2>

        <!-- Вкладки -->
        <div class="d-flex justify-content-between">
            <ul class="nav nav-tabs" id="adminTabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#instructions">Инструкции на одобрение</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#users">Пользователи</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#complaints">Жалобы пользователей</a>
                </li>
            </ul>
            <form method="POST" action="index.php?page=logout" class="d-inline">
                <button type="submit" class="btn btn-danger">Выход</button>
            </form>
        </div>

        <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="instructions">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Инструкции на одобрение</h3>
                    </div>
                        <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Пользователь</th>
                                                <th>Название инструкции</th>
                                                <th>Категория</th>
                                                <th>Подкатегория</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($instructions as $instruction): ?> 
                                            <tr>
                                            <td><?= htmlspecialchars($instruction['id']) ?></td>
                                            <td><?= htmlspecialchars($instruction['username'] ?? 'Не зарегистрирован') ?></td>
                                            <td>
                                                <a href="#" class="view-instruction" data-id="<?= htmlspecialchars($instruction['id']) ?>">
                                                <?= htmlspecialchars($instruction['title']) ?>
                                                </a>
                                            </td>
                                            <td><?= htmlspecialchars($instruction['category_name']) ?></td>
                                            <td><?= htmlspecialchars($instruction['subcategory_name'] ?? 'Нет') ?></td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <button class="btn btn-success approve-instruction" data-id="<?= htmlspecialchars($instruction['id']) ?>">Одобрить</button>
                                                    <button class="btn btn-danger delete-instruction" data-id="<?= htmlspecialchars($instruction['id']) ?>">Удалить</button>
                                                </div>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?> 
                                        </tbody>
                                    </table>
                                </div>
                        </div>
                </div>
            </div>
        
            
            <!-- Пользователи -->
            <div class="tab-pane fade" id="users">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Пользователи</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Имя пользователя</th>
                                        <th>Статус</th>
                                        <th>Причина блокировки</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= htmlspecialchars($user['status']) ?></td>
                                        <td><?= htmlspecialchars($user['block_reason'] ?? 'Нет') ?></td>
                                        <td>
                                            <?php if ($user['status'] == 'active'): ?>
                                            <button class="btn btn-warning block-user" data-id="<?= htmlspecialchars($user['id']) ?>">Заблокировать</button>
                                            <?php else: ?>
                                            <button class="btn btn-success unblock-user" data-id="<?= htmlspecialchars($user['id']) ?>">Разблокировать</button>
                                            <?php endif; ?>
                                            <button class="btn btn-danger delete-user" data-id="<?= htmlspecialchars($user['id']) ?>">Удалить</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Жалобы пользователей -->
            <div class="tab-pane fade" id="complaints">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3>Жалобы пользователей</h3>
                    </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Пользователь</th>
                                            <th>Сообщение</th>
                                            <th>Ответ</th>
                                            <th>Статус ответа</th>
                                            <th>Действия</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                    <?php if (!empty($complaints)): ?>
                                    <?php foreach ($complaints as $complaint): ?>
                                    <?php 
                                    $user = getDb()->query("SELECT * FROM users WHERE id = {$complaint['user_id']}")->fetch(); 
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($complaint['id'] ?? '') ?></td>
                                        <td><?= htmlspecialchars($user['username'] ?? 'Неизвестный пользователь') ?></td>
                                        <td><?= htmlspecialchars($complaint['complaint_text'] ?? 'Сообщение отсутствует') ?></td>
                                        <td>
                                            <form method="POST" action="app/admin/respond_complaint.php" class="d-inline">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($complaint['id'] ?? '') ?>">
                                            <textarea name="response" class="form-control" rows="1" required></textarea>
                                            <button type="submit" class="btn btn-primary mt-1">Ответить</button>
                                            </form>
                                        </td>
                                        <td><?= htmlspecialchars($complaint['response'] ? 'Ответ дан' : 'Ответ не дан') ?></td>
                                            <td>
                                            <form method="POST" action="app/admin/delete_complaint.php" class="d-inline">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($complaint['id'] ?? '') ?>">
                                                <button type="submit" class="btn btn-danger mt-1 delete-complaint">Удалить</button>
                                            </form>
                                            </td>
                                    </tr>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">Нет жалоб для отображения</td>
                                        </tr>
                                        <?php endif; ?>
                                </tbody>
                                </table>
                            </div>
                        </div>
                </div>
            </div>
    
        </div>
    <!-- Модальное окно для просмотра инструкции -->
<div class="modal fade" id="instructionAdminModal" tabindex="-1" aria-labelledby="instructionAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border: 2px solid #007bff; border-radius: 10px;">
            <div class="modal-header">
                <h5 class="modal-title" id="instructionModalLabel">Просмотр инструкции</h5>
                <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Закрыть"> 
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="instructionContent">
                    <iframe id="instructionIframe" src="" width="100%" height="800px" style="border:none;"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    
    $(document).ready(function() {
    // Обработка блокировки пользователя
    $('.block-user').click(function() {
        const userId = $(this).data('id');
        const reason = prompt("Введите причину блокировки:");
        if (reason) {
            $.post('index.php?page=block_user', {id: userId, reason: reason}, function(response) {
                const result = JSON.parse(response);
                alert(result.success ? 'Пользователь заблокирован' : result.error);
                location.reload(); // Перезагрузка страницы для обновления данных
            });
        }
    });

    // Обработка разблокировки пользователя
    $('.unblock-user').click(function() {
        const userId = $(this).data('id');
        $.post('index.php?page=unblock_user', {id: userId}, function(response) {
            const result = JSON.parse(response);
            alert(result.success ? 'Пользователь разблокирован' : result.error);
            location.reload(); // Перезагрузка страницы для обновления данных
        });
    });

    // Обработка удаления пользователя
    $('.delete-user').click(function() {
        const userId = $(this).data('id');
        if (confirm("Вы уверены, что хотите удалить этого пользователя?")) {
            $.post('index.php?page=delete_user', {id: userId}, function(response) {
                const result = JSON.parse(response);
                alert(result.success ? 'Пользователь удален' : result.error);
                location.reload(); // Перезагрузка страницы для обновления данных
            });
        }
    });
});
$(document).ready(function() {
    $('.approve-instruction').on('click', function() {
        var instructionId = $(this).data('id'); // Получаем ID инструкции

        // AJAX-запрос для одобрения инструкции
        $.ajax({
            url: '../index.php?page=approve_instruction', // Путь к вашему PHP-скрипту
            type: 'POST',
            data: { id: instructionId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    alert(data.success);
                    location.reload(); // Перезагружаем страницу для обновления списка
                } else {
                    alert(data.error);
                }
            },
            error: function() {
                alert('Ошибка при одобрении инструкции. Попробуйте позже.');
            }
        });
    });
    $('.delete-instruction').on('click', function() {
    if (confirm('Вы уверены, что хотите удалить эту инструкцию?')) {
        var instructionId = $(this).data('id'); // Получаем ID инструкции

        // AJAX-запрос для удаления инструкции
        $.ajax({
            url: '../index.php?page=delete_instruction', // Путь к вашему PHP-скрипту
            type: 'POST',
            data: { id: instructionId },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    alert(data.success);
                    location.reload(); // Перезагружаем страницу для обновления списка
                } else {
                    alert(data.error);
                }
            },
            error: function() {
                alert('Ошибка при удалении инструкции. Попробуйте позже.');
            }
        });
    }
});
});
    //для вкладок переключения
    $(document).ready(function(){
        $('a[data-toggle="tab"]').on('click', function (e) {
            e.preventDefault();
            // Удаляем класс active у всех вкладок и скрываем их
            $('#adminTabs .nav-link').removeClass('active');
            $('.tab-pane').removeClass('show active');

            // Добавляем класс active к текущей вкладке и показываем её содержимое
            $(this).addClass('active');
            $($(this).attr('href')).addClass('show active');
        });
    });

$(document).ready(function() {
    $('.view-instruction').on('click', function(e) {
        e.preventDefault(); // Предотвращаем переход по ссылке
        var instructionId = $(this).data('id'); // Получаем ID инструкции
        
        // AJAX-запрос для получения данных инструкции
        $.ajax({
            url: '../index.php?page=viewInstruction',
            type: 'GET',
            data: { id: instructionId },
            dataType: 'json', // Указываем ожидаемый тип данных
            success: function(data) {
                if (data.filePath) {
                    $('#instructionIframe').attr('src', data.filePath); // Устанавливаем путь к файлу в iframe
                    $('#instructionAdminModal').modal('show'); // Показываем модальное окно
                } else {
                    alert('Инструкция не найдена или файл отсутствует.');
                }
            },
            error: function() {
                alert('Ошибка при загрузке инструкции. Попробуйте позже.');
            }
        });
    });
});

</script>
</body> 
</html>