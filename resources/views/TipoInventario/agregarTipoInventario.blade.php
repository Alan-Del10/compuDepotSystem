@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Agregar Categoria</h1>
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
                        <h3 class="card-title">Categoria</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <div class="card-body">
                        <form action="{{route('TipoInventario.store')}}" method="POST" class="form-horizontal" >
                            @csrf
                            <div class="form-group row">
                                <label for="descripcion" class="col-sm-1 col-form-label">Descripción:</label>
                                    <textarea name="descripcion" id="descripcion" cols="150" rows="10"></textarea>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Agregar" class="btn btn-success float-right agregarSucursal">
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
                            <li>{{ Session::get('message') }}</li>
                        </ul>
                    </div>
                @endif
                <!-- /Callback-->
            </div>
        </section>
        <!-- /.content -->
    </section>
@endsection
