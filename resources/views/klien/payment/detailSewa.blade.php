<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pemesan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/galeri.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        hr {
            margin: 20px 0;
            border: 0;
            border-top: 1px solid #ddd;
        }

        .alert {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }

        .detail {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
        }

        .detail:nth-child(odd) {
            background-color: #f9f9f9;
        }

        .detail label {
            font-weight: bold;
            width: 45%;
            text-align: left;
            padding: 10px;
        }

        .detail p {
            width: 55%;
            margin: 0;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Detail Penyewa</h1>
        <hr>

        @if (session('error'))
            <div class="alert">{{ session('error') }}</div>
        @else
            <div class="detail">
                <label>Nama Penyewa:</label>
                <p>{{ $booking->nama }}</p>
            </div>
            <div class="detail">
                <label>Email:</label>
                <p>{{ $booking->email }}</p>
            </div>
            <div class="detail">
                <label>No HP:</label>
                <p>{{ $booking->noHp }}</p>
            </div>
            <div class="detail">
                <label>Alamat:</label>
                <p>{{ $booking->alamat }}</p>
            </div>
            <div class="detail">
                <label>Nama Pengantin:</label>
                <p>{{ $booking->nama_pengantin}}</p>
            </div>
            <div class="detail">
                <label>Tanggal Mulai Penggunaan:</label>
                <p>{{ $booking->tanggal_mulai_penggunaan }}</p>
            </div>
            <div class="detail">
                <label>Jam Mulai Penggunaan:</label>
                <p>{{ $booking->jam_mulai_penggunaan }}</p>
            </div>
            <div class="detail">
                <label>Jam Berakhir Penggunaan:</label>
                <p>{{ $booking->jam_berakhir_penggunaan }}</p>
            </div>
            <div class="detail">
                <label>Keterangan:</label>
                <p>{{ $booking->keterangan }}</p>
            </div>
            <div class="detail">
                <label>Status:</label>
                <p>{{ $booking->status }}</p>
            </div>
        @endif
    </div>
</body>

</html>
