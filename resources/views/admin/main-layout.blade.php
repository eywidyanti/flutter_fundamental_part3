<style>
    .menu {
        background-color: #ffffff;
        overflow: hidden;
        padding: 10px 0;
        margin-top: 20px;
        box-shadow: 5px 5px #c0baba
    }

    .menu ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
        text-align: center;
    }

    .menu ul li {
        display: inline;
    }

    .menu ul li a {
        display: inline-block;
        color: black;
        padding: 14px 20px;
        text-decoration: none;
    }

    .menu ul li a:hover {
        background-color: #ddd;
        color: black;
    }
</style>

<div class="main-menu">
    <div class="menu">
        <ul>
            <li><a href="{{ route('pembayaran.pending') }}">Pesanan Disewa</a></li>
            <li><a href="{{ route('pembayaran.kirim') }}">Pesanan Dikirim</a></li>
            <li><a href="{{ route('pembayaran.selesai') }}">Pesanan Selesai</a></li>
            <li><a href="{{ route('pembayaran.cancel') }}">Pesanan Dibatalkan</a></li>
        </ul>
    </div>
    @yield('content')
</div>
