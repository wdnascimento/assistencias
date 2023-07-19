@extends('adminlte::page')


@section('title', config('admin.title'))

@section('content')
    <section class="content p-t-0"  id="app" >
        <div class="row">
            <painel sala_id="1" titulo="Mesa 01" root="{{ url('') }}"></painel>
            <painel sala_id="2" titulo="Mesa 02" root="{{ url('') }}"></painel>
        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@section('js')
    <script  type="module"  src="{{ asset('js/app.js') }}" ></script>
@stop
