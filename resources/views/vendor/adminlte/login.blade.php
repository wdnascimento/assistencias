@extends('adminlte::master')

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
@stop

@section('adminlte_css')

    @stack('css')
    @yield('css')
@stop

@section('classes_body', 'login-page')

@php
// THE SECTION MUST BE SUBMITTED BY THE CONTROLLER USER
$index_section = (isset($section) &&  $section != '')? $section : 'aluno'  ;
@endphp

@php( $login_url = View::getSection('login_url') ?? config('adminlte.login_url.'.$index_section, 'login') )
@php( $register_url = View::getSection('register_url') ?? config('adminlte.register_url.'.$index_section, 'register') )
@php( $password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url.'.$index_section, 'password/reset') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url.'.$index_section, 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $login_url = $login_url ? route($login_url) : '' )
    @php( $register_url = $register_url ? route($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? route($password_reset_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $login_url = $login_url ? url($login_url) : '' )
    @php( $register_url = $register_url ? url($register_url) : '' )
    @php( $password_reset_url = $password_reset_url ? url($password_reset_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ $dashboard_url }}">
                <img src="{{ asset(config('adminlte.auth_logo.img.path', '')) }}" style="max-height: 80px;" alt="{{ config('adminlte.title','') }}" srcset="">
            </a>
            @switch($index_section)
                @case('aluno')
                <h4 class="w-100 text-center">Alunos</h4>
                @break
                @case('professor')
                <h4 class="w-100 text-center">Professores</h4>
                @break
                @case('admin')
                <h4 class="w-100 text-center">Administradores</h4>
                @break
                @default
                @break
            @endswitch

        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('adminlte::adminlte.login_message') }}</p>
                <form action="{{ $login_url }}" method="post">
                    {{ csrf_field() }}
                    @if($index_section != 'aluno')

                        <div class="input-group mb-3">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @if ($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('adminlte::adminlte.password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="input-group mb-3">
                            <input type="text" name="numero" id="numero"  class="form-control {{ $errors->has('numero') ? 'is-invalid' : '' }}" value="{{ old('numero') }}" placeholder="Número" autofocus>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                            @if ($errors->has('numero'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('numero') }}
                                </div>
                            @endif
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" placeholder="{{ __('adminlte::adminlte.password') }}">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                    @endif
                    @if ($errors->has('auth') )
                        <div class="text-center pb-3">
                            {{ $errors->first('auth')}}
                        </div>
                    @endif
                    <div class="row justify-content-center pb-3">
                        <div class="g-recaptcha" data-sitekey="6LfA5egnAAAAACqJYKK2j-UFj-MRxNnMqcxv1nHX"></div>
                    </div>
                    @if ($errors->has('g-recaptcha-response') )
                        <div class="invalid pb-3">
                            {{ $errors->first('g-recaptcha-response')}}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">
                                {{ __('adminlte::adminlte.sign_in') }}
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @if($index_section == "aluno")
        @section('js')
            <script src="{{ asset('plugin/jquery-3.4.1.min.js') }}"></script>
            <script src="{{ asset('plugin/jquery.mask.min.js') }}"></script>
            <script src="{{ asset('js/scripts.js') }}"></script>
        @endsection
    @endif
@stop
@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>

    @stack('js')
    @yield('js')
@stop
