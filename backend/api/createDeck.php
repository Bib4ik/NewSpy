<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../connect-bd.php';
require_once __DIR__ . '/../middleware/auth.php';

/** @var PDO $pdo */
$user = authenticate();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deckName = trim($_POST["deckName"] ?? '');
    $cards = $_POST["cards"] ?? [];

    if (empty($deckName) || empty($cards)) {
        http_response_code(400);
        echo json_encode(['error' => 'Заполните все поля']);
        exit;
    }

    //Добавляем колоду в таблицу с колодами
    $stmt = $pdo->prepare("INSERT INTO decks (user_id, deck_name) VALUES (?,?)");
    $stmt->execute([$user->userId, $deckName]);
    $deckId = $pdo->lastInsertId();

    //Добавляем карты в таблицу с картами
    $stmtCard = $pdo->prepare("INSERT INTO cards (deck_id, card_name) VALUES (?,?)");

    foreach ($cards as $cardText) {
        $cleanText = trim($cardText);
        if (!empty($cleanText)) {
            $stmtCard->execute([$deckId, $cleanText]);
        }
    }
    echo json_encode(['success' => 'Колода и карты созданы!']);
}