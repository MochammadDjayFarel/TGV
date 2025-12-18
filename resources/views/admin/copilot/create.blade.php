@extends('template.admin')

@section('title', 'Tambah Co-Pilot')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 text-gray-800">Tambah Co-Pilot</h1>
                    <p class="mb-0 text-muted">Tambah data co-pilot baru</p>
                </div>
                <a href="{{ route('admin.copilot.index') }}" class="btn btn-secondary">
                    <i data-feather="arrow-left" class="me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Form Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 1rem;">
                <div class="card-header bg-white border-0 py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Co-Pilot</h6>
                </div>
                <div class="card-body">
                    <form id="copilotForm" method="POST" action="{{ route('admin.copilot.store') }}">
                        @csrf

                        <div class="row">
                            {{-- Nama --}}
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Nomor Lisensi --}}
                            <div class="col-md-6 mb-3">
                                <label for="license_number" class="form-label">Nomor Lisensi <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('license_number') is-invalid @enderror" id="license_number" name="license_number" value="{{ old('license_number') }}" required>
                                @error('license_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Telepon --}}
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-md-12 mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('admin.copilot.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i data-feather="save" class="me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-label {
        font-weight: 600;
        color: #5a5c69;
    }

    .form-control, .form-select {
        border-radius: 0.5rem;
        border: 1px solid #d1d3e2;
    }

    .form-control:focus, .form-select:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }

    .btn {
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
    }

    .card {
        border-radius: 1rem;
    }

    /* Custom colors */
    .text-gray-800 {
        color: #2d3748 !important;
    }

    .text-primary {
        color: #4e73df !important;
    }

    .text-danger {
        color: #e74a3b !important;
    }
</style>

<script>
$(document).ready(function() {
    // Initialize Feather Icons
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>
@endsection
