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