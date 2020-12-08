@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Estatus Servicio</h1>
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
                <div class="col-md-4">
                    <div class="card bg-info">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-4">
                                    <h3 class="card-title">Datos Entrada</h3>
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="">ID: {{$id}}</label>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="">Tipo servicio: {{$servicios[0]->tipo_servicio}}</label>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="">Fecha entrada: {{$servicios[0]->fecha_servicio}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-4">
                                    <h3 class="card-title">Datos Equipo</h3>
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="">Estatus actual: {{$servicios[0]->estatus}}</label>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="">Marca: {{$servicios[0]->marca}}</label>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label for="">Modelo: {{$servicios[0]->modelo}}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-4">
                                    <h3 class="card-title">Datos Cliente</h3>
                                </div>
                                <div class="col-6">
                                </div>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label>Cliente: {{$servicios[0]->nombre_completo}}</label>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label>Teléfono: {{$servicios[0]->telefono}}</label>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col-12">
                                <label>Cliente: {{$servicios[0]->nombre_completo}}</label>
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
                    <h3 class="card-title">Seguimiento</h3>
                    </div>
                    <div class="col-6">
                    </div>
                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Empleado</th>
                            <th>Estatus</th>
                            <th style="width: 50%;">Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if(count($seguimientos) > 0)
                        @foreach($seguimientos as $seguimiento)
                            <tr>
                                <td>{{$seguimiento->fecha_registro}}</td>
                                <td>{{$seguimiento->id_empleado}}</td>
                                <td>{{$seguimiento->descripcion}}</td>
                                <td>{{$seguimiento->notas}}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>
                                <b>No existe ningun segumiento del servicio</b>
                            </td>
                        </tr>
                    @endif
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


