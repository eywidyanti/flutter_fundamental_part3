@extends('admin.layout')

@section('content')
    <!-- Menu start-->
    <section id="paketdekorasi" class="paketdekorasi">
        @if ($message = Session::get('success'))
            <div class="notifikasi success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <h2>Tambah<span> Paket</span></h2>
        <a href="{{ route('paketDragndrop') }}"> <button class="btn"><i class="fa fa-plus"></i> Tambah Paket
                Dekor</button></a>
    </section>

    <div id="data-container" class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Nama</th>
                    <th>Gambar</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th width="280px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pakets as $paket)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $paket->user->name }}</td>
                        <td>{{ $paket->nama }}</td>
                        @if(!empty($paket->gambar))
                        <td><img src="img/admin/gambarpaket/{{ $paket->gambar }}" width="100px"></td>
                        @else
                        <td><img src="img/admin/images.png" width="100px"></td>
                        @endif
                        
                        <td>{{ formatRupiah($paket->harga) }}</td>
                        <td>{{ $paket->deskripsi }}</td>
                        <td>
                            <form action="{{ route('paket.destroy', $paket->id) }}" method="POST">
                                <a href="{{ route('paket.edit', $paket->slug) }}" type="button" class="aksi-btn"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{ route('paket.show', $paket->slug) }}" type="button" class="aksi-btn2"><i
                                        class="fa fa-eye"></i></a>
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="aksi-btn1" onclick="confirmDelete(event)"><i
                                        class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        @if ($pakets->hasPages())
            <div class="pagination">
                {{-- Previous Page Link --}}
                <div class="pagination-item">
                    @if ($pakets->onFirstPage())
                        <span class="pagination-disabled"><i class="fa fa-chevron-left"></i> Prev</span>
                    @else
                        <a href="{{ $pakets->previousPageUrl() }}" rel="prev" class="pagination-link"><i
                                class="fa fa-chevron-left"></i> Prev</a>
                    @endif
                </div>

                {{-- Show page numbers --}}
                <div class="pagination-numbers">
                    @for ($i = max(1, $pakets->currentPage() - 2); $i <= min($pakets->lastPage(), $pakets->currentPage() + 2); $i++)
                        <a href="{{ $pakets->url($i) }}"
                            class="pagination-number @if ($i == $pakets->currentPage()) active @endif">{{ $i }}</a>
                    @endfor
                </div>

                {{-- Next Page Link --}}
                <div class="pagination-item">
                    @if ($pakets->hasMorePages())
                        <a href="{{ $pakets->nextPageUrl() }}" rel="next" class="pagination-link">Next <i
                                class="fa fa-chevron-right"></i></a>
                    @else
                        <span class="pagination-disabled">Next <i class="fa fa-chevron-right"></i></span>
                    @endif
                </div>
            </div>
        @endif
    </div>

@endsection
