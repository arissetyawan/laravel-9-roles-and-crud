@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Status') }}</div>
    <div class="card-body">

    <form method="POST" action="{{ Route('status/store') }}">
        @csrf
        <div class="form-group">
          <label for="name">Nama</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="status name">
          @error('name')
          <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
          @enderror
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
            @error('description')
            <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
            @enderror
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
