<a href="/frontend/pages/register.html" class="">Регистрация</a>

<script>
    let form = document.querySelector('.appForm');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(form);

        fetch('/backend/api/logic.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
    });
</script>