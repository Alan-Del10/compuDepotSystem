@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Modificar Sucursal</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->


        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Sucursal</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form action="{{route('Sucursal.update', [$sucursal->id_sucursal])}}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="sucursal" class="col-sm-1 col-form-label">Nombre:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="sucursal" id="sucursal" class="form-control" value="{{old('sucursal', $sucursal->sucursal)}}">
                                    @if ($errors->has('sucursal'))
                                        <span class="errormsg">{{ $errors->first('sucursal') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-1"></div>
                                <label for="local" class="col-sm-1 col-form-label">Local:</label>
                                <div class="col-sm-3">
                                    <input type="text" name="local" id="local" class="form-control" value="{{old('local', $sucursal->local)}}">
                                    @if ($errors->has('local'))
                                        <span class="errormsg">{{ $errors->first('local') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="direccion" class="col-sm-1 col-form-label">Dirección:</label>
                                <div class="col-sm-11">
                                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion', $sucursal->direccion)}}">
                                    @if ($errors->has('direccion'))
                                        <span class="errormsg">{{ $errors->first('direccion') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="imagen" class="col-sm-1 col-form-label">Logo:</label>
                                <div class="custom-file col-sm-11">
                                    <input type="file" class="custom-file-input" name="imagenSucursal" id="imagenSucursal" accept="image/png" >
                                    <label class="custom-file-label" id="labelImagen" for="imagenSucursal">Elegir Imagen...</label>
                                </div>
                                <img src="" class="rounded mx-auto d-block" alt="" id="imagen">
                            </div>
                            <div class="form-group row">
                                <label for="politicas" class="col-sm-1 col-form-label">Políticas</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control @error('politicas') is-invalid @enderror" id="politicas" rows="10" placeholder="Políticas" name="politicas" >{{ old('descripcion', $sucursal->politicas)}}</textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Modificar" class="btn btn-success float-right modificarSucursal">
                            </div>
                            <!-- /.card-footer -->
                        </form>
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
                @elseif (Session::has('message'))
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ Session::has('message') }}</li>
                        </ul>
                    </div>
                @endif
                <!-- /Callback-->
            </div>
        </section>
        <!-- /.content -->
    </section>
    <script>
        //Función que cambiar el texto del imput para saber el nombre de las imagenes seleccionadas para guardar en la base de datos
        $('#imagenSucursal').change(function() {
            var filename = $('#imagenSucursal').val().replace(/C:\\fakepath\\/i, '');
            $('#labelImagen').html(filename);
        });
    </script>
@endsection
