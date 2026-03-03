<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('JWT_SECRET', $_ENV['JWT_SECRET']); // Берет JWT код из .env
define('JWT_EXPIRES', 60 * 60 * 24 * 30);
