<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">

    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="/css/form.css">
</head>

<body>
    <nav class="navbar">
        <a href="#" class="navbar-logo"> Littlemee<span>Deco</span>.</a>

        <div class="navbar-nav">
            <a href="home">Home</a>
            <a href="#paket">Paket</a>
            <a href="#produk">Dekor</a>
            <a href="#galeri">Galeri</a>
            <a href="{{ route('booking.success') }}">Pembayaran</a>
            <a href="{{ route('payment') }}">Penyewaan</a>
        </div>

        <div class="navbar-extra">
            <a id="shopping-cart-button"><i data-feather="shopping-cart"></i><span class="red-cart">
                    @php
                        $paketkosong = \App\Models\Cart::where('user_id', Auth::id())->whereNull('paket_id')->exists();
                    @endphp

                    @if ($paketkosong)
                        {{ \App\Models\Cart::where('user_id', Auth::id())->count() }}
                    @else
                        {{ \App\Models\Cart::where('user_id', Auth::id())->distinct('paket_id')->count('paket_id') }}
                    @endif

                </span></a>
            <a id="furniture-menu"><i data-feather="menu"></i></a>
        </div>

        <div class="profile-container">
            <img src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : 'default.jpg' }}"
                class="user-pic" id="profilePic">
            <div class="dropdown" id="dropdownMenu">
                <div style="color: black; font-size: 14px">{{ Auth::user()->name }}</div>
                <a href="#" class="dropdown-item">Profil</a>
                <a href="" class="dropdown-item"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Shopping Cart -->
        <div class="shopping-cart">

            @php
                $cartNullPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNull('paket_id')->get();
                $cartPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNotNull('paket_id')->get();
            @endphp

            @if ($cartNullPaketId->isNotEmpty())
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:10%">Dekor</th>
                            <th style="width:10%">Harga</th>
                            <th style="width:8%">Jumlah</th>
                            <th style="width:10%" class="text-center">Total</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $total = 0 @endphp
                        @if ($cartNullPaketId->count())
                            @foreach ($cartNullPaketId as $item)
                                @php $total += $item->dekor->harga * $item->quantity @endphp
                                <tr data-id="{{ $item->dekor_id }}">
                                    <td data-th="Product">
                                        <div class="row">
                                            <div class="col-sm-3 hidden-xs">
                                                <img src="/img/admin/gambarDekor/{{ $item->dekor->gambar }}"
                                                    width="100" height="100" class="img-responsive" />
                                            </div>
                                            <div class="col-sm-9">
                                                <h4 class="nomargin">{{ $item->dekor->nama }}</h4>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-th="Price">{{ formatRupiah($item->dekor->harga) }}</td>
                                    <td data-th="Quantity">
                                        <input type="number" value="{{ $item['quantity'] }}"
                                            class="form-control quantity update-cart" />
                                    </td>
                                    <td data-th="Subtotal" class="text-center">
                                        {{ formatRupiah($item->dekor->harga * $item->quantity) }}</td>
                                    <td class="actions" data-th="">
                                        <button class="remove-from-cart"><i data-feather="trash-2"></i>hapus</button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                <h3><strong>Total {{ formatRupiah($total) }}</strong></h3>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <a href="{{ route('checkout') }}">
                    <button class="btn"><i class="fa fa-upload"></i> Sewa</button>
                </a>
            @else
                <table id="cart" class="table table-hover table-condensed">
                    <thead>
                        <tr>
                            <th style="width:10%">Dekor</th>
                            <th style="width:10%">Harga</th>
                            <th style="width:8%">Jumlah</th>
                            <th style="width:10%" class="text-center">Total</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>

                        @php $total = 0 @endphp

                        @foreach ($cartPaketId as $items)
                            @php $total += $items->paket->harga * $items->quantity @endphp
                            <tr data-id="{{ $items->paket_id }}">
                                <td data-th="Product">
                                    <div class="row">
                                        <div class="col-sm-3 hidden-xs">
                                            @if (!empty($items->paket->gambar))
                                                <img src="/img/admin/gambarpaket/{{ $items->paket->gambar }}"
                                                    width="100" height="100" class="img-responsive" />
                                            @else
                                                <img src="img/admin/images.png" width="100" height="100"
                                                    class="img-responsive" />
                                            @endif
                                        </div>
                                        <div class="col-sm-9">
                                            <h4 class="nomargin">{{ $items->paket->nama }}</h4>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="Price">{{ formatRupiah($items->paket->harga) }}</td>
                                <td data-th="Quantity">
                                    <input type="number" value="{{ $items->first()['quantity'] }}"
                                        class="form-control quantity update-cart" disabled />
                                </td>
                                <td data-th="Subtotal" class="text-center">
                                    {{ formatRupiah($items->paket->harga * $items->quantity) }}</td>
                                <td class="actions" data-th="">
                                    <button class="remove-from-cart"><i data-feather="trash-2"></i>hapus</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="text-align: center;">
                                <h3><strong>Total {{ formatRupiah($total) }}</strong></h3>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <a href="{{ route('checkout') }}">
                    <button class="btn"><i class="fa fa-upload"></i> Sewa</button>
                </a>
            @endif

        </div>
        <!-- Shopping Cart -->
    </nav>
    <div class="main-container">

        @if ($errors->any())
            <div class="alert alert-danger" id="errorAlert">
                <button class="close-btn" onclick="closeAlert()">×</button>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>

        @endif

        @php
            $cartNullPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNull('paket_id')->get();
            $cartPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNotNull('paket_id')->get();
        @endphp

        @if ($cartNullPaketId->isNotEmpty())
            <div class="product-container">
                <h2>Keranjang</h2>
                @php $total = 0 @endphp
                @if ($cartNullPaketId->count())
                    @foreach ($cartNullPaketId as $item)
                        @php $total += $item->dekor->harga * $item->quantity @endphp
                        <div class="product-card">
                            <img src="img/admin/gambarDekor/{{ $item->dekor->gambar }}" alt="Kursi"
                                class="product-image">
                            <p class="product-title">{{ $item->dekor->nama }}</p>
                            <p>Harga: {{ formatRupiah($item->dekor->harga) }}</p>
                            <p>Jumlah: {{ $item->quantity }}</p>
                        </div>
                    @endforeach
                @endif
                <div class="product-card">
                    <p class="product-title">Total {{ formatRupiah($total) }}</p>
                </div>
            </div>
        @else
            <div class="product-container">
                <h2>Keranjang</h2>
                @php $total = 0 @endphp
                @foreach ($cartPaketId as $items)
                    @php $total += $items->paket->harga * $items->quantity @endphp

                    <div class="product-card">
                        @if (!empty($items->paket->gambar))
                            <img src="/img/admin/gambarpaket/{{ $items->paket->gambar }}" class="product-image" />
                        @else
                            <img src="img/admin/images.png" class="product-image" />
                        @endif
                        <p class="product-title">{{ $items->paket->nama }}</p>
                        <p>Harga: {{ formatRupiah($total) }}</p>
                        <p>Jumlah: {{ $items->quantity }}</p>
                    </div>
                @endforeach
                <div class="product-card">
                    <p class="product-title">Total {{ formatRupiah($total) }}</p>
                </div>
            </div>
        @endif

        <div class="form-container">
            <div class="wrapper">
                <h2>Form Penyewaan</h2>
                <form action="{{ route('checkout.process') }}" method="POST" id="rentalForm">
                    @csrf
                    <!-- Input fields -->
                    <div class="input_group">
                        <div class="input_box">
                            <span class="details"> Nama: </span>
                            <input type="text" id="nama" name="nama" placeholder="Nama" required
                                class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Email : </span>
                            <input type="text" id="email" name="email" placeholder="Email" required
                                class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Alamat : </span>
                            <input type="text" placeholder="Alamat" id="alamat" name="alamat" required
                                class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> No. Telp : </span>
                            <input type="text" placeholder="No. Telepon" id="noHp" name="noHp" required
                                class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Nama Pengantin : </span>
                            <input type="text" id="nama_pengantin" name="nama_pengantin" placeholder="Nama"
                                required class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Tanggal Mulai Penggunaan: </span>
                            <input type="date" placeholder="Tanggal Penggunaan" id="tanggal_mulai_penggunaan"
                                name="tanggal_mulai_penggunaan" required class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Jam Mulai Penggunaan : </span>
                            <input type="time" placeholder="Jam Penggunaan" id="jam_mulai_penggunaan"
                                name="jam_mulai_penggunaan" required class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Jam Selesai Penggunaan : </span>
                            <input type="time" placeholder="Jam Penggunaan" id="jam_berakhir_penggunaan"
                                name="jam_berakhir_penggunaan" required class="name">
                        </div>
                    </div>
                    <div class="input_group">
                        <div class="input_box">
                            <span class=details> Keterangan: </span>
                            <input type="text" placeholder="Keterangan" id="keterangan" name="keterangan"
                                required class="name">
                        </div>
                    </div>

                    <div id="termsModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <p>Salam Kepada Para Pengguna,</p>
                            <br>
                            <p>Apabila penyewa ingin membatalkan pesanan maka uang yang telah di bayar tidak dapat
                                dikembalikan.</p>
                            <br>
                            <p>Penyewa tidak dapat mengubah tanggal pemesanan apabila pesanan telah di bayar.</p>
                            <div class="modal-footer">
                                <input type="checkbox" id="termsCheckbox">
                                <label for="termsCheckbox">Saya setuju dengan <span>Ketentuan Layanan</span> dan
                                    membaca pemberitahuan privasi.</label>
                                <br>
                                <button id="acceptTerms">Setuju</button>
                                <button id="declineTerms">Tidak Setuju</button>
                            </div>
                        </div>
                    </div>

                    <div class="input_group">
                        <div class="input_box">
                            <button type="button" id="submitButton">Sewa Sekarang</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        feather.replace();

        document.addEventListener('DOMContentLoaded', function() {
            var modal = document.getElementById("termsModal");
            var btn = document.getElementById("submitButton");
            var span = document.getElementsByClassName("close")[0];
            var acceptBtn = document.getElementById("acceptTerms");
            var declineBtn = document.getElementById("declineTerms");
            var termsCheckbox = document.getElementById("termsCheckbox");

            btn.addEventListener('click', function(event) {
                event.preventDefault();
                modal.style.display = "block";
            });

            span.onclick = function() {
                modal.style.display = "none";
            }

            acceptBtn.onclick = function() {
                if (termsCheckbox.checked) {
                    modal.style.display = "none";
                    document.getElementById('rentalForm').submit();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Anda harus menyetujui Syarat dan Ketentuan.',
                    });
                }
            }

            declineBtn.onclick = function() {
                modal.style.display = "none";
            }

            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        });

        fdocument.addEventListener('DOMContentLoaded', function() {
            var alertBox = document.getElementById('errorAlert');
            var errorsExist = {{ $errors->any() ? 'true' : 'false' }};

            if (errorsExist) {
                alertBox.style.display = 'block';
            }
        });

        function closeAlert() {
            var alertBox = document.getElementById('errorAlert');
            alertBox.style.display = 'none';
        }
    </script>
</body>

</html>
