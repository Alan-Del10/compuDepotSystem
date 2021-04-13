@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Traspasos</h1>
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
                            <h3 class="card-title">Traspasos</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a id="agregarVenta" href='{{ route('TraspasoInventario.create') }}'
                                            class="btn btn-primary btn-sm">Realizar Traspaso de inventario <i
                                                class="far fa-plus-square"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">ID</th>
                                        <th>Usuario</th>
                                        <th>Sucursal Salida</th>
                                        <th>Sucursal Entrada</th>
                                        <th>Cantidad</th>
                                        <th>Fecha Alta</th>
                                        <th>Estatus</th>
                                        @if (Auth::guard('admin')->check() || Auth::guard('sub_admin')->check() || Auth::guard('root')->check() || Auth::guard('almacenista')->check())
                                            <th scope="col" colspan="4">Acciones</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($traspasos as $traspaso)
                                        <tr class="items">
                                            <td>{{ $traspaso->id_traspaso_inventario }}</td>
                                            <td>{{ $traspaso->name }}</td>
                                            <td>{{ $traspaso->sucursal_salida }}</td>
                                            <td>{{ $traspaso->sucursal_entrada }}</td>
                                            <td>{{ $traspaso->total_productos }}</td>
                                            <td>{{ $traspaso->fecha_traspaso }}</td>
                                            <td>
                                                @if ($traspaso->estatus == 0)
                                                    Pendiente
                                                @elseif ($traspaso->estatus == 2)
                                                    Rechazado
                                                @else
                                                    Aprovado
                                                @endif
                                            </td>
                                            @if (Auth::guard('admin')->check() || Auth::guard('sub_admin')->check() || Auth::guard('root')->check() || Auth::guard('almacenista')->check())
                                                <td><a href="{{ route('detalleTraspasoSucursal',  ['id_traspaso_inventario' => $traspaso->id_traspaso_inventario]) }}"
                                                        class="btn btn-info"><i class="fas fa-info-circle"></i></a></td>
                                                <td><a href="{{ route('TraspasoInventario.edit',$traspaso->id_traspaso_inventario) }}"
                                                        class="btn btn-primary {{ $traspaso->estatus != 1 ?: 'disabled' }}"><i
                                                            class="far fa-edit"></i></a></td>
                                                <td><a href="{{ route('checklistAutorizarTraspaso', ['id_traspaso_inventario' => $traspaso->id_traspaso_inventario]) }}"
                                                        class="btn btn-success {{ $traspaso->estatus != 2 && $traspaso->estatus == 1 ? 'disabled' : '' }}"><i
                                                            class="fas fa-thumbs-up"></i></a></td>
                                            @endif
                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                    {{ $traspasos->onEachSide(5)->links('pagination::bootstrap-4') }}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->
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
                    {{ Session::get('success') }}
                </ul>
            </div>
        @endif
    </section>
    <!-- /.content -->
    <script>
        var traspasos = @json($traspasos);
        var arr = [];
        arr = traspasos;
        console.log(traspasos);
        $("#busqueda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(getResult(value, traspasos));
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
                return obj.some(function(item) {
                    return item.indexOf(filterBy) >= 0;
                });
            });
        }
        //Esta función nos permite reimprimir los tickets de las ventas con autorización de algún superior
        function autorizarTraspaso(id, estatus) {
            $.ajax({
                type: "post",
                url: "{{ route('autorizarTraspasoSucursal') }}",
                data: {
                    'id_traspaso_inventario': id,
                    'estatus': estatus
                },
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    console.log(data);
                },
                error: function(data) {
                    Toast.fire({
                        icon: 'error',
                        title: 'No tiene los permisos para esta acción!'
                    })
                }
            });
        }

    </script>
@endsection
