@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Inventario</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Busqueda</h3>
                        </div>
                        <div class="input-group p-3">
                            <input class="form-control" type="text" id="busqueda" placeholder="Buscar por UPC...">
                            <div class="input-group-append">
                                <select name="" id="" class="custom-select">
                                    <option value="0">Selecciona una categoria</option>
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id_categoria }}">{{ $categoria->categoria }}
                                        </option>
                                    @endforeach
                                </select>
                                <button id="buscar" class="btn btn-success">Buscar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <ul class="nav nav-tabs" role="tablist">
                            @if (Auth::guard('admin')->check() || Auth::guard('sub_admin')->check() || Auth::guard('root')->check())
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-toggle="tab" href="#general" role="tab"
                                        aria-controls="general" aria-selected="true" id="general">General</a>
                                </li>
                                @if ($sucursales)
                                    @foreach ($sucursales as $sucursal)
                                        <li class="nav-item" role="presentation">
                                            <a class="nav-link" data-toggle="tab" href="#{{ $sucursal->sucursal }}"
                                                role="tab" aria-controls="{{ $sucursal->sucursal }}"
                                                aria-selected="false" id="{{ $sucursal->sucursal }}">{{ $sucursal->sucursal }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#{{ $sucursal[0]->sucursal }}"
                                        role="tab" aria-controls="{{ $sucursal[0]->sucursal }}"
                                        aria-selected="true" id="{{ $sucursal[0]->sucursal }}">{{ $sucursal[0]->sucursal }}</a>
                                </li>
                            @endif
                        </ul>
                        <div class="card-header">
                            <h3 class="card-title">Lista de Inventario</h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a id="agregarInventario" href='{{ route('Inventario.create') }}'
                                            class="btn btn-primary btn-sm">Agregar Inventario <i
                                                class="far fa-plus-square"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">UPC</th>
                                        <th>Categoria</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th>Color</th>
                                        <th>Stock</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tabla" class="tab-content">
                                    @foreach ($inventarios as $inventario)
                                        <tr class="items">
                                            <td>{{ $inventario->upc }}</td>
                                            <td>{{ $inventario->categoria }}</td>
                                            <td>{{ $inventario->marca }}</td>
                                            <td>{{ $inventario->modelo }}</td>
                                            <td>{{ $inventario->color }}</td>
                                            <td>{{ $inventario->stock }}</td>
                                            <td><small><a
                                                        href="{{ route('Inventario.edit', $inventario->id_inventario) }}"
                                                        class="btn btn-primary btn-sm"><i class="far fa-edit"></i>
                                                        Editar</a></small></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    {{ $inventarios->links('pagination::bootstrap-4') }}
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Especificaciones del Producto</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-6">
                                    <picture>
                                        <source type="image/png" srcset="{{ asset('storage/icon/box.png') }}"
                                            alt="Producto" id="imagen">
                                        <source type="image/webp" srcset="{{ asset('storage/icon/box.webp') }}"
                                            alt="Producto" id="imagen">
                                        <img src="box.jpg" alt="Producto" id="imagen2"
                                            class="img-fluid rounded mx-auto d-block">
                                    </picture>
                                    <div class="card-header">
                                        <b>Datos Online</b>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id="titulo">Título:</li>
                                        <li class="list-group-item" id="descripcion">Descripción:</li>
                                    </ul>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-header">
                                        <b>Precios</b>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id="mayoreo">Precio Mayoreo:</li>
                                        <li class="list-group-item" id="minimo">Precio Mínimo:</li>
                                        <li class="list-group-item" id="maximo">Precio Máximo:</li>
                                    </ul>
                                    <div class="card-header">
                                        <b>Costos</b>
                                    </div>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item" id="costo_actual">Costo Actual:</li>
                                        <li class="list-group-item" id="costo_anterior">Costo Anterior:</li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Compatibilidad de modelos</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaCompatibilidad">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->
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
                    {{ Session::get('success') }}
                </ul>
            </div>
        @endif
    </section>

    <!-- /.content -->
    <script>
        var inventarios = @json($inventarios);
        var compatibilidades = @json($compatibilidades);
        console.log(compatibilidades);
        var arr = [];
        arr = inventarios;
        $('.items').on('click', function() {
            inventarios.data.forEach(inventario => {
                if ($(this).children().eq(0).text() == inventario.upc) {
                    imagen = '{{ URL::asset('storage/inventario/') }}' + '/';
                    imagen += inventario.imagen;
                    $('#imagen').attr("srcset", imagen);
                    $('#imagen2').attr("src", inventario.imagen);
                    $('#titulo').text("Título: " + inventario.titulo_inventario);
                    $('#descripcion').text("Descripción: " + inventario.descripcion_inventario);
                    $('#publico').text("Precio Público: $" + inventario.precio_publico);
                    $('#mayoreo').text("Precio Mayoreo: $" + inventario.precio_mayoreo);
                    $('#minimo').text("Precio Mínimo: $" + inventario.precio_min);
                    $('#maximo').text("Precio Máximo: $" + inventario.precio_max);
                    $('#costo_actual').text('Costo Actual: $' + inventario.costo);
                    $('#costo_anterior').text('Costo Anterior: $' + inventario.costo);
                }

            });
            compatibilidades.forEach(compatibilidad => {
                if ($(this).children().eq(0).text() == compatibilidad.upc) {
                    $('#tablaCompatibilidad').append(
                        '<tr class="items">' +
                        '<td>' + compatibilidad.marca + '</td>' +
                        '<td>' + compatibilidad.modelo + '</td>' +
                        '</tr>'
                    );
                }
            });
        });

        /*function myFunction() {
            // Declare variables
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("busqueda");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabla");
            tr = table.getElementsByTagName("tr");

            // Loop through all table rows, and hide those who don't match the search query
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    console.log(txtValue.toUpperCase().indexOf(filter));
                    /*if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }*/
        $("#busqueda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(getResult(value, inventarios));
            /*$.grep(arr, function( element, index ) {
                for(key in element) {
                    if(element[key].search(value) > -1){
                        console.log(element);
                    }
                }
            });*/
            /*$.each(arr, function(index, element){

                for(key in element) {
                    console.log(element[key].filter(value));
                    if(element[key].find(value)) {
                        console.log(element);
                    }
                }
            });*/
        });

        function getResult(filterBy, objList) {
            return objList.filter(function(obj) {
                return obj.some(function(item) {
                    return item.indexOf(filterBy) >= 0;
                });
            });
        }

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (event) {
            event.target // newly activated tab
            event.relatedTarget // previous active tab
            if($(this).attr('id') == 'general'){

            }else{

            }
        })
    </script>
@endsection
