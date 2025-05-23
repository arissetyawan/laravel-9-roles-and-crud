@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Priority') }} <a href="{{ Route('priority/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

                <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" class="col-8">Nama</th>
                        <th scope="col" class="col-3">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($prioritys as $priority)
                    <tr>
                        <th scope="row">{{ $priority->id }}</th>
                        <td>{{ $priority->name }}</td>
                        <td>
                        <a href="{{ Route('priority/edit',$priority->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        <a href="{{ Route('priority/destroy',$priority->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                    </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-center"> 
                    {{ $prioritys->links('pagination.custom') }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
