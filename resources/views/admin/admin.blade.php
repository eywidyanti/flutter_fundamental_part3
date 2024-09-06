@extends('admin.layout')

@section('content')
    <!-- hero section start -->
    <section class="hero" id="home">
        @if (session('success'))
            <div class="notifikasi success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="notifikasi error">
                {{ session('error') }}
            </div>
        @endif
        <main class="content">
            <h1> Mari Belanja Kebutuhan <span>Wedding</span></h1>
        </main>
    </section>
@endsection
