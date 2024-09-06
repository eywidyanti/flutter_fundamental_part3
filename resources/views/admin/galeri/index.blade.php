@extends('admin.layout')

@section('content')
    <!-- galeri start -->
    <section class="paketdekorasi">
        @if ($message = Session::get('success'))
            <div class="notifikasi success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <h2>Tambah<span> Galeri</span></h2>
        <a href="{{ route('galeri.create') }}"> <button class="btn"><i class="fa fa-plus"></i> Tambah Galeri</button></a>
    </section>

    <div id="data-container" class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Gambar</th>
                    <th>Gambar</th>
                    <th>Gambar</th>
                    <th>Video</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($galeris as $galeri)
                    <tr>
                        <td>{{ ++$i }}</td>
                        <td>{{ $galeri->user->name }}</td>
                        <td><img src="img/admin/gambarGaleri/{{ $galeri->gambar }}" width="100px"></td>

                        <td>
                            @if (empty($galeri->gambar1))
                                <img src="{{ asset('img/admin/images.png') }}" width="100px">
                            @else
                                <img src="{{ asset('img/admin/gambarGaleri/' . $galeri->gambar1) }}" width="100px">
                            @endif
                        </td>
                        <td>
                            @if (empty($galeri->gambar2))
                                <img src="{{ asset('img/admin/images.png') }}" width="100px">
                            @else
                                <img src="{{ asset('img/admin/gambarGaleri/' . $galeri->gambar2) }}" width="100px">
                            @endif
                        </td>

                        <td>
                            @if (empty($galeri->gambar1))
                                <img src="{{ asset('img/admin/images.png') }}" width="100px">
                            @else
                                <video width="320" height="240" controls>
                                    <source src="img/admin/videoGaleri/{{ $galeri->video }}" type="video/mp4">
                                </video>
                            @endif
                        </td>
                        <td>{{ $galeri->deskripsi }}</td>
                        <td>
                            <form action="{{ route('galeri.destroy', $galeri->id) }}" method="POST">
                                <a href="{{ route('galeri.edit', $galeri->slug) }}" type="button" class="aksi-btn"><i
                                        class="fa fa-pencil"></i></a>
                                <a href="{{ route('galeri.show', $galeri->slug) }}" type="button" class="aksi-btn2"><i
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
        @if ($galeris->hasPages())
            <div class="pagination">
                {{-- Previous Page Link --}}
                <div class="pagination-item">
                    @if ($galeris->onFirstPage())
                        <span class="pagination-disabled"><i class="fa fa-chevron-left"></i> Prev</span>
                    @else
                        <a href="{{ $galeris->previousPageUrl() }}" rel="prev" class="pagination-link"><i
                                class="fa fa-chevron-left"></i> Prev</a>
                    @endif
                </div>

                {{-- Show page numbers --}}
                <div class="pagination-numbers">
                    @for ($i = max(1, $galeris->currentPage() - 2); $i <= min($galeris->lastPage(), $galeris->currentPage() + 2); $i++)
                        <a href="{{ $galeris->url($i) }}"
                            class="pagination-number @if ($i == $galeris->currentPage()) active @endif">{{ $i }}</a>
                    @endfor
                </div>

                {{-- Next Page Link --}}
                <div class="pagination-item">
                    @if ($galeris->hasMorePages())
                        <a href="{{ $galeris->nextPageUrl() }}" rel="next" class="pagination-link">Next <i
                                class="fa fa-chevron-right"></i></a>
                    @else
                        <span class="pagination-disabled">Next <i class="fa fa-chevron-right"></i></span>
                    @endif
                </div>
            </div>
        @endif
    </div>
    <!-- galeri end -->
@endsection
