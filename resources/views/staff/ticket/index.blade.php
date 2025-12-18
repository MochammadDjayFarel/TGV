@extends('template.staff')

@section('title', 'Daftar Ticket')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Daftar Ticket</h2>
            <div>
                <a href="{{ route('staff.ticket.create') }}" class="btn btn-primary me-2">
                    <i class="fa fa-plus"></i> Tambah Ticket
                </a>
            </div>
        </div>
    </div>
    
    @if($tickets->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="promo-grid">
                @foreach($tickets as $ticket)
                <div class="promo-card">
                    <img src="{{ $ticket->img ? asset('storage/'.$ticket->img) : asset('img/images.jpg') }}" alt="Ticket" />
                    <div class="promo-body">
                        <!-- Rute Penerbangan -->
                        @if($ticket->flightSchedule)
                            <h4>
                                {{ $ticket->flightSchedule->departureAirport->code ?? 'N/A' }} → {{ $ticket->flightSchedule->arrivalAirport->code ?? 'N/A' }}
                            </h4>
                        @else
                            <h4>-</h4>
                        @endif
                        
                        <!-- Detail Penerbangan -->
                        <p style="font-size: 13px; color: #666; margin: 6px 0;">
                            Flight: <strong>{{ $ticket->flightSchedule->flight_number ?? '-' }}</strong>
                        </p>
                        <p style="font-size: 13px; color: #666; margin: 6px 0;">
                            Tujuan: {{ $ticket->flightSchedule->departureAirport->city ?? '-' }} - {{ $ticket->flightSchedule->arrivalAirport->city ?? '-' }}
                        </p>
                        
                        <!-- Kode Reservasi -->
                        <p style="margin: 10px 0; font-size: 12px;">
                            Kode: <span style="background: #6c757d; color: white; padding: 4px 8px; border-radius: 4px; font-weight: 600;">{{ $ticket->reservation_code }}</span>
                        </p>
                        
                        <!-- Harga Ticket -->
                        <p style="margin: 10px 0; font-size: 12px;">
                            Harga: <strong>Rp {{ number_format($ticket->price, 0, ',', '.') }}</strong>
                        </p>
                        
                        <!-- Tombol Action -->
                        <div style="display: flex; gap: 6px; margin-top: 12px;">
                            <a href="{{ route('staff.lihat', $ticket) }}" class="view-ticket-btn" data-id="{{ $ticket->id }}" style="flex: 1; padding: 6px 10px; background: #17a2b8; color: white; border: none; border-radius: 4px; text-decoration: none; font-size: 12px; cursor: pointer; text-align: center; display: inline-block;">
                                <i class="fa fa-eye"></i> Lihat
                            </a>
                            <a href="{{ route('staff.ticket.edit', $ticket) }}" style="flex: 1; padding: 6px 10px; background: #ffc107; color: #333; border: none; border-radius: 4px; text-decoration: none; font-size: 12px; cursor: pointer; text-align: center; display: inline-block;">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('staff.ticket.destroy', $ticket) }}" method="POST" style="flex: 1;" onsubmit="return confirm('Yakin hapus ticket?')">
                                @csrf
                                @method('DELETE')
                                <button style="width: 100%; padding: 6px 10px; background: #dc3545; color: white; border: none; border-radius: 4px; font-size: 12px; cursor: pointer;">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="col-12">
            <div style="background: white; border-radius: 12px; padding: 60px 20px; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
                <i style="font-size: 48px; color: #ccc; display: block; margin-bottom: 16px;" class="fa fa-inbox"></i>
                <h4 style="color: #999; margin-bottom: 8px;">Belum Ada Ticket</h4>
                <p style="color: #bbb; margin-bottom: 20px;">Mulai tambahkan ticket baru</p>
                <a href="{{ route('staff.ticket.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Buat Ticket
                </a>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Modal for Viewing Ticket -->
<div class="modal fade" id="viewTicketModal" tabindex="-1" aria-labelledby="viewTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTicketModalLabel">Detail Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Rute:</label>
                    <p id="viewTicketRoute"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Kode Reservasi:</label>
                    <p id="viewTicketCode"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Harga:</label>
                    <p id="viewTicketPrice"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Status:</label>
                    <p id="viewTicketStatus"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Dibuat Pada:</label>
                    <p id="viewTicketCreatedAt"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- CoPilot Modal -->
<div class="modal fade" id="coPilotModal" tabindex="-1" aria-labelledby="coPilotModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coPilotModalLabel">Cari kode - Bantuan Cepat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Fungsi cepat untuk kode reservasi:</p>
                <div class="mb-3">
                    <label class="form-label">Kode Reservasi (otomatis)</label>
                    <div class="input-group">
                        <input type="text" id="copilotReservationCode" class="form-control" readonly>
                        <button class="btn btn-outline-secondary" type="button" id="copilotRegenerate">Regenerate</button>
                        <button class="btn btn-outline-primary" type="button" id="copilotCopy">Copy</button>
                    </div>
                </div>

                <div class="mb-2">
                    <button class="btn btn-success" id="copilotOpenCreate">Buka Form Create dengan kode ini</button>
                    <small class="text-muted d-block mt-1">Buka halaman tambah ticket dan isi otomatis kode reservasi.</small>
                </div>

                <hr>

                <p class="mb-1"><strong>Catatan:</strong></p>
                <ul class="small">
                    <li>Kode bersifat acak, format: 3 huruf besar + 5 angka (mis. CPX12345).</li>
                    <li>Field lainnya tetap wajib diisi pada form create (flight_schedule, price).</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Handle view button click for tickets
    $(document).on('click', '.view-ticket-btn', function() {
        var ticketId = $(this).data('id');
        $.ajax({
            url: '{{ route("staff.ticket.show", ":id") }}'.replace(':id', ticketId),
            method: 'GET',
            success: function(data) {
                $('#viewTicketRoute').text(data.flightSchedule ? data.flightSchedule.departureAirport.code + ' → ' + data.flightSchedule.arrivalAirport.code : 'N/A');
                $('#viewTicketCode').text(data.reservation_code);
                $('#viewTicketPrice').text('Rp ' + new Intl.NumberFormat($price, 0, ',', '.').format(data.price));
                $('#viewTicketStatus').text(data.status || 'N/A');
                var createdAt = new Date(data.created_at);
                $('#viewTicketCreatedAt').text(createdAt.toLocaleString('id-ID'));
                $('#viewTicketModal').modal('show');
            },
            error: function() {
                toastr.error('Gagal memuat data ticket.');
            }
        });
    });
});

// CoPilot helper (generate, copy, open create)
(function() {
    function generateCode() {
        const letters = Array.from({length:3}, ()=> String.fromCharCode(65 + Math.floor(Math.random()*26))).join('');
        const numbers = Math.floor(10000 + Math.random()*90000).toString();
        return letters + numbers;
    }

    function setCode(val) {
        document.getElementById('copilotReservationCode').value = val;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // initialize
        setCode(generateCode());

        document.getElementById('copilotRegenerate').addEventListener('click', function() {
            setCode(generateCode());
        });

        document.getElementById('copilotCopy').addEventListener('click', function() {
            const input = document.getElementById('copilotReservationCode');
            navigator.clipboard.writeText(input.value).then(function() {
                toastr.success('Kode disalin ke clipboard');
            }).catch(function() {
                toastr.error('Gagal menyalin kode');
            });
        });

        document.getElementById('copilotOpenCreate').addEventListener('click', function() {
            const code = encodeURIComponent(document.getElementById('copilotReservationCode').value);
            // redirect to create route with reservation_code as query param
            window.location.href = '{{ route("staff.ticket.create") }}' + '?reservation_code=' + code;
        });
    });
})();
</script>
@endsection
