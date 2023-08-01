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
                        @if (Auth::user()->atendimento == '0')
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-info">
                            <div class="inner">
                              <h3>{{$data['admin']}}</h3>

                              <p>Administradores</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ route($params['main_route'].'.administrador.index')}}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-success">
                            <div class="inner">
                              <h3>{{$data['aluno']}}</h3>

                              <p>Alunos</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ route($params['main_route'].'.aluno.index')}}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-warning">
                            <div class="inner">
                              <h3>{{$data['professor']}}</h3>

                              <p>Professores</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ route($params['main_route'].'.professor.index')}}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-6">
                          <!-- small box -->
                          <div class="small-box bg-danger">
                            <div class="inner">
                              <h3>{{$data['aula']}}</h3>

                              <p>Aulas</p>
                            </div>
                            <div class="icon">
                              <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route($params['main_route'].'.aula.index')}}" class="small-box-footer">Ver Mais <i class="fas fa-arrow-circle-right"></i></a>
                          </div>
                        </div>
                        @else
                            <h2>Bem Vindo</h2>
                        @endif
                        <!-- ./col -->
                      </div>
                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
