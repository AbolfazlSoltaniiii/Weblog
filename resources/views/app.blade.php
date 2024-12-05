<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>وبلاگ</title>

    {{-- bootstrap cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: "B Yekan", sans-serif;
        }

        .full-height {
            min-height: 100vh;
        }

        .bg-dark-primary {
            background-color: rgb(45 53 75) !important;
        }

        .list {
            font-size: 18px;
        }

        .list:hover {
            font-size: 20px;
            border-bottom: 1px solid #4a568f !important;
        }
    </style>
</head>

<body>
<div class="container-fluid">
    <div class="modal" tabindex="-1" id="addModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex">
                        <i class="bi bi-pencil-square text-primary fs-4"></i>
                        &nbsp;
                        <h5 class="modal-title">ایجاد پست جدید</h5>
                    </div>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"> ایجاد کننده:&nbsp; &nbsp;
                            <span class="text-danger fw-bold">مدیر سیستم</span>
                        </label>
                        <br>

                        <label for="title" class="form-label mt-3">عنوان:</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="onCreatePost()">ذخیره
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="editModal" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="d-flex">
                        <i class="bi bi-pencil-square text-primary fs-4"></i>
                        &nbsp;
                        <h5 class="modal-title">ویرایش پست</h5>
                    </div>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"> ایجاد کننده:&nbsp; &nbsp;
                            <span class="text-danger fw-bold">مدیر سیستم</span>
                        </label>
                        <br>

                        <label for="postTitle" class="form-label mt-3">عنوان:</label>
                        <input type="text" class="form-control" id="postTitle">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="saveButton" data-bs-dismiss="modal" data-id=""
                            onclick="editItem(this)">ذخیره
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="confirmDeleteModal" data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تأیید حذف</h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    آیا مطمئن هستید که می‌خواهید این اطلاعات را حذف کنید؟
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">تایید</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-3 pb-3 ps-3 bg-dark-primary full-height text-white d-flex flex-column">
            <div class="d-flex border-bottom border-2 curved-border pt-2">
                <i class="bi bi-file-post fs-2"></i>
                &nbsp;
                <p class="fs-3">پست ها</p>
            </div>

            <div class="list-group list-group-flush gap-3">
                <a class="list-group-item bg-transparent text-white list" data-status="approved" href="#">تایید شده</a>
                <a class="list-group-item bg-transparent text-white list" data-status="pending" href="#">در حال
                    بررسی</a>
                <a class="list-group-item bg-transparent text-white list border-bottom" data-status="rejected" href="#">رد
                    شده</a>
            </div>

            <div class="mt-auto d-flex justify-content-end">
                <button type="button" class="btn btn-secondary fs-3" title="sign out">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
            </div>
        </div>

        <div class="col-9">
            <table id="data-container" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>ایجاد کننده</th>
                    <th style="width: 50px;"></th>
                    <th style="width: 50px"></th>
                </tr>
                </thead>
                <tbody id="tbody"></tbody>

                <button class="btn btn-success rounded-circle position-absolute bottom-0 m-4 px-3"
                        data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus fs-2"></i>
                </button>
            </table>

            <div id="success-add-toast" class="toast text-bg-success m-2 position-absolute bottom-0 start-0"
                 role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        پست جدید با موفقیت ایجاد شد.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-auto m-2 p-2"
                            data-bs-dismiss="toast"></button>
                </div>
            </div>

            <div id="success-edit-toast" class="toast text-bg-success m-2 position-absolute bottom-0 start-0"
                 role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        اطلاعات پست با موفقیت ویرایش شد.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-auto m-2 p-2"
                            data-bs-dismiss="toast"></button>
                </div>
            </div>

            <div id="success-delete-toast" class="toast text-bg-success m-2 position-absolute bottom-0 start-0"
                 role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        پست با موفقیت حذف شد.
                    </div>
                    <button type="button" class="btn-close btn-close-white me-auto m-2 p-2"
                            data-bs-dismiss="toast"></button>
                </div>
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
