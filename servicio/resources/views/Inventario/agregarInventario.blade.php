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
            <form action="{{route('Inventario.store')}}" method="POST" class="form-horizontal " id="formInventario">
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
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('upc') is-invalid @enderror" name="upc" id="upc" placeholder="UPC" value="{{ old('upc')}}" autofocus>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="Categoria">
                                    <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" id="categoria" name="categoria" disabled>
                                            <option value="0">Seleccionar Categoria</option>
                                            @foreach($categorias as $categoria)
                                                @if(old('categoria') == $categoria->id_categoria)
                                                    <option value="{{$categoria->id_categoria}}" selected>{{$categoria->descripcion}}</option>
                                                @else
                                                    <option value="{{$categoria->id_categoria}}">{{$categoria->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarCategoria" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="marca" class="col-sm-2 col-form-label">Marca</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="marca" name="marca" disabled>
                                            <option value="0">Seleccionar Marca</option>
                                            @foreach($marcas as $marca)
                                                @if(old('marca') == $marca->id_marca)
                                                    <option value="{{$marca->id_marca}}" selected> {{$marca->descripcion}}</option>
                                                @else
                                                    <option value="{{$marca->id_marca}}"> {{$marca->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
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
                                        <select class="form-control" id="modelo" name="modelo" disabled>
                                            <option value="0">Seleccionar Modelo</option>
                                            @foreach($modelos as $modelo)
                                                @if(old('modelo') == $modelo->id_modelo)
                                                    <option value="{{$modelo->id_modelo}}" selected>{{$modelo->descripcion}}</option>
                                                @else
                                                    <option value="{{$modelo->id_modelo}}">{{$modelo->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarModelo" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2 col-form-label">Color</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="color" name="color" disabled>
                                            <option value="0">Color</option>
                                            @foreach($colores as $color)
                                                @if(old('color') == $color->id_color)
                                                    <option value="{{$color->id_color}}" selected>{{$color->descripcion}}</option>
                                                @else
                                                    <option value="{{$color->id_color}}">{{$color->descripcion}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarColor" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <label for="capacidad" class="col-sm-2 col-form-label">Capacidad</label>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="capacidad" name="capacidad" disabled>
                                            <option value="0">Capacidad</option>
                                            @foreach($capacidades as $capacidad)
                                                @if(old('capacidad') == $capacidad->id_capacidad)
                                                    <option value="{{$capacidad->id_capacidad}}" selected>{{$capacidad->tipo}}</option>
                                                @else
                                                    <option value="{{$capacidad->id_capacidad}}">{{$capacidad->tipo}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarCapacidad" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group row" id="onlineTitulo">
                                    <label for="titulo" class="col-sm-3 col-form-label">Título</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" id="titulo" placeholder="Título" value="{{ old('titulo')}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row" id="onlineDescripcion">
                                    <label for="descripcion" class="col-sm-3 col-form-label">Descripción</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="4" placeholder="Descripción" name="descripcion" disabled>{{ old('descripcion')}}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="costo" class="col-sm-2 col-form-label">Costo ($)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo" placeholder="Costo" value="{{ old('costo')}}" disabled>
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
                                        <input type="number" class="form-control @error('precioMin') is-invalid @enderror" id="precioMin" name="precioMin" placeholder="Precio Mínimo" value="{{ old('precioMin')}}" disabled>
                                    </div>
                                    <label for="precioMax" class="col-sm-3 col-form-label">Precio Max.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('precioMax') is-invalid @enderror" id="precioMax" name="precioMax" placeholder="Precio Máximo" value="{{ old('precioMax')}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="publico" class="col-sm-3 col-form-label">Precio Pub.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('publico') is-invalid @enderror" id="publico" name="publico" placeholder="Precio Público" value="{{ old('publico')}}" disabled>
                                    </div>
                                    <label for="mayoreo" class="col-sm-3 col-form-label">Precio May.</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('mayoreo') is-invalid @enderror" id="mayoreo" name="mayoreo" placeholder="Precio Mayoreo" value="{{ old('mayoreo')}}" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="largo" class="col-sm-2 col-form-label">Largo(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('largo') is-invalid @enderror" id="largo" name="largo" placeholder="Largo" value="{{ old('largo')}}" disabled>
                                    </div>

                                    <label for="alto" class="col-sm-2 col-form-label">Alto(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('alto') is-invalid @enderror" id="alto" name="alto" placeholder="Alto" value="{{ old('alto')}}" disabled>
                                    </div>

                                    <label for="ancho" class="col-sm-2 col-form-label">Ancho(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('ancho') is-invalid @enderror" id="ancho" name="ancho" placeholder="Ancho" value="{{ old('ancho')}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>
                    <section class="col-lg-6 connectedSortable" >
                        <div class="card card-warning" name="detalle">
                            <div class="card-header">
                                <h3 class="card-title col-11">Detalle Inventario</h3>
                                <button type="button" class="btn btn-secondary" id="agregarDetalleInventario" disabled><i class="fas fa-plus"></i></button>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <div class="card-body scroll" id="detalleInventario"></div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Agregar Inventario" class="btn btn-success float-right" id="agregarInventario" disabled>
                            </div>
                            <!-- /.card-footer -->
                        </div>
                    </section>
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
        var upc = "";
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
                            Swal.fire("Oops", "Ese artículo no existe en el inventario, registralo!", "info");
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
            $('#agregarInventario').attr('disabled', false);
            $('#agregarDetalle').attr('disabled', false);
            $('#agregarDetalleInventario').attr('disabled', false);
            $('#formInventario').find('.card-body').children().each(function(){
                if($(this).attr('id') != 'onlineTitulo' && $(this).attr('id') != 'onlineDescripcion'){
                    $(this).find('input[type="text"],input[type="number"],textarea,select,button').attr('disabled', false);
                }
            });
            if(estado != false){
                $('#categoria option[value="'+datosFormulario[0].id_categoria+'"]').prop('selected', 'selected');
                $('#marca option[value="'+datosFormulario[0].id_marca+'"]').prop('selected', 'selected');
                $('#modelo option[value="'+datosFormulario[0].id_modelo+'"]').prop('selected', 'selected');
                $('#color option[value="'+datosFormulario[0].id_color+'"]').prop('selected', 'selected');
                $('#capacidad option[value="'+datosFormulario[0].id_capacidad+'"]').prop('selected', 'selected');
                $('#titulo').val(datosFormulario[0].titulo);
                $('#descripcion').val(datosFormulario[0].descripcion_inventario);
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
            if($('#categoria').prop('selectedIndex') != 0){
                if($('#categoria').prop('selectedIndex') == 1){
                    $('#detalleInventario').append(
                        '<div class="form-group row agregado">'+
                            '<label for="imei" class="col-sm-2 col-form-label">IMEI</label>'+
                            '<div class="col-sm-2">'+
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
                }else if($('#categoria').prop('selectedIndex') == 2){
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
                }else if($('#categoria').prop('selectedIndex') == 3){
                    $('#detalleInventai')
                }
            }
        });
        //Funcion para habílitar el campo de bateria de los equipos
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
            Swal.fire({
                title: "Agregar Marca",
                html:
                    '<div class="form-group row">' +
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
    </script>
@endsection



