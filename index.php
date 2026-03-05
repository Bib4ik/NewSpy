<?php
require_once 'connect-bd.php'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Шпион</title>
</head>
<body>

<form action="/backend/api/logic.php">
    <div class="main__ChoiceDeck">
        <label>
            <input type="radio" name="selected_deck" value<?=$deckID?>>
            Колода "English Verbs"
        </label>
        <label>
            <input type="radio" name="selected_deck" value<?=$deckID?>>
            Колода "English Verbs"
        </label>
        <label>
            <input type="radio" name="selected_deck" value<?=$deckID?>>
            Колода "English Verbs"
        </label>
        <a href="/frontend/pages/createDeck.html" class="">Создать свой набор</a>
    </div>
    <div class="main__ChoicePlayer">
        <h1>Выберите количество игроков</h1>
        <input type="text">
        <button type="submit">Создать игру</button>
        <p></p>
    </div>
</form>
<div class="auth">
    <a href="/frontend/pages/login.html" class="">Авторизация</a>
    <a href="/frontend/pages/register.html" class="">Регистрация</a>
</div>

</body>
</html>