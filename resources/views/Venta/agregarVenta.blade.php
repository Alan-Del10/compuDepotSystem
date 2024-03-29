@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Realizar Venta</h1>
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
            <div action="{{route('Venta.store')}}" method="POST" class="form-horizontal " id="formVenta" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Cliente</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="cliente" class="col-sm-2 col-form-label">Nombre Cliente</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="clienteData" class="form-control @error('cliente') is-invalid @enderror" id="cliente" name="cliente" value="{{old('cliente')}}" placeholder="Seleccionar Cliente"/>
                                        <datalist id="clienteData">
                                            @foreach ($clientes as $cliente)
                                            <option value="{{$cliente->id_cliente}} {{$cliente->nombre_completo}}">{{$cliente->nombre_completo}}</option>
                                            @endforeach
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="habilitarFormCliente"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <label for="usuario_cliente" class="col-sm-2 col-form-label">¿De quién es cliente?</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="usuarioClienteData" class="form-control @error('usuario_cliente') is-invalid @enderror" id="usuario_cliente" name="usuario_cliente" value="{{old('usuario_cliente')}}" placeholder="Seleccionar Cliente"/>
                                        <datalist id="usuarioClienteData">
                                            @foreach ($usuarios as $usuario)
                                            <option value="{{$usuario->id}} {{$usuario->name}}">{{$usuario->name}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                </div>
                                <div class="form-group row" id="mensajeCliente" style="display:none">
                                    <div class="alert alert-success form-control">
                                        <ul>

                                        </ul>
                                    </div>
                                </div>
                                <div id="formCliente" style="display: none">
                                    <hr>
                                    <div class="form-group row">
                                        <label for="nombre" class="col-sm-3 col-form-label">Nombre Completo</label>
                                        <div class="col-sm-3 input-group">
                                            <input type="text" class="form-control" id="nombre" placeholder="Nombre Completo"/>
                                        </div>
                                        <label for="telefono" class="col-sm-2 col-form-label">Teléfono</label>
                                        <div class="col-10 col-sm-3 input-group">
                                            <input type="number" class="form-control" id="telefono" minlength="7" maxlength="10" placeholder="Teléfono"/>
                                        </div>
                                        <div class="col-2 col-sm-1">
                                            <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" id="checkWhatsapp" onclick="checkWhatsapp()" checked>
                                                <label class="form-check-label" for="checkWhatsapp"><i class="fab fa-whatsapp"></i></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="correo" class="col-sm-3 col-form-label">Correo</label>
                                        <div class="col-sm-3 input-group">
                                            <input type="email" class="form-control" id="correo" placeholder="Correo electrónico"/>
                                        </div>
                                        <label for="tipo_cliente" class="col-sm-2 col-form-label">Tipo Cliente</label>
                                        <div class="col-sm-4 input-group">
                                            <select id="tipo_cliente" class="form-control">
                                                @foreach($tipos_clientes as $tipo_cliente)
                                                    <option value="{{$tipo_cliente->id_tipo_cliente}}">{{$tipo_cliente->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <input type="button" class="btn btn-success form-control" onclick="agregarCliente()" value="Agregar Cliente">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Ticket</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">Busqueda</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="number" class="form-control" name="busqueda" id="upc" placeholder="Busqueda por UPC/EAN de Inventario" minlength="12" maxlength="14" autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-warning fade show" style="display:none" id="alerta-upc">
                                        <strong>Ops!</strong> Este artículo no tiene stock o no existe.
                                        <button type="button" id="boton-alerta" class="close">
                                            <span >&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="ticket">
                                    <div class="col-12 alert alert-danger" id="mensajeTicket" style="display:none">
                                        <ul>
                                            <li>No tienes productos en el ticket!</li>
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
                                                <th scope="col">Precio</th>
                                                <th scope="col">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody class="scroll" id="ticketTabla">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-5 connectedSortable">
                        <div class="card card-warning" name="pagos">
                            <div class="card-header">
                                <h3 class="card-title col-10">Formas de pago</h3>
                                <button type="button" class="btn btn-secondary" id="agregarFormaPago"><i class="fas fa-plus"></i></button>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body scroll" id="formaPago">
                                <div class="form-group row">
                                    <div class="col-12 alert alert-danger" id="mensajeFormas" style="display:none">
                                        <ul>
                                            <li>No tienes formas de pago para realizar esta venta!</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-danger" id="mensajeTotalFormas" style="display:none">
                                        <ul>
                                            <li>Tu total de venta es mayor al total de pagos!</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="form-group row agregado" id="agregado">
                                    <label for="forma" class="col-sm-2 col-form-label">Forma</label>
                                    <div class="col-sm-4">
                                        <input type="text" list="formaData" class="form-control" id="forma" name="formas_pago[][forma]" placeholder="Forma">
                                        <datalist id="formaData">
                                            @foreach ($formas_pago as $forma)
                                            <option value="{{$forma->forma_pago}}">{{$forma->forma_pago}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <label for="pago" class="col-sm-2 col-form-label">Pago</label>
                                    <div class="col-sm-4 input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="number" class="form-control vida" id="pago" step="0.01" name="formas_pago[][pago]" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 46 && event.charCode <= 57" placeholder="Cantidad">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="row">
                            <div class="col-6 col-sm-4">
                                <div class="card card-danger" name="subtotal">
                                    <div class="card-header">
                                        <h3 class="card-title col-10">Subtotal</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body" id="subtotal">
                                        <h2>$0</h2>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="col-6 col-sm-4">
                                <div class="card card-dark" name="iva">
                                    <div class="card-header">
                                        <h3 class="card-title col-10">IVA</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body" id="iva">
                                        <h2>$0</h2>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                            <div class="col-12 col-sm-4">
                                <div class="card card-primary" name="total">
                                    <div class="card-header">
                                        <h3 class="card-title col-10">Total</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <div class="card-body" id="total">
                                        <h2>$0</h2>
                                    </div>
                                    <!-- /.card-body -->
                                </div>
                            </div>
                        </div>
                        <div class="card card-success" name="finalizar">
                            <div class="card-header">
                                <h3 class="card-title col-11">Finalizar</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-input row">
                                    <!-- <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="checkFinalizar" name="checkFinalizar"  onclick="checkFinalizarVenta()">
                                            <label class="form-check-label" for="checkFinalizar">Finalizar Venta</label>
                                        </div>
                                    </div> -->
                                    <div class="col-sm-6">
                                        <input type="submit" value="Realizar Venta" class="btn btn-success float-right"  id="agregarVenta" onclick="finalizarVenta()" >
                                        <div class="spinner-border spinner-layer spinner-blue-only" role="status" id="loading" style="display:none">
                                        <span class="sr-only">Loading...</span>
</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.card-footer -->
                </div>
            </div>
            <div class="alert" id="mensajeVenta" style="display:none">
                <ul>
                    Venta realizada correctamente!
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
                {{Session::get('success')}}
            </ul>
        </div>
    @endif

    <!-- /Callback-->
    <script>
        //Variables globales
        let subtotal = 0.0;
        let iva = 0.0;
        let total = 0.0;
        let cliente = 0;
        let permisoPrecios =  false;
        //Configuración de notificaciones pequeñas
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        //Función para detectar cunado se ingrese un UPC
        $('#upc').on('input', function(){
            upc = $(this).val();
            upc = upc.toString();
            if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);
            if(upc.length == 12 || upc.length == 13 || upc.length == 14){
                $.ajax({
                    type: "get",
                    url: "{{route('verificarUPCVenta')}}",
                    data:{'upc' : $(this).val()},
                    success: function(data) {
                        //console.log(data);
                        if(data.res == false){
                            $('#alerta-upc').show();
                        }else{
                            $('#upc').val("");
                            cantidades = "";
                            for(let i = 1; i < data[0][0].stock + 1; i++){
                                cantidades += '<option value="'+i+'">'+i+'</option>';
                            }
                            $('#ticketTabla').append(
                                '<tr>'+
                                    '<td scope="row" id="upc_art"><small>'+data[0][0].upc+'</small></td>'+
                                    '<td><small>'+data[0][0].titulo_inventario+'</small></td>'+
                                    '<td class="d-none d-lg-table-cell"><small>'+data[0][0].marca+'</small></td>'+
                                    '<td class="d-none d-lg-table-cell"><small>'+data[0][0].modelo+'</small></td>'+
                                    '<td class="d-none d-lg-table-cell"><small>'+data[0][0].color+'</small></td>'+
                                    '<td>'+
                                        '<select id="cantidad" class="form-control form-control-sm" onchange="obtenerTotal()">'+
                                            cantidades+
                                        '</select>'+
                                    '</td>'+
                                    '<td>'+
                                        '<input type="number" list="precioData" class="form-control form-control-sm" id="precio" placeholder="Precio" value="'+data[0][0].precio_max+'" onchange="comprobarPrecioProducto($(this));" min="1">'+
                                        '<datalist id="precioData">'+
                                            '<option value="'+data[0][0].precio_min+'">'+data[0][0].precio_min+'</option>'+
                                            '<option value="'+data[0][0].precio_max+'">'+data[0][0].precio_max+'</option>'+
                                            '<option value="'+data[0][0].precio_mayoreo+'">'+data[0][0].precio_mayoreo+'</option>'+
                                        '</datalist>'+
                                    '</td>'+
                                    '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarProducto($(this))"><i class="far fa-trash-alt"></i></a></td>'+
                                '</tr>'
                            );
                            obtenerTotal();
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                    }
                });
            }else{
            }
        });
        //Agregar Formulario en Formas de pago
        $('#agregarFormaPago').on('click', function(){
            $('#formaPago').append(
                '<hr>'+
                '<div class="form-group row agregado" id="agregado">'+
                    '<label for="forma" class="col-sm-2 col-form-label">Forma</label>'+
                    '<div class="col-sm-4">'+
                        '<input type="text" list="formaData" class="form-control" id="forma" name="formas_pago[][forma]" placeholder="Forma">'+
                        '<datalist id="formaData">'+
                            '@foreach ($formas_pago as $forma)'+
                            '<option value="{{$forma->forma_pago}}">{{$forma->forma_pago}}</option>'+
                            '@endforeach'+
                        '</datalist>'+
                    '</div>'+
                    '<label for="vida" class="col-sm-2 col-form-label">Pago</label>'+
                    '<div class="col-sm-4 input-group">'+
                        '<div class="input-group-prepend">'+
                            '<div class="input-group-text">$</div>'+
                        '</div>'+
                        '<input type="number" class="form-control vida" id="pago" step="0.01" name="formas_pago[][pago]" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 46 && event.charCode <= 57" placeholder="Cantidad">'+
                    '</div>'+
                '</div>'
            );
        });
        //Función para sumar o restar el total del ticket
        function obtenerTotal(){
            let totalProducto = 0;
            $.each($('#ticketTabla').children(), function(){
                cant_pza = ($(this).find('#cantidad').prop('selectedIndex') + 1);
                cant = $(this).find('#precio').val();
                totalProducto += (cant * cant_pza);
            });
            total = totalProducto.toFixed(2);
            iva = (total * .16).toFixed(2);
            subtotal = (parseFloat(total) - parseFloat(iva)).toFixed(2);
            $('#subtotal h2').html('$'+subtotal);
            $('#iva h2').html('$'+iva);
            $('#total h2').html('$'+total);
        }
        //Función para comprobar la existencia d eun producto en el ticket, tiene error en el return
        function comprobarProducto(producto){
            $.each($('#ticketTabla').find('tr'), function(i, x){
                cantidad = $(this).children().find('#cantidad option').length;
                index = $(this).children().find('#cantidad').prop('selectedIndex');
                select = $(this).children().find('#cantidad');
                if($(this).children().eq(0).text() == producto){
                    console.log(index);
                    console.log(cantidad);
                    if((index + 1) < cantidad){
                        console.log(select.val(index + 1));
                        return 1;
                    }else{
                        return 0;
                    }
                }
            });
        }
        //Función que quita productos del ticket
        function quitarProducto(elem){
            elem.parent().parent().remove();
            obtenerTotal();
        }
        //Función que módifica los totales al cambiar de cantidad productos del ticket
        function comprobarPrecioProducto(elem){
            valor_min = 0;
            valor_max = 0;
            elem.parent().find('#precioData option').each(function(i, x){
                console.log(i);
                if(i == 0){
                    valor_min = $(this).text();
                }else if(i == 1){
                    valor_max = $(this).text();
                }
            });
            if(elem.val() < valor_min && permisoPrecios == false){
                Swal.mixin({
                    input: 'text',
                    title: 'Para vender a menos del precio mínimo es necesaria una autorización',
                    confirmButtonText: 'Siguiente &rarr;',
                    showCancelButton: true,
                    cancelButtonText: 'Cancelar',
                    progressSteps: ['1', '2']
                }).queue([
                    {
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
                            'email' : result.value[0],
                            'password' : result.value[1]
                        };
                        $.ajax({
                            type: "post",
                            url: "{{route('validarPermiso')}}",
                            data: answers,
                            headers: {
                                'X-CSRF-TOKEN' : "{{ csrf_token() }}"
                            },
                            success: function(data) {
                                if(data == true){
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Permiso habilitado!'
                                    })
                                    permisoPrecios = true;
                                    obtenerTotal();
                                }else{
                                    elem.val(valor_max);
                                    Toast.fire({
                                        icon: 'error',
                                        title: 'No tiene los permisos para esta acción!'
                                    })
                                }
                            },
                            error: function(data) {
                                elem.val(valor_max);
                                Toast.fire({
                                    icon: 'error',
                                    title: 'No tiene los permisos para esta acción!'
                                })
                            }
                        });
                    }else{
                        elem.val(valor_max);
                        Toast.fire({
                            icon: 'info',
                            title: 'Sin cambio de precios!'
                        })
                    }
                })
            }else{
                obtenerTotal();
            }
        }
        //Función para habílitar el botón que envía los datos el controlador
   /*      function checkFinalizarVenta(){
            var checkBox = document.getElementById("checkFinalizar");
            if (checkBox.checked == true){
                $('#agregarVenta').attr('disabled', false);
            } else {
                $('#agregarVenta').attr('disabled', true);
            }
        } */
        //Función que envía el formulario al controlador
        function finalizarVenta(){
            $('#mensajeVenta').hide();
            clienteValidacion = true;
            ticketValidacion = true;
            formasPagoValidacion = true;
            totalFormasPagoValidacion = true;
            if(!$('#cliente').val()){
                $('#cliente').addClass('is-invalid');
                clienteValidacion = false;
            }else{
                $('#cliente').removeClass('is-invalid');
                clienteValidacion = true;
            }
            let ticket = [];
            let formas_pago = [];
            let cliente = $('#cliente').val();
            let usuario_cliente = $('#usuario_cliente').val();
            let totalFormasPago = 0.0;
            $.each($('#ticketTabla').children(), function(i,x){
                ticket.push(
                    {
                        'upc' : $(this).find('#upc_art').text(),
                        'piezas' : $(this).children().find('#cantidad').val(),
                        'precio' : $(this).children().find('#precio').val()
                    }
                );
            });
            $.each($('#formaPago').find('.agregado'), function(i, x){
                formas_pago.push(
                    {
                        'forma' : $(this).children().find('#forma').val(),
                        'pago' : $(this).children().find('#pago').val()
                    }
                );
                totalFormasPago += parseFloat($(this).children().find('#pago').val());
            });
            if(ticket.length == 0){
                $('#mensajeTicket').show();
                ticketValidacion = false;
            }else{
                $('#mensajeTicket').hide();
                ticketValidacion = true;
            }
            if(!formas_pago[0].forma || !formas_pago[0].pago){
                $('#mensajeFormas').show();
                formasPagoValidacion = false;
            }else{
                $('#mensajeFormas').hide();
                formasPagoValidacion = true;
            }
            if(totalFormasPago < total){
                $('#mensajeTotalFormas').show();
                totalFormasPagoValidacion = false;
            }else{
                $('#mensajeTotalFormas').hide();
                totalFormasPagoValidacion = true;
            }
            if(clienteValidacion == true && ticketValidacion == true && formasPagoValidacion == true && totalFormasPagoValidacion == true){
                $.ajax({
                    type: "post",
                    url: "{{route('Venta.store')}}",
                    data:{
                        'cliente' : cliente,
                        'usuario_cliente' : usuario_cliente,
                        'ticket' : ticket,
                        'formas_pago' : formas_pago,
                        'totales' :
                            {
                                'subtotal' : subtotal,
                                'iva' : iva,
                                'total' : total
                            }
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    beforeSend: function () {
                        $('#agregarVenta').hide();
                        $('#loading').show();
                    },
                    success: function(response){
                        if(response.response == "success"){
                            $('#mensajeVenta ul').text(response.message);
                            $('#mensajeVenta').removeClass('alert-danger').addClass('alert-success');
                            $('#mensajeVenta').show();
                            $('#loading').hide();
                            $('#agregarVenta').show();
                        }else{
                            $('#mensajeVenta ul').text(response.message);
                            $('#mensajeVenta').removeClass('alert-success').addClass('alert-danger');
                            $('#mensajeVenta').show();
                            $('#loading').hide();
                            $('#agregarVenta').show();
                        }
                        limpiarFormulario();
                    },
                    error: function(e){
                        console.log(e);
                        Swal.fire({
                            html: e.responseText
                        })
                    }
                });
            }
        }
        //Función que limpia el formulario
        function limpiarFormulario(){
            $('#cliente').val("");
            subtotal = 0;
            total = 0;
            iva = 0;
            $('#subtotal h2').html('$'+subtotal);
            $('#iva h2').html('$'+iva);
            $('#total h2').html('$'+total);
            $.each($('#ticketTabla').children(), function(i,x){
                $(this).remove();
            });
            $.each($('#formaPago').find('#agregado'), function(i, x){
                $(this).remove();
            });
            $('#formaPago').append(
                '<div class="form-group row agregado" id="agregado">'+
                    '<label for="forma" class="col-sm-2 col-form-label">Forma</label>'+
                    '<div class="col-sm-4">'+
                        '<input type="text" list="formaData" class="form-control" id="forma" name="formas_pago[][forma]" placeholder="Forma">'+
                        '<datalist id="formaData">'+
                            '@foreach ($formas_pago as $forma)'+
                            '<option value="{{$forma->forma_pago}}">{{$forma->forma_pago}}</option>'+
                            '@endforeach'+
                        '</datalist>'+
                    '</div>'+
                    '<label for="vida" class="col-sm-2 col-form-label">Pago</label>'+
                    '<div class="col-sm-4 input-group">'+
                        '<div class="input-group-prepend">'+
                            '<div class="input-group-text">$</div>'+
                        '</div>'+
                        '<input type="number" class="form-control vida" id="pago" step="0.01" name="formas_pago[][pago]" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 46 && event.charCode <= 57" placeholder="Cantidad">'+
                    '</div>'+
                '</div>'
            );
        }
        //Función que agrega campos para dar de alta un cliente
        $('#habilitarFormCliente').on('click', function(){
            $('#cliente').val("");
            if($('#formCliente').is(":visible")){
                $('#formCliente').hide();
            }else{
                $('#formCliente').show();
            }
        });
        //Función para dar de alta un cliente
        function agregarCliente(){
            estatus = 0;
            $('#formCliente').find('.form-group').find('input').each(function(){
                if(!$(this).val()){
                    $(this).addClass('is-invalid');
                    estatus += 1;
                }else{
                    $(this).removeClass('is-invalid');
                    if(estatus > 0){
                        estatus -= 1;
                    }
                }
            });
            if(estatus == 0){
                let nombre = $('#nombre').val();
                let telefono = $('#telefono').val();
                const cb = document.getElementById('checkWhatsapp');
                let whatsapp = 1;
                if(cb.value == 'on')
                    whatsapp = 1;
                else
                    whatsapp = 0;
                let correo = $('#correo').val();
                let tipo_cliente = $('#tipo_cliente').val();
                $.ajax({
                    type: "post",
                    url: "{{route('Cliente.store')}}",
                    data:{
                        'nombre' : nombre,
                        'telefono' : telefono,
                        'whatsapp' : whatsapp,
                        'correo' : correo,
                        'tipo_cliente' : tipo_cliente
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response){
                        if(response.res){
                            $('#mensajeCliente').show();
                            $('#mensajeCliente').removeClass('alert-success').addClass('alert-danger');
                            $('#mensajeCliente ul').text('El cliente no pudo ser dado de alta!');
                        }else{
                            $('#mensajeCliente').show();
                            if($('#mensajeCliente').hasClass('alert-danger')){
                                $('#mensajeCliente').removeClass('alert-danger').addClass('alert-success');
                            }
                            $('#mensajeCliente ul').text('Cliente dado de alta con éxito!');
                            $('#cliente').val(response[0].id_cliente+" "+response[0].nombre_completo);
                            $('#formCliente').find('.form-group').find('input').each(function(){
                                $(this).val("");
                            });
                            $('#formCliente').hide();
                        }
                    },
                    error: function(e){
                        $('#mensajeCliente').show();
                        $('#mensajeCliente').removeClass('alert-success').addClass('alert-danger');
                        $('#mensajeCliente ul').text('El cliente no pudo ser dado de alta!');
                        console.log(e);
                    }
                });
            }
        }
    </script>
@endsection
