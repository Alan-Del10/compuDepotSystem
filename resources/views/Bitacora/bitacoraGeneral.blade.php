@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Logs</h1>
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
                    <h3 class="card-title">Logs Generales</h3>
                    </div>
                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Fecha</th>
                        <th>Descripción</th>
                        <th>Usuario</th>
                        <th>Sucursal</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr class="items">
                            <td>{{$log->id_logs}}</td>
                            <td>{{$log->fecha_log_general}}</td>
                            <td>{{$log->descripcion_log_general}}</td>
                            <td>{{$log->name}}</td>
                            <td>{{$log->sucursal}}</td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            {{ $logs->links('pagination::bootstrap-4') }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        var logs = @json($logs);
        var arr = [];
        arr = logs;
        $("#busqueda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(getResult(value, logs));
        });
        //Configuración de las notificaciones pequeñas o personalizadas
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        function getResult(filterBy, objList) {
            return objList.filter(function(obj) {
                return obj.some(function(item){
                    return item.indexOf(filterBy) >= 0;
                });
            });
        }
    </script>
@endsection

