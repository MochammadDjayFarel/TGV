<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\FlightSchedule;
use App\Models\TicketPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Milon\Barcode\DNS1D;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use App\Models\Promo;

class TicketController extends Controller
{
    /**
     * Daftar promo statis — bisa ganti dengan model DB nanti.
     * key => [type=>'percent'|'fixed', value=>int, label=>string]
     */
    protected function promoList(): array
    {
        return [
            'PROMO10' => [
                'type' => 'percent',
                'value' => 10,
                'label' => 'Diskon 10%',
            ],
            'DISC50K' => [
                'type' => 'fixed',
                'value' => 50000,
                'label' => 'Potongan Rp50.000',
            ],
            'FREE50' => [
                'type' => 'percent',
                'value' => 50,
                'label' => 'Diskon 50%',
            ],
        ];
    }

    public function index()
    {
        $tickets = Ticket::with('flightSchedule')->latest()->get();
        return view('staff.ticket.index', compact('tickets'));
    }

    public function create()
    {
        $flightSchedules = FlightSchedule::all();
        return view('staff.ticket.create', compact('flightSchedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'flight_schedule_id' => 'required|exists:flight_schedules,id',
            'ticket_type'        => 'required|in:sekali jalan,pulang pergi,lintas kota',
            'img'                => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'price'              => 'required|numeric|min:100000',
        ]);

        $reservationCode = 'TGV-' . strtoupper(Str::random(10));

        $imgPath = null;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('tickets', 'public');
        }

        Ticket::create([
            'reservation_code'   => $reservationCode,
            'flight_schedule_id' => $request->flight_schedule_id,
            'ticket_type'        => $request->ticket_type,
            'price'              => $request->price,
            'img'                => $imgPath,
            'user_id'            => Auth::id(),
            'states'             => 'paid-off',
        ]);

        return redirect()->route('staff.ticket.index')
            ->with('success', 'Ticket berhasil dibuat!');
    }

    public function show(Ticket $ticket)
    {
        return view('staff.ticket.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $flightSchedules = FlightSchedule::all();
        return view('staff.ticket.edit', compact('ticket', 'flightSchedules'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'flight_schedule_id' => 'required|exists:flight_schedules,id',
            'img' => 'nullable|image|max:2048',
        ]);

        $imgPath = $ticket->img;
        if ($request->hasFile('img')) {
            $imgPath = $request->file('img')->store('tickets', 'public');
        }

        $ticket->update([
            'img' => $imgPath,
            'flight_schedule_id' => $request->flight_schedule_id,
        ]);

        return redirect()->route('staff.ticket.index')
            ->with('success', 'Ticket berhasil diupdate!');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('staff.ticket.index')
            ->with('success', 'Ticket berhasil dihapus!');
    }

    public function ticketIndex(Request $request)
    {
        $query = Ticket::with('flightSchedule.departureAirport', 'flightSchedule.arrivalAirport');

        if ($request->filled('departure_city')) {
            $query->whereHas('flightSchedule.departureAirport', function ($q) use ($request) {
                $q->where('id', $request->departure_city);
            });
        }

        if ($request->filled('arrival_city')) {
            $query->whereHas('flightSchedule.arrivalAirport', function ($q) use ($request) {
                $q->where('id', $request->arrival_city);
            });
        }

        if ($request->filled('tgl_berangkat')) {
            $date = $request->tgl_berangkat;
            $today = Carbon::today()->toDateString();
            if ($date < $today) {
                $date = $today;
            }
            $query->whereHas('flightSchedule', function ($q) use ($date) {
                $q->whereDate('departure_time', $date);
            });
        }

        if ($request->filled('ticket_type') && in_array($request->ticket_type, ['sekali jalan','pulang pergi','lintas kota'])) {
            $query->where('ticket_type', $request->ticket_type);
        }

        $tickets = $query->get();

        return view('ticket', compact('tickets'));
    }

    protected function applyPromoByModel(int $price, ?Promo $promo): array
{
    if (! $promo) {
        return [
            'promo'    => null,
            'original' => $price,
            'discount' => 0,
            'final'    => $price,
        ];
    }

    $discount = 0;
    if ($promo->type === 'percent') {
        $discount = (int) round($price * ($promo->value / 100));
    } else { // fixed
        $discount = (int) $promo->value;
    }

    $final = max(0, $price - $discount);

    return [
        'promo'    => $promo,
        'original' => $price,
        'discount' => $discount,
        'final'    => $final,
    ];
}

public function paymentPage(Ticket $ticket)
{
    // ambil daftar promo aktif dari DB (ubah query sesuai kebutuhan, contoh: where('active', 1))
    $promos = Promo::orderBy('discount_percentage', 'desc')->get();

    $payment = TicketPayment::where('ticket_id', $ticket->id)->latest()->first();

    // untuk view: kirim promoList yang akan dipakai JS (json)
    return view('payment', [
        'ticket'    => $ticket,
        'payment'   => $payment,
        'promos'    => $promos,
    ]);
}

public function paymentStore(Request $request, Ticket $ticket)
{
    $request->validate([
        'payment_type' => 'required|in:barcode,online',
        'promo_id'     => 'nullable|exists:promos,id',
    ]);

    $existing = TicketPayment::where('ticket_id', $ticket->id)
        ->whereIn('states', ['process', 'paid-off'])
        ->latest()
        ->first();

    if ($existing) {
        return redirect()->route('ticket-payments.page', $ticket->id)
            ->with('info', 'Pembayaran sudah dibuat untuk tiket ini.');
    }

    // Ambil model promo jika ada
    $promo = null;
    if ($request->filled('promo_id')) {
        $promo = Promo::find($request->promo_id);
    }

    // Hitung promo menggunakan helper
    $calc = $this->applyPromoByModel((int) $ticket->price, $promo);

    // buat barcode unik
    $barcode = TicketPayment::generateBarcode();

    $paymentData = [
        'ticket_id'       => $ticket->id,
        'barcode'         => $barcode,
        'states'          => 'process',
        'booked_date'     => now()->toDateString(),
        'promo_id'        => $promo?->id,
        'promo_code'      => $promo?->code ?? null,
        'original_price'  => $calc['original'],
        'discount_amount' => $calc['discount'],
        'final_amount'    => $calc['final'],
    ];

    $payment = TicketPayment::create($paymentData);

    // generate barcode image dan simpan
    try {
        $dns1d = app(DNS1D::class);
        $pngBase64 = $dns1d->getBarcodePNG($barcode, 'C128');
        $binary = base64_decode($pngBase64);

        $filename = 'barcodes/' . $barcode . '.png';
        Storage::disk('public')->put($filename, $binary);

        $payment->barcode_path = $filename;
        $payment->save();
    } catch (\Throwable $e) {
        // silent: tetap lanjut meskipun image gagal dibuat
    }

    // simulasi: jika online => tandai langsung paid-off (untuk demo)
    if ($request->payment_type === 'online') {
        $payment->states = 'paid-off';
        $payment->paid_date = now()->toDateString();
        $payment->save();

        try {
            if ($payment->ticket && Schema::hasColumn('tickets', 'status')) {
                $payment->ticket->update(['status' => 'paid']);
            }
        } catch (\Throwable $e) {
            // silent
        }
    }

    return redirect()->route('ticket-payments.page', $ticket->id)
        ->with('success', 'Pembayaran berhasil dibuat. Total yang harus dibayar: Rp ' . number_format($calc['final'], 0, ',', '.'));
}

    public function paymentConfirmByBarcode($barcode)
    {
        $payment = TicketPayment::where('barcode', $barcode)->first();

        if (! $payment) {
            return response()->json(['message' => 'Kode barcode tidak ditemukan'], 404);
        }

        if ($payment->states === 'paid-off') {
            return back()->with('info', 'Pembayaran sudah dikonfirmasi sebelumnya.');
        }

        $payment->states = 'paid-off';
        $payment->paid_date = Carbon::now()->toDateString();
        $payment->save();

        try {
            if ($payment->ticket && Schema::hasColumn('tickets', 'status')) {
                $payment->ticket->update(['status' => 'paid']);
            }
        } catch (\Throwable $e) {
        }

        return back ()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function paymentPrintPdf(TicketPayment $ticketPayment)
    {
        $ticketPayment->load(
            'ticket.flightSchedule.departureAirport',
            'ticket.flightSchedule.arrivalAirport'
        );

        $ticket = $ticketPayment->ticket;

        $barcodeBase64 = null;
        try {
            $filePath = public_path('storage/' . $ticketPayment->barcode_path);

            if (file_exists($filePath) && is_readable($filePath)) {
                $barcodeBase64 = base64_encode(file_get_contents($filePath));
            } else {
                $dns1d = app('DNS1D');
                $pngBase64 = $dns1d->getBarcodePNG($ticketPayment->barcode, 'C128');
                $barcodeBase64 = $pngBase64;
            }
        } catch (\Throwable $e) {
            $dns1d = new DNS1D();
            $pngBase64 = $dns1d->getBarcodePNG($ticketPayment->barcode, 'C128');
            $barcodeBase64 = $pngBase64;
        }

        if (! $barcodeBase64) {
            abort(500, 'Gagal membaca atau membuat barcode untuk PDF.');
        }

        $pdf = Pdf::loadView('pdf.ticket', [
            'ticket'       => $ticket,
            'payment'      => $ticketPayment,
            'barcodeBase64'=> $barcodeBase64,
        ])->setPaper('A4', 'portrait');

        $fileName = 'TICKET-' . $ticket->id . '.pdf';
        return $pdf->download($fileName);
    }

}
