@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}  Todo Added -
                    {{ $todos->count() }}
                    <a class="bg-white ml-4  p-2 rounded" href="{{ route('todo.create') }}" title="Create a todo"> <i class="fas fa-plus-circle"></i> Add</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
 
                    <span class="mr-2">{{ __('You are logged in!') }}</span>

                    @if (Route::has('login'))
                    {{ Auth::user()->name }}  
                    @auth
                         <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ml-2">Log out</a>
        
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

     <!-- Success -->
    @if ($message = Session::get('success'))
    <div class="alert alert-success mt-2" role="alert">
        {{ $message }}
      </div>
      @endif
    <!-- Success -->

    <div class="card p-4 mt-2">
                <form action="{{ url('search') }}" method="GET" class="form-inline mb-4 mt-4">
                    <div class="flex items-center">
                      <input class="form-control" type="search" name="search" placeholder="Search" aria-label="Search" value="{{ Request::get('search') }}">
                      <button class="btn btn-primary ml-2" type="submit">
                        Search
                      </button>
                      <a href="{{ route('todo.index') }}" class="btn ml-2" type="submit">
                        Cancel
                      </a>
                    </div>
                  </form>
                  <p>Search result for for "{{ Request::get('search') }}"</p>
                      <div id='recipients' class="table-responsive">
                        <table id="example" class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Image</th>
                <th>Date Created</th>
                <th>Action</th>
            </tr>
    </thead>
    <tbody>
        @if ($todos->isEmpty())
        <tr >
        <td colspan="5" class="text-center">
        No data available.
        </td>
        </tr>
        @else
        @foreach ($todos as $todo)
            <tr>
                <td>{{ $todo->id }}</td>
                <td>{{ $todo->title }}</td>
                @if (pathinfo($todo->images, PATHINFO_EXTENSION) == 'pdf')
                <td >
                    <a target="_blank" href="{{ asset('todoImages/'.$todo->images)}}">{{ $todo->images }}</a>
                </td>
                @else
                <td><img alt="mountain" class="img-thumbnail" width="50px" src="{{ asset('todoImages/'.$todo->images)}}" />
                @endif
                <td>{{ $todo->created_at }}</td>

                <td>
                    <form class="form-inline" action="{{ route('todo.destroy', $todo->id) }}" method="POST">
                        <a class="text-info" href="{{ route('todo.show', $todo->id) }}" title="show"> 
                            <i class="fas fa-eye"></i></a>
                                  <a  class="ml-2 text-info" href="{{ route('todo.edit', $todo->id) }}"> <i class="fas fa-pencil-alt"></i></a>
        
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="delete" class="ml-2 px-1 btn text-info">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                            </form>
                </td>
            </tr>
        @endforeach
        @endif
        </tbody>
    </table>
    </div>
    {{-- {!! $todos->links() !!} --}}
</div>

@endsection