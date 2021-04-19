@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Categorias</h1>
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
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                        <div class="row">
                            <div class="col-4">
                            <h3 class="card-title">Lista de Categorias</h3>
                            </div>
                            <div class="col-5">
                            </div>
                            <div class="col-3">
                                <a id="" href='{{route("TipoInventario.create")}}' class="btn btn-info">Agregar/Editar Categoria <i class="far fa-plus-square"></i></a>
                            </div>
                        </div>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th>Nombre</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach ($categorias as $categoria)
                                <tr class="items">
                                    <td>{{$categoria->id_categoria}}</td>
                                    <td>{{$categoria->categoria}}</td>
                                    <td>{{$categoria->estatus}}</td>
                                    <td><a href="" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sub categorias</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-header">
                                        <b>Categorias</b>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id="publico">1:</li>
                                        <li class="list-group-item" id="mayoreo">2:</li>
                                        <li class="list-group-item" id="minimo">3:</li>
                                        <li class="list-group-item" id="maximo">4:</li>
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
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


