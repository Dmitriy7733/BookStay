<?php include 'app/includes/header.php'; 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$errors = $_SESSION['errors'] ?? []; // Получаем массив сообщений об ошибках
$message = $_SESSION['success'] ?? null; // Получаем сообщение об успехе

// Очищаем сообщения после их отображения
unset($_SESSION['errors']);
unset($_SESSION['success']);
?>

<div class="change-password-container">
    <h1 class="text-center">Смена пароля</h1>

    <?php if (!empty($errors)): ?>
    <div style="color:red;">
        <?php foreach ($errors as $error): ?>
            <p><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (isset($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="?page=change_password" method="post">
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="current_password">Текущий пароль:</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="new_password">Новый пароль:</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Подтвердите новый пароль:</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Сменить пароль</button>
    </form>
</div>
<?php include 'app/includes/footer.php'; ?>