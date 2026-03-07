<?php
require_once 'connect-bd.php';
require_once 'backend/middleware/auth.php';
/** @var PDO $pdo */

// Получаем данные пользователя
//$user = authenticate();
// Мой админ айди под которым будут базовые наборы
$adminId = 1;
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Шпион</title>
    <link href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;700;900&family=Mulish:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/frontend/styles/main.css">
</head>
<body>

<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<nav>
    <div class="logo">NEWSPY</div>
    <div class="nav-user">
        <div class="nav-username">Привет, <span id="nav-login">...</span></div>
        <a href="/frontend/pages/createDeck.html" class="btn-nav">+ Набор</a>
        <button class="btn-nav" onclick="logout()">Выйти</button>
    </div>
</nav>

<main>

    <div class="hero">
        <h1>Выбери набор,<br><em>начни игру</em></h1>
        <p>Выбери любой набор карт ниже и нажми «Играть»</p>
    </div>

    <!-- PLAY PANEL -->
    <div class="play-panel empty" id="play-panel">
        <div class="play-panel-info">
            <div class="play-panel-label">Выбранный набор</div>
            <div class="play-panel-name" id="selected-name">Ничего не выбрано</div>
            <div class="play-panel-meta" id="selected-meta">Выбери набор из списка ниже</div>
        </div>
        <button class="btn-play" id="btn-play" onclick="startGame()">▶ Играть</button>
    </div>

    <!-- ADMIN DECKS -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Публичные наборы</div>
            <div class="section-badge admin">от администратора</div>
            <div class="section-badge" id="admin-count">0</div>
        </div>
        <div class="deck-grid" id="admin-decks">
            <div class="skeleton"></div>
            <div class="skeleton"></div>
            <div class="skeleton"></div>
        </div>
    </div>

    <!-- MY DECKS -->
    <div class="section">
        <div class="section-header">
            <div class="section-title">Мои наборы</div>
            <div class="section-badge" id="my-count">0</div>
        </div>
        <div class="deck-grid" id="my-decks">
            <div class="skeleton"></div>
            <div class="skeleton"></div>
        </div>
    </div>

</main>

<div class="toast" id="toast"></div>

<script src="/frontend/js/main.js"></script>
</body>
</html>