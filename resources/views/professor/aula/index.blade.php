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
                    {{-- id, disciplina_id, teacher_id, sala_id, titulo, inicio, date, fim, status, created_by, created_at, updated_at --}}

                    @if(isset($data) && count($data))
                        <table class="table table-striped ">
                            <thead>
                            <tr>
                                <th>Data</th>
                                <th  class="d-none d-sm-block">Mesa</th>

                                <th>Disciplina</th>

                                <th class="d-none d-sm-block">Professor</th>
                                <th>Operações</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td >{{ \Carbon\Carbon::parse($item['inicio'])->format('d/m/Y')}}</td>
                                    <td class="d-none d-sm-block">{{  $item['sala']['titulo']}}</td>

                                    <td>{{ $item['disciplina']['titulo']}}</td>

                                    <td class="d-none d-sm-block">{{ $item['professor']['name'] }}</td>
                                    <td>
                                        @if($item['status'])
                                            {{-- @if ($item['professor_id'] == Auth::User()->id)
                                                <form id="logout-form-{{ $item['sala_id'] }}" action="{{ route($params['main_route'].'.desativar',$item['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="sala_id" value="{{ $item['sala_id'] }}">
                                                    <button type="submit" class="btn btn-primary btn-xs" >Desativar</button>
                                                </form>
                                            @else--}}
                                                <span class=""><i class="fas fa-check"></i> Ativada</span>
                                            {{-- @endif --}}
                                        @else
                                            {{-- @if ($item['professor_id'] == Auth::User()->id)
                                                <form id="logout-form-{{ $item['sala_id'] }}" action="{{ route($params['main_route'].'.ativar',$item['id']) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="sala_id" value="{{ $item['sala_id'] }}">
                                                    <input type="hidden" name="professor_id" value="{{ $item['professor_id'] }}">
                                                    <button type="submit" class="btn btn-danger btn-xs" >Ativar</button>
                                                </form>
                                            @else--}}
                                                <span class="text-muted"><i class="fas fa-times"></i> Desativada</span>
                                            {{-- @endif --}}
                                        @endif
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

                <div class="row">
                    <div class="col-12 p-4 ">
                        {{ $data->links() }}
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
