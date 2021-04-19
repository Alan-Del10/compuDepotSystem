@extends('layouts.app')
@section('content')
<section class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Cambiar Configuración</h1>
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
                    <h3 class="card-title">Configuración</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <div class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="cliente" class="col-sm-1 col-form-label">Logo actual:</label>
                            <div class="col-sm-2">
                                <img src="{{asset('storage/img/logo.png')}}" alt="AdminLTE Logo" width="120" height="80" class="card-img-top bg-gradient-secondary">
                            </div>
                            <div class="col-sm-3"></div>
                            <label for="cliente" class="col-sm-2 col-form-label">Nombre actual: </label>
                            <p class="col-sm-4 col-form-label">{{ config('app.name') }}</p>
                        </div>
                        <div class="form-group row">
                            <label for="cliente" class="col-sm-1 col-form-label">Nuevo logo:</label>
                            <div class="col-sm-4">
                                <form action="{{route('cambiarLogoAplicacion')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="logoAplicacion" id="logoAplicacion" class="form-control-file" accept="image/png">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success float-right" id="logo">Guardar Logotipo </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-1"></div>
                            <label class="col-sm-2 col-form-label">Nuevo nombre:</label>
                            <div class="col-sm-4">
                                <form action="{{route('cambiarNombreAplicacion')}}" method="post">
                                    @csrf
                                    <input type="text" name="nombreAplicacion" id="nombreAplicacion" class="form-control">
                                    <div class="card-body">
                                        <button type="submit" class="btn btn-success float-right" id="nombre">Guardar Nombre </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="cliente" class="col-sm-1 col-form-label">Host actual: </label>
                            <p for="cliente" class="col-sm-2 col-form-label">{{ env('MAIL_HOST') }}</p>
                            <label for="cliente" class="col-sm-1 col-form-label">Puerto actual: </label>
                            <p for="cliente" class="col-sm-2 col-form-label">{{ env('MAIL_PORT') }}</p>
                            <label for="cliente" class="col-sm-1 col-form-label">Usuario actual: </label>
                            <p for="cliente" class="col-sm-2 col-form-label">{{ env('MAIL_USERNAME') }}</p>
                            <label for="cliente" class="col-sm-1 col-form-label">Password actual: </label>
                            <p for="cliente" class="col-sm-2 col-form-label">{{ env('MAIL_PASSWORD') }}</p>
                        </div>
                        <form action="{{route('cambiarSMTPAplicacion')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-1 col-form-label">Nuevo host:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="host" id="host" class="form-control">
                                </div>
                                <label class="col-sm-1 col-form-label">Nuevo puerto:</label>
                                <div class="col-sm-2">
                                    <input type="number" name="puerto" id="puerto" class="form-control">
                                </div>
                                <label class="col-sm-1 col-form-label">Nuevo usuario:</label>
                                <div class="col-sm-2">
                                    <input type="text" name="usuario" id="usuario" class="form-control">
                                </div>
                                <label class="col-sm-1 col-form-label">Nuevo password:</label>
                                <div class="col-sm-2">
                                    <input type="password" name="password" id="password" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success float-right" id="correo">Guardar configuración de correo </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>
@endsection
