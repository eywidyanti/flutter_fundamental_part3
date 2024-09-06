@extends('admin.layout')
 
@section('content')

        <!-- user start -->
    <section class="paketdekorasi">
        @if ($message = Session::get('success'))
        <div class="notifikasi success">
            <p>{{ $message }}</p>
        </div>
        @endif

        <h2>Tambah<span> user</span></h2>
        <a href="{{ route('user.create') }}"> <button class="btn"><i class="fa fa-plus"></i> Tambah user</button></a>
    </section>

    <div id="data-container" class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>No Telp</th>
                    <th>Gambar</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->noHp }}</td>
                    <td>
                        @if($user->gambar=='none')
                            <img src="{{ asset('img/admin/images.png') }}" width="100px">
                        @else
                            <img src="{{ asset('img/admin/fotoUser/' . $user->gambar) }}" width="100px">
                        @endif
                    </td>
                    <td>{{ $user->jenis_kelamin }}</td>
                    <td>
                        <form action="{{ route('user.destroy',$user->id) }}" method="POST">
                            <a href="{{ route('user.edit',$user->id) }}" type="button" class="aksi-btn"><i class="fa fa-pencil"></i></a>
                            <a href="{{ route('user.show',$user->id) }}" type="button" class="aksi-btn2"><i class="fa fa-eye"></i></a>
                        @csrf
                        @method('DELETE')
        
                        <button type="submit" class="aksi-btn1" onclick="confirmDelete(event)"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if ($users->hasPages())
            <div class="pagination">
                {{-- Previous Page Link --}}
                <div class="pagination-item">
                    @if ($users->onFirstPage())
                        <span class="pagination-disabled"><i class="fa fa-chevron-left"></i> Prev</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" rel="prev" class="pagination-link"><i
                                class="fa fa-chevron-left"></i> Prev</a>
                    @endif
                </div>

                {{-- Show page numbers --}}
                <div class="pagination-numbers">
                    @for ($i = max(1, $users->currentPage() - 2); $i <= min($users->lastPage(), $users->currentPage() + 2); $i++)
                        <a href="{{ $users->url($i) }}"
                            class="pagination-number @if ($i == $users->currentPage()) active @endif">{{ $i }}</a>
                    @endfor
                </div>

                {{-- Next Page Link --}}
                <div class="pagination-item">
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" rel="next" class="pagination-link">Next <i
                                class="fa fa-chevron-right"></i></a>
                    @else
                        <span class="pagination-disabled">Next <i class="fa fa-chevron-right"></i></span>
                    @endif
                </div>
            </div>
        @endif
        </div>
    <!-- user end -->
    @endsection
