<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

            <div class="list-group list-group-flush">
                <li class="list-group-item bg-transparent text-white">تایید شده</li>
                <li class="list-group-item bg-transparent text-white">در حال بررسی</li>
                <li class="list-group-item bg-transparent text-white">رد شده</li>
            </div>
        </div>

        <div class="col-9"></div>
    </div>
</div>
</body>
</html>
