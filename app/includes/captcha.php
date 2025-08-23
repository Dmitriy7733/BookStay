<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$fontPath = __DIR__ . '/../includes/arial_bolditalicmt.ttf';

// Генерация случайной строки
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$randomString = '';
for ($i = 0; $i < 6; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
}

$_SESSION['captcha'] = $randomString;

// Создание капчи с увеличенными размерами
$width = 240; // Увеличиваем ширину
$height = 100; // Увеличиваем высоту
$captchaImage = imagecreatetruecolor($width, $height);
$bgColor = imagecolorallocate($captchaImage, 255, 255, 255); // Белый фон
$textColor = imagecolorallocate($captchaImage, 0, 0, 0); // Черный текст
imagefilledrectangle($captchaImage, 0, 0, $width, $height, $bgColor);

// Добавление фона с шумом
for ($i = 0; $i < 200; $i++) { // Увеличиваем количество шумовых точек
    $pixelColor = imagecolorallocate($captchaImage, rand(200, 255), rand(200, 255), rand(200, 255));
    imagesetpixel($captchaImage, rand(0, $width), rand(0, $height), $pixelColor);
}

// Увеличиваем координаты для текста
$x = rand(20, 60);
$y = rand(40, 80);

// Добавление текста с использованием TrueType шрифта
imagettftext($captchaImage, 24, 0, $x, $y, $textColor, $fontPath, $randomString);

// Добавление линий для усложнения распознавания
for ($i = 0; $i < 10; $i++) { // Увеличиваем количество линий
    $lineColor = imagecolorallocate($captchaImage, rand(0, 255), rand(0, 255), rand(0, 255));
    imageline($captchaImage, 0, rand(0, $height), $width, rand(0, $height), $lineColor);
}

// Вывод изображения
header('Content-Type: image/png');
imagepng($captchaImage);
imagedestroy($captchaImage);
