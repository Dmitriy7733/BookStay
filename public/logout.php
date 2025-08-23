<?php
// /public/logout.php
session_start();

// Уничтожаем все данные сессии
$_SESSION = array(); // Очищаем массив сессии
session_destroy(); // Уничтожаем сессию

// Перенаправляем пользователя на главную страницу
header("Location: index.php");
exit();