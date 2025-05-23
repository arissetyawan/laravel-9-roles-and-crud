@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Priority') }}</div>
    <div class="card-body">


    <form method="POST" action="{{ Route('priority/store') }}">
        @csrf
        <div class="form-group">
          <label for="name">name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ old('name') }}" placeholder="priority name">
          @error('name')
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
