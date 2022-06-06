@extends('layouts.app')

@section('content')

<div class="container">
 
    @if ($errors->any()) 
                @foreach ($errors->all() as $error) 
                    <x-alert type="danger" :message="$error" class="mt-4"/>
                @endforeach
        
    @endif

    <form method="POST" action="{{ Route('role/update') }}">
        @csrf

        <input type="hidden" name="id" value="{{ $role->id }}">


        <div class="form-group">
          <label for="name">Role name</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" name="name" id="name" value="{{ $role->name }}" placeholder="Role name">
        </div>

        <div class="form-group">
            <label for="description">Role description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ $role->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@endsection
