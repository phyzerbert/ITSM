@extends('layouts.master')

@section('content')

    <section class="material-half-bg">
        <div class="cover"></div>
    </section>

    <section class="login-content">
        <a href="{{ url('/') }}" style="text-decoration:none;">
            <div class="logo">
                <h1>Bolton IT Help Desk</h1>
            </div>
        </a>
        <div class="login-box" style="min-height:490px">
            <form class="login-form" method="POST" action="{{ route('register') }}">
                <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN UP</h3>
                @csrf
                <div class="form-group">
                    <label class="control-label">USER ID</label>
                    <input id="name" type="text" class="form-control" name="name" value="" placeholder="UserID" required autofocus>
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>

                <input id="email" type="hidden" name="email">
                    
                <div class="form-group">
                    <label class="control-label">PASSWORD</label>
                    <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <div class="invalid-feedback" role="alert" style="display: block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label">CONFIRM</label>
                    <input id="password_confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm Password" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group btn-container">
                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN UP</button>
                </div>
                <br />
                <p class="text-center mb-4">Already have an account? <a href="/login"> Log In </a></p>
            </form>
        </div>
    </section>

@endsection
