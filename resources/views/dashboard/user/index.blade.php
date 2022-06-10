@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User') }} <a href="{{ Route('user/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

                <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                      <tr>
                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                        <a href="{{ Route('user/edit',$user->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        <a href="{{ Route('user/destroy',$user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                      </td>
                      </tr>
                  @endforeach
                    </tbody>
                  </table>
                  <div class="d-flex justify-content-center"> 
                    {{ $users->links('pagination.custom') }}
                 </div>
                </div>
            </div>
        </div>
    </div>
</div>
 

@endsection
