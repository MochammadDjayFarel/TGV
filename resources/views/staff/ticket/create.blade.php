@extends('template.staff')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Tambah Ticket</h2>
        <a href="{{ route('staff.ticket.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('staff.ticket.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <select name="flight_schedule_id" class="form-control mb-2" required>
                    <option value="">Pilih Jadwal</option>
                    @foreach($flightSchedules as $fs)
                        <option value="{{ $fs->id }}">
                            {{ $fs->departureAirport->city }} → {{ $fs->arrivalAirport->city }}
                        </option>
                    @endforeach
                </select>

                <select name="ticket_type" class="form-control mb-2" required>
                    <option value="">Jenis Tiket</option>
                    <option value="sekali jalan">Sekali Jalan</option>
                    <option value="pulang pergi">Pulang Pergi</option>
                    <option value="lintas kota">Lintas Kota</option>
                </select>

                <input type="number" name="price" class="form-control mb-2" placeholder="Harga" required>

                <input type="file" name="img" class="form-control mb-3">

                <button class="btn btn-primary">Simpan Ticket</button>
            </form>
        </div>
    </div>
</div>
@endsection


