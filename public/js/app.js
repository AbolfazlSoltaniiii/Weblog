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
                data.forEach(function (item) {
                    createPostFields(item)
                });
            })
            .catch(error => {
                alert('هنگام واکشی اطلاعات خطایی رخ داده است.')
            });

    });
});

function createPostFields(item) {
    let fields = ['id', 'title'],
        row = document.createElement('tr');

    for (let i = 0; i < fields.length; i++) {
        let field = fields[i];

        const cell = document.createElement('td');
        cell.textContent = item[field];

        row.appendChild(cell);
    }

    const creatorCell = document.createElement('td')
    creatorCell.textContent = 'مدیر سیستم'

    row.appendChild(creatorCell);

    body.appendChild(row);
}
