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
    <div class="login-box" style="min-height:450px">
        <form class="login-form" method="POST" action="{{ route('login') }}">
            <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
            @csrf
            <div class="form-group">
                <label class="control-label">USER ID</label>
                <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="UserID" required autofocus>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label">PASSWORD</label>
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Password" required>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <div class="utility">
                    <div class="animated-checkbox">
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><span class="label-text">Remember Me</span>
                        </label>
                    </div>

                    <!-- @if (Route::has('password.request'))
                        <p class="semibold-text mb-2">
                            <a class="btn btn-link" href="{{ route('password.request') }}" data-toggle="flip">
                                {{ __('Forgot Password?') }}
                            </a>
                        </p>
                    @endif -->
                </div>
            </div>
            <div class="form-group btn-container">
                <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
            </div>
            <br />
            {{-- <p class="text-center">Don't have an account? <a href="{{ route('register') }}">Sign Up</a></p> --}}
        </form>
        
    </div>
</section>

@endsection

@section('after_script')
<script type="text/javascript">
    // Login Page Flipbox control
    $('.login-content [data-toggle="flip"]').click(function() {
        $('.login-box').toggleClass('flipped');
        return false;
    });
</script>
@endsection
