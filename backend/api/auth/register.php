<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../../connect-bd.php';
require_once __DIR__ . '/../../config.php';
/** @var PDO $pdo */

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST["login"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $passwordAgain = $_POST["passAgain"] ?? '';


if (empty($login) || empty($email) || empty($password) || empty($passwordAgain)) {
    http_response_code(400);
    echo json_encode(['error' => 'Заполните все поля']);
    exit;
}
if (strlen($login) < 3 || strlen($email) < 3 || strlen($password) < 3 || strlen($passwordAgain) < 3){
    http_response_code(400);
    echo json_encode(['error' => 'Логин, пароль и email не могут быть короче 3 символов']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    echo json_encode(['error' => 'Некоректный email']);
    exit;
}
if ($password !== $passwordAgain) {
    http_response_code(400);
    echo json_encode(['error' => 'Пароли не совпадают']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    echo json_encode(['error' => 'Некорректный email']);
    exit;
}

$check = $pdo->prepare("SELECT id FROM users WHERE login = ? OR email = ?");
$check->execute([$login, $email]);
if ($check->fetch()) {
    echo json_encode(['error' => 'Логин или Email уже заняты']);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT); //Хешируем пароль перед тем как передать в бд

$stmt = $pdo->prepare('INSERT INTO users (login, email, password) VALUES (?, ?, ?)');

if ($stmt->execute([$login, $email, $hashedPassword])){
    echo json_encode(['good' => 'Вы успешно зарегистрированы']);
}
else{
    http_response_code(400);
    echo json_encode(['error' => 'Ошибка при регистрации']);
    }
}

