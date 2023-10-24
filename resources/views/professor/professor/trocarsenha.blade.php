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
                            <a href="{{ route($params['main_route'].'.trocarsenha')}}" class="btn btn-primary btn-xs"><span class="fas fa-arrow-left"></span>  Voltar</a>
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
                        {{Form::label('name', 'Nome')}}
                        {{Form::text('name',$data->name,['class' => 'form-control', 'placeholder' => 'Nome','readonly'=>'readonly'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('email', 'E-mail')}}
                        {{Form::text('email',$data->email,['class' => 'form-control', 'placeholder' => 'E-mail','readonly'=>'readonly'])}}
                    </div>
                    {{ Form::open(['route' => [$params['main_route'].'.updatepassword',$data->id],'method' =>'put']) }}

                    <div class="form-group">
                        {{Form::label('password', 'Nova Senha')}}
                        {{Form::password('password',['class' => 'form-control', 'placeholder' => 'Senha'])}}
                    </div>
                    <div class="form-group">
                        {{Form::label('password_confirmation', 'Confirmar Nova Senha')}}
                        {{Form::password('password_confirmation',['class' => 'form-control', 'placeholder' => 'Confirmar Senha', 'type' =>'password'])}}
                    </div>

                    <div class="form-group">
                        {{Form::submit('Trocar Senha',['class'=>'btn btn-primary btn-sm'])}}
                    </div>
                    {{ Form::close() }}
                </div>
                <!-- /.card-body -->
              </div>


           </div>
       </div>
    </section>
@stop



@section('js')

@stop
