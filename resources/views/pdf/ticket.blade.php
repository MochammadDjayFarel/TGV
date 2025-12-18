<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Tiket Pesawat</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        .box {
            border: 1px solid #000;
            padding: 15px;
            margin-top: 20px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 6px;
            vertical-align: top;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="title">TIKET PESAWAT</div>

    <div class="box">
        <table>
            <tr>
                <td><strong>Kode Tiket</strong></td>
                <td>{{ $ticket->reservation_code ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Rute</strong></td>
                <td>
                    {{ $ticket->flightSchedule->departureAirport?->name ?? '-' }}
                    →
                    {{ $ticket->flightSchedule->arrivalAirport?->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td><strong>Tanggal Berangkat</strong></td>
                <td>
                    {{ \Carbon\Carbon::parse($ticket->flightSchedule->departure_time)->format('d-m-Y H:i') }}
                </td>
            </tr>
            <tr>
                <td><strong>Harga</strong></td>
                <td>Rp {{ number_format($ticket->price, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td>PAID</td>
            </tr>
        </table>
    </div>

    <div class="barcode">
    <p><strong>Kode Pembayaran</strong></p>

    @php
        // jika $barcodeBase64 sudah berupa base64 tanpa prefix
        $dataUrl = 'data:image/png;base64,' . $barcodeBase64;
    @endphp

    <img src="{{ $dataUrl }}" style="height:70px; display:block; margin:0 auto;">
    <p style="text-align:center; margin-top:6px;">{{ $payment->barcode }}</p>
</div>


    <p style="text-align:center;margin-top:30px;">
        Tunjukkan tiket ini saat check-in
    </p>

</body>
</html>
