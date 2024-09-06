@extends('admin.layout')

@section('content')
    <section class="paketdekorasi">
        @if ($message = Session::get('success'))
            <div class="notifikasi success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <h2>Cetak<span> Laporan</span></h2>
        <div class="filter-container">
            <div class="filter-section">
                <form action="{{ route('cari') }}" method="GET" id="filter-form">
                    @csrf
                    <label for="filter-date-from">Dari tanggal:</label>
                    <input type="date" id="filter-date-from" name="date_from" value="{{ request('date_from') }}">
                    <label for="filter-date-to">Sampai tanggal:</label>
                    <input type="date" id="filter-date-to" name="date_to" value="{{ request('date_to') }}">
                    <button type="submit" class="filter-button">Cari</button>
                </form>
            </div>
        </div>
        <a href="{{ route('cetak', ['date_from' => request('date_from'), 'date_to' => request('date_to')]) }}">
            <button class="btn-primary">Cetak</button>
        </a>

    </section>
    <div id="data-container" class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No Hp</th>
                    <th>Pengantin</th>
                    <th>Tanggal</th>
                    <th>Paket/Kustom</th>
                    <th>Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupBooking as $bookingId => $bookingDetails)
                    @php
                        $firstDetail = $bookingDetails->first();
                    @endphp
                    <tr data-id="">
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

                        <td>{{ $firstDetail->booking->status }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
