@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Artículos</h1>
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
                    <label for="IdArticulo">Id Artículo</label>
                    <input class="form-control" type="text" id="IdArticulo" name="IdArticulo">
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
                    <h3 class="card-title">Articulos</h3>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-2">
                        <a id="agregarArticulo" href='{{route("Articulo.create")}}' class="btn btn-info">Agregar Artículo <i class="far fa-plus-square"></i></a>

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
                        <th>Telefono</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articulos as $articulo)
                    <tr>
                        <td>{{$articulo->id_articulo}}</td>
                        <td>{{$articulo->nombre_completo}}</td>
                        <td>{{$articulo->telefono}}</td>
                        <td>{{$articulo->fecha_articulo}}</td>
                        <td><a href="{{ route('Articulo.edit',$articulo->id_articulo)}}" class="btn btn-primary">Editar <i class="far fa-edit"></i></a></td>
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


