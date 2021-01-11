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
                                <option value="{{$categoria->id_categoria}}">{{$categoria->categoria}}</option>
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
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                    <div class="row">
                        <div class="col-4">
                        <h3 class="card-title">Lista de Inventario</h3>
                        </div>
                        <div class="col-5">
                        </div>
                        <div class="col-3">
                            <a id="agregarInventario" href='{{route("Inventario.create")}}' class="btn btn-info">Agregar/Editar Inventario <i class="far fa-plus-square"></i></a>
                        </div>
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
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody id="tabla">
                            @foreach($inventarios as $inventario)
                            <tr class="items">
                                <td>{{$inventario->upc}}</td>
                                <td>{{$inventario->categoria}}</td>
                                <td>{{$inventario->marca}}</td>
                                <td>{{$inventario->modelo}}</td>
                                <td>{{$inventario->color}}</td>
                                <td><a href="{{ route('Inventario.edit',$inventario->id_inventario)}}" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Especificaciones del Producto</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-sm-6">
                                <img src="{{asset('storage/icon/box.png')}}" alt="Producto" id="imagen" class="img-fluid rounded mx-auto d-block">
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
                                    <li class="list-group-item" id="publico">Precio Público:</li>
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
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        var inventarios = @json($inventarios);
        var arr = [];
        arr = inventarios;
        $('.items').on('click', function(){
            inventarios.forEach(inventario => {
                if($(this).children().eq(0).text() == inventario.upc){
                    imagen = '{{URL::asset('storage/inventario/')}}' + '/';
                    imagen += inventario.imagen;
                    $('#imagen').attr("src", imagen);
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
                return obj.some(function(item){
                    return item.indexOf(filterBy) >= 0;
                });
            });
        }
    </script>
@endsection


