@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Tiket') }} <a href="{{ Route('ticket/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

                <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="col-4">Deskripsi</th>
                        <th scope="col" class="col-2">Kategori</th>
                        <th scope="col" class="col-2">Prioritas</th>
                        <th scope="col" class="col-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <th scope="row">{{ $ticket->id }}</th>
                        <td>{!! Str::words($ticket->description, 3, ' ...') !!}
                        </td>
                        <td>{{ $ticket->category->name }}</td>
                        <td>{{ $ticket->priority->name }}</td>
                        <td>
                        <a href="{{ Route('ticket/edit',$ticket->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        <a href="{{ Route('ticket/destroy',$ticket->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center"> 
                    {{ $tickets->links('pagination.custom') }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
