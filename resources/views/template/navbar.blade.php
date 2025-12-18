<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TGV</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" />

    <style>
        body {
            background: #e8f0ff;
            padding-top: 120px; 
        }

        .navbar-box {
            background: white;
            border-radius: 20px;
            padding: 20px;
            width: 95%;
            margin: auto;
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
        }
        
        .profile-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: #e9f1ff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            color: #2c7bff;
            
        }

        .setting-btn {
            background: #f3f7ff;
            padding: 12px 14px;
            border-radius: 15px;
            color: #2c7bff;
            font-size: 20px;
            cursor: pointer;
        }

        /* Dropdown custom */
        .dropdown-menu {
            border-radius: 15px;
            padding: 10px 0;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .dropdown-item {
            padding: 10px 20px;
        }

        .dropdown-item:hover {
            background: #f0f6ff;
        }

    </style>
</head>
<body>

    <div class="position-fixed top-0 start-0 end-0 mt-3">
        <div class="navbar-box d-flex justify-content-between align-items-center">
            
            <!-- KIRI: Profile -->
            <div class="d-flex align-items-center gap-3">
                <div class="profile-icon">
                    <i class="bi bi-person"></i>
                </div>

                <div>
                    @if (Auth::check())
                    <h6 class="m-0 fw-bold">{{ auth()->user()->name }}</h6>
                    @else
                        <a href="{{ route('login') }}" data-mdb-ripple-init type="button" class="btn btn-link px-3 me-2">Login</a>
                        <a href="{{ route('singup') }}" data-mdb-ripple-init type="button" class="btn btn-primary me-3">Sign up</a>
                    @endif
                </div>
            </div>

            <!-- KANAN: Dropdown -->
            <div class="dropdown">
                <div 
                    class="setting-btn"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <i class="bi bi-gear"></i>
                </div>

                <ul class="dropdown-menu dropdown-menu-end mt-2">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person-circle me-2"></i> Profil</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-ticket-perforated me-2"></i> Tiket Saya</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
<main>
    @yield('content')
</main>
    

@stack('script')
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
