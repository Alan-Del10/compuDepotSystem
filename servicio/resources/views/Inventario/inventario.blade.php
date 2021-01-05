@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Inventario</h1>
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
                    <label for="IdInventario">Id Inventario</label>
                    <input class="form-control" type="text" id="IdArticulo" name="IdInventario">
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
                    <h3 class="card-title">Lista de Inventario</h3>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-2">
                        <a id="agregarInventario" href='{{route("Inventario.create")}}' class="btn btn-info">Agregar/Editar Inventario <i class="far fa-plus-square"></i></a>
                    </div>
                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">UPC</th>
                        <th>Categoria</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inventarios as $inventario)
                    <tr>
                        <td>{{$inventario->upc}}</td>
                        <td>{{$inventario->categoria}}</td>
                        <td>{{$inventario->marca}}</td>
                        <td>{{$inventario->modelo}}</td>
                        <td><a href="{{ route('Inventario.edit',$inventario->id_inventario)}}" class="btn btn-primary">Editar <i class="far fa-edit"></i></a></td>
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


