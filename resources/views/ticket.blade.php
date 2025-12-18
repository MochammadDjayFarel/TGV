@extends('template.navbar')

@section('title', 'Daftar Ticket')

@section('content')
<style>
  /* PROMO CARD GRID STYLES */
  .promo-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
  }

  .promo-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }

  .promo-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }

  .promo-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
  }

  .promo-body {
    padding: 16px;
  }

  .promo-body h4 {
    font-size: 16px;
    font-weight: 600;
    margin-bottom: 12px;
    color: #333;
  }

  .promo-body p {
    font-size: 14px;
    color: #666;
    line-height: 1.5;
  }

  .promo-body .badge {
    font-size: 12px;
    padding: 4px 8px;
  }

  .promo-body .d-flex {
    display: flex;
    gap: 8px;
  }

  .promo-body .btn-sm {
    padding: 6px 12px;
    font-size: 12px;
  }
</style>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Daftar Ticket</h2>
        </div>
    </div>

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-12">
            <form method="GET" action="{{ route('ticket') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="departure_city" class="form-label">Dari</label>
                    <select class="form-select" name="departure_city" id="departure_city">
                    <option value="">Semua Kota Asal</option>
                    @foreach(\App\Models\Airport::all() as $airport)
                    <option value="{{ $airport->id }}" {{ request('departure_city') == $airport->id ? 'selected' : '' }}>
                        {{ $airport->country == 'Indonesia' ? '🇮🇩' : '🌍' }} {{ $airport->city }}, {{ $airport->country }}
                    </option>
                    @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="arrival_city" class="form-label">Ke</label>
                    <select class="form-select" name="arrival_city" id="arrival_city">
                    <option value="">Semua Kota Tujuan</option>
                    @foreach(\App\Models\Airport::all() as $airport)
                    <option value="{{ $airport->id }}" {{ request('arrival_city') == $airport->id ? 'selected' : '' }}>
                        {{ $airport->country == 'Indonesia' ? '🇮🇩' : '🌍' }} {{ $airport->city }}, {{ $airport->country }}
                    </option>
                    @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="tgl_berangkat" class="form-label">Tanggal Berangkat</label>
                    <input class="form-control" id="tgl_berangkat" name="tgl_berangkat" type="date" value="{{ request('tgl_berangkat') }}" min="{{ date('Y-m-d') }}">
                </div>

                <div class="col-md-3">
                    <label for="ticket_type" class="form-label">Tipe Tiket</label>
                    <select class="form-select" name="ticket_type" id="ticket_type">
                    <option value="">Semua Tipe</option>
                    <option value="sekali jalan" {{ request('ticket_type')=='sekali jalan' ? 'selected' : '' }}>Sekali Jalan</option>
                    <option value="pulang pergi" {{ request('ticket_type')=='pulang pergi' ? 'selected' : '' }}>Pulang Pergi</option>
                    <option value="lintas kota" {{ request('ticket_type')=='lintas kota' ? 'selected' : '' }}>Lintas Kota</option>
                    </select>
                </div>

                <div class="col-12 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary me-2"><i class="fas fa-search"></i> Cari</button>
                    <a href="{{ route('ticket') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Reset</a>
                </div>
                </form>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="promo-grid">
                @foreach($tickets as $ticket)
                <div class="promo-card">
                    <img src="{{ $ticket->img ? asset('storage/'.$ticket->img) : asset('img/images.jpg') }}" alt="Ticket" />
                    <div class="promo-body">
                        <!-- Tujuan -->
                        <h4 style="margin-bottom: 8px;">
                            {{ $ticket->flightSchedule->departureAirport->city ?? 'N/A' }} → {{ $ticket->flightSchedule->arrivalAirport->city ?? 'N/A' }}
                        </h4>

                        <!-- Harga -->
                        <p style="margin: 8px 0; font-size: 14px; font-weight: 600; color: #007bff;">
                            Rp {{ number_format($ticket->price, 0, ',', '.') }}
                        </p>

                        <!-- Fasilitas -->
                        <p style="margin: 8px 0; font-size: 12px; color: #666;">
                            <i class="fa-solid fa-suitcase"></i> Termasuk bagasi 20kg<br>
                            <i class="fa fa-utensils"></i> Makanan & minuman<br>
                            <i class="fa fa-wifi"></i> WiFi gratis<br>
                            <i class="fa fa-plane"></i> {{ $ticket->ticket_type }}
                        </p>

                        <!-- Tombol Action -->
                        <div style="margin-top: 12px;">
                            <a href="{{ route('ticket-payments.page', $ticket) }}" style="width: 100%; padding: 8px 12px; background: #28a745; color: white; border: none; border-radius: 4px; text-decoration: none; font-size: 12px; cursor: pointer; text-align: center; display: inline-block;">
                                <i class="fa fa-shopping-cart"></i> Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
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
@push('script')
    
<script>
    $(document).ready(function() {
    // Handle view button click for tickets
    $(document).on('click', '.view-ticket-btn', function() {
        var ticketId = $(this).data('id');
        $.ajax({
            url: '/staff/ticket/' + ticketId,
            method: 'GET',
            success: function(data) {
                $('#viewTicketRoute').text(data.flightSchedule ? data.flightSchedule.departureAirport.code + ' → ' + data.flightSchedule.arrivalAirport.code : 'N/A');
                $('#viewTicketCode').text(data.reservation_code);
                $('#viewTicketPrice').text('Rp ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.price).replace('IDR', '').trim());
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
@endpush
@endsection

