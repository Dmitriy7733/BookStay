<?php
// /assets/cookies.php

function setCookieValue($name, $value, $expire = 0, $path = '/') {
    setcookie($name, $value, $expire, $path);
}

function getCookieValue($name) {
    return isset($_COOKIE[$name]) ? $_COOKIE[$name] : null;
}

function deleteCookie($name) {
    setcookie($name, '', time() - 3600, '/');
}