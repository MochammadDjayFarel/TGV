@extends('template.navbar')

@section('content')
<div class="container" style="max-width:720px; margin-top:30px;">
    <div class="card p-4" style="border:1px solid #eee; border-radius:8px;">
        <h3>Pembayaran Tiket</h3>

        @if(session('success'))
            <div style="background:#e6ffed;border:1px solid #b7f2c9;padding:10px;border-radius:6px;margin-bottom:12px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('info'))
            <div style="background:#fff8e6;border:1px solid #ffe8a8;padding:10px;border-radius:6px;margin-bottom:12px;">
                {{ session('info') }}
            </div>
        @endif

        <p><strong>Ticket ID:</strong> {{ $ticket->id }}</p>
        @if($ticket->flightSchedule)
            <p><strong>Rute:</strong>
                {{ $ticket->flightSchedule->departureAirport?->name ?? '-' }}
                →
                {{ $ticket->flightSchedule->arrivalAirport?->name ?? '-' }}
            </p>
            <p><strong>Tanggal berangkat:</strong>
                {{ optional($ticket->flightSchedule)->departure_time ? \Carbon\Carbon::parse($ticket->flightSchedule->departure_time)->format('Y-m-d H:i') : '-' }}
            </p>
        @endif
        <p><strong>Harga:</strong> {{ number_format($ticket->price ?? 0, 0, ',', '.') }}</p>

        <hr>

        {{-- Kalau belum ada pembayaran: tampilkan opsi pembayaran --}}
        @if(!$payment)
            <h5>Pilih Metode Pembayaran</h5>
            <p style="color:#666">Pilih salah satu: <strong>Buat Barcode</strong> (tunai/ke kasir) atau <strong>Bayar Online (Simulasi)</strong>.</p>

            <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:10px;">
                <!-- Form: Buat Barcode (tunai) -->
                <form action="{{ route('ticket-payments.store', $ticket->id) }}" method="POST" style="display:inline-block;" id="form-barcode">
                    @csrf
                    <input type="hidden" name="payment_type" value="barcode">
                    <label>Kode Promo (opsional)</label>
                    <select name="promo_code" id="promo_code_barcode" class="form-control">
                        <option value="">-- Tanpa Promo --</option>
                        @foreach($promos as $promo)
                            <option value="{{ $promo->code }}">{{ $promo->code }} - {{ $promo->label }}</option>
                        @endforeach
                    </select>
                    <div class="mb-2">
                        <small>Harga asli: <strong id="price_original_barcode">Rp {{ number_format($ticket->price ?? 0,0,',','.') }}</strong></small><br>
                        <small>Potongan: <strong id="price_discount_barcode">Rp 0</strong></small><br>
                        <small>Harga akhir: <strong id="price_final_barcode">Rp {{ number_format($ticket->price ?? 0,0,',','.') }}</strong></small>
                    </div>

                    <button type="submit" class="btn btn-primary" style="padding:10px 14px;border-radius:6px;">
                        Buat Barcode (Tunai / Kasir)
                    </button>
                </form>

                <!-- Form: Bayar Online (simulasi) -->
                <form action="{{ route('ticket-payments.store', $ticket->id) }}" method="POST" style="display:inline-block;" id="form-online">
                    @csrf
                    <input type="hidden" name="payment_type" value="barcode">
                    <label>Kode Promo (opsional)</label>
                    <select name="promo_code" id="promo_code_barcode" class="form-control">
                        <option value="">-- Tanpa Promo --</option>
                        @foreach($promos as $promo)
                            <option value="{{ $promo->code }}">{{ $promo->code }} - {{ $promo->label }}</option>
                        @endforeach
                    </select>

                    <div class="mb-2">
                        <small>Harga asli: <strong id="price_original_online">Rp {{ number_format($ticket->price ?? 0,0,',','.') }}</strong></small><br>
                        <small>Potongan: <strong id="price_discount_online">Rp 0</strong></small><br>
                        <small>Harga akhir: <strong id="price_final_online">Rp {{ number_format($ticket->price ?? 0,0,',','.') }}</strong></small>
                    </div>

                    <button type="submit" class="btn btn-success" style="padding:10px 14px;border-radius:6px;">
                        Bayar Online (Simulasi)
                    </button>
                </form>
            </div>

            <p style="margin-top:12px; color:#666; font-size:13px;">
                Catatan: tombol "Bayar Online (Simulasi)" hanya untuk demo — jika ingin integrasi gateway nyata, perlu tambahan server-side.
            </p>
        @else
            {{-- Jika sudah ada payment: tampilkan info + barcode --}}
            <p><strong>Status pembayaran:</strong>
                @if($payment->states === 'paid-off')
                    <span style="color:green">PAID</span>
                @else
                    <span style="color:orange">PROCESS</span>
                @endif
            </p>

            <p><strong>Tanggal booking:</strong> {{ $payment->booked_date }}</p>
            <p><strong>Tanggal bayar:</strong> {{ $payment->paid_date ?? '-' }}</p>

            <div style="margin-top:16px;">
                @if($payment->barcode_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($payment->barcode_path))
                    <img src="{{ asset('storage/' . $payment->barcode_path) }}" alt="Barcode" style="max-width:360px;">
                @else
                    <img src="data:image/png;base64,{{ app('DNS1D')->getBarcodePNG($payment->barcode,'C128') }}" alt="Barcode" style="max-width:360px;">
                @endif
            </div>

            <p style="margin-top:12px;"><strong>Kode:</strong> {{ $payment->barcode }}</p>

            <div style="margin-top:12px;">
                <a href="{{ route('ticket-payments.scan', $payment->barcode) }}" class="btn btn-success" target="_blank" style="padding:8px 12px;border-radius:6px;"> Konfirmasi</a>
                <a href="{{ route('ticket-payments.page', $ticket->id) }}" class="btn btn-secondary" style="padding:8px 12px;border-radius:6px;margin-left:8px;">Refresh</a>

                @if($payment->states === 'paid-off')
                    <a href="{{ route('ticket-payments.pdf', $payment->id) }}"
                    class="btn btn-dark"
                    style="padding:8px 12px;border-radius:6px;margin-left:8px;">
                        Cetak PDF
                    </a>
                @endif
            </div>

            @if($payment->promo_code || ($payment->original_price ?? false))
                <hr>
                <p><strong>Ringkasan Promo / Pembayaran</strong></p>
                <p>Kode Promo: {{ $payment->promo_code ?? '-' }}</p>
                <p>Harga asli: Rp {{ number_format($payment->original_price ?? $ticket->price ?? 0,0,',','.') }}</p>
                <p>Potongan: Rp {{ number_format($payment->discount_amount ?? 0,0,',','.') }}</p>
                <p>Harga akhir: Rp {{ number_format($payment->final_amount ?? ($ticket->price ?? 0),0,',','.') }}</p>
            @endif
        @endif
    </div>
</div>
@endsection

@push('script')
<script>
    // Daftar promo dari server (pastikan konsisten dengan controller)
const PROMOS = {!! json_encode($promos->map(function($p){
    return [
        'id' => $p->id,
        'code' => $p->code ?? null,
        'type' => $p->type,
        'value' => (int) $p->value,
        'label' => $p->label ?? null
    ];
})->keyBy('code')) !!};

function formatIDR(n) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(n);
}

function calcPromoById(price, promoId) {
    if (!promoId) return { discount: 0, final: price, promo: null };
    const promo = PROMOS[promoId];
    if (!promo) return { discount: 0, final: price, promo: null };

    let discount = 0;
    if (promo.type === 'percent') {
        discount = Math.round(price * (promo.value / 100));
    } else { // fixed
        discount = Number(promo.value);
    }
    const final = Math.max(0, price - discount);
    return { discount, final, promo };
}

document.addEventListener('DOMContentLoaded', function() {
    const original = Number({{ $ticket->price ?? 0 }});

    // elements barcode
    const selectBarcode = document.getElementById('promo_code_barcode');
    const discountBarcode = document.getElementById('price_discount_barcode');
    const finalBarcode = document.getElementById('price_final_barcode');

    // elements online
    const selectOnline = document.getElementById('promo_code_online');
    const discountOnline = document.getElementById('price_discount_online');
    const finalOnline = document.getElementById('price_final_online');

    function updateBarcodePreview() {
        const id = selectBarcode?.value || '';
        const rc = calcPromoById(original, id);
        discountBarcode.textContent = formatIDR(rc.discount);
        finalBarcode.textContent = formatIDR(rc.final);
    }
    function updateOnlinePreview() {
        const id = selectOnline?.value || '';
        const rc = calcPromoById(original, id);
        discountOnline.textContent = formatIDR(rc.discount);
        finalOnline.textContent = formatIDR(rc.final);
    }

    selectBarcode?.addEventListener('change', updateBarcodePreview);
    selectOnline?.addEventListener('change', updateOnlinePreview);

    updateBarcodePreview();
    updateOnlinePreview();
});
</script>
@endpush
