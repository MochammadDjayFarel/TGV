@extends('template.staff')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    {{-- Welcome Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 1rem;">
                <div class="card-body p-4">
                    <h1 class="h3 mb-2 text-gray-800">Welcome back, {{ Auth::user()->name ?? 'Staff Member' }}!</h1>
                    <p class="mb-0 text-muted">Here's what's happening with your staff dashboard today.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        {{-- Total Jadwal --}}
        <div class="col-xl-4 col-md-6">
            <a href="{{ route('staff.jadwal.index') }}" class="text-decoration-none">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; transition: transform 0.3s ease;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                                    <i data-feather="calendar" class="text-primary" style="width: 24px; height: 24px;"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-1 text-muted">Total Jadwal</h5>
                                <h2 class="mb-0 text-primary">0</h2>
                                <small class="text-muted">Kelola Jadwal Penerbangan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Total Promo --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; transition: transform 0.3s ease;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                                <i data-feather="tag" class="text-success" style="width: 24px; height: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1 text-muted">Total Promo</h5>
                            <h2 class="mb-0 text-success">{{ $totalPromo ?? 0 }}</h2>
                            <small class="text-muted">Active promotions</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Total Konfirmasi Koin --}}
        <div class="col-xl-4 col-md-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 1rem; transition: transform 0.3s ease;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                                <i data-feather="check-circle" class="text-warning" style="width: 24px; height: 24px;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="card-title mb-1 text-muted">Konfirmasi Koin</h5>
                            <h2 class="mb-0 text-warning">{{ $totalKonfirmasiKoin ?? 0 }}</h2>
                            <small class="text-muted">Coin confirmations pending</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Additional Dashboard Content --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 text-gray-800">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">No recent activity to display.</p>
                    {{-- This can be expanded with actual activity data --}}
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Hover effects for cards */
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Custom colors */
    .text-gray-800 {
        color: #2d3748 !important;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        h1 {
            font-size: 1.5rem !important;
        }
    }
</style>

<script>
    // Initialize Feather Icons
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    });
</script>
@endsection
