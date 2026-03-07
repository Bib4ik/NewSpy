// ─── AUTH CHECK ────────────────────────────────────────────────
const token = localStorage.getItem('token');
if (!token) window.location.href = '/frontend/pages/login.html';

// Декодируем payload из JWT (без проверки подписи — только для UI)
function parseJWT(t) {
    try {
        return JSON.parse(atob(t.split('.')[1].replace(/-/g,'+').replace(/_/g,'/')));
    } catch { return null; }
}

const payload = parseJWT(token);
if (payload?.login) {
    document.getElementById('nav-login').textContent = payload.login;
}

// ─── STATE ─────────────────────────────────────────────────────
let selectedDeck = null;

// ─── LOAD DECKS ────────────────────────────────────────────────
async function loadDecks() {
    try {
        const res = await fetch('/backend/api/vitrina.php', {
            headers: { 'Authorization': `Bearer ${token}` }
        });

        if (res.status === 401) {
            localStorage.removeItem('token');
            window.location.href = '/frontend/pages/login.html';
            return;
        }

        const data = await res.json();
        renderDecks('admin-decks', data.adminDecks, 'admin-count', '🌐');
        renderDecks('my-decks',    data.myDecks,    'my-count',    '🃏');
    } catch (e) {
        showToast('Ошибка загрузки наборов');
        document.getElementById('admin-decks').innerHTML = '<div class="empty-state">Не удалось загрузить</div>';
        document.getElementById('my-decks').innerHTML    = '<div class="empty-state">Не удалось загрузить</div>';
    }
}

// ─── RENDER ────────────────────────────────────────────────────
function renderDecks(containerId, decks, countId, icon) {
    const container = document.getElementById(containerId);
    document.getElementById(countId).textContent = decks.length;

    if (!decks.length) {
        const isEmpty = containerId === 'my-decks';
        container.innerHTML = `<div class="empty-state">
        ${isEmpty
            ? 'У тебя пока нет наборов. <a href="/frontend/pages/createDeck.html">Создать?</a>'
            : 'Нет публичных наборов'}
      </div>`;
        return;
    }

        container.innerHTML = decks.map(deck => `
      <div class="deck-card" id="deck-${deck.id}" onclick="selectDeck(${deck.id}, '${escHtml(deck.deck_name)}')">
        <div class="selected-check">✓</div>
        <div class="deck-card-inner">
          <div class="deck-icon">${icon}</div>
          <div class="deck-name">${escHtml(deck.deck_name)}</div>
        </div>
      </div>
    `).join('');
}

// ─── SELECT DECK ───────────────────────────────────────────────
function selectDeck(id, name) {
    if (selectedDeck) {
        const prev = document.getElementById(`deck-${selectedDeck}`);
        if (prev) prev.classList.remove('selected');
    }

    selectedDeck = id;
    document.getElementById(`deck-${id}`).classList.add('selected');

    const panel = document.getElementById('play-panel');
    panel.classList.remove('empty');
    document.getElementById('selected-name').textContent = name;
    document.getElementById('selected-meta').textContent = 'Набор готов к игре!';
}

// ─── START GAME ────────────────────────────────────────────────
function startGame() {
    if (!selectedDeck) return;
    // Переходим на страницу игры с id набора
    window.location.href = `/frontend/pages/game.html?deck=${selectedDeck}`;
}

// ─── LOGOUT ────────────────────────────────────────────────────
function logout() {
    localStorage.removeItem('token');
    window.location.href = '/frontend/pages/login.html';
}

// ─── TOAST ─────────────────────────────────────────────────────
function showToast(msg) {
    const t = document.getElementById('toast');
    t.textContent = msg;
    t.classList.add('show');
    setTimeout(() => t.classList.remove('show'), 2800);
}

// ─── UTILS ─────────────────────────────────────────────────────
function escHtml(str) {
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

// ─── INIT ──────────────────────────────────────────────────────
loadDecks();