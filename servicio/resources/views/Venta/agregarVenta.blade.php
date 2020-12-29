@extends('layouts.app')
@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Ventas</h1>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
    <!-- Main content -->
    <!-- Form Cliente -->
    <section class="content">
        <div class="container-fluid">
            <div class="row mb-2">
                <section class="col-lg-5 connectedSortable">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Cliente</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="POST" class="form-horizontal " id="formcliiente">
                            <div class="card-body">
                                <div class="form-group row" id="Nombre">
                                    <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="nombre" id="nombre" value="" placeholder="Nombre">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="sucursal" class="col-sm-3 col-form-label">Sucursal</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="sucursales">
                                            <option value="0">Seleccionar Sucursal</option>
                                            <option value="1">Phone Depot</option>
                                            <option value="2">Compu Depot</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="checkbox" id="sucursal" value="yes">
                                    </div>
                                </div>
                            </div>
                            <!-- activar select con chekbox -->
                            <script>
                                var update_sucursal = function () {
                                  if ($("#sucursal").is(":checked")) {
                                      $('#sucursales').prop('disabled', false);
                                  }
                                  else {
                                      $('#sucursales').prop('disabled', 'disabled');
                                  }
                                };
                                $(update_sucursal);
                                $("#sucursal").change(update_sucursal);
                              </script>
                            <!-- /.card-body -->
                            <div class="card-footer">
                               <!-- <input type="submit" value="limpiar" class="btn btn-success float-right" id="limpiarCliente">-->
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>

                    <!-- Form Pagos -->
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Pagos</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="POST" class="form-horizontal " id="formPagos">
                            <div class="card-body">
                                <div class="form-group row" id="Subtotal">
                                    <label for="subtotal" class="col-sm-3 col-form-label">Subtotal</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="sibtoal" id="nombre" placeholder="Subtotal">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row" id="Nombre">
                                    <label for="total" class="col-sm-3 col-form-label">Total</label>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control" name="total" id="total" placeholder="Total">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-group row" id="Pago">
                                    <label for="formaPago" class="col-sm-3 col-form-label">Pago</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="pago" name="formapago">
                                            <option value="0">Efectivo</option>
                                            <option value="02">Tarjeta</option>
                                            <option value="03">Anticipo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Vender" class="btn btn-success float-right" id="agregarVenta">
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                </section>

                <!-- Detalle ventas -->
                <section class="col-lg-7 connectedSortable">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title col-11">Detalle Venta</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="" method="POST" class="form-horizontal " id="formVenta">
                            <div class="card-body">
                                <div class="form-group row" id="Equipo">
                                    <label for="equipo" class="col-sm-1 col-form-label">UPC</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="upc" id="upc" value="" placeholder="Buscar UPC">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body scroll" id="detalleInventario"></div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <input type="submit" value="Agregar" class="btn btn-success float-right" id="agregarVenta">
                            </div>
                            <!-- /.card-footer -->
                        </form>
                    </div>
                <br>

                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">tiket</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <div class="container">
                            <div class="row clearfix">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-bordered table-hover table-sortable" id="tab_logic">
                                        <thead>
                                            <tr >
                                                <th class="text-center">
                                                    Equipo
                                                </th>
                                                <th class="text-center">
                                                    Color
                                                </th>
                                                <th class="text-center">
                                                    Descripcion
                                                </th>
                                                <th class="text-center">
                                                    Capacidad
                                                </th>
                                                <th class="text-center" style="border-top: 1px solid #ffffff; border-right: 1px solid #ffffff;">
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr id='addr0' data-id="0" class="hidden">
                                                <td data-name="name">
                                                    <input type="text" name='name0'  placeholder='Name' class="form-control"/>
                                                </td>
                                                <td data-name="mail">
                                                    <input type="text" name='mail0' placeholder='Email' class="form-control"/>
                                                </td>
                                                <td data-name="desc">
                                                    <textarea name="desc0" placeholder="Description" class="form-control"></textarea>
                                                </td>
                                                <td data-name="sel">
                                                    <select name="sel0">
                                                        <option value="">Selecionar capacidad</option>
                                                        <option value="1">Option 1</option>
                                                        <option value="2">Option 2</option>
                                                        <option value="3">Option 3</option>
                                                    </select>
                                                </td>
                                                <td data-name="del">
                                                    <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove'><span aria-hidden="true">×</span></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a id="add_row" class="btn btn-primary float-right">Add Row</a>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection



