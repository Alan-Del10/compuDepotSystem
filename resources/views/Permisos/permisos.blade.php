@extends('layouts.app')
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 id="header-pagina">Permisos</h1>
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
                    <section class="col-lg-6 connectedSortable">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Inventario</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">UPC/EAN</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="number" class="form-control @error('upc') is-invalid @enderror" name="upc" id="upc" placeholder="UPC" value="{{ old('upc')}}" minlength="12" maxlength="13" autofocus>
                                    </div>
                                </div>
                                <div class="form-check row">
                                    <div class="col-sm-12">

                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkOnline">Venta online?</label>
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
                                <div class="form-group row" id="Categoria">
                                    <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                    <div class="col-sm-5 input-group">
                                        <input type="text" list="categoriaData" class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" value="{{old('categoria')}}" placeholder="Seleccionar Categoria" disabled/>
                                        <datalist id="categoriaData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarCategoria" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
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
                                    <div class="col-sm-5 input-group">
                                        <input type="text" list="marcaData" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{old('marca')}}" placeholder="Seleccionar Marca" disabled/>
                                        <datalist id="marcaData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarMarca" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-inline">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="text" list="modeloData" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{old('modelo')}}" placeholder="Seleccionar Modelo" disabled/>
                                        <datalist id="modeloData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarModelo" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2 col-form-label">Color</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="colorData" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{old('color')}}" placeholder="Seleccionar Color" disabled/>
                                        <datalist id="colorData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarColor" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <label for="capacidad" class="col-sm-2 col-form-label">Capacidad</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="capacidadData" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" name="capacidad" value="{{old('capacidad')}}" placeholder="Seleccionar Capacidad" disabled/>
                                        <datalist id="capacidadData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <select name="labelCapacidad" id="labelCapacidad" class="custom-select" disabled>
                                                <option value="MB">MB</option>
                                                <option value="GB">GB</option>
                                                <option value="TB">TB</option>
                                            </select>
                                            <button type="button" class="btn btn-primary" id="agregarCapacidad" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="onlineImagen" style="display: none">
                                    <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                    <div class="custom-file col-sm-10">
                                        <input type="file" class="custom-file-input" name="imagenProducto" id="imagenProducto" accept="image/png, image/jpeg" disabled>
                                        <label class="custom-file-label" id="labelImagen" for="imagenProducto">Elegir Imagen...</label>
                                    </div>
                                    <img src="" class="rounded mx-auto d-block" alt="" id="imagen">
                                </div>
                                <div class="form-group row" id="onlineTitulo" style="display: none">
                                    <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" id="titulo" placeholder="Título" value="{{ old('titulo')}}" disabled>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">

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
                    <section class="col-lg-6 connectedSortable">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Inventario</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="upc" class="col-sm-2 col-form-label">UPC/EAN</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="number" class="form-control @error('upc') is-invalid @enderror" name="upc" id="upc" placeholder="UPC" value="{{ old('upc')}}" minlength="12" maxlength="13" autofocus>
                                    </div>
                                </div>
                                <div class="form-check row">
                                    <div class="col-sm-12">

                                    </div>
                                    <label class="form-check-label col-sm-3" for="checkOnline">Venta online?</label>
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
                                <div class="form-group row" id="Categoria">
                                    <label for="categoria" class="col-sm-2 col-form-label">Categoria</label>
                                    <div class="col-sm-5 input-group">
                                        <input type="text" list="categoriaData" class="form-control @error('categoria') is-invalid @enderror" id="categoria" name="categoria" value="{{old('categoria')}}" placeholder="Seleccionar Categoria" disabled/>
                                        <datalist id="categoriaData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarCategoria" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
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
                                    <div class="col-sm-5 input-group">
                                        <input type="text" list="marcaData" class="form-control @error('marca') is-invalid @enderror" id="marca" name="marca" value="{{old('marca')}}" placeholder="Seleccionar Marca" disabled/>
                                        <datalist id="marcaData">
                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarMarca" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-check form-check-inline">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="modelo" class="col-sm-2 col-form-label">Modelo</label>
                                    <div class="col-sm-10 input-group">
                                        <input type="text" list="modeloData" class="form-control @error('modelo') is-invalid @enderror" id="modelo" name="modelo" value="{{old('modelo')}}" placeholder="Seleccionar Modelo" disabled/>
                                        <datalist id="modeloData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarModelo" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="color" class="col-sm-2 col-form-label">Color</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="colorData" class="form-control @error('color') is-invalid @enderror" id="color" name="color" value="{{old('color')}}" placeholder="Seleccionar Color" disabled/>
                                        <datalist id="colorData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-primary" id="agregarColor" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                    <label for="capacidad" class="col-sm-2 col-form-label">Capacidad</label>
                                    <div class="col-sm-4 input-group">
                                        <input type="text" list="capacidadData" class="form-control @error('capacidad') is-invalid @enderror" id="capacidad" name="capacidad" value="{{old('capacidad')}}" placeholder="Seleccionar Capacidad" disabled/>
                                        <datalist id="capacidadData">

                                        </datalist>
                                        <div class="input-group-append">
                                            <select name="labelCapacidad" id="labelCapacidad" class="custom-select" disabled>
                                                <option value="MB">MB</option>
                                                <option value="GB">GB</option>
                                                <option value="TB">TB</option>
                                            </select>
                                            <button type="button" class="btn btn-primary" id="agregarCapacidad" disabled><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group row" id="onlineImagen" style="display: none">
                                    <label for="imagen" class="col-sm-2 col-form-label">Imagen</label>
                                    <div class="custom-file col-sm-10">
                                        <input type="file" class="custom-file-input" name="imagenProducto" id="imagenProducto" accept="image/png, image/jpeg" disabled>
                                        <label class="custom-file-label" id="labelImagen" for="imagenProducto">Elegir Imagen...</label>
                                    </div>
                                    <img src="" class="rounded mx-auto d-block" alt="" id="imagen">
                                </div>
                                <div class="form-group row" id="onlineTitulo" style="display: none">
                                    <label for="titulo" class="col-sm-2 col-form-label">Título</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" name="titulo" id="titulo" placeholder="Título" value="{{ old('titulo')}}" disabled>
                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div class="col-sm-1">
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
