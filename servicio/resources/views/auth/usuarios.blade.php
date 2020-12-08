@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Usuarios</h1>
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
            <div class="card">
                <div class="row p-3">
                    <div class="col-2">
                        <label for="IdServicio">Id Servicio</label>
                        <input class="form-control" type="text" id="IdServicio" name="IdServicio">
                    </div>
                    <div class="col-2">
                        <label for="nombreCompleto">Nombre</label>
                        <input  class="form-control" type="text" id="nombreCompleto" name="nombreCompleto">
                    </div>
                    <div class="col-2">
                        <label for="marca">Marca</label>
                        <input  class="form-control" type="text" id="marca" name="marca">
                    </div>
                    <div class="col-2">
                        <label for="fechaA">Fecha A</label>
                        <input  class="form-control" type="text" id="fechaA" name="fechaA">
                    </div>
                    <div class="col-2">
                        <label for="fechaB">Fecha B</label>
                        <input  class="form-control" type="text" id="fechaB" name="fechaB">
                    </div>
                    <div class="col-2">
                        <label for="" class="text-white">a</label><br>
                        <button id="buscar" class="btn btn-success" >Buscar</button>
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <div class="row">
                    <div class="col-4">
                        <h3 class="card-title">Usuarios</h3>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-2">
                        <a id="agregarUsuario" href="{{route('registrarUsuario')}}" class="btn btn-info">Agregar Usuario <i class="far fa-plus-square"></i></a>
                    </div>
                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($usuarios as $usuario)
                            <tr>
                                <td>{{$usuario->id}}</td>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>
                                <td><a href="#" class="btn btn-primary">Editar <i class="far fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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


