@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Agregar Cliente</h1>
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
                        <h3 class="card-title">Cliente</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="card-body">
                        <div class="form-group row">
                            <label for="nombre" class="col-sm-2 col-form-label">Nombre Completo</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="nombre" placeholder="Nombre del cliente">
                            </div>
                            <label for="telefono" class="col-sm-1 col-form-label">Teléfono</label>
                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="telefono" placeholder="Teléfono">
                            </div>
                            <div class="col-sm-1"></div>
                            <div class="col-sm-2">
                                <input type="checkbox" class="form-check-input" id="whatsapp">
                                <label class="form-check-label" for="whatsapp">Tiene Whatsapp?</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correo" class="col-sm-2 col-form-label">Correo</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="correo" placeholder="Correo">
                            </div>
                            <label for="direccion" class="col-sm-1 col-form-label">Dirección</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="direccion" placeholder="Dirección (Opcional)">
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="form-group row mb-0">
                            <div class="col-sm-4 co-form-label">
                                <button type="submit" class="btn btn-primary" id="registrar">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </section>
    <script>
        $('#registrar').on('click', function(){
            Swal.fire(
                'Listo!',
                'El cliente ha sido registrado!',
                'success'
            )
        });
    </script>
@endsection



