@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Editar Inventario</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>
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
    @if (session('error'))
        <div class="alert alert-danger text-center msg" id="error">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif
    <!-- /Callback-->
    <!-- /.container-fluid -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form action="{{ route('Inventario.update', $inventario[0]->id_inventario) }}" method="POST"
                class="form-horizontal " id="formInventario" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <section class="col-12 connectedSortable">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Inventario</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <h4 class="col-12">Código de Barras</h4>
                                </div>
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">UPC/EAN</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="number" class="form-control @error('upc') is-invalid @enderror"
                                            name="upc" id="upc" placeholder="UPC"
                                            value="{{ old('upc', $inventario[0]->upc) }}" minlength="12" maxlength="14"
                                            autofocus>
                                    </div>
                                    <label for="proveedor" class="col-sm-2 col-form-label">Proveedor</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="proveedorData"
                                            class="form-control @error('proveedor') is-invalid @enderror" id="proveedor"
                                            name="proveedor" value="{{ old('proveedor', $inventario[0]->proveedor) }}"
                                            placeholder="Seleccionar Proveedor" />
                                        <datalist id="proveedorData">
                                            @foreach ($proveedores as $proveedor)
                                                <option value="{{ $proveedor->proveedor }}">{{ $proveedor->proveedor }}
                                                </option>
                                            @endforeach
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarProveedor"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-check row">
                                    <div class="col-sm-12">
                                        @if ($inventario[0]->venta_online)
                                            <input type="checkbox" class="form-check-input" id="checkOnline"
                                                name="checkOnline" checked onclick="checkVentaOnline()">
                                        @else
                                            <input type="checkbox" class="form-check-input" id="checkOnline"
                                                name="checkOnline" onclick="checkVentaOnline()">
                                        @endif
                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkOnline">Venta online?</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-warning fade show" style="display:none" id="alerta-upc">
                                        <strong>Ops!</strong> Este artículo no está registrado.
                                        <button type="button" id="boton-alerta" class="close">
                                            <span>&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <h4 class="col-12">Datos Del Producto</h4>
                                </div>
                                <div class="form-group row" id="Categoria">
                                    <label for="categoria" class="col-sm-1 col-form-label">Categoria</label>
                                    <div class="col-sm-2 input-group">
                                        <input type="text" list="categoriaData"
                                            class="form-control @error('categoria') is-invalid @enderror" id="categoria"
                                            name="categoria" value="{{ old('categoria', $inventario[0]->categoria) }}"
                                            placeholder="Seleccionar Categoria" />
                                        <datalist id="categoriaData">
                                            @foreach ($categorias as $categoria)
                                                <option value="{{ $categoria->categoria }}"></option>
                                                @foreach ($subcategorias as $subcategoria)
                                                    @if ($subcategoria->id_categoria == $categoria->id_categoria)
                                                        <option class="sub" value="{{ $subcategoria->subcategoria }}">
                                                        </option>
                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarCategoria"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <label class="col-sm-1 col-form-label">Marca</label>
                                    <div class="col-sm-2 input-group">
                                        <input type="text" list="marcaData"
                                            class="form-control @error('marca') is-invalid @enderror" id="marca"
                                            name="marca" value="{{ old('marca', $inventario[0]->marca) }}"
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
                                    <label for="modelo" class="col-sm-1 col-form-label">Modelo</label>
                                    <div class="col-sm-2 input-group">
                                        <input type="text" list="modeloData"
                                            class="form-control @error('modelo') is-invalid @enderror" id="modelo"
                                            name="modelo" value="{{ old('modelo', $inventario[0]->modelo) }}"
                                            placeholder="Seleccionar Modelo" />
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
                                    <label for="color" class="col-sm-1 col-form-label">Color</label>
                                    <div class="col-sm-2 input-group">
                                        <input type="text" list="colorData"
                                            class="form-control @error('color') is-invalid @enderror" id="color"
                                            name="color" value="{{ old('color', $inventario[0]->color) }}"
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

                                <div class="form-group row" id="onlineTitulo">
                                    <label for="titulo" class="col-sm-1 col-form-label">Título</label>
                                    <div class="col-sm-11">
                                        <input type="text" class="form-control @error('titulo') is-invalid @enderror"
                                            name="titulo" id="titulo" placeholder="Título"
                                            value="{{ old('titulo', $inventario[0]->titulo_inventario) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-4">
                                        <div class="form-check form-check-inline">
                                            @if (count($compatibilidad) > 0)
                                                <input type="checkbox" class="form-check-input" id="checkCompatibilidad"
                                                    name="checkCompatibilidad" checked
                                                    onclick="checkCompatibilidadModelos()">
                                            @else
                                                <input type="checkbox" class="form-check-input" id="checkCompatibilidad"
                                                    name="checkCompatibilidad" onclick="checkCompatibilidadModelos()">
                                            @endif
                                            <label class="form-check-label" for="checkCompatibilidad">Compatibilidad con
                                                modelos?</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="divCompatibilidad"
                                    style="display: {{ count($compatibilidad) > 0 ? 'block' : 'none' }}">
                                    <hr>
                                    <div class="form-group row">
                                        <h4 class="col-12">Compatibilidad</h4>
                                    </div>
                                    <div class="form-group row ">
                                        <label for="marca2" class="col-sm-2 col-form-label">Marca</label>
                                        <div class="col-sm-4">
                                            <input type="text" list="marcaData2" class="form-control" id="marca2"
                                                name="marca2" placeholder="Seleccionar Marca" />
                                            <datalist id="marcaData2">
                                                @foreach ($marcas as $marca)
                                                    <option value="{{ $marca->marca }}">{{ $marca->marca }}</option>
                                                @endforeach
                                            </datalist>
                                        </div>
                                        <label for="modelo2" class="col-sm-2 col-form-label">Modelo</label>
                                        <div class="col-sm-4 input-group">
                                            <input type="text" list="modeloData2" class="form-control" id="modelo2"
                                                name="modelo2" placeholder="Seleccionar Modelo" />
                                            <datalist id="modeloData2">
                                                @foreach ($modelos as $modelo)
                                                    <option value="{{ $modelo->modelo }}">{{ $modelo->modelo }}
                                                    </option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-success" id="agregarCompatibilidad"><i
                                                        class="fas fa-plus"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <table class="table col-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Modelo</th>
                                                    <th scope="col">Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablaCompatibilidad">
                                                @if (count($compatibilidad) > 0)
                                                    @foreach ($compatibilidad as $compa)
                                                        <tr>
                                                            <th scope="row"><input type="text"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ $compa->modelo }}"
                                                                    name="compatibilidad[][modelo]" readonly></th>
                                                            <th scope="row"><a href="#" class="btn btn-danger btn-sm"
                                                                    onclick="$(this).parent().parent().remove()"><i
                                                                        class="fas fa-trash"></i></a></th>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="onlineImagen" style="display: none">
                                    <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                    <div class="custom-file col-sm-10">
                                        <input type="file" class="custom-file-input" name="imagenProducto"
                                            id="imagenProducto" accept="image/png, image/jpeg, image/webp" disabled>
                                        <label class="custom-file-label" id="labelImagen" for="imagenProducto">Elegir
                                            Imagen...</label>
                                    </div>
                                    <img src="" class="rounded mx-auto d-block" alt="" id="imagen">
                                </div>
                                <div class="form-group row" id="onlineDescripcion" style="display: none">
                                    <label for="descripcion" class="col-sm-2 col-form-label">Descripción</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror"
                                            id="descripcion" rows="4" placeholder="Descripción" name="descripcion"
                                            disabled>{{ old('descripcion', $inventario[0]->descripcion_inventario) }}</textarea>
                                    </div>
                                </div>
                                <hr style="display: none" id="hrOnline">
                                <div class="form-group row">
                                    <h4 class="col-12">Sucursal y Stock</h4>
                                </div>
                                <div class="form-group row" id="sucursalStock">
                                    <label for="sucursal" class="col-sm-2 col-form-label">Sucursal</label>
                                    <input type="text" list="sucursalData" class="form-control col-4" id="sucursal"
                                        name="sucursal" value="{{ old('sucursal') }}"
                                        placeholder="Seleccionar Sucursal" />
                                    <datalist id="sucursalData">
                                        @foreach ($sucursales as $sucursal)
                                            <option value="{{ $sucursal->sucursal }}">{{ $sucursal->sucursal }}
                                            </option>
                                        @endforeach
                                    </datalist>
                                    <div class="input-group col-6">
                                        <label for="stock" class="col-sm-3 col-form-label">Stock (pz)</label>
                                        <input type="number" min="1" class="form-control" id="stock" name="stock"
                                            placeholder="Stock">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" id="agregarStockSucursal"><i
                                                    class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <table class="table col-4">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="1">Sucursal</th>
                                                <th scope="col" colspan="1">Stock</th>
                                                <th scope="col" colspan="2">Etiquetas Impresión</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaStockSucursal">
                                            @if (count($detalle_inventario) > 0)
                                                {{ $x = 0 }}
                                                @foreach ($detalle_inventario as $detalle)
                                                    <tr>
                                                        <th scope="row"><input type="text"
                                                                class="form-control form-control-sm"
                                                                value="{{ $detalle->sucursal }}"
                                                                name="detalleInventario[{{ $x }}][sucursal]"
                                                                readonly></th>
                                                        <th scope="row"><input type="number" min="0"
                                                                class="form-control form-control-sm"
                                                                value="{{ $detalle->stock }}"
                                                                name="detalleInventario[{{ $x }}][stock]"></th>
                                                        <th scope="row"><input type="number" min="0"
                                                                class="form-control form-control-sm"
                                                                value="{{ $detalle->stock }}"
                                                                name="detalleInventario[{{ $x }}][etiquetas]">
                                                        </th>
                                                        <th scope="row"><a href="#" class="btn btn-danger btn-sm"
                                                                onclick="$(this).parent().parent().remove(); conteoDetalle -= 1;"><i
                                                                    class="fas fa-trash"></i></a></th>
                                                    </tr>
                                                    {{ $x++ }}
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <h4 class="col-12">Costo y Stock Mínimo</h4>
                                </div>
                                <div class="form-group row">
                                    <label for="costo" class="col-sm-2 col-form-label">Costo ($)</label>
                                    <div class="col-sm-4">
                                        <input type="number" min="0.01"
                                            class="form-control @error('costo') is-invalid @enderror" id="costo"
                                            name="costo" placeholder="Costo" step="0.01"
                                            value="{{ old('costo', $inventario[0]->costo) }}">
                                    </div>
                                    <label for="stockMin" class="col-sm-2 col-form-label">Stock Mínimo (pz)</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control @error('stockMin') is-invalid @enderror"
                                            min="1" id="stockMin" name="stockMin" placeholder="Stock Mínimo"
                                            value="{{ old('stockMin', $inventario[0]->stock_min) }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <h4 class="col-12">Precios</h4>
                                </div>
                                <div class="form-group row">
                                    <label for="precioMin" class="col-sm-2 col-form-label">Precio Min.</label>
                                    <div class="col-sm-2">
                                        <input type="number"
                                            class="form-control precios @error('precioMin') is-invalid @enderror"
                                            id="precioMin" name="precioMin" placeholder="Precio Mínimo" min="0.01"
                                            step="0.01" value="{{ old('precioMin', $inventario[0]->precio_min) }}">
                                    </div>
                                    <label for="precioMax" class="col-sm-2 col-form-label">Precio Max.</label>
                                    <div class="col-sm-2">
                                        <input type="number"
                                            class="form-control precios @error('precioMax') is-invalid @enderror"
                                            id="precioMax" name="precioMax" placeholder="Precio Máximo" min="0.01"
                                            step="0.01" value="{{ old('precioMax', $inventario[0]->precio_max) }}">
                                    </div>
                                    <label for="mayoreo" class="col-sm-2 col-form-label">Precio May.</label>
                                    <div class="col-sm-2">
                                        <input type="number"
                                            class="form-control precios @error('mayoreo') is-invalid @enderror" id="mayoreo"
                                            name="mayoreo" placeholder="Precio Mayoreo" min="0.01" step="0.01"
                                            value="{{ old('mayoreo', $inventario[0]->precio_mayoreo) }}">
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <h4 class="col-12">Medidas</h4>
                                </div>
                                <div class="form-group row">
                                    <label for="largo" class="col-sm-2 col-form-label">Largo(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('largo') is-invalid @enderror"
                                            id="largo" name="largo" min="0.01" placeholder="Largo" step="0.01"
                                            value="{{ old('largo', $inventario[0]->largo) }}">
                                    </div>

                                    <label for="alto" class="col-sm-2 col-form-label">Alto(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('alto') is-invalid @enderror"
                                            id="alto" name="alto" min="0.01" placeholder="Alto" step="0.01"
                                            value="{{ old('alto', $inventario[0]->alto) }}">
                                    </div>

                                    <label for="ancho" class="col-sm-2 col-form-label">Ancho(m)</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('ancho') is-invalid @enderror"
                                            id="ancho" name="ancho" min="0.01" placeholder="Ancho" step="0.01"
                                            value="{{ old('ancho', $inventario[0]->ancho) }}">
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </section>
                </div>
                <div class="row">
                    <section class="col-12 connectedSortable">
                        <div class="card card-success" name="finalizar">
                            <div class="card-header">
                                <h3 class="card-title col-11">Finalizar</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-input row">
                                    <div class="col-sm-6">
                                        <div class="form-check form-check-inline">
                                                <input type="checkbox" class="form-check-input" id="checkFinalizar"
                                                    name="checkFinalizar" onclick="checkFinalizarInventario()">
                                                <label class="form-check-label" for="checkFinalizar">Finalizar Proceso</label>
                                            </div>
                                    </div>
                                    <div class="col-sm-12 text-center">
                                        <input type="submit" value="Editar Inventario" class="btn btn-success "
                                            id="editarInventario" disabled>
                                        <div class="spinner-border spinner-layer spinner-blue-only" role="status"
                                            id="loading" style="display:none">
                                            <span class="sr-only">Loading...</span>
                                        </div>

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

    <script>
        var detalle_inventario = @json($detalle_inventario);
        let conteoDetalle = detalle_inventario.length;

        var modelos = @json($modelos);
        var marcas = @json($marcas);
        var categorias = @json($categorias);
        var upc = "";
        var detalleRadio = 0;
        var subcategoriaTitulo = $('#categoria').val();
        var marcaTitulo = $('#marca').val();
        var modeloTitulo = $('#modelo').val();
        var colorTitulo = $('#color').val();
        var compatibilidadTitulo = "";
        let marcasExtras = [];
        //Función para detectar cunado se ingrese un UPC
        $(document).ready(function() {
            if ($('#tablaCompatibilidad').find('tr')) {
                $.each($('#tablaCompatibilidad').find('tr'), function() {
                    console.log($(this).children().eq(0).children().val());
                    compatibilidadTitulo += $(this).children().eq(0).children().val() + "/";
                });
            }
        });
        $('#upc').on('input', function() {
            upc = $(this).val();
            upc = upc.toString();
            if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);
            //calcularUPC(upc);
            if (upc.length == 12 || upc.length == 13 || upc.length == 14) {
                $.ajax({
                    type: "get",
                    url: "{{ route('verificarUPC') }}",
                    data: {
                        'upc': $(this).val()
                    },
                    success: function(data) {
                        console.log(data);
                        if (data.res == false) {
                            $('#header-pagina').text('Agregar Inventario');
                            $('#alerta-upc').show();
                            //Swal.fire("Oops", "Ese artículo no existe en el inventario, registralo!", "info");
                            habilitarFormulario(false, data);
                        } else {
                            Swal.fire({
                                title: 'Este artículo ya existe!',
                                text: "Puede editar este artículo dando clic en el botón!",
                                icon: 'warning',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Entendido!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    var url = '{{ route('Inventario.edit', ':id') }}';
                                    url = url.replace(':id', data[0][0]['id_inventario']);
                                    window.location.href = url;
                                }
                            })
                            /*$('#header-pagina').text('Editar Inventario');
                            habilitarFormulario(true, data);*/
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
        //Función que desactiva la alerta de artículo no existente
        $('#boton-alerta').on('click', function() {
            $('#alerta-upc').hide();
        });
        //Función para desabilitar los campos
        function deshabilitarFormulario(estado) {
            $('#editarInventario').attr('disabled', true);
            $('#agregarDetalle').attr('disabled', true);
            $('#agregarDetalleInventario').attr('disabled', true);
            $('#formInventario').find('.card-body').children().each(function() {
                if ($(this).attr('id') != 'Categoria') {
                    $(this).find('input,textarea,select,button').attr('disabled', true);
                }
            });
        }
        //Función para habilitar los campos
        function habilitarFormulario(estado, datosFormulario) {
            $('#checkOnline').attr('disabled', false);
            $('#checkCompatibilidad').attr('disabled', false);
            //$('#editarInventario').attr('disabled', false);
            $('#checkFinalizar').attr('disabled', false);
            $('#agregarDetalle').attr('disabled', false);
            $('#agregarDetalleInventario').attr('disabled', false);
            $('#formInventario').find('.card-body').children().each(function() {
                if ($(this).attr('id') != 'onlineDescripcion') {
                    $(this).find('input[type="text"],input[type="number"],textarea,select,button').attr('disabled',
                        false);
                }
            });
            if (estado != false) {
                $('#categoria').val(datosFormulario[0][0].categoria);
                /*categorias.forEach(categoria => {
                    if(datosFormulario[0].id_categoria != marca.id_categoria){
                        console.log(categoria);
                        $('#categoriaData').append('<option value="'+categoria.categoria+'">'+categoria.categoria+'</option>');
                    }
                });*/
                if (datosFormulario[0][0].id_categoria != null) {
                    $('#marcaData option').remove();
                    marcas.forEach(marca => {
                        if (datosFormulario[0][0].id_categoria == marca.id_categoria) {
                            console.log(marca);
                            $('#marcaData').append('<option value="' + marca.marca + '">' + marca.marca +
                                '</option>');
                        }
                    });
                }
                $('#marca').val(datosFormulario[0][0].marca);
                if (datosFormulario[0][0].id_marca != null) {
                    $('#modeloData option').remove();
                    modelos.forEach(modelo => {
                        if (datosFormulario[0][0].id_marca == modelo.id_marca) {
                            console.log(modelo);
                            $('#modeloData').append('<option value="' + modelo.modelo + '">' + modelo.modelo +
                                '</option>');
                        }
                    });
                }
                if (datosFormulario[0][0].imagen) {
                    imagen = '{{ URL::asset('storage/inventario/') }}' + '/';
                    imagen += datosFormulario[0][0].imagen;
                    $('#imagen').attr("src", imagen);
                    $('#labelImagen').html(datosFormulario[0][0].imagen);
                }
                $('#modelo').val(datosFormulario[0][0].modelo);
                $('#color').val(datosFormulario[0][0].color);
                $('#capacidad').val(datosFormulario[0][0].tipo);
                $('#costo').val(datosFormulario[0][0].costo);
                $('#stock').val(datosFormulario[0][0].stock);
                $('#stockMin').val(datosFormulario[0][0].stock_min);
                $('#precioMin').val(datosFormulario[0][0].precio_min);
                $('#precioMax').val(datosFormulario[0][0].precio_max);
                $('#publico').val(datosFormulario[0][0].precio_publico);
                $('#mayoreo').val(datosFormulario[0][0].precio_mayoreo);
                $('#largo').val(datosFormulario[0][0].largo);
                $('#alto').val(datosFormulario[0][0].alto);
                $('#ancho').val(datosFormulario[0][0].ancho);
                $('#titulo').val(datosFormulario[0][0].titulo_inventario);
                console.log(datosFormulario);
                if (datosFormulario[0][0].venta_online == 1) {
                    $('#checkOnline').prop('checked', 'checked');
                    $('#onlineDescripcion').show();
                    $('#onlineImagen').show();
                    $('#hrOnline').show();
                    $('#imagenProducto').attr('disabled', false);
                    $('#descripcion').val(datosFormulario[0][0].descripcion_inventario);
                    $('#descripcion').attr('disabled', false);
                } else {
                    $('#checkOnline').prop('checked', false);
                    $('#onlineDescripcion').hide();
                    $('#onlineImagen').hide();
                    $('#hrOnline').hide();
                    $('#imagenProducto').attr('disabled', true);
                    $('#descripcion').val("");
                    $('#descripcion').attr('disabled', true);
                }
                if (datosFormulario[1].length > 0) {
                    if (datosFormulario[1][0].imei) {
                        $('#radioImei').prop("checked", true);
                        detalleRadio = 1;
                    } else if (datosFormulario[1][0].ns) {
                        $('#radioSerie').prop("checked", true);
                        detalleRadio = 2;
                    }
                } else {
                    detalleRadio = 0;
                }
                checkVentaOnline();
            }
        }
        //Función para habílitar las entradas en el formulario
        $('#categoria').change(function() {
            //$('#detalleInventario').remove('.agregado');
            if ($('#categoria').prop('selectedIndex') != 0) {
                if ($('#categoria').prop('selectedIndex') == 1) {
                    $('#checkBateria').attr('disabled', false);
                } else if ($('#categoria').prop('selectedIndex') == 3) {
                    $('#agregarDetalleInventario').attr('disabled', false);
                } else {
                    $('#checkBateria').attr('disabled', true);
                }
            }
        });
        //Funcion para habílitar el campo de bateria de los equipos electrónicos
        function checkCompatibilidadModelos() {
            var checkBox = document.getElementById("checkCompatibilidad");
            if (checkBox.checked == true) {
                $('#divCompatibilidad').show();
            } else {
                $('#divCompatibilidad').hide();
            }
        }
        //Funcion para habílitar los campos de título y descripción para venta online de los productos
        function checkVentaOnline() {
            var checkBox = document.getElementById("checkOnline");
            if (checkBox.checked == true) {
                $('#onlineDescripcion').show();
                $('#onlineImagen').show();
                $('#hrOnline').show();
                $('#descripcion').attr('disabled', false);
                $('#imagenProducto').attr('disabled', false);
            } else {
                $('#onlineDescripcion').hide();
                $('#hrOnline').hide();
                $('#onlineImagen').hide();
                $('#descripcion').attr('disabled', true);
                $('#imagenProducto').attr('disabled', true);
            }
        }
        //Funcion para habílitar el botón que envía los datos el controlador
              function checkFinalizarInventario() {
                  var checkBox = document.getElementById("checkFinalizar");
                  if (checkBox.checked == true) {
                      $('#editarInventario').attr('disabled', false);
                  } else {
                      $('#editarInventario').attr('disabled', true);
                  }
              }
        //Cargar marcas dependiendo de la categoria
        $('#categoria').change(function() {
            if ($(this).val() != null) {
                subcategoriaTitulo = $(this).val();
                generarTitulo();
                $('#marca option').remove();
                marcas.forEach(marca => {
                    if ($(this).val() == marca.id_categoria) {
                        console.log(marca);
                        $('#marca').append('<option value="' + marca.marca + '">' + marca.marca +
                            '</option>');
                    }
                });
            } else {
                Swal.fire({
                    title: 'Este artículo ya existe!',
                    text: "Puede editar este artículo dando clic en el botón!",
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido!'
                });
            }
        });
        //Cargar modelos dependiendo de la marca
        $('#marca').change(function() {
            if ($(this).val() != null) {
                marcaTitulo = $(this).val();
                generarTitulo();
                $('#modeloData option').remove();
                modelos.forEach(modelo => {
                    if ($(this).val() == modelo.marca) {
                        console.log(modelo);
                        $('#modeloData').append('<option value="' + modelo.modelo + '">' + modelo.modelo +
                            '</option>');
                    }
                });
            }
        });
        //Detecta el cambio del modelo para cambiar el título
        $('#modelo').change(function() {
            if ($(this).val() != null) {
                modeloTitulo = $(this).val();
                generarTitulo();
            }
        });
        //Detecta el cambio del color para cambiar el título
        $('#color').change(function() {
            if ($(this).val() != null) {
                colorTitulo = $(this).val();
                generarTitulo();
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
                                marcasExtras.push(response[0]);
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
            if (marcasExtras) {
                marcasExtras.forEach(marca => {
                    if ($('#marca').val() == marca.marca) {
                        cadenaOption = cadenaOption + '<option value="' + marca.marca + '" selected>' +
                            marca
                            .marca + '</option>';
                    } else {
                        cadenaOption = cadenaOption + '<option value="' + marca.marca + '">' + marca.marca +
                            '</option>';
                    }
                });
            }
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
        //Función para generar automáticamente un titulo para el producto
        function generarTitulo() {
            cadenaTitulo = subcategoriaTitulo + " " + marcaTitulo + " " + modeloTitulo + " " + colorTitulo + " " +
                compatibilidadTitulo;
            $('#titulo').val(cadenaTitulo);
        }
        //Función que cambiar el texto del input para saber el nombre de las imagenes seleccionadas para guardar en la base de datos
        $('#imagenProducto').change(function() {
            var filename = $('#imagenProducto').val().replace(/C:\\fakepath\\/i, '');
            $('#labelImagen').html(filename);
        });
        //Función para agregar modelo compatible a tabla de compatibilidad
        $('#agregarCompatibilidad').on('click', function() {
            if ($('#modelo2').val()) {
                $('#tablaCompatibilidad').append(
                    '<tr>' +
                    '<th scope="row"><input type="text" class="form-control form-control-sm" value="' + $(
                        '#modelo2').val() + '"" name="compatibilidad[][modelo]" readonly></th>' +
                    '<th scope="row"><a href="#" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove()"><i class="fas fa-trash"></i></a></th>' +
                    '</tr>'
                );
                compatibilidadTitulo = "";
                $.each($('#tablaCompatibilidad').find('tr'), function() {
                    console.log($(this).children().eq(0).children().val());
                    compatibilidadTitulo += $(this).children().eq(0).children().val() + "/";
                });
                generarTitulo();
                $('#modelo2').val("");

            }
        });
        //Función para agregar modelo compatible a tabla de compatibilidad
        $('#agregarStockSucursal').on('click', function() {
            if ($('#stock').val() && $('#sucursal').val()) {
                conteoDetalle += 0;
                $('#tablaStockSucursal').append(
                    '<tr>' +
                    '<th scope="row"><input type="text" class="form-control form-control-sm" value="' + $(
                        '#sucursal').val() + '"" name="detalleInventario[' + conteoDetalle +
                    '][sucursal]" readonly></th>' +
                    '<th scope="row"><input type="number" class="form-control form-control-sm" value="' + $(
                        '#stock').val() + '"" name="detalleInventario[' + conteoDetalle +
                    '][stock]" readonly></th>' +
                    '<th scope="row"><input type="number" class="form-control form-control-sm" value="' + $(
                        '#stock').val() + '"" name="detalleInventario[' + conteoDetalle +
                    '][etiquetas]"></th>' +
                    '<th scope="row"><a href="#" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove(); conteoDetalle -= 1;"><i class="fas fa-trash"></i></a></th>' +
                    '</tr>'
                );
                $('#stock').val("");
            }
        });
        //Cargar modelos dependiendo de la marca
        $('#marca2').change(function() {
            if ($(this).val() != null) {
                $('#modeloData2 option').remove();
                modelos.forEach(modelo => {
                    if ($(this).val() == modelo.marca) {
                        console.log(modelo);
                        $('#modeloData2').append('<option value="' + modelo.modelo + '">' + modelo.modelo +
                            '</option>');
                    }
                });
            }
        });
        //Comprobar que los precios sean mayores al costo
        $('.precios').on('input', function() {
            input = $(this);
            console.log('hola');
            if (input.val() < $('#costo').val()) {
                input.addClass('is-invalid');
            } else {
                input.removeClass('is-invalid');
            }
        });
        //Llena el stock mínimo dependiendo del stock
        $('#stock').on('input', function() {
            $('#stockMin').val("1");
        });
        //Llena los precios del formulario
        $('#costo').on('input', function() {
            $('#precioMin').val($('#costo').val() * 1.10);
            $('#precioMax').val($('#costo').val() * 1.20);
            $('#mayoreo').val($('#costo').val() * 1.20);
        });
        $('input[list]').on('click', function() {
            $(this).val("");
        });
        //Función que cálcula el UPC dando 11 dígitos
        function calcularUPC(data) {
            if (data.length == 11) {
                upc = data.split('');
                par = 0;
                impar = 0;
                for (i = 0; i < upc.length; i++) {
                    if ((i + 1) % 2 == 0) {
                        par = parseInt(par) + parseInt(upc[i]);
                    } else {
                        impar = parseInt(impar) + parseInt(upc[i]);
                    }
                }
                impar = impar * 3;
                total = impar + par;
                mod = parseInt(total) % 10;
                x12 = 0;
                if (mod != 0) {
                    x12 = 10 - mod;
                }
                upc = upc.join('');
                upc = upc.toString()
                upc = upc.concat('', x12.toString());
                $('#upc').val(upc);
            }
        }

        $('#editarInventario').on('click', function(e) {
            $(this).hide();
            $('#loading').show();

        });

    </script>
@endsection
