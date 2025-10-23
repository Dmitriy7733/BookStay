<!-- /app/views/user_management.php -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}
?> 

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями - Админ-панель</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                                <a class="dropdown-item text-danger" href="logout.php">
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
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="fas fa-sign-out-alt"></i>
                                Выйти
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Управление пользователями</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group mr-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="exportUsers()">
                            <i class="fas fa-download"></i> Экспорт
                        </button>
                    </div>
                </div>
            </div>

            <!-- Фильтры и поиск -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <select class="form-control" id="roleFilter">
                        <option value="">Все роли</option>
                        <option value="guest">Гости</option>
                        <option value="hotelier">Отельеры</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select class="form-control" id="statusFilter">
                        <option value="">Все статусы</option>
                        <option value="1">Активные</option>
                        <option value="0">Заблокированные</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="searchInput" placeholder="Поиск по имени или email...">
                </div>
            </div>

            <!-- Таблица пользователей -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Имя пользователя</th>
                            <th>Email</th>
                            <th>Роль</th>
                            <th>Телефон</th>
                            <th>Дата регистрации</th>
                            <th>Статус</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr data-user-id="<?= $user['id'] ?>">
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <span class="badge badge-<?= $user['role'] === 'hotelier' ? 'warning' : 'info' ?>">
                                    <?= $user['role'] === 'hotelier' ? 'Отельер' : 'Гость' ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($user['phone'] ?? 'Не указан') ?></td>
                            <td><?= date('d.m.Y H:i', strtotime($user['registration_date'])) ?></td>
                            <td>
                                <span class="badge badge-<?= $user['is_active'] ? 'success' : 'danger' ?>">
                                    <?= $user['is_active'] ? 'Активен' : 'Заблокирован' ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <?php if ($user['is_active']): ?>
                                        <button class="btn btn-warning btn-block-user" 
                                                data-user-id="<?= $user['id'] ?>" 
                                                data-username="<?= htmlspecialchars($user['username']) ?>">
                                            <i class="fas fa-lock"></i> Заблокировать
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-success btn-unblock-user" 
                                                data-user-id="<?= $user['id'] ?>" 
                                                data-username="<?= htmlspecialchars($user['username']) ?>">
                                            <i class="fas fa-unlock"></i> Разблокировать
                                        </button>
                                    <?php endif; ?>
                                    
                                    <button class="btn btn-danger btn-delete-user" 
                                            data-user-id="<?= $user['id'] ?>" 
                                            data-username="<?= htmlspecialchars($user['username']) ?>">
                                        <i class="fas fa-trash"></i> Удалить
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled"><a class="page-link" href="#">Предыдущая</a></li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Следующая</a></li>
                </ul>
            </nav>
        </main>
    </div>
</div>

<!-- Модальное окно блокировки -->
<div class="modal fade" id="blockUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Блокировка пользователя</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите заблокировать пользователя <strong id="blockUsername"></strong>?</p>
                <div class="form-group">
                    <label for="blockReason">Причина блокировки:</label>
                    <textarea class="form-control" id="blockReason" rows="3" required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-warning" id="confirmBlock">Заблокировать</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно разблокировки -->
<div class="modal fade" id="unblockUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Разблокировка пользователя</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите разблокировать пользователя <strong id="unblockUsername"></strong>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-success" id="confirmUnblock">Разблокировать</button>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно удаления -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Удаление пользователя</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Вы уверены, что хотите удалить пользователя <strong id="deleteUsername"></strong>? Это действие нельзя отменить.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Удалить</button>
            </div>
        </div>
       </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    let currentUserId = null;

    // Блокировка пользователя
    $('.btn-block-user').click(function() {
        currentUserId = $(this).data('user-id');
        $('#blockUsername').text($(this).data('username'));
        $('#blockUserModal').modal('show');
    });

    $('#confirmBlock').click(function() {
        const reason = $('#blockReason').val();
        if (!reason) {
            alert('Укажите причину блокировки');
            return;
        }

        $.post('../index.php?page=block_user', {
            id: currentUserId,
            reason: reason
        }, function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                location.reload();
            } else {
                alert(result.error || 'Ошибка при блокировке');
            }
        });
    });

    // Разблокировка пользователя
    $('.btn-unblock-user').click(function() {
        currentUserId = $(this).data('user-id');
        $('#unblockUsername').text($(this).data('username'));
        $('#unblockUserModal').modal('show');
    });

    $('#confirmUnblock').click(function() {
        $.post('../index.php?page=unblock_user', {
            id: currentUserId
        }, function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                location.reload();
            } else {
                alert(result.error || 'Ошибка при разблокировке');
            }
        });
    });

    // Удаление пользователя
    $('.btn-delete-user').click(function() {
        currentUserId = $(this).data('user-id');
        $('#deleteUsername').text($(this).data('username'));
        $('#deleteUserModal').modal('show');
    });

    $('#confirmDelete').click(function() {
        $.post('../index.php?page=delete_user', {
            id: currentUserId
        }, function(response) {
            const result = JSON.parse(response);
            if (result.success) {
                location.reload();
            } else {
                alert(result.error || 'Ошибка при удалении');
            }
        });
    });

    // Фильтрация и поиск
    $('#roleFilter, #statusFilter, #searchInput').on('change input', function() {
        filterUsers();
    });

    function filterUsers() {
        const role = $('#roleFilter').val();
        const status = $('#statusFilter').val();
        const search = $('#searchInput').val().toLowerCase();

        $('tbody tr').each(function() {
            const row = $(this);
            const userRole = row.find('td:nth-child(4)').text().toLowerCase();
            const userStatus = row.find('td:nth-child(7)').text().includes('Активен') ? '1' : '0';
            const username = row.find('td:nth-child(2)').text().toLowerCase();
            const email = row.find('td:nth-child(3)').text().toLowerCase();

            const roleMatch = !role || (role === 'guest' && userRole.includes('гость')) || 
                             (role === 'hotelier' && userRole.includes('отельер'));
            const statusMatch = !status || userStatus === status;
            const searchMatch = !search || username.includes(search) || email.includes(search);

            row.toggle(roleMatch && statusMatch && searchMatch);
        });
    }
});

function exportUsers() {
    alert('Функция экспорта будет реализована позже');
}
</script>
</body>
</html>