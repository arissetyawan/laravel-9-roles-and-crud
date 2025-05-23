@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User/ Pengguna') }} <a href="{{ Route('user/create') }}" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i></a></div>

                <div class="card-body">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col" class="text-top col-1">#</th>
                        <th scope="col">Nama, Email</th>
                        <th scope="col-2">Peran</th>
                        <th scope="col" class="col-2" colspan="2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user->name }}<br />{{ $user->email }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>
                        @if($user->role->name!='admin' && Auth::user()->role->name=='admin')
                        <a href="{{ Route('user/edit',$user->id) }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                        @endif
                        </td>
                        <td>
                        @if($user->role->name!='admin' && Auth::user()->role->name=='admin')
                        <a href="{{ Route('user/destroy',$user->id) }}" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        @endif
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
