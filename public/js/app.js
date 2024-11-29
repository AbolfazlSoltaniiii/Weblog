let links = document.querySelectorAll(".list-group-item"),
    body = document.querySelector("#tbody");

links.forEach((link) => {
    link.addEventListener("click", function (event) {
        event.preventDefault();

        let status = this.getAttribute("data-status");

        body.innerHTML = "";

        getPostData(status);
    });
});

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
        .catch((error) => {
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
        createDeleteCell(row, item["id"], item["post_status_code"]);

        body.appendChild(row);
    });
}

let createEditCell = (row, item) => {
    const cell = document.createElement("td");

    cell.innerHTML = `<button class="border-0 bg-transparent" data-id=${item['id']} title="ویرایش" data-bs-toggle="modal" data-bs-target="#editModal" onclick="fillModal('${item['title']}')"><i class="bi bi-pencil-square text-primary fs-4"></i></button>`;

    row.appendChild(cell);
}

let fillModal = (title) => {
    let titleField = document.querySelector('#postTitle');

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
            if (response.ok) {
                confirmDeleteModal.hide();

                new bootstrap.Toast(
                    document.querySelector("#success-delete-toast")
                ).show();

                document.querySelector("#tbody").innerHTML = "";

                getPostData(itemStatus);
            }
        });
    };
}
