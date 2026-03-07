<?php

    header('Content-Type: application/json');
    require_once __DIR__ . '/../../connect-bd.php';
    require_once __DIR__ . '/../middleware/auth.php';
    /** @var PDO $pdo */

    $adminId = 1;

    //Админ колоды
    $stmt = $pdo->prepare("SELECT id, deck_name FROM decks WHERE user_id = ?");
    $stmt->execute([$adminId]);
    $adminDecks = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Пользовательские колоды — только если залогинен
    $userDecks = [];
    $user = tryAuthenticate();

    if ($user && $user->userId !== $adminId) {
        $stmt = $pdo->prepare("SELECT id, deck_name FROM decks WHERE user_id = ?");
        $stmt->execute([$user->userId]);
        $userDecks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    echo json_encode([
        'adminDecks' => $adminDecks,
        'myDecks'    => $userDecks,
    ]);