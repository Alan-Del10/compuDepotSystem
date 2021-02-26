@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                <h1>Datos</h1>
                </div>
                <div class="col-sm-8">
                <fieldset class="form-group">
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="marca" name="select" class="custom-control-input" checked>
                    <label class="custom-control-label" for="marca" >Marca</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="modelo" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="modelo">Modelo</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="color" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="color">Color</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="compania" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="compania">Compania</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="estatus" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="estatus">Estatus</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="concepto" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="concepto">Concepto</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="tipo" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="tipo">Tipo</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="formasDePago" name="select" class="custom-control-input">
                    <label class="custom-control-label" for="formasDePago">Forma de Pago</label>
                    </div>
                </fieldset>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

            <!-- Main content -->
            <section class="content">
              <div class="container-fluid">
                <!-- /.marca -->
                <div class="row marcas tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Marcas</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarMarca"  class="btn btn-info">Agregar Marca</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($marcas as $marca)
                            <tr>
                              <td>{{$marca->id_marca}}</td>
                              <td>{{$marca->marca}}</td>
                              <td>
                                @if($marca->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$marca->id_marca, 'marca'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$marca->id_marca, 'marca'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin marca -->
                <!-- /.modelo -->
                <div class="row modelos tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Modelos</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarModelo"  class="btn btn-info">Agregar Modelo</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Marca</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($modelos as $modelo)
                            <tr>
                              <td>{{$modelo->id_modelo}}</td>
                              <td>{{$modelo->modelo}}</td>
                              <td>{{$modelo->marca}}</td>
                              <td>
                                @if($modelo->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$modelo->id_modelo, 'modelo'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$modelo->id_modelo, 'modelo'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin modelo -->
                <!-- /.color -->
                <div class="row colores tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Colores</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarColor"  class="btn btn-info">Agregar Color</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($colores as $color)
                            <tr>
                              <td>{{$color->id_color}}</td>
                              <td>{{$color->color}}</td>
                              <td>
                                @if($color->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$color->id_color, 'color'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$color->id_color, 'color'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin color -->
                <!-- /.compania -->
                <div class="row companias tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Marcas</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarCompania"  class="btn btn-info">Agregar Compania</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($companias as $compania)
                            <tr>
                              <td>{{$compania->id_compania}}</td>
                              <td>{{$compania->descripcion}}</td>
                              <td>
                                @if($compania->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$compania->id_compania, 'compania'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$compania->id_compania, 'compania'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin compania -->
                <!-- /.estatus -->
                <div class="row estatuses tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Estatus</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarEstatus"  class="btn btn-info">Agregar Estatus</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($estatus as $estat)
                            <tr>
                              <td>{{$estat->id_estatus}}</td>
                              <td>{{$estat->descripcion}}</td>
                              <td>
                                @if($estat->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$estat->id_estatus, 'estatus'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$estat->id_estatus, 'estatus'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach

                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin estatus -->
                <!-- /.concepto -->
                <div class="row conceptos tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Concepto</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarConcepto"  class="btn btn-info">Agregar Concepto</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($conceptos as $concepto)
                            <tr>
                              <td>{{$concepto->id_concepto_servicio}}</td>
                              <td>{{$concepto->descripcion}}</td>
                              <td>
                                @if($concepto->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$concepto->id_concepto_servicio, 'concepto_servicio'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$concepto->id_concepto_servicio, 'concepto_servicio'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin concepto -->
                <!-- /.tipo -->
                <div class="row tipos tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Tipo</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                              <a id="agregarTipo"  class="btn btn-info">Agregar Tipo</a>
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($tipos as $tipo)
                            <tr>
                              <td>{{$tipo->id_tipo_servicio}}</td>
                              <td>{{$tipo->descripcion}}</td>
                              <td>
                                @if($tipo->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$tipo->id_tipo_servicio, 'tipo_servicio'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$tipo->id_tipo_servicio, 'tipo_servicio'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin tipo -->
                <!-- /.metodoPago -->
                <div class="row formaPago tableForm">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-header">
                        <div class="row">
                          <div class="col-4">
                            <h3 class="card-title">Forma de Pago</h3>
                          </div>
                          <div class="col-6">
                          </div>
                          <div class="col-2">
                          </div>
                        </div>

                      </div>
                      <!-- /.card-header -->
                      <div class="card-body p-0">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th style="width: 10px">ID</th>
                              <th>Descripción</th>
                              <th>Acciones</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach($formasPagos as $formaPago)
                            <tr>
                              <td>{{$formaPago->id_forma_de_pago}}</td>
                              <td>{{$formaPago->forma_pago}}</td>
                              <td>{{$formaPago->estatus}}</td>
                              <td>
                                @if($formaPago->estatus == 1)
                                    <a class="btn btn-danger" href="{{route('desactivarDatos', [$formaPago->id_forma_de_pago, 'forma_de_pago'])}}" >
                                    <span class="fas fa-times"></span><small>&nbsp;&nbsp;Desactivar</small></a>
                                @else
                                <a class="btn btn-success" href="{{route('activarDatos', [$formaPago->id_forma_de_pago, 'forma_de_pago'])}}" >
                                    <span class="fas fa-check"></span><small>&nbsp;&nbsp;Activar</small></a>
                                @endif
                              </td>
                            </tr>
                          @endforeach
                          </tbody>
                        </table>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.fin metodoPago -->

              </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            <!-- Bootstrap 4 -->

            <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    </body>

    <!-- Content Header (Page header) -->
    <script>
        $(document).ready(function(){
            //inicializa variables al inicio  y detalles
            var categorias = @json($categorias);
            var marcas =  @json($marcas); //variable de marcas pasada del modelo de laravel
            $('.tableForm').hide();
            $('.marcas').show();

            //termino de inicializacion de variables

            //validacion de inputs con feedback de error
            $('#nombreCompleto').on('input', function() {

                var input=$(this);
                var re = /[^A-Za-z0-9,-.]+$/;
                var testing=re.test(input.val());
                if(testing === true){
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras,Números,Puntos,Guíones y Comas!</div>');
                }
                else{
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }

                this.value = this.value.replace(/[^A-Za-z0-9,-.]+$/g,'').toUpperCase();

            });
            //termino de validacion de input con feedback error




            //eventos de input
            $('#marca').on('click', function() {
              $('.tableForm').hide();
              $('.marcas').show();

            });

            $('#modelo').on('click', function() {
              $('.tableForm').hide();
              $('.modelos').show();

            });

            $('#color').on('click', function() {
              $('.tableForm').hide();
              $('.colores').show();

            });

            $('#compania').on('click', function() {
              $('.tableForm').hide();
              $('.companias').show();

            });

            $('#estatus').on('click', function() {
              $('.tableForm').hide();
              $('.estatuses').show();

            });

            $('#concepto').on('click', function() {
              $('.tableForm').hide();
              $('.conceptos').show();

            });

            $('#tipo').on('click', function() {
              $('.tableForm').hide();
              $('.tipos').show();

            });

            $('#formasDePago').on('click', function() {
              $('.tableForm').hide();
              $('.formaPago').show();

            });




            //termino de eventos input


            //eventos de agregar datos
            $('#agregarMarca').on('click', function() {
              var cadenaOption = '<select class="form-control" id="categoriaOption">';//inicializo variable para el options del sweet alert
              categorias.forEach(categoria => {
                  cadenaOption = cadenaOption +'<option value="'+categoria.categoria+'">'+categoria.categoria+'</option>';
              });
              cadenaOption = cadenaOption + '</select>';
              Swal.fire({
                title: "Agregar Marca",
                html: '' +
                  '<div class="form-group row">' +
                    '<div class="col-sm-12">' +
                        '<label for="categoriaOption" class="float-left col-form-label">Categoria</label>' +
                        ''+cadenaOption+'' +
                    '</div>' +
                    '<div class="col-sm-12">' +
                      '<label for="marcaDescripcion" class="float-left col-form-label">Descripcion</label>' +
                      '<input type="text" class="form-control" id="marcaDescripcion" placeholder="Descripcion">' +
                    '</div>' +
                  '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
              }).then((result) => {
                if(result.isConfirmed){

                  marcaDescripcion = document.getElementById('marcaDescripcion').value;
                  categoriaOption = document.getElementById('categoriaOption').value;
                  if(marcaDescripcion != null || marcaDescripcion != ''){
                      $.ajax({
                          type: "get",
                          url: "{{route('agregarMarca')}}",
                          data:{'marcaDescripcion' : marcaDescripcion,
                          'categoriaOption' : categoriaOption},
                          success: function(data) {
                            console.log(data);
                            if(data == 2){
                              swal.fire("Error", "Marca Existente NO Puedes Agregar La Misma!", "error");
                            }else if(data == 1){
                              swal.fire("Logrado", "La Marca Se Registro Correctamente!", "success");
                              $('.swal2-confirm').click(function(){
                                location.reload();
                              });
                            }else{
                              swal.fire("Informativo", data, "info");
                            }
                          },
                          error: function(data) {
                            console.log(data);
                            Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                          }
                      });

                  }else{
                    Swal("Oops", "No puede ir vacio!", "error");
                    return false;
                  }
                }
              });


              //validacion del modal
              $('#marcaDescripcion').on('input', function() {
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

            $('#agregarModelo').on('click', function() {
              //sacar una cadena de options para el sweet alert
              var cadenaOption = '<select class="form-control" id="marcaOption">';//inicializo variable para el options del sweet alert
              marcas.forEach(marca => {
                cadenaOption = cadenaOption +'<option value="'+marca.marca+'">'+marca.marca+'</option>';
              });
              cadenaOption = cadenaOption + '</select>';

              Swal.fire({
                title: "Agregar Modelo",
                html: '' +
                          '<div class="form-group row">' +
                            '<div class="col-sm-12">' +
                              '<label for="modeloDescripcion" class="float-left col-form-label">Descripcion</label>' +
                              '<input type="text" class="form-control" id="modeloDescripcion" placeholder="Descripcion">' +
                            '</div>' +
                            '<div class="col-sm-12">' +
                              '<label for="marcaDescripcion" class="float-left col-form-label">Marca</label>' +
                              ''+cadenaOption+'' +
                            '</div>' +
                          '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
              }).then((result) => {
                if(result.isConfirmed){

                  modeloDescripcion = document.getElementById('modeloDescripcion').value;
                  marcaOption = document.getElementById('marcaOption').value;

                  if(modeloDescripcion != null || modeloDescripcion != ''){
                      $.ajax({
                          type: "get",
                          url: "{{route('agregarModelo')}}",
                          data:{'modeloDescripcion' : modeloDescripcion,'marcaOption' : marcaOption },
                          success: function(data) {
                            console.log(data);
                            if(data == 2){
                              swal.fire("Error", "Modelo Existente NO Puedes Agregar La Misma!", "error");
                            }else if(data == 1){
                              swal.fire("Logrado", "El Modelo Se Registro Correctamente!", "success");
                              $('.swal2-confirm').click(function(){
                                location.reload();
                              });
                            }else{
                              swal.fire("Informativo", data, "info");
                            }
                          },
                          error: function(data) {
                            console.log(data);
                            Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
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



            });

            $('#agregarColor').on('click', function() {

              Swal.fire({
                title: "Agregar Color",
                html: '' +
                          '<div class="form-group row">' +
                            '<div class="col-sm-12">' +
                              '<label for="colorDescripcion" class="float-left col-form-label">Descripcion</label>' +
                              '<input type="text" class="form-control" id="colorDescripcion" placeholder="Descripcion">' +
                            '</div>' +
                          '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
              }).then((result) => {
                if(result.isConfirmed){

                  colorDescripcion = document.getElementById('colorDescripcion').value;

                  if(colorDescripcion != null || colorDescripcion != ''){
                      $.ajax({
                          type: "get",
                          url: "{{route('agregarColor')}}",
                          data:{'colorDescripcion' : colorDescripcion},
                          success: function(data) {
                            console.log(data);
                            if(data == 2){
                              swal.fire("Error", "Color Existente NO Puedes Agregar El Misma!", "error");
                            }else if(data == 1){
                              swal.fire("Logrado", "El Color Se Registro Correctamente!", "success");
                              $('.swal2-confirm').click(function(){
                                location.reload();
                              });
                            }else{
                              swal.fire("Informativo", data, "info");
                            }
                          },
                          error: function(data) {
                            console.log(data);
                            Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                          }
                      });

                  }else{
                    Swal("Oops", "No puede ir vacio!", "error");
                    return false;
                  }
                }
              });


              //validacion del modal
              $('#colorDescripcion').on('input', function() {
                  var input=$(this);
                  var re = /[^A-Za-z ]+$/;
                  var testing=re.test(input.val());
                  if(testing === true){
                      input.removeClass("is-valid").addClass("is-invalid");
                      input.parent().find('.error').remove();
                      input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras!</div>');
                  }
                  else{
                      input.removeClass("is-invalid").addClass("is-valid");
                      input.parent().find('.error').remove();
                  }

                  this.value = this.value.replace(/[^A-Za-z ]+$/g,'').toUpperCase();

                  });
            });

            $('#agregarCompania').on('click', function() {

                Swal.fire({
                  title: "Agregar Compañia",
                  html: '' +
                            '<div class="form-group row">' +
                              '<div class="col-sm-12">' +
                                '<label for="companiaDescripcion" class="float-left col-form-label">Descripcion</label>' +
                                '<input type="text" class="form-control" id="companiaDescripcion" placeholder="Descripcion">' +
                              '</div>' +
                            '</div>'
                  ,
                  confirmButtonText: "Agregar",
                  showCancelButton: true,
                  cancelButtonText: "Cancelar",
                  closeOnConfirm: true
                }).then((result) => {
                  if(result.isConfirmed){

                    companiaDescripcion = document.getElementById('companiaDescripcion').value;

                    if(companiaDescripcion != null || companiaDescripcion != ''){
                        $.ajax({
                            type: "get",
                            url: "{{route('agregarCompania')}}",
                            data:{'companiaDescripcion' : companiaDescripcion},
                            success: function(data) {
                              console.log(data);
                              if(data == 2){
                                swal.fire("Error", "Compañia Existente NO Puedes Agregar La Misma!", "error");
                              }else if(data == 1){
                                swal.fire("Logrado", "La Compañia Se Registro Correctamente!", "success");
                                $('.swal2-confirm').click(function(){
                                  location.reload();
                                });

                              }else{
                                swal.fire("Informativo", data, "info");
                              }
                            },
                            error: function(data) {
                              console.log(data);
                              Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                            }
                        });

                    }else{
                      Swal("Oops", "No puede ir vacio!", "error");
                      return false;
                    }
                  }
                });


                //validacion del modal
                  $('#companiaDescripcion').on('input', function() {
                    var input=$(this);
                    var re = /[^A-Za-z0-9- ]+$/;
                    var testing=re.test(input.val());
                    if(testing === true){
                        input.removeClass("is-valid").addClass("is-invalid");
                        input.parent().find('.error').remove();
                        input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras!</div>');
                    }
                    else{
                        input.removeClass("is-invalid").addClass("is-valid");
                        input.parent().find('.error').remove();
                    }

                    this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g,'').toUpperCase();

                  });
            });

            $('#agregarEstatus').on('click', function() {

                Swal.fire({
                  title: "Agregar Estatus",
                  html: '' +
                            '<div class="form-group row">' +
                              '<div class="col-sm-12">' +
                                '<label for="estatusDescripcion" class="float-left col-form-label">Descripcion</label>' +
                                '<input type="text" class="form-control" id="estatusDescripcion" placeholder="Descripcion">' +
                              '</div>' +
                            '</div>'
                  ,
                  confirmButtonText: "Agregar",
                  showCancelButton: true,
                  cancelButtonText: "Cancelar",
                  closeOnConfirm: true
                }).then((result) => {
                  if(result.isConfirmed){

                    estatusDescripcion = document.getElementById('estatusDescripcion').value;

                    if(estatusDescripcion != null || estatusDescripcion != ''){
                        $.ajax({
                            type: "get",
                            url: "{{route('agregarEstatus')}}",
                            data:{'estatusDescripcion' : estatusDescripcion},
                            success: function(data) {
                              console.log(data);
                              if(data == 2){
                                swal.fire("Error", "Estatus Existente NO Puedes Agregar La Misma!", "error");
                              }else if(data == 1){
                                swal.fire("Logrado", "El Estatus Se Registro Correctamente!", "success");
                                $('.swal2-confirm').click(function(){
                                  location.reload();
                                });
                              }else{
                                swal.fire("Informativo", data, "info");
                              }
                            },
                            error: function(data) {
                              console.log(data);
                              Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                            }
                        });

                    }else{
                      Swal("Oops", "No puede ir vacio!", "error");
                      return false;
                    }
                  }
                });


                //validacion del modal
                  $('#estatusDescripcion').on('input', function() {
                    var input=$(this);
                    var re = /[^A-Za-z ]+$/;
                    var testing=re.test(input.val());
                    if(testing === true){
                        input.removeClass("is-valid").addClass("is-invalid");
                        input.parent().find('.error').remove();
                        input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras!</div>');
                    }
                    else{
                        input.removeClass("is-invalid").addClass("is-valid");
                        input.parent().find('.error').remove();
                    }

                    this.value = this.value.replace(/[^A-Za-z ]+$/g,'').toUpperCase();

                  });
            });

            $('#agregarConcepto').on('click', function() {

                Swal.fire({
                  title: "Agregar Concepto",
                  html: '' +
                            '<div class="form-group row">' +
                              '<div class="col-sm-12">' +
                                '<label for="conceptoDescripcion" class="float-left col-form-label">Descripcion</label>' +
                                '<input type="text" class="form-control" id="conceptoDescripcion" placeholder="Descripcion">' +
                              '</div>' +
                            '</div>'
                  ,
                  confirmButtonText: "Agregar",
                  showCancelButton: true,
                  cancelButtonText: "Cancelar",
                  closeOnConfirm: true
                }).then((result) => {
                  if(result.isConfirmed){

                    conceptoDescripcion = document.getElementById('conceptoDescripcion').value;

                    if(conceptoDescripcion != null || conceptoDescripcion != ''){
                        $.ajax({
                            type: "get",
                            url: "{{route('agregarConcepto')}}",
                            data:{'conceptoDescripcion' : conceptoDescripcion},
                            success: function(data) {
                              console.log(data);
                              if(data == 2){
                                swal.fire("Error", "Concepto Existente NO Puedes Agregar La Misma!", "error");
                              }else if(data == 1){
                                swal.fire("Logrado", "El Concepto Se Registro Correctamente!", "success");
                                $('.swal2-confirm').click(function(){
                                  location.reload();
                                });

                              }else{
                                swal.fire("Informativo", data, "info");
                              }
                            },
                            error: function(data) {
                              console.log(data);
                              Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                            }
                        });

                    }else{
                      Swal("Oops", "No puede ir vacio!", "error");
                      return false;
                    }
                  }
                });


                //validacion del modal
                  $('#conceptoDescripcion').on('input', function() {
                    var input=$(this);
                    var re = /[^A-Za-z0-9- ]+$/;
                    var testing=re.test(input.val());
                    if(testing === true){
                        input.removeClass("is-valid").addClass("is-invalid");
                        input.parent().find('.error').remove();
                        input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras!</div>');
                    }
                    else{
                        input.removeClass("is-invalid").addClass("is-valid");
                        input.parent().find('.error').remove();
                    }

                    this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g,'').toUpperCase();

                  });
            });

            $('#agregarTipo').on('click', function() {

              Swal.fire({
                title: "Agregar Tipo",
                html: '' +
                          '<div class="form-group row">' +
                            '<div class="col-sm-12">' +
                              '<label for="tipoDescripcion" class="float-left col-form-label">Descripcion</label>' +
                              '<input type="text" class="form-control" id="tipoDescripcion" placeholder="Descripcion">' +
                            '</div>' +
                          '</div>'
                ,
                confirmButtonText: "Agregar",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                closeOnConfirm: true
              }).then((result) => {
                if(result.isConfirmed){

                  tipoDescripcion = document.getElementById('tipoDescripcion').value;

                  if(tipoDescripcion != null || tipoDescripcion != ''){
                      $.ajax({
                          type: "get",
                          url: "{{route('agregarTipo')}}",
                          data:{'tipoDescripcion' : tipoDescripcion},
                          success: function(data) {
                            console.log(data);
                            if(data == 2){
                              swal.fire("Error", "Tipo Existente NO Puedes Agregar La Misma!", "error");
                            }else if(data == 1){
                              swal.fire("Logrado", "El Tipo Se Registro Correctamente!", "success");

                              $('.swal2-confirm').click(function(){
                                location.reload();
                              });
                            }else{
                              swal.fire("Informativo", data, "info");
                            }
                          },
                          error: function(data) {
                            console.log(data);
                            Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                          }
                      });

                  }else{
                    Swal("Oops", "No puede ir vacio!", "error");
                    return false;
                  }
                }
              });


              //validacion del modal
                $('#tipoDescripcion').on('input', function() {
                  var input=$(this);
                  var re = /[^A-Za-z0-9- ]+$/;
                  var testing=re.test(input.val());
                  if(testing === true){
                      input.removeClass("is-valid").addClass("is-invalid");
                      input.parent().find('.error').remove();
                      input.parent().append('<div class="invalid-feedback error">Error solo se permiten Letras!</div>');
                  }
                  else{
                      input.removeClass("is-invalid").addClass("is-valid");
                      input.parent().find('.error').remove();
                  }

                  this.value = this.value.replace(/[^A-Za-z0-9- ]+$/g,'').toUpperCase();

                });
            });
            //termino de agregar datos



            //0-9-


    </script>




@endsection
