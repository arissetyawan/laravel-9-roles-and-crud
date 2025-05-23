@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Tiket') }}</div>
    <div class="card-body">


    <form method="POST" action="{{ Route('ticket/store') }}">
        @csrf

        <input type="hidden" name="reporter_id" value="{{ Auth::user()->id }}">

        <div class="form-group">
          <label for="description">Descripsi</label>
          <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ old('description') }}</textarea>
          @error('description')
          <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
          @enderror
        </div>
        <br />
        <div class="form-group">
          <label for="description">Kategori</label>
          <select name="category_id"  id="category_id" class="form-control @error('category') is-invalid @enderror">
              @foreach($categories as $category)
              <option value="{{ $category->id }}">{{ $category->name }} </option>
              @endforeach
          </select>
          @error('category')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <br />
        <div class="form-group">
          <label for="description">Prioritas</label>
          <select name="priority_id"  id="priority_id" class="form-control @error('priority') is-invalid @enderror">
              @foreach($prioritas as $priority)
              <option value="{{ $priority->id }}">{{ $priority->name }} </option>
              @endforeach
          </select>
          @error('priority')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <br />
        <button type="submit" class="btn btn-primary">Laporkan</button>
      </form>
        </div>
        </div>
        </div>
        </div>
</div>
@endsection
