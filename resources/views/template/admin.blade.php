<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Bootstrap Fixed Left Sidebar</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

<style>
  body {
    overflow-x: hidden;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f8f9fa;
    min-height: 100vh;
  }

  #sidebar {
    width: 280px;
    transition: all 0.3s ease;
    background: #4a5568;
    box-shadow: 2px 0 10px rgba(0,0,0,0.1);
  }

  #sidebar.collapsed {
    width: 80px;
  }

  #sidebar.collapsed .text-menu {
    display: none;
  }

  #content-area {
    margin-left: 280px;
    transition: all 0.3s ease;
    background: #f8f9fa;
    min-height: 100vh;
  }

  #content-area.collapsed {
    margin-left: 80px;
  }

  #collapse-btn {
    position: absolute;
    top: 20px;
    right: -18px;
    width: 40px;
    height: 40px;
    background: #e3f2fd;
    border-radius: 50%;
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 999;
    border: 2px solid white;
    transition: all 0.3s ease;
  }

  #collapse-btn:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(0,0,0,0.3);
  }

  /* SIDEBAR HEADER */
  #sidebar .p-3 {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }

  #sidebar h5 {
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }

  /* NAV LINKS */
  .nav-link {
    color: rgba(255,255,255,0.8) !important;
    border-radius: 10px;
    margin: 5px 10px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .nav-link::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }

  .nav-link:hover::before {
    left: 100%;
  }

  /* HOVER STYLE */
  .nav-link:hover {
    background: rgba(255,255,255,0.1) !important;
    color: white !important;
    transform: translateX(5px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  }

  /* ACTIVE STYLE */
  .nav-link.active {
    background: #1976d2 !important;
    color: white !important;
    font-weight: 600;
    box-shadow: 0 4px 15px rgba(25,118,210,0.4);
  }

  .nav-link.active i {
    color: white !important;
  }

  /* Ikon default warna abu */
  .nav-link i {
    color: rgba(255,255,255,0.7);
    transition: all 0.3s ease;
    font-size: 1.2em;
  }

  .nav-link:hover i {
    color: white !important;
    transform: scale(1.1);
  }

  /* LOGOUT STYLE */
  .nav-link.text-danger {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
  }

  .nav-link.text-danger:hover {
    background: rgba(220, 53, 69, 0.2) !important;
    border-color: rgba(220, 53, 69, 0.5);
  }

  /* CONTENT AREA */
  #content-area {
    padding: 30px;
  }

  /* CARDS */
  .card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    background: white;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
  }

  .card-header {
    background: #e3f2fd;
    color: #1565c0;
    border-radius: 15px 15px 0 0 !important;
    border: none;
    padding: 20px;
  }

  .card-header h4 {
    margin: 0;
    font-weight: 600;
  }

  .btn-primary {
    background: #1976d2;
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(25,118,210,0.3);
  }

  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(25,118,210,0.4);
    background: #1565c0;
  }

  .btn-secondary {
    background: #e3f2fd;
    border: none;
    border-radius: 25px;
    padding: 10px 25px;
    font-weight: 600;
    color: #1565c0;
    transition: all 0.3s ease;
  }

  .btn-secondary:hover {
    background: #bbdefb;
    transform: translateY(-2px);
  }

  /* TABLE */
  .table {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  }

  .table thead th {
    background: #667eea;
    color: white;
    border: none;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }

  .table tbody tr:hover {
    background: rgba(102,126,234,0.05);
    transform: scale(1.01);
    transition: all 0.2s ease;
  }

  /* MODALS */
  .modal-content {
    border-radius: 15px;
    border: none;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
  }

  .modal-header {
    background: #e3f2fd;
    color: #1565c0;
    border-radius: 15px 15px 0 0;
    border: none;
  }

  .modal-title {
    font-weight: 600;
  }

  .form-control {
    border-radius: 10px;
    border: 2px solid #e2e8f0;
    transition: all 0.3s ease;
  }

  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102,126,234,0.25);
  }

  /* ALERTS */
  .alert {
    border-radius: 10px;
    border: none;
  }

  /* STATS CARDS */
  .stats-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 15px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  }

  .stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  }

  .stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
  }

  /* TIMELINE */
  .timeline {
    position: relative;
    padding-left: 30px;
  }

  .timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
  }

  .timeline-item {
    position: relative;
    margin-bottom: 20px;
  }

  .timeline-marker {
    position: absolute;
    left: -22px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 3px solid white;
    box-shadow: 0 0 0 2px #e9ecef;
  }

  .tabs button {
    background: #e3f2fd;
    color: #1976d2
  }

  .timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
  }

  /* RESPONSIVE */
  @media (max-width: 768px) {
    #sidebar {
      width: 100%;
      position: relative;
    }
    #content-area {
      margin-left: 0;
    }
    #collapse-btn {
      display: none;
    }
  }
</style>

</head>
<body class="bg-light">

  <!-- SIDEBAR -->
  <div id="sidebar" class="position-fixed top-0 start-0 shadow h-100">

    <div id="collapse-btn">
      <i class="fa-solid fa-angle-left"></i>
    </div>

    <div class="p-3 border-bottom">
      <h5 class="fw-bold m-0">
        <span>TGV</span>
        <span class="text-menu">Admin</span>
        <br>
        <small class="text-menu">{{ auth()->user()?->name ?? 'Guest' }}</small>
      </h5>
    </div>

    <ul class="nav flex-column mt-3">

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-3 px-4 py-2" href="{{ route('admin.dashboard') }}">
          <i class="fa-solid fa-gauge"></i>
          <span class="text-menu ">Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-3 px-4 py-2" href="{{ route('admin.user.index') }}">
          <i class="fa-solid fa-user-plus"></i>
          <span class="text-menu">Pembuatan Staff</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-3 px-4 py-2" href="{{ route('admin.airport.index') }}">
          <i class="fa-solid fa-plane-departure"></i>
          <span class="text-menu">Pembuatan Bandara</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-3 px-4 py-2" href="{{ route('admin.pilot.index') }}">
          <i class="fa-solid fa-plane"></i>
          <span class="text-menu">Pembuatan Pilot</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-3 px-4 py-2" href="{{ route('admin.copilot.index') }}">
          <i class="fa-solid fa-plane-circle-check"></i>
          <span class="text-menu">Pembuatan Co-Pilot</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link d-flex align-items-center gap-3 px-4 py-2" href="{{ route('admin.airline.index') }}">
          <i class="fa-solid fa-building"></i>
          <span class="text-menu">Pembuatan Maskapai</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <a class="nav-link text-danger d-flex align-items-center gap-3 px-4 py-2" href="{{ route('logout') }}">
          <i class="fa-solid fa-right-from-bracket"></i>
          <span class="text-menu">Logout</span>
        </a>
      </li>

    </ul>
  </div>

  <!-- MAIN CONTENT -->
  <div id="content-area" class="p-4">
    @yield('content')
  </div>


  <!-- JS -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    const sidebar = document.getElementById("sidebar");
    const content = document.getElementById("content-area");
    const collapseBtn = document.getElementById("collapse-btn");

    collapseBtn.onclick = () => {
      sidebar.classList.toggle("collapsed");
      content.classList.toggle("collapsed");

      collapseBtn.innerHTML = sidebar.classList.contains("collapsed")
        ? '<i class="fa-solid fa-angle-right"></i>'
        : '<i class="fa-solid fa-angle-left"></i>';
    };
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  @yield('scripts')

</body>
</html>
