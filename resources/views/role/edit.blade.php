@extends('layouts.master')
@section('title')
Role
@endsection
@section('bc')
Edit Role
@endsection
@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Role</h3>
        <div class="card-tools">
            <a href="{{ route('role.index') }}" class="btn btn-danger">See all Roles</a>
        </div>
    </div>
    <editrole roleid="{{ $role->id }}"></editrole>
</div>


@endsection
