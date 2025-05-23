@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header">{{ __('Tiket') }} Status: <b>{{ $ticket->get_status_name() }}</b></div>
    <div class="card-body">

    @if ($errors->any()) 
        @foreach ($errors->all() as $error)
            <x-alert type="danger" :message="$error" class="mt-4"/>
        @endforeach
    @endif

    <form method="POST" action="{{ Route('ticket/update') }}">
        @csrf

        <input type="hidden" name='rating' id='rating' value="{{ $ticket->rating }}">
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
        <button type="submit" class="btn btn-warning">Selesai</button>
        <hr />
        <div class="form-group">
          <label for="priority_id">Umpang balik selesai</label><br />
          @for ($i = 1; $i < 6; $i++)
              @if($i<=$ticket->rating)
              <i class="btn btn-outline-secondary fa fa-star feedback-star" style="font-size:  40px; color: gold" onclick="document.getElementById('rating').value={{$i}};"></i>
              @else
              <i class="btn btn-outline-secondary fa fa-star feedback-star" style="font-size:  40px; color: grey" onclick="document.getElementById('rating').value={{$i}};'"></i>
              @endif
            @endfor
            <br />
            <label for="description">Komentar Penyelesaian</label>
            <textarea class="form-control @error('rating_comment') is-invalid @enderror" name="rating_comment" id="rating_comment" rows="3">{{ old('description') }}</textarea>
            @error('rating_comment')
            <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
            @enderror
          <br />
          <button type="submit" class="btn btn-success">Terima kasih!</button>
        </div>
        <br />
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

     <div class="form-group">
        <b>Riwayat</b>
        <ul>
          <li>
            Dibuat: {{ $ticket->reported_at }}
          </li>
          <li>
            Ditugaskan: {{ $ticket->assigned_at }}
          </li>
          <li>
            Status terakhir: {{ $ticket->last_status_at }}, Status tiket: <b>{{ $ticket->get_status_name()}}</b>
          </li>
          <li>
            Kualitas Penyelesaian:
            @for ($i = 1; $i < 6; $i++)
              @if($i<=$ticket->rating)
              <i class="fa fa-star" style="color: gold"></i>
              @else
              <i class="fa fa-star" style="color: grey"></i>
              @endif
            @endfor
            <br />
            Komentar Penyelesaian: {{ $ticket->rating_comment }}<br />
          </li>
        </ul>
    </div>
    <br />
    </div>
    </div>
    </div>
    </div>
</div>
@endsection
