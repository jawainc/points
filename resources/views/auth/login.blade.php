@extends('layouts.login')
@section('title', 'Admin Login')


@section('content')
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">{{ __('Login') }}</p>

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" name="email" value="{{ old('email') }}" required autofocus>
                <i class="fas fa-envelope form-control-feedback"></i>
                @if ($errors->has('email'))
                    <small class="help-block">{{ $errors->first('email') }}</small>
                @endif
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password">
                <i class="fas fa-user-lock form-control-feedback"></i>
                @if ($errors->has('password'))
                    <small class="help-block">{{ $errors->first('password') }}</small>
                @endif
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>



    </div>
    <!-- /.login-box-body -->

@endsection
