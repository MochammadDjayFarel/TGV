@extends('template.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="text-dark fw-bold mb-4">
                <i class="fa-solid fa-gauge me-3 text-primary"></i>Dashboard Admin
            </h1>
            <p class="text-muted">Selamat datang di panel administrasi TGV. Kelola semua aspek sistem penerbangan dengan mudah.</p>
        </div>
    </div>

    <!-- Tab Content -->
    <div class="tab-content" id="dashboardTabContent">
        
        <!-- Overview Tab -->
        <div class="tab-pane fade show active" id="overview" role="tabpanel">
            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-primary">
                                    <i class="fa-solid fa-building text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-0">{{ $airlineCount ?? 0 }}</h3>
                                    <p class="card-text text-muted mb-0">Maskapai</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-success">
                                    <i class="fa-solid fa-plane-departure text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-0">{{ $airportCount ?? 0 }}</h3>
                                    <p class="card-text text-muted mb-0">Bandara</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-warning">
                                    <i class="fa-solid fa-plane text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-0">{{ $pilotCount ?? 0 }}</h3>
                                    <p class="card-text text-muted mb-0">Pilot</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-danger">
                                    <i class="fa-solid fa-plane-circle-check text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-0">{{ $copilotCount ?? 0 }}</h3>
                                    <p class="card-text text-muted mb-0">Co Pilot</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-md-6 mb-4">
                    <div class="card stats-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon bg-info">
                                    <i class="fa-solid fa-users text-white"></i>
                                </div>
                                <div class="ms-3">
                                    <h3 class="card-title mb-0">{{ $userCount ?? 0 }}</h3>
                                    <p class="card-text text-muted mb-0">Staff</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa-solid fa-bolt me-2"></i>Aksi Cepat
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.airline.create') }}" class="btn btn-primary btn-lg w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah Maskapai
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.airport.create') }}" class="btn btn-success btn-lg w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah Bandara
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.pilot.create') }}" class="btn btn-warning btn-lg w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah Pilot
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.copilot.create') }}" class="btn btn-danger btn-lg w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah co Pilot
                                    </a>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <a href="{{ route('admin.user.create') }}" class="btn btn-info btn-lg w-100">
                                        <i class="fa-solid fa-plus me-2"></i>Tambah Staff
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa-solid fa-clock me-2"></i>Aktivitas Terbaru
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Maskapai Baru Ditambahkan</h6>
                                        <p class="text-muted mb-0">Garuda Indonesia telah ditambahkan ke sistem</p>
                                        <small class="text-muted">2 jam yang lalu</small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Bandara Diperbarui</h6>
                                        <p class="text-muted mb-0">Informasi Bandara Soekarno-Hatta diperbarui</p>
                                        <small class="text-muted">5 jam yang lalu</small>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-1">Pilot Baru Terdaftar</h6>
                                        <p class="text-muted mb-0">Pilot John Doe bergabung dengan tim</p>
                                        <small class="text-muted">1 hari yang lalu</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">
                                <i class="fa-solid fa-chart-pie me-2"></i>Ringkasan Sistem
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Maskapai Aktif</span>
                                    <span class="badge bg-primary">{{ $airlineCount ?? 0 }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-primary" style="width: {{ ($airlineCount ?? 0) * 10 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Bandara Tersedia</span>
                                    <span class="badge bg-success">{{ $airportCount ?? 0 }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: {{ ($airportCount ?? 0) * 10 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Pilot Aktif</span>
                                    <span class="badge bg-warning">{{ $pilotCount ?? 0 }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: {{ ($pilotCount ?? 0) * 10 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Co Pilot Aktif</span>
                                    <span class="badge bg-danger">{{ $copilotCount ?? 0 }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-danger" style="width: {{ ($copilotCount ?? 0) * 10 }}%"></div>
                                </div>
                            </div>
                            <div class="mb-0">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Staff Terdaftar</span>
                                    <span class="badge bg-info">{{ $userCount ?? 0 }}</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: {{ ($userCount ?? 0) * 10 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.nav-link[href="{{ route("admin.dashboard") }}"]').addClass('active');

    // Copilot AI Chat
    $('#copilotSend').click(function() {
        const input = $('#copilotInput').val().trim();
        if (input === '') return;

        const chatContainer = $('#copilotChat');
        
        // User message
        chatContainer.append(`
            <div class="d-flex justify-content-end mb-2">
                <div class="bg-secondary text-white rounded p-2" style="max-width: 70%; word-wrap: break-word;">
                    <small>${input}</small>
                </div>
            </div>
        `);

        $('#copilotInput').val('');
        chatContainer.scrollTop(chatContainer[0].scrollHeight);

        // Simulate AI response
        setTimeout(function() {
            const responses = [
                'Sesuai analisis data terkini, sistem penerbangan Anda beroperasi dengan efisien.',
                'Total maskapai saat ini: ' + '{{ $airlineCount ?? 0 }}'. Pertimbangkan untuk menambah 2-3 maskapai baru.',
                'Bandara dengan aktivitas tertinggi adalah Bandara Soekarno-Hatta dengan 45% dari total traffic.',
                'Rekomendasi: Tingkatkan kapasitas pilot dengan merekrut 5 pilot baru untuk musim puncak.',
                'Sistem aman dan stabil. Tidak ada anomali terdeteksi dalam 24 jam terakhir.'
            ];
            const randomResponse = responses[Math.floor(Math.random() * responses.length)];
            
            chatContainer.append(`
                <div class="d-flex mb-2">
                    <div class="bg-primary text-white rounded p-2" style="max-width: 70%; word-wrap: break-word;">
                        <small>${randomResponse}</small>
                    </div>
                </div>
            `);
            chatContainer.scrollTop(chatContainer[0].scrollHeight);
        }, 500);
    });

    $('#copilotInput').keypress(function(e) {
        if (e.which === 13) {
            $('#copilotSend').click();
        }
    });
});
</script>
@endsection
