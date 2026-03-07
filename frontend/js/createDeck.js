async function submitDeck() {
    const deckName = document.querySelector('input[name="deckName"]').value.trim();
    const cardInputs = document.querySelectorAll('input[name="cards[]"]');
    const cards = Array.from(cardInputs).map(i => i.value.trim()).filter(v => v);

    if (!deckName || cards.length === 0) {
        alert('Заполните название и добавьте хотя бы одну карту');
        return;
    }

    const formData = new FormData();
    formData.append('deckName', deckName);
    cards.forEach(card => formData.append('cards[]', card));

    const token = localStorage.getItem('token');

    const res = await fetch('/backend/api/createDeck.php', {
        method: 'POST',
        headers: { 'Authorization': 'Bearer ' + token },
        body: formData
    });

    const data = await res.json();

    if (data.success) {
        alert('Колода создана!');
        window.location.href = '/';
    } else {
        alert(data.error || 'Ошибка');
    }
}

function addCard() {
    const container = document.getElementById('cards-container');
    const cardCount = container.getElementsByClassName('card-row').length + 1;

    // Создаем обертку для инпута и кнопки удаления
    const row = document.createElement('div');
    row.className = 'card-row';
    row.style.marginBottom = '5px';

    row.innerHTML = `
        <input type="text" name="cards[]" placeholder="Карта ${cardCount}" required>
        <button type="button" onclick="removeCard(this)" style="color: red; cursor: pointer;">&times;</button>
    `;

    container.appendChild(row);
}

function removeCard(btn) {
    // Удаляем элемент .card-row, в котором находится нажатая кнопка
    btn.parentElement.remove();
}