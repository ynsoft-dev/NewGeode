@extends('adminlte::auth.login')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('css')
@stop


@section('classes_body', 'login-page login-background')

@section('adminlte_js')
    @yield('js')
@stop

@section('body')

    <div class="left-aligned">
        <div class=" login-box">
            <div style="text-align: center;">
                <img src="{{ config('adminlte.logo_img') }}" alt="{{ config('adminlte.logo_img_alt') }}"
                    style="height: 100px; width: 140px; margin-bottom: 5px;">
            </div>
            <div class="card-login">
                <div class="card-body login-card-body">

                    <!-- <p class="login-box-msg"><b>Log in to start a session</b></p> -->

                    <form action="{{ url(config('adminlte.login_url', 'login')) }}" method="post">
                        {{ csrf_field() }}

                        <div class="input-group mb-3">
                            <input type="email" name="email"
                                class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" name="password"
                                class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                placeholder="{{ __('adminlte::adminlte.password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">{{ __('adminlte::adminlte.remember_me') }}</label>
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit"
                                    class="btn btn-primary btn-block">{{ __('adminlte::adminlte.sign_in') }}</button>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <p> </p>
                                    <p><strong><u>pour le test : </u></strong> </p>
                                    <p><strong>compte admin :</strong> admin@admin.com <strong>/</strong> adminadmin
                                    </p>
                                    <p><strong>compte user :</strong> abdelghani.ziani@cevital.com
                                        <strong>/</strong>
                                        user123
                                    </p>
                                    <p><strong>compte archiviste :</strong> naim.bensaadi@cevital.com
                                        <strong>/</strong>
                                        archiviste
                                    </p>
                                </div>

                            </div>
                        </div>
                    </form>

                    <!-- <p class="mb-1">
                                <a href="{{ url(config('adminlte.password_reset_url', 'password/reset')) }}">
                                    {{ __('adminlte::adminlte.i_forgot_my_password') }}
                                </a>
                                </p> -->
                    @if (config('adminlte.register_url', 'register'))
                        <!-- <p class="mb-0">
                                <a href="{{ url(config('adminlte.register_url', 'register')) }}" class="text-center">
                                    {{ __('adminlte::adminlte.register_a_new_membership') }}
                                </a>
                            </p> -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@stop
