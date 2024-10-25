<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>وبلاگ</title>

    {{--bootstrap cdn--}}
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
            border-bottom: 1px solid red;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-3 bg-dark-primary full-height text-white">
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
        </div>

        <div class="col-9">
            <table id="data-container" class="table table-striped">
                <thead>
                <tr>
                    <th>ردیف</th>
                    <th>عنوان</th>
                    <th>ایجاد کننده</th>
                </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
