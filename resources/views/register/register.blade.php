<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>ثبت نام</title>

    {{-- bootstrap cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="icon" href="{{asset('icon/logo.png')}}">

    <style>
        @font-face {
            font-family: "Yekan";
            src: url("/font/Yekan.woff");
        }

        body {
            font-family: "Yekan", sans-serif;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        input {
            font-family: Montserrat sans-serif;
            font-size: 18px !important;
        }
    </style>
</head>
<body dir="rtl">
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row">
        <div class="col border rounded-3 p-4 shadow-lg bg-light">
            <form method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label" for="email">ایمیل:</label>

                    <input type="email" id="email" name="email" class="form-control text-end rounded-pill"
                           oninvalid="this.setCustomValidity('ایمیل الزامی است.')"
                           oninput="this.setCustomValidity(''); validateInput(this);" required>

                    @error('email')
                    <small class="text-danger fw-bold">* {{ $message }}</small><br>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="username">نام کاربری:</label>

                    <input type="text" id="username" name="username" class="form-control text-end rounded-pill"
                           oninvalid="this.setCustomValidity('نام کاربری الزامی است.')"
                           oninput="this.setCustomValidity(''); validateInput(this);" required>

                    @error('username')
                    <small class="text-danger fw-bold">* {{ $message }}</small><br>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">رمز عبور:</label>

                    <div class="position-relative">
                        <input type="password" id="passwordInput" name="password"
                               class="form-control text-end rounded-pill ps-5"
                               oninvalid="this.setCustomValidity('رمز عبور الزامی است.')"
                               oninput="this.setCustomValidity(''); validateInput(this);" required>

                        <span class="position-absolute top-50 translate-middle-y start-0 ms-3"
                              onclick="toggleVisibility('passwordInput', 'passwordIcon')">
                            <i id="passwordIcon" class="bi bi-eye cursor-pointer"></i>
                        </span>
                    </div>

                    @error('password')
                    <small class="text-danger fw-bold">* {{ $message }}</small><br>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">تکرار رمز عبور:</label>

                    <div class="position-relative">
                        <input type="password" id="passwordConfirmationInput" name="password_confirmation"
                               class="form-control text-end rounded-pill ps-5"
                               oninvalid="this.setCustomValidity('تکرار رمز عبور الزامی است.')"
                               oninput="this.setCustomValidity(''); validateInput(this);" required>

                        <span class="position-absolute top-50 translate-middle-y start-0 ms-3"
                              onclick="toggleVisibility('passwordConfirmationInput', 'passwordConfirmationIcon')">
                            <i id="passwordConfirmationIcon" class="bi bi-eye cursor-pointer"></i>
                        </span>
                    </div>

                    @error('password_confirmation')
                    <small class="text-danger fw-bold">* {{ $message }}</small><br>
                    @enderror
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary rounded-pill">ثبت نام</button>
                </div>

                <p class="text-center">
                    قبلا ثبت نام کرده اید؟
                    <a class="link-opacity-50-hover text-decoration-none" href="/login">وارد شوید</a>
                </p>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('js/register/register.js') }}"></script>

</body>
</html>
