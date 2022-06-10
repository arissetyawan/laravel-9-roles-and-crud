@extends('layouts.app')

@section('content')

<div class="container">
 
    @if ($errors->any()) 
                @foreach ($errors->all() as $error) 
                    <x-alert type="danger" :message="$error" class="mt-4"/>
                @endforeach
        
    @endif

    <form method="POST" action="{{ Route('category/update') }}">
        @csrf

        <input type="hidden" name="id" value="{{ $category->id }}">


        <div class="form-group">
          <label for="name">Category name</label>
          <input type="text" class="form-control @error('email') is-invalid @enderror" name="name" id="name" value="{{ $category->name }}" placeholder="Category name">
        </div>

        <div class="form-group">
            <label for="description">Category description</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ $category->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@endsection
