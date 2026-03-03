<?php
// Параметры подключения
$host = 'db';
$db   = 'newspy';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

// Строка подключения (DSN)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Настройки PDO
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Ошибки БД будут вызывать исключения
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Данные будут возвращаться в виде массивов
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Использовать реальные подготовленные выражения
];

try {
    // Создаем тот самый объект $pdo
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Если подключение не удалось, выводим ошибку
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}