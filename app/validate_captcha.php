<?php
//   /app/validate_captcha
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$captcha_input = $_POST['captcha'] ?? '';
$expected_captcha = $_SESSION['captcha'] ?? ''; 

header('Content-Type: application/json');
if ($captcha_input === $expected_captcha) {
    echo json_encode(['success' => true,'message' => 'Капча решена.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Капча введена неверно.']);
}