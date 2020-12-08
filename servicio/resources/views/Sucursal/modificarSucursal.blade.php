@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Modificar Sucursal</h1>
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
                        <form action="{{route('Sucursal.update', [$sucursal->id_sucursal])}}" method="POST" class="form-horizontal" >
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="nombre" class="col-sm-1 col-form-label">Nombre:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre', $sucursal->nombre)}}">
                                    @if ($errors->has('nombre'))
                                        <span class="errormsg">{{ $errors->first('nombre') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="local" class="col-sm-1 col-form-label">Local:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="local" id="local" class="form-control" value="{{old('local', $sucursal->local)}}">
                                    @if ($errors->has('local'))
                                        <span class="errormsg">{{ $errors->first('local') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="direccion" class="col-sm-1 col-form-label">Dirección:</label>
                                <div class="col-sm-11">
                                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion', $sucursal->direccion)}}">
                                    @if ($errors->has('direccion'))
                                        <span class="errormsg">{{ $errors->first('direccion') }}</span>
                                    @endif
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Modificar" class="btn btn-success float-right modificarSucursal">
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
                                <li>{{ Session::has('message') }}</li>
                        </ul>
                    </div>
                @endif
                <!-- /Callback-->
            </div>
        </section>
        <!-- /.content -->
    </section>
@endsection
