{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
<section class="content" >
    <div class="row">
        <div class="col-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body ">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 ">
                            <a href="{{ route($params['main_route'].'.aula.index')}}" class="small-box-footer">
                                <!-- small box -->
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                    <h3>Aula</h3>

                                    <p>Cadastrar Mesa</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                            <a href="{{ route($params['main_route'].'.atendimento.index')}}" class="small-box-footer">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                    <h3>Atendimento</h3>

                                    <p>Iniciar Atendimento</p>
                                    </div>
                                    <div class="icon">
                                    <i class="ion ion-bag"></i>
                                    </div>
                                </div>
                            </a>
                        </div>



                      </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
