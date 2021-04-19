@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Información Traspaso No. {{ $traspaso[0]->id_traspaso_inventario }}</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <div class="form-horizontal " id="formTraspaso">
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Información General</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h4>Usuario</h4>
                                        <p class="card-text">{{ $traspaso[0]->name }}</p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4>Fecha</h4>
                                        <p class="card-text">{{ $traspaso[0]->fecha_traspaso }}</p>
                                    </div>
                                    <div class="col-log-4">
                                        <h4>Estatus</h4>
                                        <p class="card-text">
                                            @if ($traspaso[0]->estatus == 0)
                                                Pendiente
                                            @elseif ($traspaso[0]->estatus == 2)
                                                Rechazado
                                            @else
                                                Aprovado
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <h4>Sucursal Salida</h4>
                                        <p class="card-text">
                                            {{ $traspaso[0]->sucursal_salida }}
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4>Sucursal Entrada</h4>
                                        <p class="card-text">
                                            {{ $traspaso[0]->sucursal_entrada }}
                                        </p>
                                    </div>
                                    <div class="col-lg-4">
                                        <h4>Cantidad</h4>
                                        <p class="card-text">
                                            {{ $traspaso[0]->total_productos }} pza(s).
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <h4>Razón/Motivo</h4>
                                        <p class="card-text">
                                            {{ $traspaso[0]->razon }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Artículos del Traspaso</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">UPC/EAN</th>
                                            <th scope="col">Título</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Marca</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Modelo</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Color</th>
                                            <th scope="col">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scroll" id="ticketTabla">
                                        @foreach ($detalle_traspaso as $detalle)
                                        <tr>
                                            <td><small>{{ $detalle->upc }}</small></td>
                                            <td><small>{{ $detalle->titulo_inventario }}</small></td>
                                            <td><small>{{ $detalle->categoria }}</small></td>
                                            <td><small>{{ $detalle->marca }}</small></td>
                                            <td><small>{{ $detalle->modelo }}</small></td>
                                            <td><small>{{ $detalle->color }}</small></td>
                                            <td><small>{{ $detalle->cantidad }}</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
@endsection
