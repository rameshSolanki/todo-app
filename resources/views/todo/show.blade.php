@extends('layouts.app')


@section('content')
<div class="card">
   <div class="card-header">
      <h4 id="name" class="mt-2">{{ $todo->title }}</h4>
   </div>
   <div class="card-body">
          <img alt="mountain" class="img-thumbnail" src="{{ asset('todoImages/'.$todo->images)}}" />
          <div class="">
            
             <p id="job" class="mt-2">{{ $todo->content }}</p>
                <p class=""> {{ $todo->created_at }}</p>
          
          </div>
         </div>
         <div class="card-footer">
          <a class="btn btn-primary" href="{{ route('todo.index') }}" title="Go back"> <i
            class="fas fa-arrow-circle-left"></i> Go back</a>
         </div>
       </div>
@endsection