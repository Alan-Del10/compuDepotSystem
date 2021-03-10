@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Registrar Compra de Inventario</h1>
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
            <div action="{{route('Compra.store')}}" method="POST" class="form-horizontal " id="formCompra" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <section class="col-lg-8 connectedSortable">
                        <div class="card card-secondary">
                            <div class="card-header">
                                <h3 class="card-title">Paquete</h3>
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
                                                <th scope="col">Costo</th>
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
                    <section class="col-lg-4 connectedSortable">
                        <div class="card card-success" name="finalizar">
                            <div class="card-header">
                                <h3 class="card-title col-11">Finalizar</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="numero" class="col-sm-4 col-form-label">No. Compra</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control @error('numero') is-invalid @enderror" name="numero" id="numero" placeholder="No. Compra" value="{{ old('numero')}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Proveedor</label>
                                    <div class="col-sm-8 input-group">
                                        <input type="text" list="proveedorData" class="form-control @error('proveedor') is-invalid @enderror" id="proveedor" name="proveedor" value="{{old('proveedor')}}" placeholder="Seleccionar Proveedor"/>
                                        <datalist id="proveedorData">
                                            @foreach($proveedores as $proveedor)
                                                <option value="{{$proveedor->proveedor}}">{{$proveedor->proveedor}}</option>
                                            @endforeach
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarProveedor" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Total</label>
                                    <div class="col-sm-8 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">$</span>
                                        </div>
                                        <input type="text" class="form-control @error('total') is-invalid @enderror" id="total" name="total" value="{{old('total')}}" placeholder="Total" readonly/>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-input row">
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="checkFinalizar" name="checkFinalizar"  onclick="checkFinalizarCompra()">
                                            <label class="form-check-label" for="checkFinalizar">Finalizar Compra</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="submit" value="Registrar Compra" class="btn btn-success float-right" disabled id="agregarCompra" onclick="finalizarVenta()" >
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
        //Busca el producto en la BD, des ser enontrado lo agrea con sus datos, sino, agrega un renglón para que el usuario inserte los datos
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
                            $('#ticketTabla').append(
                                '<tr>'+
                                    '<td scope="row" id="upc_art">'+$('#upc').val()+'</td>'+
                                    '<td id="titulo" class="titulo"><input type="text" placeholder="Título" class="form-control form-control-sm"/></td>'+
                                    '<td class="d-none d-lg-table-cell"></td>'+
                                    '<td class="d-none d-lg-table-cell"></td>'+
                                    '<td class="d-none d-lg-table-cell"></td>'+
                                    '<td id="cantidad" class="cantidad"><input type="number" placeholder="Cantidad" class="form-control form-control-sm" value="1"/></td>'+
                                    '<td id="costo" class="costo"><input type="number" placeholder="Costo" class="form-control form-control-sm"/></td>'+
                                    '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarProducto($(this).parent().parent())"><i class="far fa-trash-alt"></i></a></td>'+
                                '</tr>'
                            );
                        }else{
                            $('#ticketTabla').append(
                                '<tr>'+
                                    '<td scope="row" id="upc_art">'+data[0][0].upc+'</td>'+
                                    '<td>'+data[0][0].titulo_inventario+'</td>'+
                                    '<td>'+data[0][0].marca+'</td>'+
                                    '<td>'+data[0][0].modelo+'</td>'+
                                    '<td>'+data[0][0].color+'</td>'+
                                    '<td id="cantidad" class="cantidad"><input type="number" placeholder="Cantidad" class="form-control form-control-sm" value="1"/></td>'+
                                    '<td id="costo" class="costo"><input type="number" placeholder="Costo" class="form-control form-control-sm" value="'+data[0][0].costo+'"/></td>'+
                                    '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarProducto($(this).parent().parent())"><i class="far fa-trash-alt"></i></a></td>'+
                                '</tr>'
                            );
                        }
                        $('#upc').val("");
                        calcularTotal();
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                    }
                });
            }
        });
        //Remueve los productos del ticket de compra
        function quitarProducto(elem){
            elem.remove();
            calcularTotal();
        }
        //Cálcula el total de la compra
        function calcularTotal(){
            total = 0;
            if($('#ticketTabla').children()){
                $.each($('#ticketTabla').children(), function(){
                    total += $(this).find('#costo').children().val() * $(this).find('#cantidad').children().val();
                });
                $('#total').val(total);
            }else{
                $('#total').val("");
            }

        }

        //Función para habílitar el botón que envía los datos el controlador
        function checkFinalizarCompra(){
            var checkBox = document.getElementById("checkFinalizar");
            if (checkBox.checked == true){
                $('#agregarCompra').attr('disabled', false);
            } else {
                $('#agregarCompra').attr('disabled', true);
            }
        }
    </script>
@endsection

