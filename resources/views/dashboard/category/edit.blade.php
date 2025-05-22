@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Kategori') }}</div>
    <div class="card-body">

    @if ($errors->any()) 
        @foreach ($errors->all() as $error)
            <x-alert type="danger" :message="$error" class="mt-4"/>
        @endforeach
    @endif

    <form method="POST" action="{{ Route('category/update') }}">
        @csrf

        <input type="hidden" name="id" value="{{ $category->id }}">

        <div class="form-group">
          <label for="name">Nama</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $category->name }}" placeholder="name">
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" name="description" id="description" rows="3">{{ $category->description }}</textarea>
        </div>

        <br />
        <button type="submit" class="btn btn-primary">Submit</button>

      </form>

    </div>
    </div>
    </div>
    </div>
</div>
@endsection
