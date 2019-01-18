@extends('sablonlg')
@section('head')
    <link rel="stylesheet" href="{{asset("css/linearicons.css")}}">
    <link rel="stylesheet" href="{{asset("css/nice-select.css")}}">
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.css")}}"/>
    <link rel="stylesheet" href="{{asset("css/ion.rangeSlider.skinFlat.css")}}"/>
    <link rel="stylesheet" href="{{asset("/css/main.css")}}">
    <link rel="stylesheet" href="{{asset("/css/chc.css")}}">
@endsection

@section('title') Login · Bosnabook @endsection
@section('content')
    <section class="property-area section-gap relative regpr" id="property">
        <div class="overlay overlay-bg"></div>
        <div class="container ccc">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 pb-40 header-text" style="margin-top: 50px">
                    <h1><span class="fa-fw fas fa-sign-in-alt"></span> Login · Bosnabook</h1>
                </div>
            </div>
            <form method="POST" action="{{ route('login') }}" class="trrrr bijelo">
                @csrf

                <div class="form-group row">
                    <label for="username" class="col-sm-4 col-form-label text-md-right"><span class="fa-fw fas fa-user"></span> {{ __('Username') }}</label>

                    <div class="col-md-6">
                        <input id="username" type="text"
                               class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username"
                               value="{{ old('username') }}" required autofocus>

                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right"><span class="fa-fw fas fa-lock"></span> {{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password"
                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
                               required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6 offset-md-4">
                        <div class="form-check checkboxes-and-radios">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label style="margin-right: 10rem;" for="remember">
                                <span class="fa-fw fas fa-cookie"></span> {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        {{----}}
                        {{--<a class="btn btn-link" href="{{ route('password.request') }}">--}}
                            {{--{{ __('Forgot Your Password?') }}--}}
                        {{--</a>--}}
                        {{----}}
                        <button type="submit" class="btn btn-primary">
                            <span class="fa-fw fas fa-check"></span> {{ __('Login') }}
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection
