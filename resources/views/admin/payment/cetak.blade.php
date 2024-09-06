<!-- resources/views/admin/payment/cetak.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>Laporan PDF</title>
    <style>
        /* Tambahkan styling yang diperlukan untuk PDF */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        h2 {
            text-align: center;
            font-size: 2.6rem;
            margin-bottom: 3rem;
            color: rgb(33, 29, 29);
        }

        h2 span {
            color: var(--primary);
        }

        h2 {
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <section class="paketdekorasi">

        <h2>Littlemee<span> Decoration</span></h2>
    </section>
    <h3>Laporan dari {{ $dateFrom }} sampai {{ $dateTo }}</h2>
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Hp</th>
                    <th>Pengantin</th>
                    <th>Tanggal</th>
                    <th>Paket/Kustom</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sortedGroupBooking as $bookingId => $bookingDetails)
                    @php
                        $firstDetail = $bookingDetails->first();
                    @endphp
                    <tr>
                        <td>{{ $firstDetail->booking->nama }}</td>
                        <td>{{ $firstDetail->booking->alamat }}</td>
                        <td>{{ $firstDetail->booking->noHp }}</td>
                        <td>{{ $firstDetail->booking->nama_pengantin }}</td>
                        <td>{{ $firstDetail->booking->tanggal_mulai_penggunaan }}</td>
                        @if ($firstDetail->paket_id)
                            <td>{{ $firstDetail->paket->nama }}</td>
                        @else
                            <td>Kustom</td>
                        @endif
                        
                        @if ($firstDetail->booking->dp != 0 && $firstDetail->booking->kekurangan == 0)
                            <td>{{ formatRupiah($firstDetail->booking->total) }}</td>
                        @elseif($firstDetail->booking->dp == 0 && $firstDetail->booking->kekurangan != 0)
                            <td>{{ formatRupiah($firstDetail->booking->total) }}</td>
                        @else
                            <td>{{ formatRupiah($firstDetail->booking->dp) }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Menampilkan total pendapatan -->
        <div style="margin-top: 20px;">
            <strong>Total Pendapatan:</strong> {{ formatRupiah($totalPendapatan) }}
        </div>

</body>

</html>
