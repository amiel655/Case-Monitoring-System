@extends('layouts.app')

@section('content')
<div class="container-fluid login-bg pb-3">
    <div class="justify-content-center">
        <div class="container" id="login-form">
            <div class="login-padding"></div>
            <div class="row login">
                <div class="col-md-5 p-3 pao-login-left">
                    <div class="mt-5 text-center">
                        <img src="./img/logo/PAO_Logo.png" alt="PAO's Logo" class="img-fluid login-logo">
                        <h3>Public Attorney's Office</h3>
                        <h6>District III : San Fernando City</h6><br>
                        <h4>Department of Justice</h4>
                    </div>
                </div>
                <div class="col-md-7 p-5 pao-login-right">
                    <h3><i class="material-icons" style="font-size: 40px !important">fingerprint</i> {{ __('LOGIN') }}</h3><br>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="ml-3 form-group">
                            <label for="username"><i class="material-icons">mail</i> {{ __('Username') }}</label>
                            <input type="text" id="username" class="form-control login-input {{ $errors->has('username') ? ' is-invalid' : '' }}"
                                name="username" value="{{ old('username') }}" placeholder="Username" required autofocus>
                            @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="ml-3 form-group"><br>
                            <label for="password"><i class="material-icons">lock</i> {{ __('Password') }}</label>
                            <input type="password" id="password" name="password" class="form-control login-input {{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" required>
                            @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group text-right row pt-4">
                            <div class="col-md-8 offset-md-4 mt-3">
                                <button type="submit" class="btn btn-success btn-login">
                                    {{ __('Login') }}
                                    <i class="material-icons">trending_flat</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
