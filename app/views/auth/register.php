<!-- app/views/auth/register.php -->

<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'app/includes/header.php'; 
?>
<div class="register-container">
    <h2>Регистрация</h2>
    <?php 
    if (isset($_SESSION['errors'])) { foreach ($_SESSION['errors'] as $error) { echo "<div class='alert alert-danger'>$error</div>"; } unset($_SESSION['errors']); } 
    ?>
    
    <form action="index.php?page=register" method="post">
        <div class="form-group">
            <label for="username">Логин</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Повторите пароль</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <div class="form-group">
            <label for="captcha">Пожалуйста, введите текст с изображения:</label><br>
            <img src="../app/includes/captcha.php" alt="Капча" id="captchaImage">
            <button type="button" class="btn btn-secondary" onclick="refreshCaptcha()">Обновить капчу</button>
            <input type="text" class="form-control" id="captcha" name="captcha" required>
            <div id="captchaError" class="text-danger" style="display:none;"></div>
        </div>
        <button type="button" class="btn btn-primary" onclick="submitForm()">Зарегистрироваться</button>
    </form>
</div>
<?php include 'app/includes/footer.php'; ?>
<script>
function refreshCaptcha() {
    var captchaImage = document.getElementById('captchaImage');
    captchaImage.src = '../app/includes/captcha.php?' + Math.random();
}
function submitForm() {
    var captchaInput = document.getElementById('captcha').value;
    var captchaError = document.getElementById('captchaError');

    fetch('../app/validate_captcha.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'captcha=' + encodeURIComponent(captchaInput)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.querySelector('form').submit();
        } else {
            captchaError.textContent = data.message;
            captchaError.style.display = 'block';
        }
    });
}
</script>