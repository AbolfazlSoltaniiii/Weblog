@php
    use Illuminate\Support\Facades\Auth;
@endphp

    <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>نشر‌ یار</title>

    <link rel="icon" href="{{asset('icon/logo.png')}}">

    <style>
        @font-face {
            font-family: "Yekan";
            src: url("/font/Yekan.woff");
        }

        body {
            font-family: "Yekan", sans-serif;
        }

        .full-height {
            min-height: 100vh;
        }

        .list-group-item {
            transition: all 0.3s ease !important;
            border-radius: 10px !important;
        }

        .bg-dark-primary {
            background-color: #2C3E50 !important;
        }

        .list {
            font-size: 18px;
        }

        .list:hover {
            font-size: 20px;
            border-bottom: 1px solid #4a568f !important;
        }

        #mainContent {
            max-height: 100vh;
            overflow-y: auto;
        }

        #data-container {
            table-layout: fixed;
        }

        ::-webkit-scrollbar {
            width: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #4a568f;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #2C3E50;
        }

        .site-title {
            background: linear-gradient(20deg, #92c4fc, #bec7fc);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            font-size: 1.9rem;
            letter-spacing: 1px;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>
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
                <form id="postForm" novalidate>
                    <div class="mb-3">
                        <label class="form-label">
                            @php
                                $userName = Auth::user()?->username;
                            @endphp

                            ایجاد کننده:&nbsp; &nbsp;
                            <span
                                class="text-danger fw-bold">{{$userName === 'admin' ? 'مدیر سیستم' : $userName}}</span>
                        </label>
                        <br>
                        <label for="title" class="form-label mt-3">عنوان:</label>
                        <input
                            type="text"
                            class="form-control"
                            id="title"
                            name="title"
                            required>
                        <div class="invalid-feedback" id="invalidCreateFeedback">
                            فیلد عنوان الزامی است.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="onCreatePost()">ذخیره</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" id="editModal" data-bs-backdrop="static">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <div class="d-flex">
                    <i class="bi bi-pencil-square text-primary fs-4"></i>
                    &nbsp;
                    <h5 class="modal-title">ویرایش پست</h5>
                </div>
                <button type="button" class="btn-close m-0" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body d-flex flex-column">
                <form id="postEditForm" class="d-flex flex-column flex-grow-1" novalidate>
                    <div class="mb-3">
                        <label class="form-label"> ایجاد کننده:&nbsp; &nbsp;
                            <span class="text-danger fw-bold" id="postCreator"></span>
                        </label>

                        <div class="row mt-3">
                            <div class="col-md-8">
                                <label for="postTitle" class="form-label">عنوان:</label>
                                <input type="text" class="form-control" id="postTitle" required>
                                <div class="invalid-feedback" id="invalidEditFeedback">
                                    فیلد عنوان الزامی است.
                                </div>
                            </div>
                            <div class="col-md-4 mt-md-0 mt-3">
                                <label for="postStatus" class="form-label">وضعیت:</label>
                                <select class="form-select" id="postStatus"
                                    {{ $userName !== 'admin' ? 'disabled' : '' }}
                                >
                                    <option value="approved">تایید شده</option>
                                    <option value="pending">در حال بررسی</option>
                                    <option value="rejected">رد شده</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <label for="postContent" class="form-label mt-3">محتوا:</label>
                    <textarea class="form-control flex-grow-1" id="postContent" rows="4"
                              style="resize: none;"></textarea>
                </form>
            </div>


            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveButton" data-id=""
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

<div class="container-fluid">
    <div class="row">
        <div
            class="d-md-none d-flex justify-content-between align-items-center p-3 bg-dark-primary text-white shadow-sm">
            <button class="btn bg-transparent text-white" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#sidebarOffcanvas">
                <i class="bi bi-list fs-3"></i>
            </button>

            <h2 class="site-title fw-bold mx-auto">گروه نشر یار</h2>
        </div>

        <div
            class="offcanvas offcanvas-end d-md-none col-12 pb-3 ps-3 bg-dark-primary full-height text-white d-flex flex-column"
            id="sidebarOffcanvas">

            <div class="d-flex border-bottom border-2 curved-border pt-2 mb-3 pb-2 align-items-center">
                <i class="bi bi-file-post fs-2"></i>
                &nbsp;
                <p class="fs-3 mb-0">پست ها</p>

                <button type="button" class="btn-close me-auto" data-bs-dismiss="offcanvas"
                        style="filter: invert(1);"></button>
            </div>


            <div class="list-group list-group-flush gap-4">
                <a class="list-group-item bg-transparent text-white list d-flex align-items-center"
                   data-status="approved" href="#" data-bs-dismiss="offcanvas">
                    <i class="bi bi-check-circle-fill text-success ms-2"></i>
                    تایید شده
                </a>
                <a class="list-group-item bg-transparent text-white list d-flex align-items-center"
                   data-status="pending" href="#" data-bs-dismiss="offcanvas">
                    <i class="bi bi-hourglass-split text-warning ms-2"></i>
                    در حال بررسی
                </a>
                <a class="list-group-item bg-transparent text-white list d-flex align-items-center border-bottom"
                   data-status="rejected" href="#" data-bs-dismiss="offcanvas">
                    <i class="bi bi-x-circle-fill text-danger ms-2"></i>
                    رد شده
                </a>
            </div>

            <form method="post" action="/logout" class="mt-auto d-flex justify-content-end">
                @csrf
                <button class="btn btn-secondary fs-3" title="logout">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
            </form>
        </div>

        <div class="d-none d-md-flex col-md-3 pb-3 ps-3 bg-dark-primary full-height text-white flex-column"
             id="sidebarStatic">

            <div class="d-flex flex-md-column">
                <div class="d-flex border-bottom border-2 curved-border pt-2 mb-3">
                    <i class="bi bi-file-post fs-2"></i>
                    &nbsp;
                    <p class="fs-3">پست ها</p>
                </div>
            </div>

            <div class="list-group list-group-flush gap-4">
                <a class="list-group-item bg-transparent text-white list d-flex align-items-center"
                   data-status="approved" href="#">
                    <i class="bi bi-check-circle-fill text-success ms-2"></i>
                    تایید شده
                </a>
                <a class="list-group-item bg-transparent text-white list d-flex align-items-center"
                   data-status="pending" href="#">
                    <i class="bi bi-hourglass-split text-warning ms-2"></i>
                    در حال بررسی
                </a>
                <a class="list-group-item bg-transparent text-white list d-flex align-items-center border-bottom"
                   data-status="rejected" href="#">
                    <i class="bi bi-x-circle-fill text-danger ms-2"></i>
                    رد شده
                </a>
            </div>

            <form method="post" action="/logout" class="mt-auto d-flex justify-content-end">
                @csrf
                <button class="btn btn-secondary fs-3" title="logout">
                    <i class="bi bi-box-arrow-left"></i>
                </button>
            </form>
        </div>

        <div class="col-md-9 ms-md-auto" id="mainContent">
            <table id="data-container" class="table table-striped table-hover">
                <thead class="position-sticky top-0">
                <tr>
                    <th style="width: 70px;">ردیف</th>
                    <th>عنوان</th>
                    <th>ایجاد کننده</th>
                    <th style="width: 50px;"></th>
                    <th style="width: 50px"></th>
                </tr>
                </thead>

                <tbody id="tbody">
                <tr id="firstEmptyRecord">
                    <td colspan="5" class="text-center fw-bold text-muted">
                        پستی جهت نمایش وجود ندارد.
                    </td>
                </tr>
                </tbody>
            </table>

            <button class="btn btn-success rounded-circle position-absolute bottom-0 m-3 px-md-3 py-md-2"
                    data-bs-toggle="modal" data-bs-target="#addModal" onclick="onCreatePostModalClick()">
                <i class="bi bi-plus fs-2"></i>
            </button>

            <button class="btn btn-primary bg-gradient position-absolute bottom-0 start-0 mx-4 my-3" title="نمایش داشبورد"
                    onclick="onShowDashboardClick()">
                <i class="bi bi-columns-gap fs-2"></i>
            </button>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
