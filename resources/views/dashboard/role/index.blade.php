@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Peran') }} <a href="{{ Route('role/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

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
                  @foreach($roles as $role)
                    <tr>
                      <td>{{ $loop->index+1 }}</td>
                      <td>{{ $role->name }}</td>
                      <td>{{ $role->description }}</td>
                      <td>
                        @if($role->name!='admin' && Auth::user()->role->name=='admin')
                        <a href="{{ Route('role/edit',$role->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        @endif
                      </td>
                      <td>
                        @if($role->users()->count()==0 && $role->name!='admin' && Auth::user()->role->name=='admin')
                        <a href="{{ Route('role/destroy',$role->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif
                      </td>
                    </tr>
                @endforeach
                  </tbody>
                </table>
                <div class="d-flex justify-content-center"> 
                    {{ $roles->links('pagination.custom') }}
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
