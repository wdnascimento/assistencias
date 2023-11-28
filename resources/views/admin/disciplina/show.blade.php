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
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">{{$params['subtitulo']}}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route($params['main_route'].'.index')}}" class="btn btn-primary btn-xs"><span class="fas fa-arrow-left"></span>  Voltar</a>
                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body ">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0 ">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        {{Form::label('titulo', 'Título')}}
                        {{Form::text('titulo',$data->titulo,['class' => 'form-control', 'placeholder' => 'Título','readonly'=>'readonly'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('grupo_disciplina_id', 'Grupo de Disciplina')}}
                        {{Form::select('grupo_disciplina_id',
                                $preload['grupo_disciplinas'],
                                ((isset($data->grupo_disciplina_id)) ? $data->grupo_disciplina_id : null),
                                ['id'=>'grupo_disciplina_id','class' =>'form-control ','readonly'=>'readonly'])}}
                    </div>
                    {{ Form::open(['route' => [$params['main_route'].'.destroy',$data->id],'method' =>'DELETE']) }}
                    <div class="form-group">
                        {{Form::submit('Deletar',['class'=>'btn btn-danger btn-sm'])}}
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.card-body -->
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
