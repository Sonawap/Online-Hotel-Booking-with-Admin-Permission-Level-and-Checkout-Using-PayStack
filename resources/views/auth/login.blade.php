
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Login - The RockValley Hotel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" >
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"><b>Rock</b>Valley</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form class="form" method="post" action="{{ route('login') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" required class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Email">
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="input-group mb-3">
                <input type="password" required name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-8">
                    <span>
                        <a href="{{ url('/') }}"><i class="fas fa-arrow-left"></i> Back Home</a>
                    </span>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>


<script src="{{ asset('js/app.js') }}"></script>

</body>
</html>
