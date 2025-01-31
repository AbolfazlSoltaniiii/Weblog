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

    cell.innerHTML = `<button class="border-0 bg-transparent" title="ویرایش" data-bs-toggle="modal" data-bs-target="#editModal" data-item='${JSON.stringify(item)}' onclick="fillModal(this)"><i class="bi bi-pencil-square text-primary fs-4"></i></button>`;

    row.appendChild(cell);
}

let fillModal = (button) => {
    let titleField = document.querySelector('#postTitle'),
        contentField = document.querySelector('#postContent'),
        saveButton = document.querySelector('#saveButton'),
        editItem = JSON.parse(button.getAttribute('data-item'));

    saveButton.setAttribute('data-id', editItem['id']);
    saveButton.setAttribute('data-status', editItem['post_status']['code']);

    titleField.value = editItem['title'];
    contentField.value = editItem['content'];
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

            showToast('پست با موفقیت حذف شد.');

            reloadData(itemStatus)
        });
    };
}

let editItem = (button) => {
    let postTitle = document.querySelector('#postTitle').value,
        postContent = document.querySelector('#postContent').value,
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
            title: postTitle,
            content: postContent
        })
    }).then((response) => {
        if (!response.ok) return;

        showToast('اطلاعات پست با موفقیت ویرایش شد.');

        reloadData(itemStatus)
    });
}

let reloadData = (itemStatus) => {
    document.querySelector("#tbody").innerHTML = "";

    getPostData(itemStatus);
}

let onCreatePost = () => {
    let postForm = document.getElementById("postForm"),
        postTitleField = document.querySelector('#title'),
        allPostStatus = document.querySelectorAll('.list'),
        postTitle = postTitleField.value;

    let addModal = bootstrap.Modal.getInstance(
        document.querySelector("#addModal")
    );

    postTitleField.classList.remove("is-invalid");

    if (!postForm.checkValidity()) {
        postTitleField.classList.add("is-invalid");
        return;
    }

    fetch(`post/`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"), // for 419 error
        },
        body: JSON.stringify({
            title: postTitle
        })
    }).then(async (response) => {
        if (response.ok) {
            addModal.hide()
            showToast('پست جدید با موفقیت ایجاد شد.')

            // show pending status data
            allPostStatus[1].click();
        } else {
            let errorData = await response.json(),
                errorTitle = errorData.errors.title;

            if (!errorTitle || !errorTitle.length) return;

            postTitleField.classList.add("is-invalid");
            document.querySelector(".invalid-feedback").textContent = errorTitle[0];
        }
    }).catch(() => {
        let className = "toast bg-danger text-white m-2 position-absolute bottom-0 start-0";

        showToast("مشکلی در ارتباط با سرور رخ داده است.", "failure", className);
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

let showToast = (message, type = 'success', className = null) => {
    let mainContent = document.querySelector("#mainContent"),
        div = document.createElement("div");

    div.className = "toast text-bg-success m-2 position-absolute bottom-0 start-0"

    if (type !== 'success') {
        div.className = className;
    }

    div.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-auto m-2 p-2" data-bs-dismiss="toast"></button>
        </div>
    `;

    mainContent.appendChild(div)
    new bootstrap.Toast(div).show();
}
