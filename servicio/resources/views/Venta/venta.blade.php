@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Ventas</h1>
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
                        <input class="form-control" type="text" id="busqueda" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button id="buscar" class="btn btn-success">Buscar</button>
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
                    <h3 class="card-title">Ventas</h3>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-2">
                        <a id="agregarVenta" href='{{route("Venta.create")}}' class="btn btn-info">Agregar Venta <i class="far fa-plus-square"></i></a>

                    </div>
                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">Ticket</th>
                        <th>Usuario</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($ventas as $venta)
                        <tr class="items">
                            <td>{{$venta->id_venta}}</td>
                            <td>{{$venta->name}}</td>
                            <td>{{$venta->nombre_completo}}</td>
                            <td>{{$venta->fecha_venta}}</td>
                            <td>{{$venta->subtotal}}</td>
                            <td>{{$venta->iva}}</td>
                            <td>{{$venta->total}}</td>
                            <td><a href="#" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a></td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            {{ $ventas->onEachSide(5)->links('pagination::bootstrap-4') }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        var ventas = @json($ventas);
        var arr = [];
        arr = ventas;
        $("#busqueda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(getResult(value, ventas));
        });

        function getResult(filterBy, objList) {
            return objList.filter(function(obj) {
                return obj.some(function(item){
                    return item.indexOf(filterBy) >= 0;
                });
            });
        }
    </script>
@endsection

