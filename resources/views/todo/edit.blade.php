@extends('layouts.app')

@section('content')

<div class="container mt-4">
    <div class="col-md-9">
      <div class="card mb-5">
        <div class="card-header">
          <h3 class="btn btn-primary mt-2"><i class="fa fa-plus"></i> Edit todo</h3>
          <a href="{{ route('todo.index') }}" class="btn btn-success ml-2">
            <i
            class="fas fa-arrow-circle-left fa-sm"></i> Home
          </a>
        </div>
        <div class="card-body">
          @if ($errors->any())
          <!-- Danger -->
  
          <div class=''>
              @foreach ($errors->all() as $error)
              <p class="text-danger">{{ $error }}</p>
              @endforeach
      </div>

  @endif


    <form class="form-horizontal" action="{{ route('todo.update', $todo->id) }}" method="POST" class="p-0" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <input value="{{ $todo->title }}" id="title" type="text" name="title" class="form-control"
            />

            <textarea id="content" type="textarea" name="content" rows="3" placeholder="Enter some long form content." class="mt-4 form-textarea form-control"
            >{{ $todo->content }}</textarea>

            @if($todo->images)
            <img alt="mountain" class="img-thumbnail" src="{{ asset('todoImages/'.$todo->images)}}" />
            @endif

            <input type="file" name="images" class="form-input mt-4">
            @error('image')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
         @enderror
            <div class="mt-5">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

    </form> </div>
@endsection