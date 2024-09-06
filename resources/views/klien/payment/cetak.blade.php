<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .receipt {
            width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #000;
        }

        .receipt-header,
        .receipt-footer {
            text-align: right;
        }

        .receipt-header {
            margin-bottom: 20px;
        }

        .receipt-body {
            margin-bottom: 20px;
        }

        .receipt-body table {
            width: 100%;
            border-collapse: collapse;
        }

        .receipt-body table td {
            padding: 5px 0;
        }

        .amount {
            font-weight: bold;
            font-size: 1em;
        }

        .dotted {
            border-bottom: 1px dotted #000;
        }

        .right-align {
            text-align: right;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="receipt-header">
            <p>Littlemee Decoration</p>
        </div>
        <div class="receipt-body">
            <table>
                <tr>
                    <td>TELAH DITERIMA DARI</td>
                    <td class="dotted">: {{ $booking->nama }}</td>
                </tr>
                <tr>
                    <td>UANG SEJUMLAH</td>
                    @if ($booking->dp != 0 && $booking->kekurangan != 0)
                        <td class="dotted">: {{ formatRupiah($booking->dp) }}</td>
                    @else
                        <td class="dotted">: {{ formatRupiah($booking->total) }}</td>
                    @endif
                </tr>
                <tr>
                    <td>UNTUK PEMBAYARAN</td>
                    <td class="dotted">: PENYEWAAN DEKORASI</td>
                </tr>
            </table>
        </div>
        <div class="receipt-footer">
            <div class="right-align">Pamekasan, {{$booking->tgl_bayar}}</div>
            @if ($booking->dp != 0 && $booking->kekurangan != 0)
                <div class="amount">Dp: {{ formatRupiah($booking->dp) }}</div>
                <div class="amount">Kekurangan: {{ formatRupiah($booking->kekurangan) }}</div>
            @else
            <div class="amount">Lunas: {{ formatRupiah($booking->total) }}</div>
            @endif
        </div>
    </div>
</body>

</html>
