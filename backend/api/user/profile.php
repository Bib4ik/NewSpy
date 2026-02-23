<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../database.php';
require_once __DIR__ . '/../../middleware/auth.php';

// Одна строка — и роут защищён
$user = authenticate();

// Если токен невалидный — скрипт остановится в authenticate()
// Сюда дойдём только если токен ок
echo json_encode([
    'message' => 'Привет!',
    'userId'  => $user->userId,
    'email'   => $user->email
]);
