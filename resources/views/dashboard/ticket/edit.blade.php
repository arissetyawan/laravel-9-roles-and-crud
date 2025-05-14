@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Ticket') }}</div>
    <div class="card-body">

    @if ($errors->any()) 
                @foreach ($errors->all() as $error) 
                    <x-alert type="danger" :message="$error" class="mt-4"/>
                @endforeach
        
    @endif

    <form method="POST" action="{{ Route('ticket/update') }}">
        @csrf

        <input type="hidden" name="id" value="{{ $ticket->id }}">
        <div class="form-group">
          <label for="name">Description</label>
          <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
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
