@extends('adminlte::master')

@section('adminlte_css')
    @yield('css')
@stop

@section('classes_body', 'login-page')

@php
// THE SECTION MUST BE SUBMITTED BY THE CONTROLLER USER
$index_section = (isset($section) &&  $section != '')? $section : 'aluno'  ;
@endphp

@php( $password_email_url = View::getSection('password_email_url') ?? config('adminlte.password_email_url.'.$index_section, 'password/email') )
@php( $dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url.'.$index_section, 'home') )

@if (config('adminlte.use_route_url', false))
    @php( $password_email_url = $password_email_url ? route($password_email_url) : '' )
    @php( $dashboard_url = $dashboard_url ? route($dashboard_url) : '' )
@else
    @php( $password_email_url = $password_email_url ? url($password_email_url) : '' )
    @php( $dashboard_url = $dashboard_url ? url($dashboard_url) : '' )
@endif

@section('body')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ $dashboard_url }}">{!! config('adminlte.logo.'.$index_section, '<b>Admin</b>LTE') !!}</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('adminlte::adminlte.password_reset_message') }}</p>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form action="{{ $password_email_url }}" method="post">
                    {{ csrf_field() }}
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
                    <button type="submit" class="btn btn-primary btn-block btn-flat">
                        {{ __('adminlte::adminlte.send_password_reset_link') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
