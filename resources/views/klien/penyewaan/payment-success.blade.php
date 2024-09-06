@extends('klien.layout1')

@section('content')
    @include('klien.penyewaan.main-layout')
    <div class="main-container">
        @foreach ($groupedBookingDetails as $bookingId => $bookingDetails)
            @php $total = 0 @endphp

            <div class="main">
                <h2>Penyewaan</h2>

                @if ($bookingDetails->first()->paket_id)
                    @php $firstItem = $bookingDetails->first() @endphp

                    @php $total += $firstItem->harga @endphp

                    <div class="product-card">
                        <div class="produk-card">
                            @if (!empty($firstItem->paket->gambar))
                            <img src="/img/admin/gambarpaket/{{ $firstItem->paket->gambar }}" class="produk-image">
                            @else
                            <img src="/img/admin/images.png" class="produk-image">
                            @endif
                            <p class="produk-title">{{ $firstItem->paket->nama }}</p>
                            <p>{{ formatRupiah($firstItem->booking->total) }}</p>
                            <p>x{{ $firstItem->quantity }}</p>
                        </div>
                    </div>
                @else
                    @foreach ($bookingDetails as $index => $item)
                        @php $total += $item->harga * $item->quantity @endphp

                        <div class="product-card">
                            <div class="produk-card">
                                <img src="/img/admin/gambarDekor/{{ $item->dekor->gambar }}" class="produk-image">
                                <p class="produk-title">{{ $item->dekor->nama }}</p>
                                <p>{{ formatRupiah($item->harga) }}</p>
                                <p>x{{ $item->quantity }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if ($bookingDetails->first()->paket_id)
                @php $firstItem = $bookingDetails->first() @endphp
                    @if ($firstItem->booking->dp != 0 && $firstItem->booking->kekurangan != 0)
                        <div class="total">
                            <p>Dp: {{ formatRupiah($firstItem->booking->dp) }}</p>
                            <p>Kurang: {{ formatRupiah($firstItem->booking->kekurangan) }}</p>
                        </div>
                    @else
                        <div class="total">
                            <p>Total: {{ formatRupiah($firstItem->booking->total) }}</p>
                        </div>
                    @endif
                @else
                @if ($item->booking->dp != 0 && $item->booking->kekurangan != 0)
                        <div class="total">
                            <p>Dp: {{ formatRupiah($item->booking->dp) }}</p>
                            <p>Kurang: {{ formatRupiah($item->booking->kekurangan) }}</p>
                        </div>
                    @else
                        <div class="total">
                            <p>Total: {{ formatRupiah($item->booking->total) }}</p>
                        </div>
                    @endif
                @endif

                @if ($bookingDetails->first()->booking->payment_status == 'Unpaid' && $bookingDetails->first()->booking->dp != 0)
                    <div class="input_group">
                        <div class="input_box">
                            <form action="{{ route('process.payment') }}" method="POST">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $bookingId }}">
                                <button type="submit">Bayar Kekurangan</button>
                            </form>
                        </div>
                    </div>
                @endif

                @if ($bookingDetails->first()->booking->status == 'Cancel')
                @else
                    <div class="input_group">
                        <div class="input_box">
                            <div class="actions" data-id="{{ $bookingId }}">
                                <button class="process-cancel" style="text-decoration:none ; background-color:red;">
                                    <i class="fa fa-ban"></i> Batalkan Pesanan
                                </button>
                            </div>
                        </div>
                    </div>
                @endif


                <hr>
                <form action="{{ route('detail.sewa') }}" method="POST" style="margin: 0px;">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $bookingId }}">
                    <button type="submit" style="border:none; margin-top: 0px; height: 40px; width:100%;">Detail
                        Penyewa</button>
                </form>

                <div class="input_group">
                    <div class="input_box">
                        <form action="{{ route('cetakBayar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{ $bookingId }}">
                            <button type="submit" class="btn-primary">Cetak Kwitansi</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">
        $(".process-cancel").click(function(e) {
            e.preventDefault();

            var ele = $(this);

            if (confirm("Batalkan pesanan? Uang anda tidak dapat dikembalikan")) {
                $.ajax({
                    url: "{{ route('process.cancel') }}",
                    method: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.parents(".actions").attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>

    <!-- Modal -->
    <div id="paymentModal" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Bayar Sekarang</h2>
            <p>Silakan lanjutkan untuk menyelesaikan pembayaran Anda.</p>
            <button id="payNowButton" type="button">Bayar Sekarang</button>
        </div>
    </div>
@endsection
