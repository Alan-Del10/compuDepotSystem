@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Realizar Traspaso(s)</h1>
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
            <div class="form-horizontal " id="formTraspaso" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <section class="col-lg-8 connectedSortable">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Sucursales y Motivo</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="sucursal_salida" class="col-sm-3 col-form-label">Sucursal Salida</label>
                                    <div class="col-sm-3">
                                        <input type="text" list="sucursalSalidaData"
                                            class="form-control @error('sucursal_salida') is-invalid @enderror"
                                            id="sucursal_salida" name="sucursal_salida"
                                            value="{{ old('sucursal_salida') }}"
                                            placeholder="Seleccionar Sucursal Salida" />
                                        <datalist id="sucursalSalidaData">
                                            @foreach ($sucursales as $sucursal)
                                                <option value="{{ $sucursal->id_sucursal }} {{ $sucursal->sucursal }}">
                                                    {{ $sucursal->sucursal }}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <label for="sucursal_entrada" class="col-sm-3 col-form-label">Sucursal Entrada</label>
                                    <div class="col-sm-3 input-group">
                                        <input type="text" list="sucursalEntradaData"
                                            class="form-control @error('sucursal_entrada') is-invalid @enderror"
                                            id="sucursal_entrada" name="sucursal_entrada"
                                            value="{{ old('sucursal_entrada') }}"
                                            placeholder="Seleccionar Sucursal Entrada" />
                                        <datalist id="sucursalEntradaData">
                                            @foreach ($sucursales as $sucursal)
                                                <option value="{{ $sucursal->id_sucursal }} {{ $sucursal->sucursal }}">
                                                    {{ $sucursal->sucursal }}</option>
                                            @endforeach
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarSucursal"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row" id="mensajeSucursal" style="display:none">
                                    <div class="alert alert-success form-control">
                                        <ul>

                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="razon" class="col-sm-3 col-form-label">Razón/Motivo:</label>
                                    <div class="col-sm-9 input-group">
                                        <textarea name="razon" id="razon" rows="2" class="form-control"
                                            placeholder="Escribe la razón o motivo"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Inventario a Traspasar</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">Busqueda</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="number" class="form-control" name="busqueda" id="upc"
                                            placeholder="Busqueda por UPC/EAN de Inventario" minlength="12" maxlength="14"
                                            autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-warning fade show" style="display:none" id="alerta-upc">
                                        <strong>Ops!</strong> Este artículo no tiene stock o no existe en el inventario de
                                        tu sucursal seleccionada.
                                        <button type="button" id="boton-alerta" class="close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="ticket">
                                    <div class="col-12 alert alert-danger" id="mensajeTicket" style="display:none">
                                        <ul>
                                            <li>No tienes productos para traspasar!</li>
                                        </ul>
                                    </div>
                                    <table class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">UPC/EAN</th>
                                                <th scope="col">Título</th>
                                                <th scope="col" class="d-none d-lg-table-cell">Marca</th>
                                                <th scope="col" class="d-none d-lg-table-cell">Modelo</th>
                                                <th scope="col" class="d-none d-lg-table-cell">Color</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="scroll" id="ticketTabla">

                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <button id="editarTraspaso" type="button" class="btn btn-secondary" onclick="editarTraspaso()"
                                                disabled>Editar
                                                Traspaso</button>
                                            <button id="agregarTraspaso" type="button" class="btn btn-primary">Agregar
                                                Traspaso</button>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-4 connectedSortable">
                        <div class="card card-primary" name="pagos">
                            <div class="card-header">
                                <h3 class="card-title col-10">Lista de traspasos</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body scroll">
                                <div class="form-group row">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Sucursal Salida</th>
                                                <th scope="col">Sucursal Entrada</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col" colspan="2">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="scroll" id="listaTraspasos">

                                        </tbody>
                                    </table>
                                    <div class="col-12 alert alert-danger" id="mensajeListaTraspasos" style="display:none">
                                        <ul>
                                            <li>No tienes traspasos!</li>
                                        </ul>
                                    </div>
                                </div>
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
        let sucursales = @json($sucursales);
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
                $.ajax({
                    type: "get",
                    url: "{{ route('buscarInventarioSucursal') }}",
                    data: {
                        'upc': $(this).val(),
                        'sucursal': $('#sucursal_salida').val()
                    },
                    success: function(data) {
                        //console.log(data);
                        if (data.res == false) {
                            $('#alerta-upc').show();
                        } else {
                            $('#upc').val("");
                            cantidades = "";
                            for (let i = 1; i < data[0][0].stock + 1; i++) {
                                cantidades += '<option value="' + i + '">' + i + '</option>';
                            }
                            $('#ticketTabla').append(
                                '<tr>' +
                                '<td scope="row" id="upc_art"><small>' + data[0][0].upc +
                                '</small></td>' +
                                '<td id="titulo_art"><small>' + data[0][0].titulo_inventario + '</small></td>' +
                                '<td id="marca_art" class="d-none d-lg-table-cell"><small>' + data[0][0].marca +
                                '</small></td>' +
                                '<td id="modelo_art" class="d-none d-lg-table-cell"><small>' + data[0][0].modelo +
                                '</small></td>' +
                                '<td id="color_art" class="d-none d-lg-table-cell"><small>' + data[0][0].color +
                                '</small></td>' +
                                '<td>' +
                                '<select id="cantidad" class="form-control form-control-sm">' +
                                cantidades +
                                '</select>' +
                                '</td>' +
                                '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarFila($(this))"><i class="far fa-trash-alt"></i></a></td>' +
                                '</tr>'
                            );
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                    }
                });
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
        //Función que quita productos del ticket
        function quitarFila(elem) {
            elem.parent().parent().remove();
        }
        //Función que quita los traspasos de la lista
        function quitarFilaTraspasos(elem) {
            if(indexArray != null && seleccionado != null){
                indexArray = null;
                seleccionado = null;
                $('#editarTraspaso').attr('disabled', true);
                $('#agregarTraspaso').attr('disabled', false);
            }
            indexArray = elem.parent().parent().index();
            elem.parent().parent().remove();
            listaTraspasos.splice(indexArray, 1);
            $.each($('#listaTraspasos').children(), function(i, v) {
                $(this).find('#index small').text(i + 1);
            });
        }
        //Función que muestra los artículos a traspasar a la lista de ticket par editar el traspaso
        function editarListaTraspasos(elem) {
            elem.attr('disabled', true);
            $('#agregarTraspaso').attr('disabled', true);
            $('#editarTraspaso').attr('disabled', false);
            elem.parent().parent().addClass('table-info');
            seleccionado = elem;
            indexArray = elem.parent().parent().index();
            $('#razon').val(listaTraspasos[indexArray].razon);
            $.each(sucursales, function(i, v) {
                sucursal_valor = v.id_sucursal+" "+v.sucursal;
                if (parseInt(v.id_sucursal) == parseInt(listaTraspasos[indexArray].sucursal_salida)) {
                    $('#sucursal_salida').val(sucursal_valor);
                }
                if (parseInt(v.id_sucursal) == parseInt(listaTraspasos[indexArray].sucursal_entrada)) {
                    $('#sucursal_entrada').val(v.id_sucursal+' '+v.sucursal);
                }
            });
            $.each(listaTraspasos[indexArray]['inventario'], function(i, value) {
                cantidades_editar = "";
                for (let i = 1; i < parseInt(value.cantidad_disponible) + 1; i++) {
                    if(i == value.cantidad){
                        cantidades_editar += '<option value="' + i + '" selected>' + i + '</option>';
                    }else{
                        cantidades_editar += '<option value="' + i + '">' + i + '</option>';
                    }
                }
                $('#ticketTabla').append(
                    '<tr>' +
                    '<td scope="row" id="upc_art"><small>' + value.upc +
                    '</small></td>' +
                    '<td id="titulo_art"><small>' + value.titulo + '</small></td>' +
                    '<td id="marca_art" class="d-none d-lg-table-cell"><small>' + value.marca +
                    '</small></td>' +
                    '<td id="modelo_art" class="d-none d-lg-table-cell"><small>' + value.modelo +
                    '</small></td>' +
                    '<td id="color_art" class="d-none d-lg-table-cell"><small>' + value.color +
                    '</small></td>' +
                    '<td>' +
                    '<select id="cantidad" class="form-control form-control-sm">' +
                        cantidades_editar +
                    '</select>' +
                    '</td>' +
                    '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarFila($(this))"><i class="far fa-trash-alt"></i></a></td>' +
                    '</tr>'
                );
            });
        }
        //Función que edita el traspaso seleccionado anteriormente
        function editarTraspaso(){
            if ($('#ticketTabla').children().length > 0) {
                total_inventario = 0;
                pos_salida = $('#sucursal_salida').val().indexOf(" ");
                id_salida = $('#sucursal_salida').val().substring(0, pos_salida);
                salida = $('#sucursal_salida').val().substring(pos_salida, $('#sucursal_salida').val().length);
                pos_entrada = $('#sucursal_entrada').val().indexOf(" ");
                id_entrada = $('#sucursal_entrada').val().substring(0, pos_entrada);
                entrada = $('#sucursal_entrada').val().substring(pos_entrada, $('#sucursal_entrada').val().length);
                listaTraspasos[indexArray]['inventario'].splice(0, listaTraspasos[indexArray]['inventario'].length);
                $.each($('#ticketTabla').children(), function(i, v) {
                    listaTraspasos[indexArray]['inventario'].push({
                        'upc': $(this).find('#upc_art').text(),
                        'cantidad': $(this).find('#cantidad').val(),
                        'titulo' : $(this).find('#titulo_art').text(),
                        'marca' : $(this).find('#marca_art').text(),
                        'modelo' : $(this).find('#modelo_art').text(),
                        'color' : $(this).find('#color_art').text(),
                        'cantidad_disponible' : $(this).find('#cantidad option:last').val()
                    });
                    total_inventario += parseInt($(this).find('#cantidad').val());
                });
                $.each($('#listaTraspasos').children(), function(i, v){
                    if($(this).index() == indexArray){
                        $(this).children().eq(1).children().text(salida);
                        $(this).children().eq(2).children().text(entrada);
                        $(this).children().eq(3).children().text(total_inventario);
                        $(this).children().eq(4).children().attr('disabled', false);
                    }
                });
                listaTraspasos[indexArray].sucursal_salida = id_salida;
                listaTraspasos[indexArray].sucursal_entrada = id_entrada;
                listaTraspasos[indexArray].cantidad = total_inventario;
                listaTraspasos[indexArray].razon = $('#razon').val();
                seleccionado.parent().parent().removeClass('table-info');
                console.log(listaTraspasos[indexArray]);
                indexArray = null;
                seleccionado = null;
                $('#editarTraspaso').attr('disabled', true);
                $('#agregarTraspaso').attr('disabled', false);
                $('#ticketTabla').children().remove();
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No tines productos en la tabla de Inventario a Traspasar'
                })
            }
        }
        //Función para agregar un traspaso a la lista de traspasos
        $('#agregarTraspaso').on('click', function() {
            if ($('#ticketTabla').children().length > 0) {
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
                        'titulo' : $(this).find('#titulo_art').text(),
                        'marca' : $(this).find('#marca_art').text(),
                        'modelo' : $(this).find('#modelo_art').text(),
                        'color' : $(this).find('#color_art').text(),
                        'cantidad_disponible' : $(this).find('#cantidad option:last').val()
                    });
                    total_inventario += parseInt($(this).find('#cantidad').val());
                });
                datos_generales.cantidad = total_inventario;
                listaTraspasos.push(datos_generales);
                $('#ticketTabla').children().remove();
                $('#listaTraspasos').append(
                    '<tr>' +
                    '<td scope="row" id="index"><small>' + listaTraspasos.length +
                    '</small></td>' +
                    '<td scope="row"><small>' + salida +
                    '</small></td>' +
                    '<td scope="row"><small>' + entrada +
                    '</small></td>' +
                    '<td scope="row"><small>' + datos_generales.cantidad +
                    '</small></td>' +
                    '<td><button type="submit" class="btn btn-sm btn-primary" onclick="editarListaTraspasos($(this))"><i class="fas fa-edit"></i></button></td>' +
                    '<td><a href="#" class="btn btn-sm btn-danger" onclick="quitarFilaTraspasos($(this))"><i class="far fa-trash-alt"></i></a></td>' +
                    '</tr>'
                );
            } else {
                Toast.fire({
                    icon: 'info',
                    title: 'No tines productos en la tabla de Inventario a Traspasar'
                })
            }

        });
        //Función que limpia el formulario
        function limpiarFormulario() {
            $('#sucursal_salida').val("");
            $('#sucursal_entrada').val("");
            $('#razon').val("");
            $('#ticketTabla').children().remove();
            $('#listaTraspasos').children().remove();
            $('#mensajeTraspaso').find('#errores').remove();
        }
        //Función que envía el formulario al controlador
        function finalizarTraspaso() {
            $('#mensajeTraspaso').hide();
            $('#mensajeTraspaso').find('#errores').remove();
            listaTraspasosValidacion = true;
            if (listaTraspasos.length == 0) {
                $('#listaTraspasos').addClass('is-invalid');
                listaTraspasosValidacion = false;
            } else {
                $('#listaTraspasos').removeClass('is-invalid');
                listaTraspasosValidacion = true;
            }
            if (listaTraspasosValidacion == true) {
                console.log(listaTraspasos);
                $.ajax({
                    type: "post",
                    url: "{{ route('TraspasoInventario.store') }}",
                    data: {
                        'traspasos': listaTraspasos
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        if (response[0].response == "success") {
                            limpiarFormulario();
                            listaTraspasos = [];
                            indexArray = null;
                            seleccionado = null;
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
