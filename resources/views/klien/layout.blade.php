<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wedding Org</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap"
        rel="stylesheet">

    <!-- icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- style -->
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/klien.css">

    <!-- Midtrains -->
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-VxH0DhCPRNssZyY0"></script>
</head>


<body>
    <!-- Navbar started -->
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
                <a href="{{ route('profilKlien') }}" class="dropdown-item">Profil</a>
                <a href="" class="dropdown-item"
                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>


        <div class="shopping-cart">

            @php
                $cartNullPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNull('paket_id')->get();
                $cartPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNotNull('paket_id')->get();
            @endphp

            @if ($cartNullPaketId->isNotEmpty())
                <div class="table-container">
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
                                                class="form-control quantity update-cart" disabled />
                                        </td>
                                        <td data-th="Subtotal" class="text-center">
                                            {{ formatRupiah($item->dekor->harga * $item->quantity) }}</td>
                                        <td class="actions" data-th="">
                                            <button class="remove-from-cart"><i
                                                    data-feather="trash-2"></i>hapus</button>
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
                </div>
                <div class="checkout-button-container">
                    <a href="{{ route('checkout') }}">
                        <button class="btn"><i class="fa fa-upload"></i> Sewa</button>
                    </a>
                </div>
            @else
                <div class="table-container">
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
                </div>
                <div class="checkout-button-container">
                    <a href="{{ route('checkout') }}">
                        <button class="btn"><i class="fa fa-upload"></i> Sewa</button>
                    </a>
                </div>
            @endif


        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <script>
        feather.replace();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- JS -->
    <script src="js/klien.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const descriptions = document.querySelectorAll('.produk .produk-content p:last-of-type');

            descriptions.forEach(description => {
                description.addEventListener('click', function() {
                    this.classList.toggle('expanded');
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const galleries = document.querySelectorAll('.gallery');

            galleries.forEach(gallery => {
                const wrapper = gallery.querySelector('.gallery-wrapper');
                const slides = gallery.querySelectorAll('.gallery-slide');
                const prevButton = gallery.querySelector('.gallery-prev');
                const nextButton = gallery.querySelector('.gallery-next');

                let currentIndex = 0;

                function updateGallery() {
                    wrapper.style.transform = `translateX(-${currentIndex * 100}%)`;
                }

                prevButton.addEventListener('click', () => {
                    currentIndex = (currentIndex > 0) ? currentIndex - 1 : slides.length - 1;
                    updateGallery();
                });

                nextButton.addEventListener('click', () => {
                    currentIndex = (currentIndex < slides.length - 1) ? currentIndex + 1 : 0;
                    updateGallery();
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(".update-cart").change(function(e) {
            e.preventDefault();

            var ele = $(this);

            $.ajax({
                url: "{{ route('update.cart') }}",
                method: "patch",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele.parents("tr").attr("data-id"),
                    quantity: ele.parents("tr").find(".quantity").val()
                },
                success: function(response) {
                    window.location.reload();
                }
            });
        });

        $(".remove-from-cart").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Are you sure want to remove?")) {
                $.ajax({
                    url: "{{ route('remove.from.cart') }}",
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents("tr").attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>

</body>

</html>
