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
            <div class="form-horizontal " id="formCompra">
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
                                        <input type="number" class="form-control" name="busqueda" id="upc"
                                            placeholder="Busqueda por UPC/EAN de Inventario" minlength="12" maxlength="14"
                                            autofocus>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-warning fade show" style="display:none" id="alerta-upc">
                                        <strong>Ops!</strong> Este artículo no está registrado.
                                        <button type="button" id="boton-alerta" class="close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <div id="productoNuevo" style="display: none">
                                    <div class="form-group row ">
                                        <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                        <div class="col-sm-2 input-group">
                                            <input type="text" list="categoriaData" class="form-control" id="categoria"
                                                name="categoria" placeholder="Seleccionar Categoria" />
                                            <datalist id="categoriaData">
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria->categoria }}"></option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="agregarCategoria"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Marca</label>
                                        <div class="col-sm-2 input-group">
                                            <input type="text" list="marcaData" class="form-control" id="marca" name="marca"
                                                placeholder="Seleccionar Marca" />
                                            <datalist id="marcaData">
                                                @foreach ($marcas as $marca)
                                                    <option value="{{ $marca->marca }}">{{ $marca->marca }}</option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="agregarMarca"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                        <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
                                        <div class="col-sm-2 input-group">
                                            <input type="text" list="modeloData" class="form-control" id="modelo"
                                                name="modelo"
                                                            placeholder=" Seleccionar Modelo" />
                                            <datalist id="modeloData">
                                                @foreach ($modelos as $modelo)
                                                    <option value="{{ $modelo->modelo }}">{{ $modelo->modelo }}</option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="agregarModelo"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="costo" class="col-sm-2 col-form-label">Costo</label>
                                        <div class="col-sm-2 input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">$</span>
                                            </div>
                                            <input type="number" placeholder="Costo" class="form-control" id="costo" />
                                        </div>
                                        <label for="cantidad" class="col-sm-2 col-form-label">Cantidad (pza)</label>
                                        <div class="col-sm-2">
                                            <input type="number" placeholder="Cantidad" class="form-control" id="cantidad"
                                                value="1" />
                                        </div>
                                        <label for="color" class="col-sm-2 col-form-label">Color</label>
                                        <div class="col-sm-2 input-group">
                                            <input type="text" list="colorData" class="form-control" id="color" name="color"
                                                placeholder="Seleccionar Color" />
                                            <datalist id="colorData">
                                                @foreach ($colores as $color)
                                                    <option value="{{ $color->color }}">{{ $color->color }}</option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="agregarColor"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <input type="button" class="btn btn-success form-control" id="agregarProducto"
                                            onclick="agregarProducto()" value="Agregar Producto" disabled>
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
                                        <tbody class="scroll" id="paqueteTicketTabla">

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
                                        <input type="text" class="form-control @error('numero') is-invalid @enderror"
                                            name="numero" id="numero" placeholder="No. Compra"
                                            value="{{ old('numero') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Proveedor</label>
                                    <div class="col-sm-8 input-group">
                                        <input type="text" list="proveedorData"
                                            class="form-control @error('proveedor') is-invalid @enderror" id="proveedor"
                                            name="proveedor" value="{{ old('proveedor') }}"
                                            placeholder="Seleccionar Proveedor" />
                                        <datalist id="proveedorData">
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->proveedor }}">
                                                    {{ $proveedor->proveedor }}
                                                </option>
                                            @endforeach
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarProveedor"><i
                                                    class="fas fa-plus"></i></button>
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
                                        <input type="text" class="form-control @error('total') is-invalid @enderror"
                                            id="total" name="total" value="{{ old('total') }}" placeholder="Total"
                                            readonly />
                                    </div>
                                </div>
                                <hr>
                                <div class="form-input row">
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                            <input type="checkbox" class="form-check-input" id="checkFinalizar"
                                                name="checkFinalizar" onclick="checkFinalizarCompra()">
                                            <label class="form-check-label" for="checkFinalizar">Finalizar Compra</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="submit" value="Registrar Compra" class="btn btn-success float-right"
                                            disabled id="agregarCompra" onclick="finalizarCompra()">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.card-footer -->
                </div>
            </div>
            <div class="alert" id="mensajeCompra" style="display:none">
                <ul>
                    Compra realizada correctamente!
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
    <!-- /Callback-->
    <script>
        var modelos = @json($modelos);
        var marcas = @json($marcas);
        var categorias = @json($categorias);
        let total = 0;
        //Busca el producto en la BD, des ser enontrado lo agrea con sus datos, sino, agrega un renglón para que el usuario inserte los datos
        $('#upc').on('input', function() {
            upc = $(this).val();
            upc = upc.toString();
            if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);
            if (upc.length == 12 || upc.length == 13 || upc.length == 14) {
                $.ajax({
                    type: "get",
                    url: "{{ route('verificarUPCVenta') }}",
                    data: {
                        'upc': $(this).val()
                    },
                    success: function(data) {
                        //console.log(data);
                        if (data.res == false) {
                            $('#alerta-upc').show();
                            $('#categoria').attr('disabled', false);
                            $('#marca').attr('disabled', false);
                            $('#modelo').attr('disabled', false);
                            $('#productoNuevo').show();
                            $('#agregarProducto').attr('disabled', false);
                            $('#agregarProducto').focus();
                        } else {
                            $('#productoNuevo').show();
                            $('#categoria').attr('disabled', true);
                            $('#marca').attr('disabled', true);
                            $('#modelo').attr('disabled', true);
                            $('#categoria').val(data[0][0].categoria);
                            $('#marca').val(data[0][0].marca);
                            $('#modelo').val(data[0][0].modelo);
                            $('#color').val(data[0][0].color);
                            $('#costo').val(data[0][0].costo);
                            $('#cantidad').val(1);
                            $('#agregarProducto').attr('disabled', false);
                            $('#agregarProducto').focus();
                        }

                    },
                    error: function(data) {
                        console.log(data);
                        Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                    }
                });
            }
        });
        //Remueve los productos del ticket de compra
        function quitarProducto(elem) {
            elem.remove();
            calcularTotal();
        }
        //Cálcula el total de la compra
        function calcularTotal() {
            total = 0;
            if ($('#paqueteTicketTabla').children()) {
                $.each($('#paqueteTicketTabla').children(), function() {
                    total += $(this).find('.costo').text() * $(this).find('.cantidad').text();
                });
                $('#total').val(total);
            } else {
                $('#total').val("");
            }

        }
        //Función para habílitar el botón que envía los datos el controlador
        function checkFinalizarCompra() {
            var checkBox = document.getElementById("checkFinalizar");
            if (checkBox.checked == true) {
                $('#agregarCompra').attr('disabled', false);
            } else {
                $('#agregarCompra').attr('disabled', true);
            }
        }
        //Función para agragr productos a la tabla de productos de la compra
        function agregarProducto() {
            $('#paqueteTicketTabla').append(
                '<tr>' +
                '<td id="upc_art">' + $('#upc').val() + '</td>' +
                '<td id="categoriaTabla">' + $('#categoria').val() + '</td>' +
                '<td id="marcaTabla">' + $('#marca').val() + '</td>' +
                '<td id="modeloTabla">' + $('#modelo').val() + '</td>' +
                '<td id="colorTabla">' + $('#color').val() + '</td>' +
                '<td id="cantidadTabla">' + $('#cantidad').val() + '</td>' +
                '<td id="costoTabla">' + $('#costo').val() + '</td>' +
                '<td><a href="#" class="btn btn-danger form-control form-control-sm" onclick="quitarProducto($(this).parent().parent())"><i class="far fa-trash-alt"></i></a></td>' +
                '</tr>'
            );
            $('#productoNuevo').hide();
            $('#agregarProducto').attr('disabled', true);
            $('#upc').val("");
            calcularTotal();
        }
        //Cargar modelos dependiendo de la marca
        $('#marca').on('change', function() {
            if ($(this).val() != null) {
                $('#modeloData option').remove();
                modelos.forEach(modelo => {
                    if ($(this).val() == modelo.marca) {
                        $('#modeloData').append('<option value="' + modelo.modelo + '">' + modelo.modelo +
                            '</option>');
                    }
                });
            }
        });
        //Agregar marca
        $('#agregarMarca').on('click', function() {
            //sacar una cadena de options para el sweet alert
            var cadenaOption =
                '<select class="form-control" id="categoriaOption">'; //inicializo variable para el options del sweet alert
            categorias.forEach(categoria => {
                cadenaOption = cadenaOption + '<option value="' + categoria.categoria + '">' + categoria
                    .categoria + '</option>';
            });
            cadenaOption = cadenaOption + '</select>';
            Swal.fire({
                title: "Agregar Marca",
                html: '<div class="form-group row">' +
                    '<div class="col-sm-12">' +
                    '<label for="categoriaOption" class="float-left col-form-label">Categoria</label>' +
                    '' + cadenaOption + '' +
                    '</div>' +
                    '<div class="col-sm-12">' +
                    '<label for="marcaDescripcion" class="float-left col-form-label">Descripcion</label>' +
                    '<input type="text" class="form-control" id="marcaDescripcion" placeholder="Descripcion">' +
                    '</div>' +
                    '</div>',
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }).then((result) => {
                if (result.isConfirmed) {
                    marcaDescripcion = document.getElementById('marcaDescripcion').value;
                    categoriaOption = document.getElementById('categoriaOption').value;
                    if (marcaDescripcion != null || marcaDescripcion != '') {
                        $.ajax({
                            type: "get",
                            url: "{{ route('agregarMarca') }}",
                            data: {
                                'marcaDescripcion': marcaDescripcion,
                                'categoriaOption': categoriaOption
                            },
                            success: function(response) {
                                $('#marca').val(response[0].marca);
                                $('#marcaData').append('<option value="' + response[0].marca +
                                    '">' + response[0].marca + '</option>');
                                console.log(response);
                            },
                            error: function(e) {
                                console.log(e);
                                Swal.fire({
                                    html: e.responseText
                                })
                            }
                        });
                    } else {
                        Swal("Oops", "No puede ir vacio!", "error");
                        return false;
                    }
                }
            });


            //validacion del modal
            $('#marcaDescripcion').on('input', function() {
                var input = $(this);
                var re = /[^A-Za-z0-9- ]+$/;
                var testing = re.test(input.val());
                if (testing === true) {
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append(
                        '<div class="invalid-feedback error">Error solo se permiten Letras,Números y Guíones!</div>'
                    );
                } else {
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }
                this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g, '').toUpperCase();
            });
        });
        //Agregar  modelo
        $('#agregarModelo').on('click', function() {
            //sacar una cadena de options para el sweet alert
            var cadenaOption =
                '<select class="form-control" id="marcaOption">'; //inicializo variable para el options del sweet alert
            marcas.forEach(marca => {
                if ($('#marca').val() == marca.marca) {
                    cadenaOption = cadenaOption + '<option value="' + marca.marca + '" selected>' + marca
                        .marca + '</option>';
                } else {
                    cadenaOption = cadenaOption + '<option value="' + marca.marca + '">' + marca.marca +
                        '</option>';
                }

            });
            cadenaOption = cadenaOption + '</select>';

            Swal.fire({
                title: "Agregar Modelo",
                html: '<div class="form-group row">' +
                    '<div class="col-sm-12">' +
                    '<label for="modeloDescripcion" class="float-left col-form-label">Descripcion</label>' +
                    '<input type="text" class="form-control" id="modeloDescripcion" placeholder="Descripcion">' +
                    '</div>' +
                    '<div class="col-sm-12">' +
                    '<label for="marcaDescripcion" class="float-left col-form-label">Marca</label>' +
                    '' + cadenaOption + '' +
                    '</div>' +
                    '</div>',
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }).then((result) => {
                if (result.isConfirmed) {

                    modeloDescripcion = document.getElementById('modeloDescripcion').value;
                    marcaOption = document.getElementById('marcaOption').value;

                    if (modeloDescripcion != null || modeloDescripcion != '') {
                        $.ajax({
                            type: "get",
                            url: "{{ route('agregarModelo') }}",
                            data: {
                                'modeloDescripcion': modeloDescripcion,
                                'marcaOption': marcaOption
                            },
                            success: function(response) {
                                $('#modelo').val(response[0].modelo);
                                $('#modeloData').append('<option value="' + response[0].modelo +
                                    '">' + response[0].modelo + '</option>')
                                console.log(response);
                            },
                            error: function(e) {
                                console.log(e);
                                Swal.fire({
                                    html: e.responseText
                                })
                            }
                        });
                    } else {
                        Swal("Oops", "No puede ir vacio!", "error");
                        return false;
                    }
                }
            });


            //validacion del modal
            $('#modeloDescripcion').on('input', function() {
                var input = $(this);
                var re = /[^A-Za-z0-9- ]+$/;
                var testing = re.test(input.val());
                if (testing === true) {
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append(
                        '<div class="invalid-feedback error">Error solo se permiten Letras,Números y Guíones!</div>'
                    );
                } else {
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }

                this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g, '').toUpperCase();

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
                    if (descripcion) {
                        descripcionCategoria = descripcion;
                    } else {
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
                        url: "{{ route('Categoria.store') }}",
                        type: 'POST',
                        data: {
                            'descripcion': descripcionCategoria
                        },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            /*if (!response.ok) {
                                throw new Error(response);
                            }
                            Swal.fire({
                                html: response.responseText
                            })*/
                            $('#categoriaData').append('<option value="' + response[0]
                                .categoria + '">' + response[0].categoria + '</option>');
                            $('#categoria').val(response[0].categoria);
                            console.log(response);
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
                    if (descripcion) {
                        colorDescripcion = descripcion;
                    } else {
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
                        url: "{{ route('agregarColor') }}",
                        type: 'get',
                        data: {
                            'colorDescripcion': colorDescripcion
                        },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            /*if (!response.ok) {
                                throw new Error(response);
                            }
                            Swal.fire({
                                html: response.responseText
                            })*/
                            $('#color').val(response[0].color);
                            $('#colorData').append('<option value="' + response[0].color +
                                '">' + response[0].color + '</option>')
                            console.log(response);
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
        });
        //Agregar  Proveedor
        $('#agregarProveedor').on('click', function() {
            //sacar una cadena de options para el sweet alert
            Swal.fire({
                title: 'Agrega el nombre del proveedor',
                input: 'text',
                showCancelButton: true,
                confirmButtonText: 'Agregar Proveedor',
                preConfirm: (descripcion) => {
                    if (descripcion) {
                        proveedorDescripcion = descripcion;
                    } else {
                        Swal.showValidationMessage(
                            `Error: Debes de llenar el formulario!`
                        )
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(result);
                    console.log(proveedorDescripcion);
                    $.ajax({
                        url: "{{ route('agregarProveedorInventario') }}",
                        type: 'get',
                        data: {
                            'proveedorDescripcion': proveedorDescripcion
                        },
                        dataType: 'JSON',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {

                            /*if (!response.ok) {
                                throw new Error(response);
                            }
                            Swal.fire({
                                html: response.responseText
                            })*/
                            $('#proveedor').val(response[0].proveedor);
                            $('#proveedorData').append('<option value="' + response[0]
                                .proveedor + '">' + response[0].proveedor + '</option>')
                            console.log(response);
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
        });
        //Función que envía el formulario al controlador
        function finalizarCompra() {
            $('#mensajeCompra').hide();
            compra = "";
            proveedor = "";
            productos = [];
            proveedorValidacion = true;
            totalValidacion = true;
            productosValidacion = true;
            numeroCompraValidacion = true;
            if(!$('#numero').val()){
                $('#numero').addClass('is-invalid');
                numeroCompraValidacion = false;
            }  else {
                $('#numero').removeClass('is-invalid');
                compra = $('#numero').val();
                numeroCompraValidacion = true;
            }
            if (!$('#proveedor').val()) {
                $('#proveedor').addClass('is-invalid');
                proveedorValidacion = false;
            } else {
                $('#proveedor').removeClass('is-invalid');
                proveedor = $('#proveedor').val();
                proveedorValidacion = true;
            }

            $.each($('#paqueteTicketTabla').children(), function(i, x) {
                productos.push({
                    'upc': $(this).find('#upc_art').text(),
                    'piezas': $(this).find('#cantidadTabla').text(),
                    'costo': $(this).find('#costoTabla').text(),
                    'categoria': $(this).find('#categoriaTabla').text(),
                    'marca': $(this).find('#marcaTabla').text(),
                    'modelo': $(this).find('#modeloTabla').text(),
                    'color': $(this).find('#colorTabla').text()
                });
            });
            if (productos.length == 0) {
                $('#mensajeTicket').show();
                productosValidacion = false;
            } else {
                $('#mensajeTicket').hide();
                productosValidacion = true;
            }

            if (total) {
                totalValidacion = false;
            } else {
                totalValidacion = true;
            }
            if (proveedorValidacion == true && productosValidacion == true && totalValidacion == true &&
                numeroCompraValidacion == true) {
                $.ajax({
                    type: "post",
                    url: "{{ route('Compra.store') }}",
                    data: {
                        'compra': compra,
                        'proveedor': proveedor,
                        'total': total,
                        'productos': productos
                    },
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        console.log(response);
                        /*if(response.response == "success"){
                            $('#mensajeCompra ul').text(response.message);
                            $('#mensajeCompra').removeClass('alert-danger').addClass('alert-success');
                            $('#mensajeCompra').show();
                        }else{
                            $('#mensajeCompra ul').text(response.message);
                            $('#mensajeCompra').removeClass('alert-success').addClass('alert-danger');
                            $('#mensajeCompra').show();
                        }
                        limpiarFormulario();*/
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
