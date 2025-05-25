@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card">
    <div class="card-header" ><b>{{ __('Tiket') }}: {{$ticket->get_code()}}&nbsp;<sup style="padding: 2px;background-color: yellow">{{ $ticket->get_status_name() }}</b></sup></b></div>
    <div class="card-body">

    @if ($errors->any()) 
        @foreach ($errors->all() as $error)
            <x-alert type="danger" :message="$error" class="mt-4"/>
        @endforeach
    @endif

    <form method="POST" action="{{ Route('ticket/update') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name='rating' id='rating' value="{{ $ticket->rating }}">
        <input type="hidden" name="id" value="{{ $ticket->id }}">
        <div class="form-group">
          <label for="name">Deskripsi</label>
          <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" maxlength="255" rows="3" {{(Auth::user()->role->name=='petugas' && $ticket->reporter_id!=$ticket->assigned_id) ? 'readonly=true' : 'false' }}" >{{ $ticket->description }}</textarea>
          @error('description')
          <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
          @enderror
        </div>
        <br />
        <div class="form-group">
          <label for="category_id">Kategori</label>
          <select name="category_id"  id="category_id" required="true" class="form-control @error('category') is-invalid @enderror">
              <option value="">-- Pilih Kategori --</option>
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
          <label for="reporter_name">Pelapor</label>
          <input type="text" class="form-control" disabled='true' name="reporter_name" id="reporter_name" value="{{ $ticket->reporter_name() }}" placeholder="Reporter name">
        </div>
        <br />
        <div class="form-group">
          <label for="description">Petugas</label>
          <select name="assigned_id" {{($ticket->is_new() || $ticket->is_ditolak()) ? '': 'disabled'}} id="assigned_id" class="form-control @error('assigned') is-invalid @enderror" required="true">
              <option value="">-- Pilih Petugas --</option>
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

        <a class="btn btn-success" onclick="window.history.back();"><i class="fa fa-chevron-left"></i>&nbsp;Kembali</a>
         @if(Auth::user()->role->name=='user' && $ticket->reporter_id==Auth::user()->id && $ticket->is_new())
           <input name='btn' type="submit" class="btn btn-primary" value="Simpan">
         @endif

         @if(Auth::user()->role->name=='admin' && ($ticket->is_ditolak() || $ticket->is_new()))
            <input name='btn' type="submit" class="btn btn-primary" value="Tugaskan">
         @endif
         @if(Auth::user()->role->name=='admin' || Auth::user()->role->name=='petugas')
           @if($ticket->is_sedang_dikerjakan())
            <input name='btn' type="submit" class="btn btn-warning" value="Tiket Selesai Dikerjakan">
           @endif
           @if($ticket->is_new() || $ticket->is_sedang_dikerjakan())
              <a href='javascript:void(0)' name='btn' class="btn btn-danger" onclick="document.getElementById('btn-tolak').click();">Tolak</a>
           @endif
         @endif

         @if($ticket->is_selesai() && ($ticket->reporter_id===Auth::user()->id || Auth::user()->role->name=='admin'))
        <hr />
        <div class="form-group" disabled='true'>
            <table class="table table-hover">
                <thead>
                <tr class="{{$ticket->get_class()}}">
                    <th scope="col">Formulir Umpan Balik Tiket Selesai</th>
                </tr>
                </thead>
                <tbody>
                  <tr><td>
                    @for ($i = 1; $i < 6; $i++)
                      @if($i<=$ticket->rating)
                      <i class="btn btn-outline-secondary fa fa-star feedback-star" value='{{$i}}' style="font-size: 40px; color: gold" onclick="document.getElementById('rating').value={{$i}}; star(this, '.fa-star')"></i>
                      @else
                      <i class="btn btn-outline-secondary fa fa-star feedback-star" value='{{$i}}' style="font-size: 40px; color: grey" onclick="document.getElementById('rating').value={{$i}}; star(this, '.fa-star')"></i>
                      @endif
                    @endfor
                  </td></tr>
                </tbody>
                <tfooter>
                    <tr>
                      <td>
                        <label for="description">Komentar Pelapor</label>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <textarea class="form-control @error('rating_comment') is-invalid @enderror" name="rating_comment" id="rating_comment" rows="3">{{ $ticket->rating_comment }}</textarea>
                        @error('rating_comment')
                        <x-alert type="invalid-feedback" :message="$message" class="mt-4"/>
                        @enderror
                      </td>
                    </tr>
                </tfooter>
              </table>

          <input name='btn' type="submit" class="btn btn-primary" value="Terima kasih!">
        </div>
        @endif

     </form>


    <form method="POST" action="{{ Route('ticket/update') }}" style="display: none">
        @csrf
        <input type="hidden" name="id" value="{{ $ticket->id }}">
        <input type="hidden" name="description" value="{{ $ticket->description }}">
        <input type="hidden" name="category_id" value="{{ $ticket->category_id }}">
        <input name='btn' type="submit" class="btn btn-danger" value="Tolak" id='btn-tolak'>
    </form>

     @if(!$ticket->is_ditolak() && ($ticket->reporter_id==Auth::user()->id || $ticket->assigned_id==Auth::user()->id))
     <div class="form-group">
      <div class="bg-light p-5 rounded">
        <b>Sertakan Berkas Dokumen (Jika Perlu)</b>
       <table class="table table-striped">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Size</th>
              <th scope="col">Type</th>
              <th scope="col">Waktu</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            @foreach($documents as $file)
              <tr>
                <td width="3%">{{ $loop->index+1 }}</td>
                <td><a target="_NEW" href='{{$file->get_url($host)}}'><img style="float:left" src="{{$file->get_url(null)}}" style="{{ $file->thumbnail()}}" >&nbsp;{{ $file->name }}</a> oleh {{$file->get_user_name()}}</td>
                <td width="10%">{{ $file->size }}</td>
                <td width="10%">{{ $file->type }}</td>
                <td>{{ $file->created_at }}</td>
                <td width="5%">
                    @if((Auth::user()->role->name=='admin' || ($file->user_id==Auth::user()->id)) && !$ticket->is_selesai())
                    <a href="{{ Route('document/destroy',['id'=> $file->id, 'ticket_id'=>$ticket->id]) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <form method="POST" action="{{ Route('document/store') }}" enctype="multipart/form-data">
            @csrf
           <a name='document'></a>
           <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
           <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
           <div class="form-group mt-4">
              <input type="file" name="document" multiple="false" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" required="true">
            </div>
            <input type="submit" name="attach" class="w-100 btn btn-lg btn-primary mt-4" value="Upload" />
        </form>
      </div>
     </div>
    <br />
    @endif

     <div class="form-group"><br />
        <b>Riwayat</b>&nbsp; (<small>counter flow: {{$ticket->circle_counter}}</small>)
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