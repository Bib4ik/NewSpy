-- 1. Таблица пользователей
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB;

-- 2. Таблица колод (Deck)
-- Каждая колода привязана к пользователю через user_id
CREATE TABLE IF NOT EXISTS decks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    deck_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;

-- 3. Таблица карт
-- Каждая карта привязана к колоде через deck_id
CREATE TABLE IF NOT EXISTS cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    deck_id INT NOT NULL,
    card_name VARCHAR(100) NOT NULL,
    photo VARCHAR(255) DEFAULT 'default_card.png',
    FOREIGN KEY (deck_id) REFERENCES decks(id) ON DELETE CASCADE
    ) ENGINE=InnoDB;