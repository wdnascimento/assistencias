@extends('adminlte::page')

@section('title', config('admin.title'))

@section('content_header')
    @include('admin.layouts.header')
@stop

@section('content')
    <section class="content" id="app">
       <div  class="row">
           <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h3 class="card-title">{{$params['subtitulo']}}</h3>
                        </div>
                        <div class="col-6 text-right">
                            <a href="{{ route($params['main_route'].'.create')}}" class="btn btn-primary btn-xs"><span class="fas fa-plus"></span> Novo Cadastro</a>
                        </div>
                    </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="m-0 ">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(isset($data) && count($data))
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Data/Hora</th>
                                <th>Cadastrastrado por</th>
                                <th>Importado</th>
                                <th>Operação</th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- id, titulo, data_hora, importado, usuario, deleted_at, created_at, updated_at -->
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->titulo}}</td>
                                    <td>{{ $item->data_hora }}</td>
                                    <td>{{ $item->usuario }}</td>
                                    <td>{{ $item->desc_importado }}</td>


                                    <td>
                                        @if($item->importado)
                                            <a href="{{ route($params['main_route'].'.removeimport', $item->id) }}" class="btn btn-danger btn-xs"><span class="fas fa-trash"></span> Remover Importação</a>
                                        @else
                                            <a href="{{ route($params['main_route'].'.import', $item->id) }}" class="btn btn-info btn-xs"><span class="fas fa-edit"></span> Importar</a>
                                        @endif
                                        <a href="{{ asset('storage/'.$item->titulo) }}" class="btn btn-primary btn-xs"><span class="fas fa-eye"></span> Ver Arquivo</a>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @else
                        <div class="alert alert-success m-2" role="alert">
                            Nenhuma informação cadastrada.
                        </div>
                    @endif
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
    <script  type="module"  src="{{ asset('js/admin/app.js') }}" ></script>
@stop
