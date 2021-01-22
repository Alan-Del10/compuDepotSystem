@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Título</h1>
            </div>
            <div class="col-sm-6">

            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Busqueda</h3>
                    </div>
                    <div class="input-group p-3">
                        <input class="form-control" type="text" id="busqueda" placeholder="Buscar por ?...">
                        <div class="input-group-append">
                            <select name="" id="" class="custom-select">
                                <option value="0">Selecciona ?</option>

                            </select>
                            <button id="buscar" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                        <h3 class="card-title">Lista de ?</h3>
                        </div>
                        <div class="col-5">
                        </div>
                        <div class="col-3">
                            <a id="" href='' class="btn btn-info">Agregar/Editar ? <i class="far fa-plus-square"></i></a>
                        </div>
                    </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 10px">Campo 1</th>
                            <th>Campo 2</th>
                            <th>Campo 3</th>
                            <th>Campo 4</th>
                            <th>Campo 5</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="tabla">

                            <tr class="items">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><a href="" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a></td>
                            </tr>

                        </tbody>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Detalle</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{asset('storage/icon/box.png')}}" alt="Producto" id="imagen" class="img-fluid rounded mx-auto d-block">
                                <div class="card-header">
                                    <b>Datos Online</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" id="titulo">Título:</li>
                                    <li class="list-group-item" id="descripcion">Descripción:</li>
                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-header">
                                    <b>Precios</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" id="publico">Precio Público:</li>
                                    <li class="list-group-item" id="mayoreo">Precio Mayoreo:</li>
                                    <li class="list-group-item" id="minimo">Precio Mínimo:</li>
                                    <li class="list-group-item" id="maximo">Precio Máximo:</li>
                                </ul>
                                <div class="card-header">
                                    <b>Costos</b>
                                </div>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item" id="costo_actual">Costo Actual:</li>
                                    <li class="list-group-item" id="costo_anterior">Costo Anterior:</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


