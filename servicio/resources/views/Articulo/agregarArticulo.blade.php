@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Agregar Artículo</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
        </div><!-- /.container-fluid -->


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Artículo</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('Articulo.store')}}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="card-body">
                        <div class="form-group row">
                            <label for="marca" class="col-sm-2 col-form-label">Marca</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="marca">
                                    <option value="0">Seleccionar Marca</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{$marca->id_marca}}">{{$marca->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary" id="agregarMarca"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="modelo">
                                    <option value="0">Seleccionar Modelo</option>
                                    @foreach($modelos as $modelo)
                                        <option value="{{$modelo->id_modelo}}">{{$modelo->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary" id="agregarModelo"><i class="fas fa-plus"></i></button>
                            </div>
                            <label for="capacidad" class="col-sm-1 col-form-label">Capacidad</label>
                            <div class="col-sm-3">
                                <select class="form-control" id="capacidad">
                                    <option value="0">Seleccionar Capacidad</option>
                                    @foreach($capacidades as $capacidad)
                                        <option value="{{$capacidad->id_capacidad}}">{{$capacidad->tipo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary" id="agregarCapacidad"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="descripcion" placeholder="Descripción">
                            </div>
                            <label for="costo" class="col-sm-2 col-form-label">Costo Promedio ($)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="costo" placeholder="Costo Promedio">
                            </div>
                            <label for="peso" class="col-sm-1 col-form-label">Peso(Kg)</label>
                            <div class="col-sm-1">
                                <input type="text" class="form-control" id="peso" placeholder="Peso">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="largo" class="col-sm-2 col-form-label">Largo(m)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="largo" placeholder="Largo">
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="alto" class="col-sm-1 col-form-label">Alto(m)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="alto" placeholder="Alto">
                            </div>
                            <div class="col-sm-1"></div>
                            <label for="ancho" class="col-sm-1 col-form-label">Ancho(m)</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="ancho" placeholder="Ancho">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <input type="submit" value="Agregar" class="btn btn-success float-right agregarArticulo">
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>

            </div>
            <!-- Callback-->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @elseif (Session::has('message'))
                <div class="alert alert-success">
                    <ul>
                        {{Session::get('success')}}
                    </ul>
                </div>
            @endif
        <!-- /Callback-->
        </section>
        <!-- /.content -->
    </section>
@endsection



