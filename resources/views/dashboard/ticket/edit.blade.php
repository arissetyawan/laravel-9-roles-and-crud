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
          <label for="name">Name</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $ticket->name }}" placeholder="name">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
      </form>

    </div>
    </div>
    </div>
    </div>
</div>
@endsection
