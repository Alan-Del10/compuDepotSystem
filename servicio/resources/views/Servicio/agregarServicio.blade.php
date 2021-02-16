@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Agregar Servicio</h1>
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
                        <h3 class="card-title">Servicio</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="card-body">
                        <div class="form-group row">
                            <label for="cliente" class="col-sm-2 col-form-label">Cliente</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="cliente">
                                    <option value="0">Seleccionar Cliente</option>
                                    @foreach($clientes as $cliente)
                                        <option value="{{$cliente->id_cliente}}">{{$cliente->nombre_completo}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1">
                                <button type="button" class="btn btn-primary" id="agregarCliente"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="estatus" class="col-sm-2 col-form-label">Estatus</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="estatus">
                                    <option value="0">Seleccionar</option>
                                    @foreach($estatus as $estat)
                                        <option value="{{$estat->id_estatus}}">{{$estat->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="lugar" class="col-sm-1 col-form-label">Lugar</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="lugar" placeholder="Lugar">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="concepto" class="col-sm-2 col-form-label">Concepto</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="concepto">
                                    <option value="0">Seleccionar</option>
                                    @foreach($conceptos as $concepto)
                                        <option value="{{$concepto->id_concepto_servicio}}">{{$concepto->descripcion}}</option>
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
                                        <option value="{{$tipo->id_tipo_servicio}}">{{$tipo->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="clase" class="col-sm-1 col-form-label">Clase</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="clase" placeholder="Clase">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="color" class="col-sm-2 col-form-label">Color</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="color">
                                    <option value="0">Seleccionar</option>
                                    @foreach($colores as $color)
                                        <option value="{{$color->id_color}}">{{$color->color}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="compania" class="col-sm-1 col-form-label">Compania</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="compania">
                                    <option value="0">Seleccionar</option>
                                    @foreach($companias as $compania)
                                        <option value="{{$compania->id_compania}}">{{$compania->descripcion}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="codigoAcceso" class="col-sm-2 col-form-label">Codigo Acceso</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="codigoAcceso" placeholder="Codigo Acceso">
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <div class="col-sm-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="seHaMojado">
                                    <label class="form-check-label" for="whatsapp">Alguna Vez Se Mojó?</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="autorizaRiesgo">
                                    <label class="form-check-label" for="whatsapp">Autoriza Riesgo?</label>
                                </div>
                            </div>

                        </div>
                        <div class="form-group row">
                            <label for="notasTecnicas" class="col-sm-2 col-form-label">Notas Técnicas (Revision adicional)</label>
                            <div class="col-sm-4">
                            <textarea name="notasTecnicas" id="notasTecnicas" class="form-control" rows="5" placeholder="Notas Técnicas (Revision adicional)"></textarea>
                            </div>
                            <div class="col-sm-2"></div><!-- separador -->
                            <div class="col-sm-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="respaldo">
                                    <label class="form-check-label" for="whatsapp">Desea Respaldo?</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="marca" class="col-sm-2 col-form-label">Marca</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="marca">
                                    <option value="0">Seleccionar</option>
                                    @foreach($marcas as $marca)
                                        <option value="{{$marca->id_marca}}">{{$marca->marca}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="modelo" class="col-sm-1 col-form-label">Modelo</label>
                            <div class="col-sm-4">
                                <select class="form-control" id="modelo">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="modeloTecnico" class="col-sm-2 col-form-label">Modelo Tecnico</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="modeloTecnico" placeholder="Modelo Tecnico">
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="monto" class="col-sm-1 col-form-label">$Monto (*)</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control border-success" id="monto" placeholder="$">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="serie" class="col-sm-2 col-form-label">No. Serie</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="serie" placeholder="No. Serie">
                            </div>
                            <div class="col-sm-1"></div><!-- separador -->
                            <label for="IMEI" class="col-sm-1 col-form-label">IMEI (*#06#)</label>
                            <div class="col-sm-4">
                            <input type="text" class="form-control" id="IMEI" placeholder="IMEI">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <div class="col-sm-12">
                                <button  class="btn btn-info float-right " id="agregarPago"  type="button">Agregar Pago</button>
                            </div>
                        </div>
                        <div class=" pagos">
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="notas" class="col-sm-2 col-form-label">Notas</label>
                            <div class="col-sm-4">
                            <textarea name="notas" class="form-control" id="notas" cols="120" rows="5" placeholder="Notas"></textarea>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="button" class="btn btn-default float-right agregarServicio">Agregar</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </section>

    <!-- Content Header (Page header) -->
    <script>
        $(document).ready(function(){
            //inicializa variables al inicio
            var modelos =  @json($modelos); //variable de modelos pasada del modelo de laravel

            //termino de inicializacion de variables

            //validacion de inputs con feedback de error
            //Solo se permiten Letras,Números,Puntos,Guíones y Comas
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
            //Solo se permiten Números
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
            //Solo se permiten Números
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
            //evento del cambio de marca
            $('#marca').change(function(){
                if($(this).val() != null){

                    $('#modelo option').remove();
                    modelos.forEach(modelo => {
                        if($(this).val() == modelo.id_marca){
                            console.log(modelo);
                            $('#modelo').append('<option value="'+modelo.id_modelo+'">'+modelo.descripcion+'</option>');
                        }

                    });
                }
            });

            //evento sobre el click de agregar el pao
            $('#agregarPago').click(function(){

                $('.pagos').append(''+
                    '<div class="form-group row pagosx">'+
                        '<label for="formaPago" class="col-sm-1 col-form-label">Forma de Pago</label>'+
                        '<div class="col-sm-2">'+
                            '<select name="formaPago" id="formaPago" class="form-control formaPago">'+
                                '@foreach($formasPagos as $formaPago)'+
                                '<option value="{{$formaPago->id_forma_de_pago}}">{{$formaPago->forma_pago}}</option>'+
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

            //enviar datos a BD con ruta servicio add

            $('.agregarServicio').click(function(){

                datos = [];


                if ($('#seHaMojado').prop("checked")) { mojado = 'SI';}else{mojado = 'NO';}
                if ($('#autorizaRiesgo').prop("checked")) { riesgo = 'SI';}else{riesgo = 'NO';}
                if ($('#whatsapp').prop("checked")) { whats = 'SI';}else{whats = 'NO';}
                if ($('#respaldo').prop("checked")) { respaldo = 'SI';}else{respaldo = 'NO';}

                servicio = {
                    'cliente': $('#cliente').val(),
                    'estatus': $('#estatus').val(),
                    'lugar': $('#lugar').val(),
                    'concepto': $('#concepto').val(),
                    'tipo': $('#tipo').val(),
                    'clase': $('#clase').val(),
                    'color': $('#color').val(),
                    'compania': $('#compania').val(),
                    'codigoAcceso': $('#codigoAcceso').val(),
                    'mojado':mojado,
                    'riesgo': riesgo,
                    'respaldo': respaldo,
                    'notasTecnicas': $('#notasTecnicas').val(),
                    'marca': $('#marca').val(),
                    'modelo': $('#modelo').val(),
                    'modeloTecnico': $('#modeloTecnico').val(),
                    'monto': $('#monto').val(),
                    'serie': $('#serie').val(),
                    'IMEI': $('#IMEI').val(),
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
                    url: "{{route('agregarServicio')}}",
                    dataType: "json",
                    data: {'array': JSON.stringify(datos)},
                    success: function(data) {
                        console.log(data);
                        if(data.respuesta == 1){
                            Swal.fire({title:"Logrado", text:"El servicio se agrego correctamente!", icon: "success", allowOutsideClick:false});
                            $('.swal2-confirm').click(function(){
                                var ticket = data.ticket;
                                var urlTicket = "{{URL::asset('storage/ticket/servicio')}}";
                                window.open(urlTicket+'/'+ticket);
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

        function imprimirRecibo(id){
            $.ajax({
                type: "get",
                url: "{{route('reciboServicio', ".id.")}}",
                dataType: "json",
                data: {'id_servicio': id},
                done: function(data){
                    var pdf= window.open("")
      pdf.document.write("<iframe width='100%' height='100%'"+
      " src='data:application/pdf;base64, " + encodeURI(data)+"'></iframe>")
                }
            });
        }
    </script>
@endsection



