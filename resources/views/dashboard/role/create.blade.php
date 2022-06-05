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
          <label for="name">Role name</label>
          <input type="text" class="form-control" name="name" id="name" placeholder="Role name">
        </div>

        <div class="form-group">
            <label for="description">Role description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
</div>
@endsection
