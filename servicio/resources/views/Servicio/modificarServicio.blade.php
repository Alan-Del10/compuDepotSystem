@extends('layouts.app')
@section('content')
    <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Modificar Servicio</h1>
                </div>
                <div class="col-sm-6">

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
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="card-body">
                        <div class="form-group row">
                            <label for="nombreCompleto" class="col-sm-2 col-form-label">Nombre Completo</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nombreCompleto" placeholder="Nombre Completo" value = "{{$servicio[0]->nombre_completo}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="telefono" class="col-sm-2 col-form-label">Telefono</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="telefono" maxlength="10" placeholder="telefono" value = "{{$servicio[0]->telefono}}" >
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    @if($servicio[0]->whatsapp == 'SI')
                                        <input type="checkbox" class="form-check-input" id="whatsapp" checked>
                                    @else
                                        <input type="checkbox" class="form-check-input" id="whatsapp">
                                    @endif
                                    <label class="form-check-label" for="whatsapp">Whatsapp?</label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="estatus" class="col-sm-2 col-form-label">Estatus</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="estatus">
                                    <option value="0">Seleccionar</option>
                                    @foreach($estatus as $estat)
                                        <option value="{{$estat->id_estatus}}" {{ $estat->id_estatus == $servicio[0]->id_estatus ? 'selected' : '' }} >{{$estat->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="lugar" class="col-sm-1 col-form-label">Lugar</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="lugar" placeholder="Lugar" value = "{{$servicio[0]->lugar}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="concepto" class="col-sm-2 col-form-label">Concepto</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="concepto">
                                    <option value="0">Seleccionar</option>
                                    @foreach($conceptos as $concepto)
                                        <option value="{{$concepto->id_concepto_servicio}}" {{ $concepto->id_concepto_servicio == $servicio[0]->id_concepto_servicio ? 'selected' : '' }} >{{$concepto->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tipo" class="col-sm-2 col-form-label">Tipo</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="tipo">
                                    <option value="0">Seleccionar</option>
                                    @foreach($tipos as $tipo)
                                        <option value="{{$tipo->id_tipo_servicio}}" {{ $tipo->id_tipo_servicio == $servicio[0]->id_tipo_servicio ? 'selected' : '' }}>{{$tipo->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="clase" class="col-sm-1 col-form-label">Clase</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="clase" placeholder="Clase" value = "{{$servicio[0]->clase}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color" class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="color">
                                    <option value="0">Seleccionar</option>
                                    @foreach($colores as $color)
                                        <option value="{{$color->id_color}}" {{ $color->id_color == $servicio[0]->id_color ? 'selected' : '' }} disabled>{{$color->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="compania" class="col-sm-1 col-form-label">Compania</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="compania">
                                    <option value="0">Seleccionar</option>
                                    @foreach($companias as $compania)
                                        <option value="{{$compania->id_compania}}" {{ $compania->id_compania == $servicio[0]->id_compania ? 'selected' : '' }} disabled>{{$compania->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="codigoAcceso" class="col-sm-2 col-form-label">Codigo Acceso</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="codigoAcceso" placeholder="Codigo Acceso" value = "{{$servicio[0]->codigo_acceso}}">
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <div class="col-sm-3">
                                <div class="form-check">
                                    @if($servicio[0]->mojado == 'SI')
                                    <input type="checkbox" class="form-check-input" id="seHaMojado" checked>
                                    @else
                                    <input type="checkbox" class="form-check-input" id="seHaMojado">
                                    @endif
                                    <label class="form-check-label" for="whatsapp">Alguna Vez Se Mojó?</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    @if($servicio[0]->riesgo == 'SI')
                                    <input type="checkbox" class="form-check-input" id="autorizaRiesgo" checked>
                                    @else
                                    <input type="checkbox" class="form-check-input" id="autorizaRiesgo">
                                    @endif
                                    <label class="form-check-label" for="whatsapp">Autoriza Riesgo?</label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="notasTecnicas" class="col-sm-2 col-form-label">Notas Técnicas (Revision adicional)</label>
                            <div class="col-sm-4">
                            <textarea name="notasTecnicas" id="notasTecnicas" cols="120" rows="5" placeholder="Notas Técnicas (Revision adicional)">{{$servicio[0]->notas_tecnicas}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="marca" class="col-sm-2 col-form-label">Marca</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="marca">
                                    <option value="0">Seleccionar</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{$marca->id_marca}}" {{ $marca->id_marca == $servicio[0]->id_marca ? 'selected' : '' }} disabled>{{$marca->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="modelo" class="col-sm-1 col-form-label">Modelo</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="modelo">
                                    @foreach($modelos as $modelo)
                                        <option value="{{$modelo->id_modelo}}" {{ $modelo->id_modelo == $servicio[0]->id_modelo ? 'selected' : '' }} disabled >{{$modelo->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="modeloTecnico" class="col-sm-2 col-form-label">Modelo Tecnico</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="modeloTecnico" placeholder="Modelo Tecnico" value = "{{$servicio[0]->modelo_tecnico}}" disabled>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="monto" class="col-sm-1 col-form-label">$Monto (*)</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control border-success" id="monto" placeholder="$" value = "{{$servicio[0]->monto}}">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="serie" class="col-sm-2 col-form-label">No. Serie</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="serie" placeholder="No. Serie" value = "{{$servicio[0]->no_serie}}" disabled>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="IMEI" class="col-sm-1 col-form-label">IMEI (*#06#)</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="IMEI" placeholder="IMEI"  value = "{{$servicio[0]->IMEI}}" disabled>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button  class="btn btn-info float-right " id="agregarPago"  type="button">Agregar Pago</button>
                            </div>
                        </div>
                        <div class=" pagos">
                            @foreach($pagos as $pago)
                            <div class="form-group row pagosy">
                                <label for="formaPago" class="col-sm-1 col-form-label">Forma de Pago</label>
                                <div class="col-sm-2">
                                    <select name="formaPago" id="formaPago" class="form-control formaPago" disabled>
                                        @foreach($formasPagos as $formaPago)
                                            <option value="{{$formaPago->id_forma_de_pago}}" {{ $formaPago->id_forma_de_pago == $pago->id_forma_de_pago ? 'selected' : '' }}>{{$formaPago->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-1"></div><!-- separador -->
                                <label for="cantidad" class="col-sm-1 col-form-label">Cantidad</label>
                                <div class="col-sm-1">
                                    <input type="text" class="form-control cantidad" id="cantidad" maxlength ="14" placeholder="Cantidad" value = "{{$pago->cantidad}}" disabled>
                                </div>
                                <div class="col-sm-1"></div><!-- separador -->
                                <label for="nota" class="col-sm-1 col-form-label">Nota</label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control nota" id="nota" placeholder="Nota" maxlength ="45" value = "{{$pago->nota}}" disabled>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr>
                        <div class="form-group row">
                            <label for="notas" class="col-sm-2 col-form-label">Notas</label>
                            <div class="col-sm-4">
                            <textarea name="notas" id="notas" cols="120" rows="5" placeholder="Notas"> {{$servicio[0]->notas_extra}}</textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default float-right modificarServicio">Modificar</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
            </div>
        </section>
            <!-- /.content -->

    <!-- Content Header (Page header) -->
    <script>
        $(document).ready(function(){
            //inicializa variables al inicio
            var modelos =  @json($modelos); //variable de modelos pasada del modelo de laravel

            //termino de inicializacion de variables

            //validacion de inputs con feedback de error
            $('#nombreCompleto').on('input', function() {

                var input=$(this);
                var re = /[^A-Za-z0-9,-. ]+$/;
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

                this.value = this.value.replace(/[^A-Za-z0-9,-. ]+$/g,'').toUpperCase();

            });

            $('#telefono').on('input', function() {

                var input=$(this);
                var re =/[^0-9]+$/;
                var testing=re.test(input.val());
                if(testing === true){
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append('<div class="invalid-feedback error">Error solo se permiten Números!</div>');
                }
                else{
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }

                this.value = this.value.replace(/[^0-9]+$/g,'').toUpperCase();

            });

            $('#IMEI').on('input', function() {

                var input=$(this);
                var re =/[^0-9]+$/;
                var testing=re.test(input.val());
                if(testing === true){
                    input.removeClass("is-valid").addClass("is-invalid");
                    input.parent().find('.error').remove();
                    input.parent().append('<div class="invalid-feedback error">Error solo se permiten Números!</div>');
                }
                else{
                    input.removeClass("is-invalid").addClass("is-valid");
                    input.parent().find('.error').remove();
                }

                this.value = this.value.replace(/[^0-9]+$/g,'').toUpperCase();

            });

            //termino de validacion de input con feedback error


            //eventos


            $('#agregarPago').click(function(){

                $('.pagos').append(''+
                    '<div class="form-group row pagosx">'+
                        '<label for="formaPago" class="col-sm-1 col-form-label">Forma de Pago</label>'+
                        '<div class="col-sm-2">'+
                            '<select name="formaPago" id="formaPago" class="form-control formaPago">'+
                                '@foreach($formasPagos as $formaPago)'+
                                '<option value="{{$formaPago->id_forma_de_pago}}">{{$formaPago->descripcion}}</option>'+
                                '@endforeach'+
                            '</select>'+
                        '</div>'+
                        '<div class="col-sm-1"></div><!-- separador -->'+
                        '<label for="cantidad" class="col-sm-1 col-form-label">Cantidad</label>'+
                        '<div class="col-sm-1">'+
                            '<input type="text" class="form-control cantidad" id="cantidad" maxlength ="14" placeholder="Cantidad">'+
                        '</div>'+
                        '<div class="col-sm-1"></div><!-- separador -->'+
                        '<label for="nota" class="col-sm-1 col-form-label">Nota</label>'+
                        '<div class="col-sm-3">'+
                            '<input type="text" class="form-control nota" id="nota" placeholder="Nota" maxlength ="45">'+
                        '</div>'+
                        '<h1><span class="text-danger float-right col-sm-1 removePago"><i class="fas fa-times"></i></span></h1>'+
                    '</div>'
                );

                $('.removePago').click(function(){
                   $(this).parent().parent().remove();
                });

                $('.nota').on('input', function() {

                    var input=$(this);
                    var re = /[^A-Za-z0-9,-. ]+$/;
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

                    this.value = this.value.replace(/[^A-Za-z0-9,-. ]+$/g,'').toUpperCase();

                });

                $('.cantidad').on('input', function() {

                    var input=$(this);
                    var re = /[^0-9.]+$/;
                    var testing=re.test(input.val());
                    if(testing === true){
                        input.removeClass("is-valid").addClass("is-invalid");
                        input.parent().find('.error').remove();
                        input.parent().append('<div class="invalid-feedback error">Error solo se permiten Números!</div>');
                    }
                    else{
                        input.removeClass("is-invalid").addClass("is-valid");
                        input.parent().find('.error').remove();
                    }

                    this.value = this.value.replace(/[^0-9.]+$/g,'').toUpperCase();

                });
            });

            //enviar datos a bd con ruta servicio add

            $('.modificarServicio').click(function(){

                datos = [];


                if ($('#seHaMojado').prop("checked")) { mojado = 'SI';}else{mojado = 'NO';}
                if ($('#autorizaRiesgo').prop("checked")) { riesgo = 'SI';}else{riesgo = 'NO';}
                if ($('#whatsapp').prop("checked")) { whats = 'SI';}else{whats = 'NO';}

                servicio = {
                    'idServicio': '{{$servicio[0]->id_servicio}}',
                    'telefono': $('#telefono').val(),
                    'whatsapp': whats,
                    'estatus': $('#estatus').val(),
                    'lugar': $('#lugar').val(),
                    'concepto': $('#concepto').val(),
                    'tipo': $('#tipo').val(),
                    'clase': $('#clase').val(),
                    'codigoAcceso': $('#codigoAcceso').val(),
                    'mojado':mojado,
                    'riesgo': riesgo,
                    'notasTecnicas': $('#notasTecnicas').val(),
                    'monto': $('#monto').val(),
                    'notas': $('#notas').val()
                }

                datos.push(servicio);

                pagos = [];
                $('.pagosx').each(function(index){
                    pagosArray = {
                        'formaPago': $( this ).find('.formaPago').val(),
                        'cantidad':  $( this ).find('.cantidad').val(),
                        'nota': $( this ).find('.nota').val()
                    }

                    pagos.push(pagosArray);

                });

                datos.push(pagos);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "post",
                    url: "{{route('modificarServicio')}}",
                    dataType: "json",
                    data: {'array': JSON.stringify(datos)},
                    success: function(data) {
                        console.log(data);
                        if(data == 1){
                            Swal.fire("Logrado", "El servicio se modifico correctamente!", "success");
                            $('.swal2-confirm').click(function(){
                                location.reload();
                            });
                        }else{
                            Swal.fire("Opps", "" + data, "error");
                            $('.swal2-confirm').click(function(){
                                location.reload();
                            });
                        }

                    },
                    error: function(data) {
                    console.log(data);
                    Swal.fire("Oops", "No se pudo agregar revisa correctamente la info!", "error");
                    }
                });

            });

            //termino de eventos


        });
    </script>
@endsection


