@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Tiket') }}</div>
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
          <label for="name">Deskripsi</label>
          <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3">{{ $ticket->description }}</textarea>
          @error('description')
          <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
          @enderror
        </div>
        <br />
        <div class="form-group">
          <label for="description">Kategori</label>
          <select name="category_id"  id="category_id" class="form-control @error('category') is-invalid @enderror">
              @foreach($categories as $category)
                <option @if($category->id == $ticket->category_id) selected @endif value="{{ $category->id }}">{{ $category->name }} </option>
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
          <label for="description">Pelapor</label>
          <input type="text" class="form-control" disabled='true' name="reporter_name" id="reporter_name" value="{{ $ticket->reporter_name() }}" placeholder="Role name">
        </div>
        <br />
        <div class="form-group">
          <label for="description">Petugas</label>
          <select name="assigned_id"  id="assigned_id" class="form-control @error('assigned') is-invalid @enderror">
              @foreach($assigneds as $assigned)
                <option @if($assigned->id == $ticket->assigned_id) selected @endif value="{{ $assigned->id }}">{{ $assigned->name }} </option>
            @endforeach
          </select>
          @error('assigned')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <br />
        <div class="form-group">
          <label for="priority_id">Prioritas</label>
          <select name="priority_id" id="priority_id" {{Auth::user()->role_id!=1 ? 'disabled': ''}} class="form-control @error('priority') is-invalid @enderror">
              @foreach($prioritas as $priority)
                <option @if($priority->id == $ticket->priority_id) selected @endif value="{{ $priority->id }}">{{ $priority->name }} </option>
              @endforeach
          </select>
          @error('priority')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
        </div>
        <br />
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>


     <div class="form-group">
      <div class="bg-light p-5 rounded">
        <b>Sertakan Berkas Gambar</b>

        <form action="{{ '/' }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group mt-4">
              <input type="file" name="file" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip">
            </div>

            <button class="w-100 btn btn-lg btn-primary mt-4" type="submit">Kirim</button>
        </form>

      </div>
    </div>
    <br />

    </div>
    </div>
    </div>
    </div>
</div>
@endsection
