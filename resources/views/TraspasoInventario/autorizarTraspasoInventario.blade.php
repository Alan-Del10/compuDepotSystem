@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Autorizar Traspaso No. {{ $traspaso[0]->id_traspaso_inventario }}</h1>
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
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">Lectura de Productos</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="number" class="form-control" name="busqueda" id="upc"
                                            placeholder="Busqueda por UPC/EAN de Inventario" minlength="12" maxlength="14"
                                            autofocus>
                                    </div>
                                </div>
                                <hr>
                                <table class="table table-bordered table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">UPC/EAN</th>
                                            <th scope="col">Título</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Categoria</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Marca</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Modelo</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Color</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col" colspan="2">Cantidad Recibida</th>
                                        </tr>
                                    </thead>
                                    <tbody class="scroll" id="ticketTabla">
                                        @foreach ($detalle_traspaso as $detalle)
                                            <tr>
                                                <td id="upc_art"><small>{{ $detalle->upc }}</small></td>
                                                <td><small>{{ $detalle->titulo_inventario }}</small></td>
                                                <td class="d-none d-lg-table-cell">
                                                    <small>{{ $detalle->categoria }}</small>
                                                </td>
                                                <td class="d-none d-lg-table-cell"><small>{{ $detalle->marca }}</small>
                                                </td>
                                                <td class="d-none d-lg-table-cell"><small>{{ $detalle->modelo }}</small>
                                                </td>
                                                <td class="d-none d-lg-table-cell"><small>{{ $detalle->color }}</small>
                                                </td>
                                                <td><small>{{ $detalle->cantidad }}</small></td>
                                                <td>
                                                    <input type="number" name="cantidad_comprobada" id="cantidad_comprobada"
                                                        class="form-control form-control-sm cantidad_comprobada"
                                                        oninput="validity.valid||(value='');"
                                                        placeholder="Cantidad Recibida" disabled>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-success" name="finalizar">
                            <div class="card-header">
                                <h3 class="card-title col-11">Finalizar</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-input row">
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="checkFinalizar"
                                                name="checkFinalizar" onclick="checkFinalizarTraspaso()">
                                            <label class="form-check-label" for="checkFinalizar">Finalizar Traspaso</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="submit" value="Rechazar Traspaso" class="btn btn-danger float-right"
                                            id="rechazarTraspaso" onclick="rechazarTraspaso()">
                                        <input type="submit" value="Realizar Traspaso" class="btn btn-success float-right"
                                            disabled id="finalizarTraspaso" onclick="finalizarTraspaso()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.card-footer -->
                </div>
            </div>
            <div class="alert" id="mensajeTraspaso" style="display:none">
                <ul>
                    Traspaso realizado correctamente!
                </ul>
            </div>
        </div>

    </section>
    <!-- Callback-->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (Session::has('success'))
        <div class="alert alert-success">
            <ul>
                {{ Session::get('success') }}
            </ul>
        </div>
    @endif
    <script>
        let listaTraspasos = [];
        let seleccionado = null;
        let indexArray = null;
        let infoTraspao = @json($traspaso);
        let detalle_traspaso = @json($detalle_traspaso);
        //Configuración de notificaciones pequeñas
        const Toast = Swal.mixin({
            toast: true,
            //position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        //Función para detectar cunado se ingrese un UPC
        $('#upc').on('input', function() {
            upc = $(this).val();
            upc = upc.toString();
            if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);
            if (upc.length == 12 || upc.length == 13 || upc.length == 14) {
                $.each($('#ticketTabla').children(), function(i, v) {
                    fila = $(this);
                    if (fila.find('#upc_art').text() == upc) {
                        seleccionado = upc;
                        $('#upc').attr('disabled', true);
                        fila.find('#cantidad_comprobada').attr('disabled', false);
                        fila.find('#cantidad_comprobada').focus();
                    }
                });
            }
        });
        //Función para comprobar la cantidad recibida del traspaso
        $('.cantidad_comprobada').on('keyup', function(e) {
            fila = $(this);
            if (e.keyCode === 13) {
                fila.attr('disabled', true);
                $('#upc').attr('disabled', false);
                $('#upc').val("");
                e.preventDefault();
                $.each(detalle_traspaso, function(i, v) {
                    if (v['upc'] == seleccionado) {
                        if (fila.val() == 0 || fila.val() == null) {
                            fila.parent().parent().removeClass('table-success').removeClass('table-primary')
                                .removeClass('table-warning');
                        } else if (fila.val() < v['cantidad']) {
                            fila.parent().parent().removeClass('table-success').removeClass('table-primary')
                                .addClass('table-warning');
                        } else if (fila.val() > v['cantidad']) {
                            fila.parent().parent().removeClass('table-warning').removeClass('table-success')
                                .addClass('table-primary');
                        } else {
                            fila.parent().parent().removeClass('table-warning').removeClass('table-primary')
                                .addClass('table-success');
                        }
                    }
                });
                seleccionado = null;
            }
        });
        //Función para habílitar el botón que envía los datos el controlador
        function checkFinalizarTraspaso() {
            var checkBox = document.getElementById("checkFinalizar");
            if (checkBox.checked == true) {
                $('#finalizarTraspaso').attr('disabled', false);
            } else {
                $('#finalizarTraspaso').attr('disabled', true);
            }
        }
        //Función que envía el formulario al controlador
        function finalizarTraspaso() {
            $('#mensajeTraspaso').hide();
            $('#mensajeTraspaso').find('#errores').remove();
            listaTraspasosValidacion = [];
            $.each($('#ticketTabla').children(), function(i, v) {
                filaTicket = $(this);
                $.each(detalle_traspaso, function(x, e) {
                    if (filaTicket.find('#upc_art').text() == e['upc']) {
                        if (filaTicket.find('#cantidad_comprobada').val()) {
                            detalle_traspaso[i]['cantidad_comprobada'] = filaTicket.find(
                                '#cantidad_comprobada').val();
                        } else {
                            listaTraspasosValidacion.push(e);
                        }
                    }
                });
            });
            if (listaTraspasosValidacion.length > 0) {
                Swal.fire({
                    title: 'Tienes productos sin cantidad comprobada, deseas continuar?',
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: `Sí`,
                    denyButtonText: `No`,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        traspasar();
                    } else if (result.isDenied) {
                        $.each($('#ticketTabla').children(), function(i, v) {
                            $.each(listaTraspasosValidacion, function(x, e) {

                            });
                        });
                    }
                })
            } else if (listaTraspasosValidacion.length == 0) {
                traspasar();
            }
        }
        //Función que manda a llamar el rechazo del traspaso
        function rechazarTraspaso() {
            Swal.fire({
                title: 'Seguro que quieres rechazar el traspaso?, una vez rechazado ya no se podrá aprobar.',
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: `Sí`,
                denyButtonText: `No`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajax({
                        type: "post",
                        url: "{{ route('autorizarTraspasoSucursal') }}",
                        data: {
                            'traspaso': infoTraspao,
                            'detalle_traspaso': detalle_traspaso,
                            'estatus': 2
                        },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            console.log(response);
                            $('#finalizarTraspaso').attr('disabled', true);
                            $('#rechazarTraspaso').attr('disabled', true);
                            $('#upc').attr('disabled', true);
                            if (response[0].response == "success") {
                                Toast.fire({
                                    icon: 'success',
                                    title: response[0].message
                                })
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response[0].message
                                })
                            }
                        },
                        error: function(e) {
                            console.log(e);
                            Swal.fire({
                                html: e.responseText
                            })
                        }
                    });
                }
            })

        }
        //Función con la petición AJAX para realizar el traspaso
        function traspasar() {
            $.ajax({
                type: "post",
                url: "{{ route('autorizarTraspasoSucursal') }}",
                data: {
                    'traspaso': infoTraspao,
                    'detalle_traspaso': detalle_traspaso,
                    'estatus': 1
                },
                dataType: 'JSON',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(response) {
                    console.log(response);
                    $('#finalizarTraspaso').attr('disabled', true);
                    $('#rechazarTraspaso').attr('disabled', true);
                    $('#upc').attr('disabled', true);
                    if (response[0].response == "success") {
                        Toast.fire({
                            icon: 'success',
                            title: response[0].message
                        })
                    } else {
                        Toast.fire({
                            icon: 'warning',
                            title: response[0].message
                        })
                        /*$('#mensajeTraspaso ul').text(response[0].message);*/
                        $('#mensajeTraspaso').removeClass('alert-success').addClass('alert-danger');
                        /*response[1][0].forEach(element => {
                            $.each($('#listaTraspasos').children(), function(i, v) {
                                if ($(this).index() == element[0].index) {
                                    $(this).addClass('table-warning');
                                } else {
                                    $(this).remove();
                                }
                            });
                            $.each($('#listaTraspasos').children(), function(i, v) {
                                $(this).find('#index small').text(i + 1);
                            });
                            $('#mensajeTraspaso').append(
                                '<ul id="errores">' +
                                '<li>Error en el traspaso #' + parseInt(element[0].index + 1) +
                                '. ' + element[0].error + '</li>' +
                                '</ul>'
                            )
                        });*/
                        //$('#mensajeTraspaso').show();
                    }

                },
                error: function(e) {
                    console.log(e);
                    Swal.fire({
                        html: e.responseText
                    })
                }
            });
        }

    </script>
@endsection
