<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

const JWT_SECRET = 'твой_ключ';
const JWT_EXPIRES = 60 * 60 * 24 * 30;
