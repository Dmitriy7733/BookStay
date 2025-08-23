<?php
// /assets/session.php
// Запускаем сессию
session_start();

// Функция для установки значения в сессии
function setSession($key, $value) {
    $_SESSION[$key] = $value;
}

// Функция для получения значения из сессии
function getSession($key) {
    return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
}

// Функция для удаления значения из сессии
function unsetSession($key) {
    unset($_SESSION[$key]);
}