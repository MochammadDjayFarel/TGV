@extends('template.staff')

@section('title', 'Tambah Jadwal Penerbangan')

@section('content')
<div class="container-fluid">
    {{-- Header Section --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-2 text-gray-800">Tambah Jadwal Penerbangan</h1>
                    <p class="mb-0 text-muted">Buat jadwal penerbangan baru</p>
                </div>
                <a href="{{ route('staff.jadwal.index') }}" class="btn btn-secondary">
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
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Jadwal</h6>
                </div>
                <div class="card-body">
                    <form id="jadwalForm" method="POST" action="{{ route('staff.jadwal.store') }}">
                        @csrf

                        <div class="row">
                            {{-- Nomor Penerbangan --}}
                            <div class="col-md-6 mb-3">
                                <label for="flight_number" class="form-label">Nomor Penerbangan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('flight_number') is-invalid @enderror" id="flight_number" name="flight_number" value="{{ old('flight_number') }}" required>
                                @error('flight_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bandara Keberangkatan --}}
                            <div class="col-md-6 mb-3">
                                <label for="departure_airport_id" class="form-label">Bandara Keberangkatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('departure_airport_id') is-invalid @enderror" id="departure_airport_id" name="departure_airport_id" required>
                                    <option value="">Pilih Bandara Keberangkatan</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('departure_airport_id') == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->name }} ({{ $airport->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('departure_airport_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Bandara Kedatangan --}}
                            <div class="col-md-6 mb-3">
                                <label for="arrival_airport_id" class="form-label">Bandara Kedatangan <span class="text-danger">*</span></label>
                                <select class="form-select @error('arrival_airport_id') is-invalid @enderror" id="arrival_airport_id" name="arrival_airport_id" required>
                                    <option value="">Pilih Bandara Kedatangan</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('arrival_airport_id') == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->name }} ({{ $airport->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('arrival_airport_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Waktu Keberangkatan --}}
                            <div class="col-md-6 mb-3">
                                <label for="departure_time" class="form-label">Waktu Keberangkatan <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('departure_time') is-invalid @enderror" id="departure_time" name="departure_time" value="{{ old('departure_time') }}" required>
                                @error('departure_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Waktu Kedatangan --}}
                            <div class="col-md-6 mb-3">
                                <label for="arrival_time" class="form-label">Waktu Kedatangan <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('arrival_time') is-invalid @enderror" id="arrival_time" name="arrival_time" value="{{ old('arrival_time') }}" required>
                                @error('arrival_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Maskapai --}}
                            <div class="col-md-6 mb-3">
                                <label for="airline_id" class="form-label">Maskapai <span class="text-danger">*</span></label>
                                <select class="form-select @error('airline_id') is-invalid @enderror" id="airline_id" name="airline_id" required>
                                    <option value="">Pilih Maskapai</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>
                                            {{ $airline->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('airline_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pilot --}}
                            <div class="col-md-6 mb-3">
                                <label for="pilot_id" class="form-label">Pilot <span class="text-danger">*</span></label>
                                <select class="form-select @error('pilot_id') is-invalid @enderror" id="pilot_id" name="pilot_id" required>
                                    <option value="">Pilih Pilot</option>
                                    @foreach($pilots as $pilot)
                                        <option value="{{ $pilot->id }}" {{ old('pilot_id') == $pilot->id ? 'selected' : '' }}>
                                            {{ $pilot->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pilot_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Co-Pilot --}}
                            <div class="col-md-6 mb-3">
                                <label for="co_pilot_id" class="form-label">Co-Pilot</label>
                                <select class="form-select @error('co_pilot_id') is-invalid @enderror" id="co_pilot_id" name="co_pilot_id">
                                    <option value="">Pilih Co-Pilot (Opsional)</option>
                                    @foreach($coPilots as $coPilot)
                                        <option value="{{ $coPilot->id }}" {{ old('co_pilot_id') == $coPilot->id ? 'selected' : '' }}>
                                            {{ $coPilot->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('co_pilot_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('staff.jadwal.index') }}" class="btn btn-secondary me-2">Batal</a>
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
    // Form validation
    $('#jadwalForm').on('submit', function(e) {
        var departure = new Date($('#departure_time').val());
        var arrival = new Date($('#arrival_time').val());
        var departureAirport = $('#departure_airport_id').val();
        var arrivalAirport = $('#arrival_airport_id').val();

        // Check if arrival is after departure
        if (arrival <= departure) {
            e.preventDefault();
            toastr.error('Waktu kedatangan harus setelah waktu keberangkatan');
            return false;
        }

        // Check if departure and arrival airports are different
        if (departureAirport === arrivalAirport) {
            e.preventDefault();
            toastr.error('Bandara keberangkatan dan kedatangan harus berbeda');
            return false;
        }
    });

    // Set minimum departure time to now
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    $('#departure_time').attr('min', now.toISOString().slice(0,16));

    // Update arrival time min when departure changes
    $('#departure_time').on('change', function() {
        var departureTime = $(this).val();
        $('#arrival_time').attr('min', departureTime);
    });
});

// Initialize Feather Icons
document.addEventListener('DOMContentLoaded', function() {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }
});
</script>
@endsection
