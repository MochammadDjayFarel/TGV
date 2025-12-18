@extends('template.staff')

@section('title', 'Detail Ticket')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2>Detail Ticket</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-center">
                        <img src="{{ $ticket->img ? asset('storage/'.$ticket->img) : asset('img/images.jpg') }}" alt="img" class="img-fluid rounded" style="max-height:120px;">
                    </div>
                    <dl class="row">
                        <dt class="col-sm-4">Kode Reservasi</dt>
                        <dd class="col-sm-8">{{ $ticket->reservation_code }}</dd>
                        <dt class="col-sm-4">Jadwal</dt>
                        <dd class="col-sm-8">
                            @if($ticket->flightSchedule)
                                {{ $ticket->flightSchedule->flight_number }}<br>
                                {{ $ticket->flightSchedule->departureAirport->city ?? '-' }} ➝ {{ $ticket->flightSchedule->arrivalAirport->city ?? '-' }}
                            @else
                                -
                            @endif
                        </dd>
                    </dl>
                    <a href="{{ route('staff.ticket.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
