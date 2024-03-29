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
                            <h3 class="card-title">Ventas</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a id="agregarVenta" href='{{ route('Venta.create') }}'
                                            class="btn btn-primary btn-sm">Agregar Venta <i class="far fa-plus-square"></i></a>
                                    </li>
                                </ul>
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
                                        <th colspan="2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                        <tr class="items">
                                            <td>{{ $venta->id_venta }}</td>
                                            <td>{{ $venta->name }}</td>
                                            <td>{{ $venta->nombre_completo }}</td>
                                            <td>{{ $venta->fecha_venta }}</td>
                                            <td>{{ $venta->subtotal }}</td>
                                            <td>{{ $venta->iva }}</td>
                                            <td>{{ $venta->total }}</td>
                                            <td>
                                                <!--<a href="#" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a>-->
                                                <a href="#" class="btn btn-success" id="imprimir" onclick="imprimirTicket($(this))"><i
                                                        class="fas fa-file-invoice-dollar"></i> Ticket</a>
                                                        <div class="spinner-border spinner-layer spinner-blue-only" role="status" id="loading" style="display:none">
                                        <span class="sr-only">Loading...</span>
</div>
                                            </td>
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
        console.log(ventas);
        $("#busqueda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(getResult(value, ventas));
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
        function imprimirTicket(venta) {

            id_venta = venta.parent().siblings().eq(0).text();
            Swal.mixin({
                input: 'text',
                confirmButtonText: 'Siguiente &rarr;',
                showCancelButton: true,
                cancelButtonText: 'Cancelar',
                progressSteps: ['1', '2']
            }).queue([{
                    title: 'Correo',
                    text: 'Introduce el correo con privilegios',
                    input: 'email'
                },
                {
                    title: 'Contraseña',
                    text: 'Introduce la contraseña del usuario',
                    input: 'password'
                },
            ]).then((result) => {
                if (result.value) {
                    const answers = {
                        'email': result.value[0],
                        'password': result.value[1]
                    };
                    $.ajax({
                        type: "post",
                        url: "{{ route('validarPermiso') }}",
                        data: answers,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },

                        success: function(data) {
                            console.log(data);
                            if (data == true || data == 1) {
                                $.ajax({
                                    type: "post",
                                    url: "{{ route('ReimprimirTicket') }}",
                                    data: {
                                        'id_venta': id_venta
                                    },
                                    headers: {
                                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                                    },
                                    beforeSend: function () {
                        $('#imprimir').hide();
                        $('#loading').show();
                         },
                                    success: function(data) {

                                        Toast.fire({
                                            icon: 'success',
                                            title: 'Imprimiendo ticket...'
                                        });
                                        $('#imprimir').show();
                                        $('#loading').hide();
                                    },
                                    error: function(data) {
                                        Toast.fire({
                                            icon: 'error',
                                            title: 'No se pudo imprimir el ticket!'
                                        })
                                        $('#imprimir').show();
                                        $('#loading').hide();
                                    }
                                });
                            } else {
                                Toast.fire({
                                    icon: 'error',
                                    title: 'No tiene los permisos para esta acción!'
                                })
                            }
                        },
                        error: function(data) {
                            Toast.fire({
                                icon: 'error',
                                title: 'No tiene los permisos para esta acción!'
                            })
                        }
                    });
                }
            })
        }

    </script>
@endsection
