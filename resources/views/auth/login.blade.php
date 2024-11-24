<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('images/logo.svg') }}">

    <title>{{ __('translate.Sign_in') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/styles/vendor/login_page.css') }}">
    <style>
        .login-main {
            text-align: center;
        }
        .login-main img {
            max-width: 150px;
            margin-bottom: 1em;
        }
        .theme-form {
            text-align: left; /* Align form content to the left */
            max-width: 400px; /* Optional: constrain the width of the form */
            margin: 0 auto; /* Center the form horizontally */
        }
        .theme-form h4 {
            text-align: center; /* Center the heading text */
            margin-bottom: 1em;
        }
        .form-group {
            margin-bottom: 1em;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5em;
        }
        .form-group input {
            width: 100%;
            padding: 0.75em;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-input {
            position: relative;
        }
        .form-input input {
            padding-right: 2.5em; /* Adjust this value if needed */
        }
    </style>
</head>

<body class="login-page">
<div id="main-wrapper" class="show">
    <div class="login-posly">
        <div>
            <div class="login-main">
                <!-- Logo -->
                <img src="{{ asset('images/alshara-png.png') }}" alt="Company Logo">

                <form class="theme-form" id="form_login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h4>{{ __('translate.Login to your system') }}</h4>
                    <div class="form-group">
                        <label class="col-form-label">{{ __('translate.Email_Address') }}</label>
                        <input class="form-control" type="email" placeholder="Example@Example.com" @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @elseif ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">{{ __('translate.Password') }}</label>
                        <div class="form-input">
                            <input class="form-control" type="password" placeholder="*********" @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <div class="checkbox p-0">
                            <input id="checkbox1" type="checkbox">
                            <label class="text-muted" for="checkbox1">{{ __('translate.Remember_password') }}</label>
                        </div>

                        <div class="mt-3">
                            <button id="btn_submit" class="btn btn-primary w-100">{{ __('translate.Sign_in') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Libraries -->
<script src="{{ asset('/assets/js/jquery.js') }}"></script>
<script src="{{ asset('/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/js/scripts.js') }}"></script>
<script src="{{ asset('/assets/js/custom.js') }}"></script>

<script>
    $(function () {
        $("#form_login").one("submit", function () {
            // Enter your submit code
            $("#btn_submit").prop('disabled', true);
        });
    });
</script>
</body>
</html>
