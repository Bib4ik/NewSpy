<?php
require_once __DIR__ . '/../config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function authenticate() {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? '';
    $token = str_replace('Bearer ', '', $authHeader);

    if (!$token) {
        http_response_code(401);
        echo json_encode(['error' => 'Токен отсутствует']);
        exit;
    }

    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET, 'HS256'));
        return $decoded; // возвращает данные из токена (userId, email)
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['error' => 'Токен недействителен']);
        exit;
    }
}
