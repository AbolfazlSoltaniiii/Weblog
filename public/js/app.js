let links = document.querySelectorAll(".list-group-item"),
    body = document.querySelector("#tbody");

// event for remove every input when creating new post
document.addEventListener('shown.bs.modal', function (event) {
    if (event.target.id === 'addModal') {
        event.target.querySelectorAll('input').forEach(input => input.value = '');
    }
});


links.forEach((link) => {
    link.addEventListener("click", function (event) {
        event.preventDefault();

        setLinksStyle(links, this)

        let status = this.getAttribute("data-status");

        reloadData(status)
    });
});

let setLinksStyle = (links, selectedLink) => {
    links.forEach((el) => {
        el.style.fontWeight = 'normal'
        el.style.color = 'yellow';
    });

    selectedLink.style.fontWeight = 'bold';
    selectedLink.style.color = 'white';
}

let getPostData = (status) => {
    fetch(`/post/index`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"), // for 419 error
        },
        body: JSON.stringify({
            status,
        }),
    })
        .then((response) => {
            if (response.ok) {
                return response.json();
            }
        })
        .then((data) => {
            createPostFields(data);
        })
        .catch(() => {
            alert("هنگام واکشی اطلاعات خطایی رخ داده است.");
        });
}

let createPostFields = (data) => {
    data.forEach((item, index) => {
        const row = document.createElement("tr");

        let dataContent = [index + 1, item["title"], "مدیر سیستم"];

        for (let i = 0; i < dataContent.length; i++) {
            const cell = document.createElement("td");

            cell.textContent = dataContent[i];
            row.appendChild(cell);
        }

        createEditCell(row, item);
        createDeleteCell(row, item["id"], item["post_status"]["code"]);

        setActiveRowListener(row);

        body.appendChild(row);
    });
}

let createEditCell = (row, item) => {
    const cell = document.createElement("td");

    cell.innerHTML = `<button class="border-0 bg-transparent" title="ویرایش" data-bs-toggle="modal" data-bs-target="#editModal" onclick="fillModal('${item['title']}', ${item['id']}, '${item["post_status"]["code"]}')"><i class="bi bi-pencil-square text-primary fs-4"></i></button>`;

    row.appendChild(cell);
}

let fillModal = (title, id, status) => {
    let titleField = document.querySelector('#postTitle'),
        saveButton = document.querySelector('#saveButton');

    saveButton.setAttribute('data-id', id);
    saveButton.setAttribute('data-status', status);

    titleField.value = title;
}

let createDeleteCell = (row, itemId, itemStatus) => {
    const cell = document.createElement("td");

    cell.innerHTML = `<button class="border-0 bg-transparent" data-id=${itemId} data-status=${itemStatus} title="حذف" onclick="checkDeleteItem(this)"><i class="bi bi-trash text-danger fs-4"></i></button>`;

    row.appendChild(cell);
}

let checkDeleteItem = (button) => {
    let itemId = button.getAttribute("data-id"),
        itemStatus = button.getAttribute("data-status"),
        confirmDeleteModal = new bootstrap.Modal(
            document.querySelector("#confirmDeleteModal")
        ),
        deleteModalBtn = document.querySelector("#confirmDeleteBtn");

    confirmDeleteModal.show();

    deleteModalBtn.onclick = () => {
        fetch(`post/${itemId}`, {
            method: "delete",
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"), // for 419 error
            },
        }).then((response) => {
            if (!response.ok) return;

            confirmDeleteModal.hide();

            new bootstrap.Toast(
                document.querySelector("#success-delete-toast")
            ).show();

            reloadData(itemStatus)
        });
    };
}

let editItem = (button) => {
    let postTitle = document.querySelector('#postTitle').value,
        itemId = button.getAttribute('data-id'),
        itemStatus = button.getAttribute('data-status');

    fetch(`post/${itemId}`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"), // for 419 error
        },
        body: JSON.stringify({
            title: postTitle
        })
    }).then((response) => {
        if (!response.ok) return;

        new bootstrap.Toast(
            document.querySelector("#success-edit-toast")
        ).show();

        reloadData(itemStatus)
    });
}

let reloadData = (itemStatus) => {
    document.querySelector("#tbody").innerHTML = "";

    getPostData(itemStatus);
}

let onCreatePost = () => {
    let postTitleField = document.querySelector('#title'),
        allPostStatus = document.querySelectorAll('.list'),
        postTitle = postTitleField.value;

    fetch(`post/`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"), // for 419 error
        },
        body: JSON.stringify({
            title: postTitle
        })
    }).then((response) => {
        if (!response.ok) return;

        new bootstrap.Toast(
            document.querySelector("#success-add-toast")
        ).show();

        // show pending status data
        allPostStatus[1].click();
    });
}

let setActiveRowListener = (row) => {
    row.addEventListener("click", () => {
        let activeRow = document.querySelector('.table-active');

        if (activeRow)
            activeRow.classList.remove("table-active");

        row.classList.add("table-active");
    });
}
