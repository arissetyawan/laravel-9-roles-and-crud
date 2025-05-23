@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Kategori') }} <a href="{{ Route('status/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

                <div class="card-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col" class="col-1">#</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Deskripsi</th>
                        <th scope="col" class="col-2" colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($statuses as $status)
                    <tr>
                        <th scope="row">{{ $status->id }}</th>
                        <td>{{ $status->name }}</td>
                        <td>{!! Str::words($status->description, 3, ' ...') !!}</td>
                        <td>
                        <a href="{{ Route('status/edit',$status->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        </td>
                        <td>
                        <a href="{{ Route('status/destroy',$status->id) }}" class="btn  btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center"> 
                    {{ $statuses->links('pagination.custom') }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
