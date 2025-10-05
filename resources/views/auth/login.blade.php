<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Presensi</title>
    <link rel="shortcut icon" href="{{ asset('images/kodekoding-logo-icon-152.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/compiled/css/auth.css') }}">
</head>

<body>
    <script src="{{ asset('assets/static/js/initTheme.js') }}"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                    <link rel="stylesheet" href="{{ asset('assets/css/logo-theme.css') }}">
                    <img class="logo-light" src="{{ asset('images/logo-presensi-kodekoding-alt.png') }}" alt="Background" style="width: 100%; height: 100%; object-fit: cover;">
                    <img class="logo-dark" src="{{ asset('images/logo-presensi-kodekoding-alt-white.png') }}" alt="Background" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email" name="email" value="{{ old('email') }}" required>
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password" name="password" required>
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
                <div class="text-center  pb-4">
                    <p class= "small">
                        © {{ date('Y') }} Made with ❤️ by Kode Koding
                    </p>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <div class="auth-image d-flex justify-content-center align-items-center" style="height: 100vh;">
                        <img src="{{ asset('images/logo-kodekoding-white.png') }}" alt="Background" style="max-width: 70%; max-height: 60vh; object-fit: contain; display: block; margin: auto;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>