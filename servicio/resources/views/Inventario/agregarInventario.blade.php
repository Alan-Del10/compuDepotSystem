@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Agregar Inventario</h1>
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
            <form action="{{route('Inventario.store')}}" method="POST" class="form-horizontal " id="formInventario" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <section class="col-lg-6 connectedSortable">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Inventario</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">UPC</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control @error('upc') is-invalid @enderror" name="upc" id="upc" placeholder="UPC" value="{{ old('upc')}}" autofocus>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        @if(old('checkOnline') == true)
                                            <input type="checkbox" class="form-check-input" id="checkOnline" name="checkOnline" disabled onclick="checkVentaOnline()" checked>
                                        @else
                                            <input type="checkbox" class="form-check-input" id="checkOnline" name="checkOnline" disabled onclick="checkVentaOnline()">
                                        @endif
                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkOnline">Venta online?</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-warning alert-dismissible fade show" role="alert" style="display:none" id="alerta-upc">
                                        <strong>Ops!</strong> Este artículo no está registrado.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="Categoria">
                                    <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                    <div class="col-sm-4">
                                        <input type="text" list="categoriaData" class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" value="{{old('categoria')}}" placeholder="Seleccionar Categoria" disabled/>
                                        <datalist id="categoriaData">
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->categoria}}"></option>
                                            @foreach ($subcategorias as $subcategoria)
                                                @if($subcategoria->id_categoria == $categoria->id_categoria)
                                                <option class="sub" value="{{$subcategoria->subcategoria}}"></option>
                                                @endif
                                            @endforeach
                                        @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarCategoria" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radiosDetalle" id="radioDefault" value="default" onclick="radioDetalle($(this))" checked>
                                            <label class="form-check-label" for="radioDefault">N/A</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radiosDetalle" id="radioImei" value="imei" onclick="radioDetalle($(this))">
                                            <label class="form-check-label" for="radioImei">IMEI</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radiosDetalle" id="radioSerie" value="no_serie" onclick="radioDetalle($(this))">
                                            <label class="form-check-label" for="radioSerie">No. Serie</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Marca</label>
                                    <div class="col-sm-4">
                                        <input type="text" list="marcaData" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{old('marca')}}" placeholder="Seleccionar Marca" disabled/>
                                        <datalist id="marcaData">
                                            @foreach($marcas as $marca)
                                                <option value="{{$marca->marca}}">{{$marca->marca}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarMarca" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        @if(old('checkBateria') == true)
                                            <input type="checkbox" class="form-check-input" id="checkBateria" name="checkBateria" disabled onclick="checkVidaBateria()" checked>
                                        @else
                                            <input type="checkbox" class="form-check-input" id="checkBateria" name="checkBateria" disabled onclick="checkVidaBateria()">
                                        @endif
                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkBateria">Vida de bateria?</label>
                                </div>
                                <div class="form-group row">
                                    <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
                                    <div class="col-sm-9">
                                        <input type="text" list="modeloData" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{old('modelo')}}" placeholder="Seleccionar Modelo" disabled/>
                                        <datalist id="modeloData">
                                            @foreach($modelos as $modelo)
                                                <option value="{{$modelo->modelo}}">{{$modelo->modelo}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarModelo" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2 col-form-label">Color</label>
                                    <div class="col-sm-3">
                                        <input type="text" list="colorData" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{old('color')}}" placeholder="Seleccionar Color" disabled/>
                                        <datalist id="colorData">
                                            @foreach($colores as $color)
                                                <option value="{{$color->color}}">{{$color->color}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarColor" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <label for="capacidad" class="col-sm-2 col-form-label">Capacidad</label>
                                    <div class="col-sm-3">
                                        <input type="text" list="capacidadData" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" name="capacidad" value="{{old('capacidad')}}" placeholder="Seleccionar Capacidad" disabled/>
                                        <datalist id="capacidadData">
                                            @foreach($capacidades as $capacidad)
                                                <option value="{{$capacidad->tipo}}">{{$capacidad->tipo}}</option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarCapacidad" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="onlineImagen" style="display: none">
                                    <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                    <div class="custom-file col-sm-10">
                                        <input type="file" class="custom-file-input" name="imagenProducto" id="imagenProducto" accept="image/png, image/jpeg" disabled>
                                        <label class="custom-file-label" id="labelImagen" for="imagenProducto">Elegir Imagen...</label>
                                    </div>
                                </div>
                                <div class="form-group row" id="onlineTitulo" style="display: none">
                                    <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" id="titulo" placeholder="Título" value="{{ old('titulo')}}" disabled>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        @if(old('checkGenerarTitulo') == true)
                                            <input type="checkbox" class="form-check-input" id="checkGenerarTitulo" name="checkGenerarTitulo" onclick="generarTitulo()" checked>
                                        @else
                                            <input type="checkbox" class="form-check-input" id="checkGenerarTitulo" name="checkGenerarTitulo" onclick="generarTitulo()">
                                        @endif
                                    </div>
                                    <label class="form-check-label col-sm-2" for="checkGenerarTitulo">Generar Título</label>
                                </div>
                                <div class="form-group row" id="onlineDescripcion" style="display: none">
                                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="4" placeholder="Descripción" name="descripcion" disabled>{{ old('descripcion')}}</textarea>
                                    </div>
                                </div>
                                <hr style="display: none" id="hrOnline">
                                <div class="form-group row">
                                    <label for="costo" class="col-sm-2 col-form-label">Costo ($)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo" placeholder="Costo" step="0.01" value="{{ old('costo')}}" disabled>
                                    </div>
                                    <label for="stock" class="col-sm-2 col-form-label">Stock (pz)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" placeholder="Stock" value="{{ old('stock')}}" disabled>
                                    </div>
                                    <label for="stockMin" class="col-sm-2 col-form-label">Stock <. (pz)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('stockMin') is-invalid @enderror" id="stockMin" name="stockMin" placeholder="Stock Mínimo" value="{{ old('stockMin')}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="precioMin" class="col-sm-3 col-form-label">Precio Min.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('precioMin') is-invalid @enderror" id="precioMin" name="precioMin" placeholder="Precio Mínimo" step="0.01" value="{{ old('precioMin')}}" disabled>
                                    </div>
                                    <label for="precioMax" class="col-sm-3 col-form-label">Precio Max.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('precioMax') is-invalid @enderror" id="precioMax" name="precioMax" placeholder="Precio Máximo" step="0.01" value="{{ old('precioMax')}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="publico" class="col-sm-3 col-form-label">Precio Pub.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('publico') is-invalid @enderror" id="publico" name="publico" placeholder="Precio Público" step="0.01" value="{{ old('publico')}}" disabled>
                                    </div>
                                    <label for="mayoreo" class="col-sm-3 col-form-label">Precio May.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('mayoreo') is-invalid @enderror" id="mayoreo" name="mayoreo" placeholder="Precio Mayoreo" step="0.01" value="{{ old('mayoreo')}}" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="largo" class="col-sm-2 col-form-label">Largo(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('largo') is-invalid @enderror" id="largo" name="largo" placeholder="Largo" step="0.01" value="{{ old('largo')}}" disabled>
                                    </div>

                                    <label for="alto" class="col-sm-2 col-form-label">Alto(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('alto') is-invalid @enderror" id="alto" name="alto" placeholder="Alto" step="0.01" value="{{ old('alto')}}" disabled>
                                    </div>

                                    <label for="ancho" class="col-sm-2 col-form-label">Ancho(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('ancho') is-invalid @enderror" id="ancho" name="ancho" placeholder="Ancho" step="0.01" value="{{ old('ancho')}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-6 connectedSortable" >
                        <div class="card card-success" name="finalizar">
                            <div class="card-header">
                                <h3 class="card-title col-11">Finalizar</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-input row">
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" class="form-check-input" id="checkFinalizar" name="checkFinalizar" disabled onclick="checkFinalizarInventario()">
                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkFinalizar">Finalizar Proceso</label>
                                    <div class="col-sm-4"></div>
                                    <div class="col-sm-3">
                                        <input type="submit" value="Agregar Inventario" class="btn btn-success float-right" id="agregarInventario" disabled>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card card-warning" name="detalle">
                            <div class="card-header">
                                <h3 class="card-title col-11">Detalle Inventario</h3>
                                <button type="button" class="btn btn-secondary" id="agregarDetalleInventario" disabled><i class="fas fa-plus"></i></button>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body scroll" id="detalleInventario"></div>
                            <!-- /.card-body -->

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
    @elseif (Session::has('message'))
        <div class="alert alert-success">
            <ul>
                {{Session::get('success')}}
            </ul>
        </div>
    @endif
    <!-- /Callback-->
    <script>
        let conteoDetalle = 0;
        var modelos = @json($modelos);
        var marcas = @json($marcas);
        var categorias = @json($categorias);
        var upc = "";
        var detalleRadio = 0;
        //Función para detectar cunado se ingrese un UPC
        $('#upc').on('input', function(){
            upc = $(this).val();
            upc = upc.toString();
            if(upc.length == 12){
                $.ajax({
                    type: "get",
                    url: "{{route('verificarUPC')}}",
                    data:{'upc' : $(this).val()},
                    success: function(data) {
                        if(data.res == false){
                            $('#header-pagina').text('Agregar Inventario');
                            $('#alerta-upc').show();
                            //Swal.fire("Oops", "Ese artículo no existe en el inventario, registralo!", "info");
                            habilitarFormulario(false, data);
                        }else{
                            $('#header-pagina').text('Editar Inventario');
                            habilitarFormulario(true, data);
                        }
                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                    }
                });
            }
        });
        //Función para desabilitar los campos
        function deshabilitarFormulario(estado){
            $('#agregarInventario').attr('disabled', true);
            $('#agregarDetalle').attr('disabled', true);
            $('#agregarDetalleInventario').attr('disabled', true);
            $('#formInventario').find('.card-body').children().each(function(){
                if($(this).attr('id') != 'Categoria'){
                    $(this).find('input,textarea,select,button').attr('disabled', true);
                }
            });
        }
        //Función para habilitar los campos
        function habilitarFormulario(estado, datosFormulario){
            $('#checkOnline').attr('disabled', false);
            //$('#agregarInventario').attr('disabled', false);
            $('#checkFinalizar').attr('disabled', false);
            $('#agregarDetalle').attr('disabled', false);
            $('#agregarDetalleInventario').attr('disabled', false);
            $('#formInventario').find('.card-body').children().each(function(){
                if($(this).attr('id') != 'onlineTitulo' && $(this).attr('id') != 'onlineDescripcion'){
                    $(this).find('input[type="text"],input[type="number"],textarea,select,button').attr('disabled', false);
                }
            });
            if(estado != false){
                $('#categoria').val(datosFormulario[0].categoria);
                /*categorias.forEach(categoria => {
                    if(datosFormulario[0].id_categoria != marca.id_categoria){
                        console.log(categoria);
                        $('#categoriaData').append('<option value="'+categoria.categoria+'">'+categoria.categoria+'</option>');
                    }
                });*/
                if(datosFormulario[0].id_categoria != null){
                    $('#marcaData option').remove();
                    marcas.forEach(marca => {
                        if(datosFormulario[0].id_categoria == marca.id_categoria){
                            console.log(marca);
                            $('#marcaData').append('<option value="'+marca.marca+'">'+marca.marca+'</option>');
                        }
                    });
                }
                $('#marca').val(datosFormulario[0].marca);
                if(datosFormulario[0].id_marca != null){
                    $('#modeloData option').remove();
                    modelos.forEach(modelo => {
                        if(datosFormulario[0].id_marca == modelo.id_marca){
                            console.log(modelo);
                            $('#modeloData').append('<option value="'+modelo.modelo+'">'+modelo.modelo+'</option>');
                        }
                    });
                }
                $('#modelo').val(datosFormulario[0].modelo);
                $('#color').val(datosFormulario[0].color);
                $('#capacidad').val(datosFormulario[0].tipo);
                $('#costo').val(datosFormulario[0].costo);
                $('#stock').val(datosFormulario[0].stock);
                $('#stockMin').val(datosFormulario[0].stock_min);
                $('#precioMin').val(datosFormulario[0].precio_min);
                $('#precioMax').val(datosFormulario[0].precio_max);
                $('#publico').val(datosFormulario[0].precio_publico);
                $('#mayoreo').val(datosFormulario[0].precio_mayoreo);
                $('#largo').val(datosFormulario[0].largo);
                $('#alto').val(datosFormulario[0].alto);
                $('#ancho').val(datosFormulario[0].ancho);
                if(datosFormulario[0].venta_online == 1){
                    $('#checkOnline').prop('checked', 'checked');
                    $('#titulo').val(datosFormulario[0].titulo_inventario);
                    $('#titulo').attr('disabled', false);
                    $('#descripcion').val(datosFormulario[0].descripcion_inventario);
                    $('#descripcion').attr('disabled', false);
                }else{
                    $('#checkOnline').prop('checked', false);
                    $('#titulo').val("");
                    $('#titulo').attr('disabled', true);
                    $('#descripcion').val("");
                    $('#descripcion').attr('disabled', true);
                }
                checkVentaOnline();
            }
        }
        //Función para cambiar el formulario del detalle del inventario
        function radioDetalle(radio){
            console.log(radio);
            $('#detalleInventario').children().remove();
            if(radio.val() == "imei"){
                detalleRadio = 1;
            }else if(radio.val() == "no_serie"){
                detalleRadio = 2;
            }else{
                detalleRadio = 0;
            }
        }
        //Función para habílitar las entradas en el formulario
        $('#categoria').change(function(){
            //$('#detalleInventario').remove('.agregado');
            if( $('#categoria').prop('selectedIndex') != 0){
                if($('#categoria').prop('selectedIndex') == 1){
                    $('#checkBateria').attr('disabled', false);
                }else if($('#categoria').prop('selectedIndex') == 3){
                    $('#agregarDetalleInventario').attr('disabled', false);
                }else{
                    $('#checkBateria').attr('disabled', true);
                }
            }
        });
        //Agregar Formulario en Detalle Inventario
        $('#agregarDetalleInventario').on('click', function(){
            conteoDetalle += 1;
            $('#categoria').on('change', function(){
                conteoDetalle = 0;
                $('#detalleInventario').children().remove();
            });
            if(detalleRadio == 1){
                $('#detalleInventario').append(
                    '<div class="form-group row agregado">'+
                        '<label for="imei" class="col-sm-1 col-form-label">IMEI</label>'+
                        '<div class="col-sm-3">'+
                            '<input type="text" class="form-control" id="imei" name="detalle['+conteoDetalle+'][imei]" placeholder="IMEI">'+
                        '</div>'+
                        '<label for="liberado" class="col-sm-2 col-form-label">Condición</label>'+
                        '<div class="col-sm-2">'+
                            '<select class="form-control" id="liberado" name="detalle['+conteoDetalle+'][liberado]">'+
                                '<option value="1">Liberado</option>'+
                                '<option value="2">No Liberado</option>'+
                            '</select>'+
                        '</div>'+
                        '<label for="vida" class="col-sm-2 col-form-label">Vida Bateria</label>'+
                        '<div class="col-sm-2">'+
                            '<input type="number" class="form-control vida" id="vida" name="detalle['+conteoDetalle+'][vida]" placeholder="Vida" disabled>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'
                );
            }else if(detalleRadio == 2){
                $('#detalleInventario').append(
                    '<div class="form-group row agregado">'+
                        '<label for="ns" class="col-sm-2 col-form-label">N/S</label>'+
                        '<div class="col-sm-2">'+
                            '<input type="text" class="form-control" id="ns" name="detalle['+conteoDetalle+'][ns]" placeholder="N/S">'+
                        '</div>'+
                        '<label for="liberado" class="col-sm-2 col-form-label">Condición</label>'+
                        '<div class="col-sm-2">'+
                            '<select name="liberado"  class="form-control" id="liberado" name="detalle['+conteoDetalle+'][liberado]">'+
                                '<option value="1">Liberado</option>'+
                                '<option value="2">No Liberado</option>'+
                            '</select>'+
                        '</div>'+
                        '<label for="vida" class="col-sm-2 col-form-label">Vida Bateria</label>'+
                        '<div class="col-sm-2">'+
                            '<input type="number" class="form-control" name="detalle['+conteoDetalle+'][vida]" id="vida" placeholder="Vida" disabled>'+
                        '</div>'+
                    '</div>'+
                    '<hr>'
                );
            }
        });
        //Funcion para habílitar el campo de bateria de los equipos electrónicos
        function checkVidaBateria(){
            var checkBox = document.getElementById("checkBateria");
            if (checkBox.checked == true){
                $('.vida').each(function(){
                    $(this).attr('disabled', false);
                });
            } else {
                $('.vida').each(function(){
                    $(this).attr('disabled', true);
                });
            }
        }
        //Funcion para habílitar los campos de título y descripción para venta online de los productos
        function checkVentaOnline(){
            var checkBox = document.getElementById("checkOnline");
            if (checkBox.checked == true){
                $('#onlineTitulo').show();
                $('#onlineDescripcion').show();
                $('#onlineImagen').show();
                $('#hrOnline').show();
                $('#titulo').attr('disabled', false);
                $('#descripcion').attr('disabled', false);
                $('#imagenProducto').attr('disabled', false);
            } else {
                $('#onlineTitulo').hide();
                $('#onlineDescripcion').hide();
                $('#hrOnline').hide();
                $('#onlineImagen').hide();
                $('#titulo').attr('disabled', true);
                $('#descripcion').attr('disabled', true);
                $('#imagenProducto').attr('disabled', true);
            }
        }
        //Funcion para habílitar el botón que envía los datos el controlador
        function checkFinalizarInventario(){
            var checkBox = document.getElementById("checkFinalizar");
            if (checkBox.checked == true){
                $('#agregarInventario').attr('disabled', false);
            } else {
                $('#agregarInventario').attr('disabled', true);
            }
        }
        //Cargar marcas dependiendo de la categoria
        $('#categoria').change(function(){
            if($(this).val() != null){
                $('#marca option').remove();
                marcas.forEach(marca => {
                    if($(this).val() == marca.id_categoria){
                        console.log(marca);
                        $('#marca').append('<option value="'+marca.id_marca+'">'+marca.descripcion+'</option>');
                    }
                });
            }
        });
        //Cargar modelos dependiendo de la marca
        $('#marca').change(function(){
            if($(this).val() != null){
                $('#modelo option').remove();
                modelos.forEach(modelo => {
                    if($(this).val() == modelo.id_marca){
                        console.log(modelo);
                        $('#modelo').append('<option value="'+modelo.id_modelo+'">'+modelo.descripcion+'</option>');
                    }
                });
            }
        });
        //Agregar marca
        $('#agregarMarca').on('click', function() {
            //sacar una cadena de options para el sweet alert
            var cadenaOption = '<select class="form-control" id="categoriaOption">';//inicializo variable para el options del sweet alert
            categorias.forEach(categoria => {
                cadenaOption = cadenaOption +'<option value="'+categoria.id_categoria+'">'+categoria.descripcion+'</option>';
            });
            cadenaOption = cadenaOption + '</select>';
            Swal.fire({
                title: "Agregar Marca",
                html:
                    '<div class="form-group row">' +
                    '<div class="col-sm-12">' +
                        '<label for="categoriaOption" class="float-left col-form-label">Categoria</label>' +
                        ''+cadenaOption+'' +
                    '</div>' +
                    '<div class="col-sm-12">' +
                        '<label for="marcaDescripcion" class="float-left col-form-label">Descripcion</label>' +
                        '<input type="text" class="form-control" id="marcaDescripcion" placeholder="Descripcion">' +
                    '</div>' +
                    '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }).then((result) => {
            if(result.isConfirmed){
                marcaDescripcion = document.getElementById('marcaDescripcion').value;
                if(marcaDescripcion != null || marcaDescripcion != ''){
                    $.ajax({
                        type: "get",
                        url: "{{route('agregarMarca')}}",
                        data:{'marcaDescripcion' : marcaDescripcion},
                        success: function(response){
                            $('#marca').append('<option value="'+response[0].id_marca+'" selected>'+response[0].descripcion+'</option>')
                            console.log(response);
                        },
                        error: function(e){
                            console.log(e);
                            Swal.fire({
                                html: e.responseText
                            })
                        }
                    });
                }else{
                    Swal("Oops", "No puede ir vacio!", "error");
                        return false;
                    }
                }
            });


            //validacion del modal
            $('#marcaDescripcion').on('input', function() {
                var input=$(this);
                var re = /[^A-Za-z0-9- ]+$/;
                var testing=re.test(input.val());
                if(testing === true){
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras,Números y Guíones!</div>');
                }
                else{
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }
                this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g,'').toUpperCase();
            });
        });
        //Agregar  modelo
        $('#agregarModelo').on('click', function() {
            //sacar una cadena de options para el sweet alert
            var cadenaOption = '<select class="form-control" id="marcaOption">';//inicializo variable para el options del sweet alert
            marcas.forEach(marca => {
                cadenaOption = cadenaOption +'<option value="'+marca.id_marca+'">'+marca.descripcion+'</option>';
            });
            cadenaOption = cadenaOption + '</select>';

            Swal.fire({
                title: "Agregar Modelo",
                html:
                    '<div class="form-group row">' +
                    '<div class="col-sm-12">' +
                        '<label for="modeloDescripcion" class="float-left col-form-label">Descripcion</label>' +
                        '<input type="text" class="form-control" id="modeloDescripcion" placeholder="Descripcion">' +
                    '</div>' +
                    '<div class="col-sm-12">' +
                        '<label for="marcaDescripcion" class="float-left col-form-label">Marca</label>' +
                        ''+cadenaOption+'' +
                    '</div>' +
                    '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }).then((result) => {
                if(result.isConfirmed){

                    modeloDescripcion = document.getElementById('modeloDescripcion').value;
                    marcaOption = document.getElementById('marcaOption').value;

                    if(modeloDescripcion != null || modeloDescripcion != ''){
                        $.ajax({
                            type: "get",
                            url: "{{route('agregarModelo')}}",
                            data:{'modeloDescripcion' : modeloDescripcion,'marcaOption' : marcaOption },
                            success: function(response){
                                $('#modelo').append('<option value="'+response[0].id_modelo+'" selected>'+response[0].descripcion+'</option>')
                                console.log(response);
                            },
                            error: function(e){
                                console.log(e);
                                Swal.fire({
                                    html: e.responseText
                                })
                            }
                        });
                    }else{
                        Swal("Oops", "No puede ir vacio!", "error");
                        return false;
                    }
                }
            });


            //validacion del modal
            $('#modeloDescripcion').on('input', function() {
                var input=$(this);
                var re = /[^A-Za-z0-9- ]+$/;
                var testing=re.test(input.val());
                if(testing === true){
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras,Números y Guíones!</div>');
                }
                else{
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }

                this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g,'').toUpperCase();

            });
        });
        //Agregar  categoria
        $('#agregarCategoria').on('click', function() {
            //sacar una cadena de options para el sweet alert
            Swal.fire({
                title: 'Agrega la descripción de la categoria',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Agregar Categoria',
                preConfirm: (descripcion) => {
                    if(descripcion){
                        descripcionCategoria = descripcion;
                    }else{
                        Swal.showValidationMessage(
                            `Error: Debes de llenar el formulario!`
                        )
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    console.log(descripcionCategoria);
                    $.ajax({
                        url: "{{route('Categoria.store')}}",
                        type: 'POST',
                        data: {'descripcion' : descripcionCategoria},
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response){

                            /*if (!response.ok) {
                                throw new Error(response);
                            }
                            Swal.fire({
                                html: response.responseText
                            })*/
                            $('#categoria').append('<option value="'+response[0].id_categoria+'" selected>'+response[0].descripcion+'</option>')
                            console.log(response);
                        },
                        error: function(e){
                            console.log(e);
                            Swal.fire({
                                html: e.responseText
                            })
                        }
                    });
                }
            })
        });
        //Agregar  color
        $('#agregarColor').on('click', function() {
            //sacar una cadena de options para el sweet alert
            Swal.fire({
                title: 'Agrega la descripción del color',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Agregar Color',
                preConfirm: (descripcion) => {
                    if(descripcion){
                        colorDescripcion = descripcion;
                    }else{
                        Swal.showValidationMessage(
                            `Error: Debes de llenar el formulario!`
                        )
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    console.log(colorDescripcion);
                    $.ajax({
                        url: "{{route('agregarColor')}}",
                        type: 'get',
                        data: {'colorDescripcion' : colorDescripcion},
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response){

                            /*if (!response.ok) {
                                throw new Error(response);
                            }
                            Swal.fire({
                                html: response.responseText
                            })*/
                            $('#color').append('<option value="'+response[0].id_color+'" selected>'+response[0].descripcion+'</option>')
                            console.log(response);
                        },
                        error: function(e){
                            console.log(e);
                            Swal.fire({
                                html: e.responseText
                            })
                        }
                    });
                }
            })
        });
        //Agregar  capacidad
        $('#agregarCapacidad').on('click', function() {
            //sacar una cadena de options para el sweet alert
            Swal.fire({
                title: 'Agrega la capaciad',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Agregar Color',
                preConfirm: (capacidad) => {
                    if(capacidad){
                        if(!isNaN(capacidad)){
                            capacidadDescripcion = capacidad;
                        }else{
                            Swal.showValidationMessage(
                                `Error: Debes de llenar el formulario con solo números!`
                            )
                        }
                    }else{
                        Swal.showValidationMessage(
                            `Error: Debes de llenar el formulario!`
                        )
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    console.log(capacidadDescripcion);
                    $.ajax({
                        url: "{{route('agregarCapacidad')}}",
                        type: 'get',
                        data: {'capacidadDescripcion' : capacidadDescripcion},
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response){

                            /*if (!response.ok) {
                                throw new Error(response);
                            }
                            Swal.fire({
                                html: response.responseText
                            })*/
                            $('#capacidad').append('<option value="'+response[0].id_capacidad+'" selected>'+response[0].tipo+'</option>')
                            console.log(response);
                        },
                        error: function(e){
                            console.log(e);
                            Swal.fire({
                                html: e.responseText
                            })
                        }
                    });
                }
            })
        });
        //Función para generar automáticamente un titulo para el producto
        function generarTitulo(){
            var checkBox = document.getElementById("checkGenerarTitulo");
            if (checkBox.checked == true){
                var cadenaTitulo = "";
                cadenaTitulo = $('#marca').val() + " " + $('#modelo').val() + " " + $('#color').val() + " " + $('#capacidad').val();
                $('#titulo').val(cadenaTitulo);
            }else{
                $('#titulo').val("");
            }
        }
        //Función que cambiar el texto del imput para saber el nombre de las imagenes seleccionadas para guardar en la base de datos
        $('#imagenProducto').change(function() {
            var filename = $('#imagenProducto').val().replace(/C:\\fakepath\\/i, '');
            $('#labelImagen').html(filename);
        });
    </script>
@endsection



