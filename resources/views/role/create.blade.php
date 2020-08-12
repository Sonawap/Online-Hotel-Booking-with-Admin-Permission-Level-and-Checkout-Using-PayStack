@extends('layouts.master')
@section('title')
Role
@endsection
@section('bc')
Create Role
@endsection
@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add new Role</h3>
        <div class="card-tools">
            <a href="{{ route('role.index') }}" class="btn btn-danger">See all Roles</a>
        </div>
    </div>
    <div class="card-body">
        <role></role>
    </div>
</div>

@endsection
