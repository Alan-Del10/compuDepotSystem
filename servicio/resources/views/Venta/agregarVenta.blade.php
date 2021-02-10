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
            <form action="{{route('Venta.store')}}" method="POST" class="form-horizontal " id="formVenta" enctype="multipart/form-data">
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
                                    <label for="cliente" class="col-sm-3 col-form-label">Nombre Cliente</label>
                                    <div class="col-sm-9 input-group">
                                        <input type="text" list="clienteData" class="form-control @error('cliente') is-invalid @enderror" id="cliente" name="cliente" value="{{old('cliente')}}" placeholder="Seleccionar Cliente"/>
                                        <datalist id="clienteData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarCliente"><i class="fas fa-plus"></i></button>
                                        </div>
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
                                        <strong>Ops!</strong> Este artículo no está registrado.
                                        <button type="button" id="boton-alerta" class="close">
                                            <span >&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="ticket">
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
                                <div class="form-group row agregado">
                                    <label for="forma" class="col-sm-2 col-form-label">Forma</label>
                                    <div class="col-sm-4">
                                        <input type="text" list="formaData" class="form-control" id="forma" name="detalle[][forma]" placeholder="Forma">
                                        <datalist id="formaData">
                                            @foreach ($formas_pago as $forma)
                                            <option value="{{$forma->forma_pago}}">{{$forma->forma_pago}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <label for="vida" class="col-sm-2 col-form-label">Pago</label>
                                    <div class="col-sm-4 input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">$</div>
                                        </div>
                                        <input type="number" class="form-control vida" id="pago" name="detalle[][pago]" placeholder="Cantidad">
                                    </div>
                                </div>
                                <hr>
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
                                        <div class="form-group row">
                                            <h2>$0</h2>
                                        </div>
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
                                        <div class="form-group row">
                                            <h2>$0</h2>
                                        </div>
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
                                        <div class="form-group row agregado">
                                            <h2>$0</h2>
                                        </div>
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
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="checkFinalizar" name="checkFinalizar" disabled onclick="checkFinalizarInventario()">
                                            <label class="form-check-label" for="checkFinalizar">Finalizar Venta</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="submit" value="Realizar Venta" class="btn btn-success float-right" id="agregarVenta" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.card-footer -->
                </div>
            </form>
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
        /*$(document).ready(function(){
            Swal.fire(
                'Good job!',
                'You clicked the button!',
                'success'
            )
        });*/
        //Función para detectar cunado se ingrese un UPC
        $('#upc').on('input', function(){
            upc = $(this).val();
            upc = upc.toString();
            if(this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);
            if(upc.length == 12 || upc.length == 13 || upc.length == 14){
                $.ajax({
                    type: "get",
                    url: "{{route('verificarUPC')}}",
                    data:{'upc' : $(this).val()},
                    success: function(data) {
                        //console.log(data);
                        if(data.res == false){
                            $('#alerta-upc').show();
                            //Swal.fire("Oops", "Ese artículo no existe en el inventario, registralo!", "info");
                            //habilitarFormulario(false, data);
                        }else{
                            $('#upc').val("");
                            cantidades = "";
                            for(let i = 1; i < data[0][0].stock + 1; i++){
                                cantidades += '<option value="'+i+'">'+i+'</option>';
                            }

                            $('#ticketTabla').append(
                                '<tr>'+
                                    '<td scope="row">'+data[0][0].upc+'</td>'+
                                    '<td>'+data[0][0].titulo_inventario+'</td>'+
                                    '<td class="d-none d-lg-table-cell">'+data[0][0].marca+'</td>'+
                                    '<td class="d-none d-lg-table-cell">'+data[0][0].modelo+'</td>'+
                                    '<td class="d-none d-lg-table-cell">'+data[0][0].color+'</td>'+
                                    '<td>'+
                                        '<select name="cantidad" id="cantidad" class="form-control form-control-sm" onchange="cambiarCantidadProducto($(this).parent().parent())">'+
                                            cantidades+
                                        '</select>'+
                                    '</td>'+
                                    '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarProducto($(this).parent().parent())"><i class="far fa-trash-alt"></i></a></td>'+
                                    '<td class="d-none" id="precio">'+data[0][0].precio_publico+'</td>'+
                                '</tr>'
                            );
                            obtenerTotal(1, data[0][0].precio_publico, 0);
                            /*Swal.fire({
                                title: 'Este artículo ya existe!',
                                text: "Puede editar este artículo dando clic en el botón!",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Entendido!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var url = '{{ route("Inventario.edit", ":id") }}';
                                    url = url.replace(':id', upc);
                                    window.location.href = url;
                                }
                            })*/
                            /*$('#header-pagina').text('Editar Inventario');
                            habilitarFormulario(true, data);*/
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
                '<div class="form-group row agregado">'+
                    '<label for="forma" class="col-sm-2 col-form-label">Forma</label>'+
                    '<div class="col-sm-4">'+
                        '<input type="text" list="formaData" class="form-control" id="forma" name="detalle[][forma]" placeholder="Forma">'+
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
                        '<input type="number" class="form-control vida" id="pago" name="detalle[][pago]" placeholder="Cantidad">'+
                    '</div>'+
                '</div>'+
                '<hr>'
            );
        });
        //Función para sumar o restar el total del ticket
        function obtenerTotal(cantidad_pza, cantidad, tipo){
            valor = cantidad_pza * cantidad;
            if(tipo == 0){
                subtotal += valor;
                iva = subtotal * .16;
                total = subtotal + iva;
                $('#subtotal h2').html('$'+subtotal);
                $('#iva h2').html('$'+iva);
                $('#total h2').html('$'+total);
            }else if(tipo == 1){
                subtotal -= valor;
                iva = subtotal * .16;
                total = subtotal + iva;
                $('#subtotal h2').html('$'+subtotal);
                $('#iva h2').html('$'+iva);
                $('#total h2').html('$'+total);
            }
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
            elem.remove();
            cant_pza = elem.children().find('#cantidad').prop('selectedIndex');
            cant = elem.children().eq(7).text();
            obtenerTotal(cant_pza + 1, cant, 1);
        }

        //Función que quita productos del ticket
        function cambiarCantidadProducto(elem){
            cant_pza = elem.children().find('#cantidad').prop('selectedIndex');
            cant = elem.children().eq(7).text();
            obtenerTotal(cant_pza, cant, 0);
        }
    </script>
@endsection



