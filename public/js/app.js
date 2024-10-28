let links = document.querySelectorAll('.list-group-item'),
    body = document.querySelector('#tbody');

links.forEach(link => {
    link.addEventListener('click', function (event) {
        event.preventDefault();

        let status = this.getAttribute('data-status');

        body.innerHTML = ''

        fetch(`/post/index`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // for 419 error
            },
            body: JSON.stringify({
                status
            })
        })
            .then(response => {
                if (response.ok) {
                    return response.json();
                }
            })
            .then(data => {
                createPostFields(data)
            })
            .catch(error => {
                alert('هنگام واکشی اطلاعات خطایی رخ داده است.')
            });

    });
});

function createPostFields(data) {
    data.forEach((item, index) => {
        const row = document.createElement('tr');

        let dataContent = [index + 1, item['title'], 'مدیر سیستم'];

        for (let i = 0; i < dataContent.length; i++) {
            const cell = document.createElement('td');

            cell.textContent = dataContent[i];
            row.appendChild(cell);

        }

        body.appendChild(row);
    });
}
