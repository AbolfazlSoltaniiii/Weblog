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
    if (!data.length) {
        return showEmptyPostRecord();
    }

    data.forEach((item, index) => {
        const row = document.createElement("tr");

        let postUser = item?.post_user,
            user = postUser.length ? postUser[0]?.users : null,
            userName = null;

        if (user) {
            userName = user['username'] === 'admin' ? 'مدیر سیستم' : user['username'];
        }

        let dataContent = [index + 1, item["title"], userName];

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

let showEmptyPostRecord = () => {
    const row = document.createElement("tr"),
        cell = document.createElement("td");

    cell.textContent = "پستی جهت نمایش وجود ندارد.";

    cell.setAttribute("colspan", 5);
    cell.classList.add("text-center", "fw-bold", "text-muted");

    row.appendChild(cell);
    body.appendChild(row);
}

let createEditCell = (row, item) => {
    const cell = document.createElement("td");

    cell.innerHTML = `<button class="border-0 bg-transparent" title="ویرایش" data-bs-toggle="modal" data-bs-target="#editModal" data-item='${JSON.stringify(item)}' onclick="fillModal(this)"><i class="bi bi-pencil-square text-primary fs-4"></i></button>`;

    row.appendChild(cell);
}

let fillModal = (button) => {
    let titleField = document.querySelector('#postTitle'),
        creatorField = document.querySelector('#postCreator'),
        statusField = document.querySelector('#postStatus'),
        contentField = document.querySelector('#postContent'),
        saveButton = document.querySelector('#saveButton'),
        editItem = JSON.parse(button.getAttribute('data-item')),
        postStatsCode = editItem['post_status']['code'] ?? null;

    titleField.classList.remove("is-invalid");

    saveButton.setAttribute('data-id', editItem['id']);
    saveButton.setAttribute('data-status', postStatsCode);

    let userName = editItem['post_user'][0]['users']['username'];

    userName = userName === 'admin' && 'مدیر سیستم' || userName;

    creatorField.innerHTML = userName;
    titleField.value = editItem['title'];
    statusField.value = postStatsCode;
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
    let postEditForm = document.querySelector("#postEditForm"),
        postTitleField = document.querySelector('#postTitle'),
        postStatusField = document.querySelector('#postStatus'),
        postContentField = document.querySelector('#postContent'),
        postTitle = postTitleField.value,
        postStatus = postStatusField.value,
        postContent = postContentField.value,
        itemId = button.getAttribute('data-id'),
        itemStatus = button.getAttribute('data-status');

    let editModal = bootstrap.Modal.getInstance(
        document.querySelector("#editModal")
    );

    postTitleField.classList.remove("is-invalid");

    if (!postEditForm.checkValidity()) {
        postTitleField.classList.add("is-invalid");
        return;
    }

    fetch(`post/${itemId}`, {
        method: "PUT",
        headers: {
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"), // for 419 error
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            title: postTitle,
            status: postStatus,
            content: postContent
        })
    }).then(async (response) => {
        if (response.ok) {
            editModal.hide();

            showToast('اطلاعات پست با موفقیت ویرایش شد.');

            reloadData(itemStatus)
        } else {
            let errorData = await response.json(),
                errorTitle = errorData.errors.title;

            if (!errorTitle || !errorTitle.length) return;

            postTitleField.classList.add("is-invalid");
            document.querySelector("#invalidEditFeedback").textContent = errorTitle[0];
        }
    }).catch(() => {
        let className = "toast bg-danger text-white m-2 position-absolute bottom-0 start-0";

        showToast("مشکلی در ارتباط با سرور رخ داده است.", "failure", className);
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
            title: postTitle,
            status: "pending"
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
            document.querySelector("#invalidCreateFeedback").textContent = errorTitle[0];
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

let onCreatePostModalClick = () => {
    let titleField = document.querySelector('#title');

    titleField.classList.remove("is-invalid");
}
