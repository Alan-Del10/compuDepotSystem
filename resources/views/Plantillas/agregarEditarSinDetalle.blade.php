@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Agregar/Editar ?</h1>
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
            <form action="" method="POST" class="form-horizontal " id="formInventario" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <div class="card card-info connectedSorteable">
                            <div class="card-header">
                                <h3 class="card-title">Título</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">Campo 1</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control @error('upc') is-invalid @enderror" name="upc" id="upc" placeholder="UPC" value="{{ old('upc')}}" autofocus>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" class="form-check-input" id="checkOnline" name="checkOnline" disabled onclick="checkVentaOnline()" checked>
                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkOnline">Check 1</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-12 alert alert-warning alert-dismissible fade show" role="alert" style="display:none" id="alerta-upc">
                                        <strong>Ops!</strong> Este campo no está registrado.
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="Categoria">
                                    <label for="categoria" class="col-sm-2 col-form-label">Campo 2</label>
                                    <div class="col-sm-4">
                                        <input type="text" list="categoriaData" class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" value="{{old('categoria')}}" placeholder="Seleccionar Categoria" disabled/>
                                        <datalist id="categoriaData">

                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarCategoria" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-4">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radiosDetalle" id="radioDefault" value="default" onclick="radioDetalle($(this))" checked>
                                            <label class="form-check-label" for="radioDefault">Check 2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radiosDetalle" id="radioImei" value="imei" onclick="radioDetalle($(this))">
                                            <label class="form-check-label" for="radioImei">Check 3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="radiosDetalle" id="radioSerie" value="no_serie" onclick="radioDetalle($(this))">
                                            <label class="form-check-label" for="radioSerie">Check 4</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Campo 3</label>
                                    <div class="col-sm-4">
                                        <input type="text" list="marcaData" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{old('marca')}}" placeholder="Seleccionar Marca" disabled/>
                                        <datalist id="marcaData">
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarMarca" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" class="form-check-input" id="checkBateria" name="checkBateria" disabled onclick="checkVidaBateria()" checked>
                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkBateria">Check 5</label>
                                </div>
                                <div class="form-group row">
                                    <label for="modelo" class="col-sm-2 col-form-label">Campo 4</label>
                                    <div class="col-sm-9">
                                        <input type="text" list="modeloData" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{old('modelo')}}" placeholder="Seleccionar Modelo" disabled/>
                                        <datalist id="modeloData">
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarModelo" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2 col-form-label">Campo 5</label>
                                    <div class="col-sm-3">
                                        <input type="text" list="colorData" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{old('color')}}" placeholder="Seleccionar Color" disabled/>
                                        <datalist id="colorData">
                                        </datalist>
                                    </div>
                                    <div class="col-sm-1">
                                        <button type="button" class="btn btn-primary" id="agregarColor" disabled><i class="fas fa-plus"></i></button>
                                    </div>
                                    <label for="capacidad" class="col-sm-2 col-form-label">Campo 6</label>
                                    <div class="col-sm-3">
                                        <input type="text" list="capacidadData" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" name="capacidad" value="{{old('capacidad')}}" placeholder="Seleccionar Capacidad" disabled/>
                                        <datalist id="capacidadData">
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
                                    <label for="titulo" class="col-sm-2 col-form-label">Campo 7</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" id="titulo" placeholder="Título" value="{{ old('titulo')}}" disabled>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" class="form-check-input" id="checkGenerarTitulo" name="checkGenerarTitulo" onclick="generarTitulo()" checked>
                                    </div>
                                    <label class="form-check-label col-sm-2" for="checkGenerarTitulo">Check 6</label>
                                </div>
                                <div class="form-group row" id="onlineDescripcion" style="display: none">
                                    <label for="descripcion" class="col-sm-2 col-form-label">Campo 7</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" rows="4" placeholder="Descripción" name="descripcion" disabled>{{ old('descripcion')}}</textarea>
                                    </div>
                                </div>
                                <hr style="display: none" id="hrOnline">
                                <div class="form-group row">
                                    <label for="costo" class="col-sm-2 col-form-label">Campo 8</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo" placeholder="Costo" step="0.01" value="{{ old('costo')}}" disabled>
                                    </div>
                                    <label for="stock" class="col-sm-2 col-form-label">Campo 9</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" placeholder="Stock" value="{{ old('stock')}}" disabled>
                                    </div>
                                    <label for="stockMin" class="col-sm-2 col-form-label">Campo 10</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('stockMin') is-invalid @enderror" id="stockMin" name="stockMin" placeholder="Stock Mínimo" value="{{ old('stockMin')}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="precioMin" class="col-sm-3 col-form-label">Campo 11</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('precioMin') is-invalid @enderror" id="precioMin" name="precioMin" placeholder="Precio Mínimo" step="0.01" value="{{ old('precioMin')}}" disabled>
                                    </div>
                                    <label for="precioMax" class="col-sm-3 col-form-label">Campo 12</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('precioMax') is-invalid @enderror" id="precioMax" name="precioMax" placeholder="Precio Máximo" step="0.01" value="{{ old('precioMax')}}" disabled>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="publico" class="col-sm-3 col-form-label">Campo 13</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('publico') is-invalid @enderror" id="publico" name="publico" placeholder="Precio Público" step="0.01" value="{{ old('publico')}}" disabled>
                                    </div>
                                    <label for="mayoreo" class="col-sm-3 col-form-label">Campo 14</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control @error('mayoreo') is-invalid @enderror" id="mayoreo" name="mayoreo" placeholder="Precio Mayoreo" step="0.01" value="{{ old('mayoreo')}}" disabled>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row">
                                    <label for="largo" class="col-sm-2 col-form-label">Campo 15</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('largo') is-invalid @enderror" id="largo" name="largo" placeholder="Largo" step="0.01" value="{{ old('largo')}}" disabled>
                                    </div>

                                    <label for="alto" class="col-sm-2 col-form-label">Campo 16</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('alto') is-invalid @enderror" id="alto" name="alto" placeholder="Alto" step="0.01" value="{{ old('alto')}}" disabled>
                                    </div>

                                    <label for="ancho" class="col-sm-2 col-form-label">Campo 17</label>
                                    <div class="col-sm-2">
                                        <input type="number" class="form-control @error('ancho') is-invalid @enderror" id="ancho" name="ancho" placeholder="Ancho" step="0.01" value="{{ old('ancho')}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>

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
                                        <input type="submit" value="Agregar ?" class="btn btn-success float-right" id="agregarInventario" disabled>
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
    @elseif (Session::has('message'))
        <div class="alert alert-success">
            <ul>
                {{Session::get('success')}}
            </ul>
        </div>
    @endif
    <!-- /Callback-->
@endsection



