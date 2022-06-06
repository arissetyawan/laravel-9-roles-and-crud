@extends('layouts.app')

@section('content')

<div class="container">
    <a href="{{ Route('role/create') }}" class="btn btn-primary">Add new role</a>
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
        <td><a href="{{ Route('role/edit',$role->id) }}" class="btn btn-primary">Edit</a><a href="{{ Route('role/destroy',$role->id) }}" class="btn btn-danger">delete</a></td>
      </tr>
  @endforeach
    </tbody>
  </table>
  
</div>

@endsection
