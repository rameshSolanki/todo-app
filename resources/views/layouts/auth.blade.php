@extends('layouts.base')

@section('body')
    <div class="container mt-5 mb-5">
        @yield('content')

        @isset($slot)
            {{ $slot }}
        @endisset
    </div>
@endsection
