@extends('layouts.master')
@section('title')
Role
@endsection
@section('bc')
Role
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Category Table</h3>
        <div class="card-tools">
            <a href="{{ route('role.createRole') }} " class="btn btn-primary">Add new Role</a>
        </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role</th>
                    <th>Permission</th>
                    <th>Date Posted</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role )
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach ($role->permissions as $permission )
                                <button class="btn btn-warning" role="button">{{ $permission->name }}</button>
                            @endforeach
                        </td>
                        <td><span class="tag tag-success">{{ $role->created_at }}</span></td>
                        <td>
                            {{--  <a href="{{ route('role.show', $role->id ) }}" class="btn btn-info">Edit</a> |
                            <a href="{{ route('role.destroy',$role->id ) }}" class="btn btn-danger">Delete</a>  --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection
