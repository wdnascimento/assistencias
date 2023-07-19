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
                        {{Form::label('ano', 'Ano')}}
                        {{Form::select('ano',
                                $preload['ano'],
                                ((isset($data->ano)) ? $data->ano : null),
                                ['id'=>'ano','class' =>'form-control','disabled'=>'true'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('name', 'Nome')}}
                        {{Form::text('name',$data->name,['class' => 'form-control', 'placeholder' => 'Nome','readonly'=>'readonly'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('numero', 'Número')}}
                        {{Form::text('numero',$data->numero,['class' => 'form-control','readonly'=>'readonly'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('cabine', 'Cabine')}}
                        {{Form::text('cabine',$data->cabine,['class' => 'form-control', 'placeholder' => 'Cabine','readonly'=>'readonly'])}}
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
