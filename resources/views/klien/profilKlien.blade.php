<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Profil User</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,700;1,700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css"
    rel="stylesheet" />
    <script>$.fn.poshytip = { defaults: null }</script>
    <script
    src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="/css/profil.css">
    <link rel="stylesheet" href="/css/klien.css">
    <!-- icons -->
    <script src="https://unpkg.com/feather-icons"></script>
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

            @if($paketkosong)
                {{ \App\Models\Cart::where('user_id', Auth::id())->count() }}
            @else
                {{ \App\Models\Cart::where('user_id', Auth::id())->distinct('paket_id')->count('paket_id') }}
            @endif

            </span></a>
            <a  id="furniture-menu"><i data-feather="menu"></i></a>
        </div>

        <div class="profile-container">
            <img src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : 'default.jpg' }}" class="user-pic" id="profilePic" onclick="toggleDropdown()">
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




        <!-- Shopping Cart -->
        <div class="shopping-cart">
        
        @php
            $cartNullPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNull('paket_id')->get();
            $cartPaketId = \App\Models\Cart::where('user_id', Auth::id())->whereNotNull('paket_id')->get();
        @endphp

@if($cartNullPaketId->isNotEmpty())
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:10%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:8%">Quantity</th>
                <th style="width:10%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @if($cartNullPaketId->count())
                @foreach($cartNullPaketId as $item)
                    @php $total += $item->dekor->harga * $item->quantity @endphp
                    <tr data-id="{{ $item->dekor_id }}">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs">
                                    <img src="/img/admin/gambarDekor/{{ $item->dekor->gambar }}" width="100" height="100" class="img-responsive"/>
                                </div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $item->dekor->nama }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">{{ formatRupiah($item->dekor->harga) }}</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{ $item['quantity'] }}" class="form-control quantity update-cart" />
                        </td>
                        <td data-th="Subtotal" class="text-center">{{ formatRupiah($item->dekor->harga * $item->quantity) }}</td>
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
        <button class="btn"><i class="fa fa-upload"></i> Booking</button>
    </a>
@else
    <table id="cart" class="table table-hover table-condensed">
        <thead>
            <tr>
                <th style="width:10%">Product</th>
                <th style="width:10%">Price</th>
                <th style="width:8%">Quantity</th>
                <th style="width:10%" class="text-center">Subtotal</th>
                <th style="width:10%"></th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0 @endphp
            @if($cartPaketId->count())
                @php
                    $groupedItems = $cartPaketId->groupBy('paket_id');
                @endphp

                @foreach($groupedItems as $paket_id => $items)
                    @php
                    
                        $subtotal = $items->sum(function($item) {
                            return $item->dekor->harga * $item->dekor->stok;
                        });

                            $persen = $subtotal * 0.1; 

                        $jumlah = $subtotal - $persen;
                        $total += $jumlah;
                    @endphp

                    <tr data-id="{{ $items->first()->paket_id }}">
                        <td data-th="Product">
                            <div class="row">
                                <div class="col-sm-3 hidden-xs">
                                    <img src="/img/admin/gambarpaket/{{ $items->first()->paket->gambar }}" width="100" height="100" class="img-responsive"/>
                                </div>
                                <div class="col-sm-9">
                                    <h4 class="nomargin">{{ $items->first()->paket->nama }}</h4>
                                </div>
                            </div>
                        </td>
                        <td data-th="Price">{{ formatRupiah($total) }}</td>
                        <td data-th="Quantity">
                            <input type="number" value="{{ $items->first()['quantity'] }}" class="form-control quantity update-cart" disabled />
                        </td>
                        <td data-th="Subtotal" class="text-center">{{ formatRupiah($total * $items->first()->quantity) }}</td>
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
        <button class="btn"><i class="fa fa-upload"></i> Booking</button>
    </a>
@endif

        </div>
        <!-- Shopping Cart -->
    </nav>

  <div class="container">
            @csrf
    <div class="profile-card">
        <div class="profile-img-container">
            <img id="profile-img" src="{{ Auth::user()->gambar ? asset('img/admin/fotoUser/' . Auth::user()->gambar) : 'default.jpg' }}" alt="Profile Picture" class="profile-img">
            <div class="camera-icon-container" id="update-photo-icon">
                <i class="fa fa-camera camera-icon"></i>
            </div>
        </div>
    </div>
    <form id="profile-update-form" action="{{ route('profile.img.update') }}" method="POST" enctype="multipart/form-data" style="display: none;">
        @csrf
        <input type="file" id="profile-image-input" name="profile_image">
    </form>
    <div class="details-card">
      <table>
        <tr>
          <td>Nama</td>
          <td class="editable" data-name="name" data-type="text" data-pk="{{ Auth::user()->id }}"
          data-title="Enter Name">{{ Auth::user()->name }}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td class="editable" data-name="email" data-type="text" data-pk="{{ Auth::user()->id }}"
          data-title="Enter Email">{{ Auth::user()->email }}</td>
        </tr>
        <tr>
          <td>No. Telp</td>
          <td class="editable" data-name="noHp" data-type="text" data-pk="{{ Auth::user()->id }}"
          data-title="Enter Phone">{{ Auth::user()->noHp }}</td>
        </tr>
        <tr>
          <td>Jenis Kelamin</td>
          <td class="editable" data-name="jenis_kelamin"
                    data-type="select" data-pk="{{ Auth::user()->id }}" data-title="Select Gender"
                    data-source='[{"value": "Laki-laki", "text": "Laki-laki"},{"value": "Perempuan", "text": "Perempuan"}]'>{{ Auth::user()->jenis_kelamin }}</td>
        </tr>
      </table>
    </div>
  </div>
  <div class="buttons">
    <a href="{{ route('home') }}"><button class="btnb back">Kembali</button></a>
  </div>

  
  <script>
      feather.replace();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <!-- JS -->
    <script src="js/klien.js"></script>
    <script>
    document.getElementById('update-photo-icon').onclick = function() {
    document.getElementById('profile-image-input').click();
    };

    document.getElementById('profile-image-input').onchange = function() {
        var formData = new FormData(document.getElementById('profile-update-form'));
        
        $.ajax({
            url: document.getElementById('profile-update-form').action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    document.getElementById('profile-img').src = response.image;
                    document.getElementById('profilePic').src = response.image;
                } else {
                    alert('There was an error updating your profile picture.');
                }
            },
            error: function() {
                alert('There was an error updating your profile picture.');
            }
        });
    };
        $.fn.editable.defaults.mode = "inline";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        $('.editable[data-name="name"]').editable({
            url: "{{ route('profile.update') }}",
            type: 'text',
            pk: 1,
            name: 'name',
            title: 'Enter name'
        });
        $('.editable[data-name="email"]').editable({
            url: "{{ route('profile.update') }}",
            type: 'text',
            pk: 1,
            name: 'email',
            title: 'Enter Email'
        });
        $('.editable[data-name="noHp"]').editable({
            url: "{{ route('profile.update') }}",
            type: 'text',
            pk: 1,
            name: 'noHp',
            title: 'Enter Phone'
        });
        $('.editable[data-name="jenis_kelamin"]').editable({
        url: "{{ route('profile.update') }}",
        type: 'select',
        pk: 1,
        name: 'jenis_kelamin',
        title: 'Select Gender',
        source: [
            { value: 'Laki-laki', text: 'Laki-laki' },
            { value: 'Perempuan', text: 'Perempuan' }
        ]
    });
    </script>
</body>
</html>
