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
                                            <th scope="col">Categoria</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Marca</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Modelo</th>
                                            <th scope="col" class="d-none d-lg-table-cell">Color</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Cantidad Entregada</th>
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
                                                <td><input type="number" name="cantidad_comprobada" id="cantidad_comprobada" class="form-control form-control-sm"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
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

            } else {

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
            listaTraspasosValidacion = true;
            total_inventario = 0;
            pos_salida = $('#sucursal_salida').val().indexOf(" ");
            id_salida = $('#sucursal_salida').val().substring(0, pos_salida);
            salida = $('#sucursal_salida').val().substring(pos_salida, $('#sucursal_salida').val().length);
            pos_entrada = $('#sucursal_entrada').val().indexOf(" ");
            id_entrada = $('#sucursal_entrada').val().substring(0, pos_entrada);
            entrada = $('#sucursal_entrada').val().substring(pos_entrada, $('#sucursal_entrada').val().length);
            datos_generales = {
                'sucursal_salida': id_salida,
                'sucursal_entrada': id_entrada,
                'razon': $('#razon').val(),
                'cantidad': 0,
                'inventario': []
            };
            $.each($('#ticketTabla').children(), function(i, v) {
                datos_generales['inventario'].push({
                    'upc': $(this).find('#upc_art').text(),
                    'cantidad': $(this).find('#cantidad').val(),
                    'titulo': $(this).find('#titulo_art').text(),
                    'marca': $(this).find('#marca_art').text(),
                    'modelo': $(this).find('#modelo_art').text(),
                    'color': $(this).find('#color_art').text(),
                    'cantidad_disponible': $(this).find('#cantidad option:last').val()
                });
                total_inventario += parseInt($(this).find('#cantidad').val());
            });
            datos_generales.cantidad = total_inventario;
            if (datos_generales.length == 0) {
                $('#listaTraspasos').addClass('is-invalid');
                listaTraspasosValidacion = false;
            } else {
                $('#listaTraspasos').removeClass('is-invalid');
                listaTraspasosValidacion = true;
            }
            if (listaTraspasosValidacion == true) {
                $.ajax({
                    type: "post",
                    url: "{{ route('autorizarTraspasoSucursal') }}",
                    data: datos_generales,
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        if (response[0].response == "success") {
                            $('#mensajeTraspaso ul').text(response[0].message);
                            $('#mensajeTraspaso').removeClass('alert-danger').addClass('alert-success');
                            $('#mensajeTraspaso').show();
                        } else {
                            $('#mensajeTraspaso ul').text(response[0].message);
                            $('#mensajeTraspaso').removeClass('alert-success').addClass('alert-danger');
                            response[1]['traspaso_invalido'].forEach(element => {
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
                            });
                            $('#mensajeTraspaso').show();
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
        }

    </script>
@endsection
