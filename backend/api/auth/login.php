<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../connect-bd.php';
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../vendor/autoload.php'; // Важно для JWT!

use Firebase\JWT\JWT;
/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = trim($_POST["login"] ?? '');
    $password = $_POST["password"] ?? '';

    if (empty($login) || empty($password)) {
        http_response_code(400);
        echo json_encode(['error' => 'Заполните все поля']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, login, password FROM users WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $payload = [
            'iss' => 'my-app',
            'iat' => time(),
            'exp' => time() + JWT_EXPIRES,
            'userId' => $user['id'],
            'login'  => $user['login']
        ];

        $jwt = JWT::encode($payload, JWT_SECRET, 'HS256');

        // Отправляем ОДИН ответ с сообщением И токеном
        echo json_encode([
            'success' => true,
            'message' => 'Вы успешно вошли',
            'token' => $jwt
        ]);
        exit;

    } else {
        http_response_code(401);
        echo json_encode(['error' => 'Неверный логин или пароль']);
        exit;
    }
}


