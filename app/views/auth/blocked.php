<?php
// views/auth/blocked.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доступ заблокирован</title>
</head>
<body>
    <h1>Ваш доступ заблокирован</h1>
    <p>Пожалуйста, свяжитесь с администратором для получения дополнительной информации.</p>
</body>
</html>