@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content"  id="app" >
           <div class="row pt-4">
            @if($data['unidades'] && count($data['unidades']))
                @foreach ($data['unidades'] as $item)

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6  ">
                        <a href="{{ route($params['main_route'].'.unidade', $item->id)}}" class="small-box-footer">
                            <!-- small box -->
                            <div class="small-box pt-2 bg-gradient-orange">
                                <div class="inner">
                                    <h3>{{ $item->titulo}}</h3>
                                </div>
                                <div class="icon py-2">
                                    <i class="fas fa-building"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="col-12 py-3 d-flex justify-content-end">
                    <a class="d-flex btn btn-dark btn-sm py-1" href="{{ route('professor.dashboard')}}" role="button">Voltar</a>
                </div>
            @else
                <div class="alert alert-danger text-center w-100" role="alert">
                    Nenhuma Unidade Cadastrada
                </div>
            @endif
           </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    @if(isset($data['sala']))
        <script src="{{ asset('js/professor/app.js') }}" ></script>
    @endif
    <script src="{{ asset('plugin/jquery.mask.min.js') }}" ></script>
    <script src="{{ asset('js/scripts.js') }}" ></script>
@stop
