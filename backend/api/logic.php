<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../connect-bd.php';
require_once __DIR__ . '/../config.php';
/** @var PDO $pdo */

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedDeckId = $_POST["selectedDeckId"] ?? '';
    $playerCount  = (int)$_POST["playerCount"] ?? '';

    if ($playerCount < 3) {
        echo json_encode(['error' => 'Минимум 3 игрока для старта игры']);
        exit;
    }

    if (empty($selectedDeckId)) {
        echo json_encode(['error' => 'Колода не выбрана']);
        exit;
    }

    $stmt = $pdo->prepare("SELECT id, card_name FROM cards WHERE deck_id = ?");
    $stmt->execute([$selectedDeckId]);
    $cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Выбор 1 карты для игры
    $selectCard = $cards[array_rand($cards)];
    $secretCard = $selectCard["card_name"];

    //Выбор шпиона
    $spy = rand(1, $playerCount);

    //Список ролей
    $gameData = [];
    for ($i = 1; $i <=$playerCount; $i++) {
        if ($i === $spy) {
            $gameData[$i]= "Шпион";
        }
        else {
            $gameData[$i]= $secretCard;
        }
    }

    echo json_encode($gameData);
}




