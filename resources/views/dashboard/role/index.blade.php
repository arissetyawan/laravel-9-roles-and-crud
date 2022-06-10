@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Role') }} <a href="{{ Route('role/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

                <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Role Name</th>
                      <th scope="col">Description</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($roles as $role)
                    <tr>
                      <th scope="row">{{ $role->id }}</th>
                      <td>{{ $role->name }}</td>
                      <td>{{ $role->description }}</td>
                      <td>
                      <a href="{{ Route('role/edit',$role->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                      <a href="{{ Route('role/destroy',$role->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
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
