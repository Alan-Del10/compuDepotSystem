@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Agregar Usuario</h1>
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
                    <h3 class="card-title">Registrar usuario</h3>
                </div>
                <!-- /.card-header -->
                <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nombre') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Dirección E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sucursal" class="col-md-4 col-form-label text-md-right">{{ __('Sucursal') }}</label>

                            <div class="col-md-6 input-group">
                                <input id="sucursal" list="sucursalData" type="text" class="form-control @error('sucursal') is-invalid @enderror" name="sucursal" value="{{ old('sucursal') }}" required autocomplete="sucursal" placeholder="Selecciona una Sucursal">
                                <datalist id="sucursalData">
                                    @foreach($sucursales as $sucursal)
                                    <option value="{{$sucursal->sucursal}}">{{$sucursal->sucursal}}</option>
                                    @endforeach
                                </datalist>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="agregarSucursal"><i class="fas fa-plus"></i></button>
                                </div>
                                @error('sucursal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_usuario" class="col-md-4 col-form-label text-md-right">{{ __('Tipo Usuario') }}</label>

                            <div class="col-md-6 input-group">
                                <input id="tipo_usuario" list="tipo_usuarioData" type="text" class="form-control @error('tipo_usuario') is-invalid @enderror" name="tipo_usuario" value="{{ old('tipo_usuario') }}" required autocomplete="tipo_usuario" placeholder="Selecciona un Puesto">
                                <datalist id="tipo_usuarioData">
                                    @foreach($tipo_usuarios as $tipo_usuario)
                                    <option value="{{$tipo_usuario->puesto}}">{{$tipo_usuario->puesto}}</option>
                                    @endforeach
                                </datalist>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="agregarSucursal"><i class="fas fa-plus"></i></button>
                                </div>
                                @error('tipo_usuario')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmar Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</section>
@endsection
