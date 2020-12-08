@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Agregar Sucursal</h1>
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
                        <h3 class="card-title">Sucursal</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form action="{{route('Sucursal.store')}}" method="POST" class="form-horizontal" >
                            @csrf
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-1 col-form-label">Nombre:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="local" class="col-sm-1 col-form-label">Local:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="local" id="local" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="direccion" class="col-sm-1 col-form-label">Dirección:</label>
                                <div class="col-sm-11">
                                    <input type="text" name="direccion" id="direccion" class="form-control">
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Agregar" class="btn btn-success float-right agregarSucursal">
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
                @endif
                <!-- /Callback-->
            </div>
        </section>
        <!-- /.content -->
    </section>
@endsection