<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        .peringatan{
            position: absolute;
            top: 0;
        }
        body {
            background: url("https://images.unsplash.com/photo-1507525428034-b723cf961d3e") no-repeat center center/cover;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            width: 380px;
            background: white;
            padding: 35px 30px;
            border-radius: 18px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.12);
        }

        .title {
            font-weight: 700;
            text-align: center;
            font-size: 28px;
            margin-bottom: 25px;
        }

        /* Input with icon */
        .input-group-icon {
            position: relative;
        }

        .input-group-icon i:first-child {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            font-size: 18px;
            color: #6c757d;
        }

        .input-group-icon input {
            padding-left: 40px;
            height: 48px;
        }

        /* Show password eye icon */
        .password-toggle {
            cursor: pointer;
            right: 12px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 18px;
        }

        /* Avoid collision between text & eye icon */
        .password-input {
            padding-right: 40px !important;
        }

        .btn-login {
            height: 48px;
            font-size: 17px;
            font-weight: 600;
        }

        .bottom-text {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>

<body>
<div class="peringatan">
        @if (Session::get('oke'))
            <div class="alert alert-success">{{ Session::get('oke') }}</div>
        @endif
        @if (Session::get('error'))
            <div class="alert alert-danger">{{ Session::get('error') }}</div>
        @endif
</div>
    <div class="login-card">
        <form action="{{ route('login.auth') }}" method="POST">
            @csrf
            <div class="title">Login</div>

            <!-- Email -->
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="mb-3 input-group-icon">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" id="email" name="email" class="form-control @error('email')
                    is-invalid
                @enderror" placeholder="Email">
            </div>

            <!-- Password -->
            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
            <div class="mb-3 input-group-icon">
                <i class="fa-solid fa-lock"></i>
                <input type="password" id="password" name="password" class="form-control password-input @error('password')
                    is-invalid
                @enderror" placeholder="Password">
                <i class="fa-solid fa-eye password-toggle" id="toggleLoginPass"></i>
            </div>
            <a href="#">Reset Password</a>

            <button class="btn btn-primary w-100 btn-login" type="submit">Masuk</button>

            <div class="bottom-text">
                Belum punya akun? <a href="{{ route('singup') }}">Daftar</a>
            </div>
        </form>
    </div>
    <!-- JS -->
    <script>
        const pass = document.getElementById("loginPassword");
        const toggle = document.getElementById("toggleLoginPass");

        toggle.addEventListener("click", () => {
            const type = pass.getAttribute("type") === "password" ? "text" : "password";
            pass.setAttribute("type", type);

            toggle.classList.toggle("fa-eye");
            toggle.classList.toggle("fa-eye-slash");
        });
    </script>

</body>
</html>
