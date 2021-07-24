@extends('layouts.app')

@section('content')


<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-4">
                        {{ __('Profile') }}  
                    </div>
                    <div class="col-4">
                        <span class="mr-2">{{ __('You are logged in!') }}</span>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ml-2">Log out</a>
                    </div>
                  </div>
                </div>
          

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                @if (Route::has('login'))
                <p>{{ Auth::user()->name }}</p>

               <p>Email: {{ Auth::user()->email }}</p>
               <p>Created At: {{ Auth::user()->created_at }}</p>
               <p>Updated At: {{ Auth::user()->updated_at }}</p>
                @auth
                     
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="">Log in</a>
    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="">Register</a>
                    @endif
                @endauth
        @endif
            </div>
        </div>
    </div>
</div>
@endsection 