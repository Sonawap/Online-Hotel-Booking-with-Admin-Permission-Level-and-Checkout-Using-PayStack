@extends('layouts.master')
@section('title')
Permission
@endsection
@section('bc')
Add Permission
@endsection
@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Add new Permission</h3>
        <div class="card-tools">
            <a href="{{ route('permission.index') }}" class="btn btn-danger">See all Permission</a>
        </div>
    </div>
    <form method="POST" action="{{ route('permission.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" name="name"  id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Permission Name">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Permission</button>
        </div>
    </form>
</div>


@endsection
