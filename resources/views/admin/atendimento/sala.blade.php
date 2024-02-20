@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('title', config('admin.title'))

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('content')
    <section class="content"  id="app" >
            <atendimento turma_id="{{ $data['turma_id'] }}" ></atendimento>
            <div class="row d-flex justify-content-around">
                <div class="col-12 py-3 d-flex justify-content-end">
                    <a class="d-flex btn btn-dark btn-sm py-1" href="{{ route($params['main_route'].'.unidade',$data['unidade_id'] )}}" role="button">Voltar</a>
                </div>
           </div>
    </section>
@stop

@section('js')
    <script src="{{ asset('js/admin/app.js') }}" ></script>
    <script>

        $(document).ready(function () {
            $('[data-widget="pushmenu"]').on('mousedown',function(event){
                if($('body').hasClass('sidebar-collapse')){
                    $('div[class="content-header"]').show();
                    // <li class="nav-item fullscreen">
                    $('li[class="nav-item fullscreen"]').hide();
                }else{
                    $('li[class="nav-item fullscreen"]').show();
                    $('div[class="content-header"]').hide();
                }
            });
        });


    </script>
@stop
