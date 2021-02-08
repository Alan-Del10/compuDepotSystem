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
                                    <label for="busqueda" class="col-sm-2 col-form-label">Busqueda</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="search" class="form-control @error('busqueda') is-invalid @enderror" name="busqueda" id="busqueda" placeholder="Busqueda por UPC/EAN de Inventario" value="{{ old('busqueda')}}" autofocus>
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
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col">UPC/EAN</th>
                                                <th scope="col">Marca</th>
                                                <th scope="col">Modelo</th>
                                                <th scope="col">Color</th>
                                            </tr>
                                        </thead>
                                        <tbody class="scroll">
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">2</th>
                                                <td>Jacob</td>
                                                <td>Thornton</td>
                                                <td>@fat</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">3</th>
                                                <td colspan="2">Larry the Bird</td>
                                                <td>@twitter</td>
                                            </tr>
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
                        console.log(data);
                        if(data.res == false){
                            $('#header-pagina').text('Agregar Inventario');
                            $('#alerta-upc').show();
                            //Swal.fire("Oops", "Ese artículo no existe en el inventario, registralo!", "info");
                            habilitarFormulario(false, data);
                        }else{
                            Swal.fire({
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
    </script>
@endsection



