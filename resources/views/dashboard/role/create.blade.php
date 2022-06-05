@extends('layouts.app')

@section('content')

<div class="container">
 
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div> 
    @endif

    <form method="POST" action="{{ Route('role/store') }}">
        @csrf
        <div class="form-group">
          <label>Role name</label>
          <input type="text" class="form-control" name="name" placeholder="Role name">
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        
        </div>
        <div class="form-group">
          <label>Role description</label>
          <input type="text" class="form-control" name="description"  placeholder="Role description">
          @error('description')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div> 
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@endsection
