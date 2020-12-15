@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Ventas</h1>
            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
            <div class="container-fluid">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Servicio</h3>
                    </div>
                        <div class="form-group row">
                            <label for="notas" class="col-sm-2 col-form-label">Notas</label>
                            <div class="col-sm-4">
                            <textarea name="notas" id="notas" cols="120" rows="5" placeholder="Notas"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default float-right agregarServicio">Agregar</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
@endsection
