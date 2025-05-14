@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Ticket') }}</div>
    <div class="card-body">


    <form method="POST" action="{{ Route('ticket/store') }}">
        @csrf
        <div class="form-group">
          <label for="description">description</label>
          <input type="text" class="form-control @error('description') is-invalid @enderror" description="description" id="description" value="{{ old('description') }}" placeholder="ticket description">
          @error('description')
          <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
          @enderror
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
        </div>
        </div>
        </div>
        </div>
</div>
@endsection
