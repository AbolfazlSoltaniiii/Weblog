<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>نشر‌ یار</title>
    <link rel="icon" href="{{asset('icon/logo.png')}}">

    {{-- bootstrap cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        @font-face {
            font-family: "Yekan";
            src: url("/font/Yekan.woff");
        }

        body {
            font-family: "Yekan", sans-serif;
        }

        .title {
            background: linear-gradient(20deg, #034998, #7789f1);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            letter-spacing: 1px;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body data-bs-theme="light">
<div class="container-fluid">
    <div class="row">
        <div id="titleDivide" class="d-flex justify-content-center align-items-center bg-light">
            <h2 class="p-3 title text-center w-75">بررسی وضعیت پست های سیستم</h2>

            <button id="themeToggle" class="btn btn-outline-dark position-absolute end-0 mx-4"
                    onclick="onChangeThemeClick()">
                <i id="themeIcon" class="bi bi-moon-fill"></i>
            </button>

            <button id="redirect" class="btn btn-outline-dark position-absolute start-0 mx-4"
                    title="رفتن به صفحه اصلی" onclick="onRedirectClick()">
                <i class="bi bi-box-arrow-in-left"></i>
            </button>
        </div>

        <div class="col-4 border d-md-flex d-none p-3 mb-3" dir="rtl">
            تعداد پست های&nbsp;<span class="fw-bold text-danger">رد شده:&nbsp;{{ $rejectedPosts }}</span>
        </div>
        <div class="col-4 border d-md-flex d-none p-3 mb-3" dir="rtl">
            تعداد پست های&nbsp;<span class="fw-bold text-warning">در حال بررسی:&nbsp;{{ $pendingPosts }}</span>
        </div>
        <div class="col-4 border d-md-flex d-none p-3 mb-3" dir="rtl">
            تعداد پست های&nbsp;<span class="fw-bold text-success">تایید شده:&nbsp;{{ $approvedPosts }}</span>
        </div>

        <div class="col-md-8 col-12">
            <canvas id="barChart"></canvas>
        </div>
        <div class="col-md-4 col-12">
            <canvas id="doughnutChart"></canvas>
        </div>
    </div>
</div>
</body>

{{-- chart.js cdn --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
<script>
    const data = {
        labels: ['رد شده', 'در حال بررسی', 'تایید شده'],
        datasets: [{
            backgroundColor: ['rgb(185,5,5)', 'rgb(250,221,59)', 'rgb(5,122,24)'],
            borderColor: ['rgb(185,5,5)', 'rgb(250,221,59)', 'rgb(5,122,24)'],
            data: [{{$rejectedPosts}}, {{$pendingPosts}}, {{$approvedPosts}}],
        }]
    };

    const barConfig = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                    ticks: {
                        stepSize: 1
                    },
                    beginAtZero: true,
                },
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    };

    const doughnutConfig = {
        type: 'doughnut',
        data: data,
        options: {
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    };

    const barChart = new Chart(
        document.getElementById('barChart'),
        barConfig
    );

    const doughnutChart = new Chart(
        document.getElementById('doughnutChart'),
        doughnutConfig
    );

    window.addEventListener('resize', function () {
        barChart.resize();
        doughnutChart.resize();
    });
</script>
</html>
