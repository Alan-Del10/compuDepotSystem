@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Cortes de Caja</h1>
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
                        <input class="form-control" type="text" id="busqueda" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button id="buscar" class="btn btn-success">Buscar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <div class="row">
                    <div class="col-4">
                    <h3 class="card-title">Cortes de Caja</h3>
                    </div>
                    <div class="col-6">
                    </div>
                    <div class="col-2">
                        <a id="agregarCorte" href='#' class="btn btn-info">Agregar Corte de Caja <i class="far fa-plus-square"></i></a>
                    </div>
                </div>

                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th style="width: 10px">ID</th>
                        <th>Usuario</th>
                        <th>Sucursal</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Tipo de Corte</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($cortes as $corte)
                        <tr class="items">
                            <td>{{$corte->id_corte_caja}}</td>
                            <td>{{$corte->name}}</td>
                            <td>{{$corte->sucursal}}</td>
                            <td>{{$corte->fecha_corte}}</td>
                            <td>{{$corte->monto}}</td>
                            @if ($corte->tipo_corte == true)
                                <td>Inicial</td>
                            @else
                                <td>Final</td>
                            @endif
                            <td><a href="#" class="btn btn-primary"><i class="far fa-edit"></i> Editar</a></td>
                        </tr>
                        @endforeach

                    </tbody>

                </table>

                </div>
                <!-- /.card-body -->

            </div>
            <!-- /.card -->
            {{ $cortes->onEachSide(5)->links('pagination::bootstrap-4') }}
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <script>
        var cortes = @json($cortes);
        var sucursales = @json($sucursales);
        var arr = [];
        arr = cortes;
        $("#busqueda").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            console.log(getResult(value, cortes));
        });

        function getResult(filterBy, objList) {
            return objList.filter(function(obj) {
                return obj.some(function(item){
                    return item.indexOf(filterBy) >= 0;
                });
            });
        }
        //Función para agregar los dos tipos de corte de caja  modelo
        $('#agregarCorte').on('click', function() {
            //sacar una cadena de options para el sweet alert
            var cadenaOption = '<select class="form-control" id="sucursal">';//inicializo variable para el options del sweet alert
            sucursales.forEach(sucursal => {
                cadenaOption = cadenaOption +'<option value="'+sucursal.id_sucursal+'">'+sucursal.sucursal+'</option>';
            });
            cadenaOption = cadenaOption + '</select>';

            Swal.fire({
                title: "Agregar Corte de Caja",
                html:
                    '<div class="form-group row">' +
                        '<div class="col-sm-12">' +
                            '<label for="tipo_corte" class="float-left col-form-label">Tipo de Corte</label>' +
                            '<select class="form-control" id="tipo_corte">' +
                                '<option value="1" selected>Inicial</option>' +
                                '<option value="0">Final</option>' +
                            '</select>'+
                        '</div>' +
                        '<div class="col-sm-12">' +
                            '<label for="sucursal" class="float-left col-form-label">Sucursal</label>' +
                            ''+cadenaOption+'' +
                        '</div>' +
                        '<div class="col-sm-12">' +
                            '<label for="monto" class="float-left col-form-label">Monto</label>' +
                            '<input type="number" class="form-control" id="monto" placeholder="Monto $">' +
                        '</div>' +
                    '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
            }).then((result) => {
                if(result.isConfirmed){

                    tipo_corte = document.getElementById('tipo_corte').value;
                    sucursal = document.getElementById('sucursal').value;
                    monto = document.getElementById('monto').value;

                    if(tipo_corte != null || tipo_corte != '' || sucursal != null || sucursal != '' || monto != null || monto != ''){
                        $.ajax({
                            type: "post",
                            url: "{{route('CorteCaja.store')}}",
                            data:{'sucursal' : sucursal,'monto' : monto, 'tipo_corte': tipo_corte },
                            dataType: 'JSON',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            success: function(response){
                                $('#modelo').val(response[0].modelo);
                                $('#modeloData').append('<option value="'+response[0].modelo+'">'+response[0].modelo+'</option>')
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
    </script>
@endsection

