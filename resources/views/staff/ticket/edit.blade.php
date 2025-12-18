@extends('template.staff')

@section('title', 'Edit Ticket')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Edit Ticket</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('staff.ticket.update', $ticket) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="flight_schedule_id" class="form-label">Jadwal Penerbangan</label>
                            <select name="flight_schedule_id" id="flight_schedule_id" class="form-select" required>
                                <option value="">Pilih Jadwal</option>
                                @foreach($flightSchedules as $jadwal)
                                    <option value="{{ $jadwal->id }}" {{ $ticket->flight_schedule_id == $jadwal->id ? 'selected' : '' }}>
                                        {{ $jadwal->flight_number }} - {{ $jadwal->departureAirport->city ?? '-' }} ➝ {{ $jadwal->arrivalAirport->city ?? '-' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="img" class="form-label">Ganti Gambar (opsional)</label>
                            <input type="file" name="img" id="img" class="form-control" accept="image/*">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar.</small>
                            <div class="mt-2">
                                <img src="{{ $ticket->img ? asset('storage/'.$ticket->img) : asset('img/images.jpg') }}" alt="img" class="img-fluid rounded" style="max-height:80px;">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Ticket</button>
                        <a href="{{ route('staff.ticket.index') }}" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
