<html>
    <head>
       <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Tempusdominus Bootstrap 4 -->
        <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
        <!-- iCheck -->
        <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
        <!-- JQVMap -->
        <link rel="stylesheet" href="{{asset('plugins/jqvmap/jqvmap.min.css')}}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="{{asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker.css')}}">
        <!-- summernote -->
        <link rel="stylesheet" href="{{asset('plugins/summernote/summernote-bs4.min.css')}}">
        <!-- jQuery -->
        <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <link href="https://fonts.googleapis.com/css2?family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Amatic+SC&family=Sansita+Swashed:wght@300&display=swap" rel="stylesheet">
    <style>
        body{
            background-color:#f4f6f9;
            height: "100%";
            font-family: 'Amatic SC', cursive;
        }

        
        .content{
            font-size: 25px;
        }
    </style>
    </head>
    <body>
            <section class="content-header">
              <div class="container-fluid">
                <div class="row mb-2">
                  <div class="col-sm-6">

                  </div>
                  <div class="col-sm-6">
        
                  </div>
                </div>
              </div><!-- /.container-fluid -->
            </section>
        
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid col-8">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Información del Servicio</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                            <div class="card-body">
                            <div class="form-group row">
                                <label for="nombreCompleto" class="col-sm-4 col-form-label dato">Nombre Completo</label>
                                <div class="col-sm-8">
                                    <label  class="form-check-label value" id="nombreCompleto">Edgar Campos</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telefono" class="col-sm-4 col-form-label dato">Telefono</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="telefono">4492104496</label>
                                </div>
                                <div class="col-sm-4">
                                    <label class="dato" for="whatsapp">Whatsapp?</label>
                                    <label  class="form-check-label value" id="whatsapp">SI</label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="Estatus" class="col-sm-4 col-form-label dato">Estatus</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="estatus">ENTREGADO</label>
                                </div>
                                <div class="col-sm-4">
                                    <label for="lugar" class=" col-form-label dato">Lugar</label>
                                    <label  class="form-check-label value" id="lugar">l01</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="concepto" class="col-sm-4 col-form-label dato">Concepto</label>
                                <div class="col-sm-8">
                                    <label  class="form-check-label value" id="concepto">Reparación</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tipo" class="col-sm-4 col-form-label dato">Tipo</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="tipo">Realizar</label>
                                
                                </div>
                                <div class="col-sm-4">
                                    <label for="clase" class="col-form-label dato">Clase</label>
                                    <label  class="form-check-label value" id="clase">IMEI</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="color" class="col-sm-4 col-form-label dato">Color</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="color">Blanco</label>
                                </div>
                                <div class="col-sm-4">
                                    <label for="compania" class="col-form-label dato">Compania</label>
                                    <label  class="form-check-label value" id="compania">Telcel</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="codigoAcceso" class="col-sm-4 col-form-label dato">Codigo Acceso</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="codigoAcceso">1,3,5,7,6</label>
                                </div>
                                <div class="col-sm-2">
                                        <label class="dato" for="whatsapp">Alguna Vez Se Mojó?</label>
                                        <label  class="form-check-label value" id="seHaMojado">SI</label>                                    
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-check">
                                        <label class="dato" for="whatsapp">Autoriza Riesgo?</label>
                                        <label  class="form-check-label value" id="autorizaRiesgo">SI</label>                                    
                                    </div>
                                </div>

                            </div>
                            <div class="form-group row">
                                <label for="notasTecnicas" class="col-sm-4 col-form-label dato">Notas Técnicas (Revision adicional)</label>
                                <div class="col-sm-8">
                                    <label  class="form-check-label value" id="notasTecnicas">ERROR EN LA PLACA MADRE</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="marca" class="col-sm-4 col-form-label dato">Marca</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="marca">IPHONE</label>
                                </div>
                                <div class="col-sm-4">
                                    <label for="modelo" class=" col-form-label dato">Modelo</label>
                                    <label  class="form-check-label value" id="modelo">4</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="modeloTecnico" class="col-sm-4 col-form-label dato">Modelo Tecnico</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="modeloTecnico">LKSA</label>
                                </div>
                                <div class="col-sm-4">
                                    <label for="IMEI" class="col-form-label dato">IMEI (*#06#)</label>
                                    <label  class="form-check-label value" id="IMEI">013661003739780</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="monto" class="col-sm-4 col-form-label dato">Monto</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="monto">$100</label>
                                </div>
                                <div class="col-sm-4">
                                    <label for="amortizacion" class=" col-form-label dato">Amortizacion</label>
                                    <label  class="form-check-label value" id="amortizacion">$100</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="porPagar" class="col-sm-4 col-form-label dato">Por Pagar</label>
                                <div class="col-sm-4">
                                    <label  class="form-check-label value" id="porPagar">$0</label>
                                </div>
                                <div class="col-sm-4">
                                    <label for="tipoDePago" class="col-sm-4 col-form-label dato">Tipo de Pago</label>
                                    <label  class="form-check-label value" id="porPagar">EFECTIVO</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="notas" class="col-sm-4 col-form-label dato">Notas</label>
                                <div class="col-sm-8">
                                    <label  class="form-check-label value" id="notas"></label>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-default float-right">OK</button>
                            </div>
                            <!-- /.card-footer -->
                    </div>
                </div>
            </section>
            <!-- /.content -->
            <!-- Bootstrap 4 -->
        
            <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        
    </body>
    
    <!-- Content Header (Page header) -->
    

</html>


    