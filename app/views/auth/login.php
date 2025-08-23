<!-- app/views/auth/login.php -->
<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'app/includes/header.php'; 
?>

<div class="login-container">
    <h1 class="text-center">Вход в систему</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color:red;'>" . htmlspecialchars($_SESSION['error']) . "</p>";
        unset($_SESSION['error']); // Удаляем ошибку после отображения
    }
    
    if (isset($_SESSION['success'])) {
        echo "<div class='success'>{$_SESSION['success']}</div>";
        unset($_SESSION['success']); // Удаляем сообщение после отображения
    }

    ?>
    <form action="" method="post">
        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" name="username" id="username" class="form-control" required autocomplete="username">
        </div>
        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
        </div>
        <button type="submit" class="btn btn-primary btn-block">Войти</button>
    </form>
    <p class="text-center mt-4">
        <a href="?page=change_password">Сменить пароль</a>
    </p>
</div>

<?php include 'app/includes/footer.php'; ?>