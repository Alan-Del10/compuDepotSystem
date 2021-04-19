<html>
    <head>
        <style>
            html {
                margin: 0;
                font-size: 7px;
                font-family: Arial, Helvetica, sans-serif;
            }
            body {
                margin: 1mm -5mm 0mm 2mm;
            }
            .row:after{
                content: "";
                display: table;
                clear: both;
            }
            .col-sm{
                float: left;
                width: 20%;
            }
            .col-md{
                float: left;
                width: 30%;
            }
            .col-lg{
                float: left;
                width: 60%;
            }
            .col-xl{
                float: left;
                width: 100%;
            }
            img #idBarcode{
                position: absolute;
                right: 0;
                width: 10%;
            }
            .firma{
                height: 20px;
                width: 80px;
                border-color: black;
                border-style: solid;
                border-width: 1px;
            }
            .absolute{
                top: 85px;
                position: absolute;
                z-index: -1;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        <div class="row">
            <div class="col-lg"><b>Nombre: </b>{{$cliente}}</div>
            <div class="col-md" style="padding-left:20px;"><b  style="text-decoration: underline;"><i>CPD04 </i></b><b style="font-size: 10px;">LP011</b></div>
        </div>
        <div class="row">
            <div class="col-md"><b>Teléfono: </b>{{$telefono}}</div>
            <div class="col-md" style="padding-left:50px;">
                {!! DNS1D::getBarcodeHTML($barcode, "C128",1,15) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md"><b>Fecha: </b>{{$fecha}}</div>
            <div class="col-lg" style="padding-left:65px;">
                No. de Servicio: {{$barcode}}
            </div>
        </div>
        <div class="row">
            <div class="col-md"><b>Marca: </b>{{$marca}}</div>
            <div class="col-lg" style="padding-left:50px;">
                <b>Mod. Técnico: </b>{{$modelo}}
            </div>
        </div>
        <div class="row">
            <div class="col-xl"><b>Código de Acceso: </b> {{$codigo_acceso}}</div>
            </div>
        <div class="row">
            <div class="col-xl"><b>Correo Electrónico: </b> {{$correo}}</div>
            </div>
        <div class="row">
            <div class="col-xl"><b>¿Reparaciones anteriores? </b> {{$reparacion}}</div>
        </div>
        <div class="row">
            <div class="col-xl"><b>¿Qué Evento Provocó el fallo? </b> </div>
        </div>
        <div class="row">
            <div class="col-xl"><b>¿Respaldo De Información? </b>{{$respaldo}} </div>
        </div>
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-md" style="padding-left:10px;">
                {!! DNS1D::getBarcodeHTML($barcode_2, "C39",1,18) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-sm"></div>
            <div class="col-md"style="padding-left:10px; font-size: 5px">
                *{{$barcode_2}}*
            </div>
        </div>
        <div class="row">
            <div class="col-md"><b>Atendidó: </b><i>EMPLEADO</i></div>
            <div class="col-md" style="padding-left:40px;"><b>Precio: </b><b style="font-size: 10px;">{{$monto}}</b></div>
        </div>
        <div class="row">
            <div class="col-xl" style="font-size: 5px; text-decoration: underline;"><b>{{$tipo_servicio}}</b></div>
        </div>
        <div class="row">
            <div class="col-md">{{$concepto_servicio}}</div>
            <div class="col-md" style="padding-left:40px;">Actualización</div>
        </div>
        <div class="row">
            <div class="col-xl"><b>OBSERVACIONES</b></div>
            <div class="col-sm" style="padding-left:70; font-size: 5px">{{$notas}}</div>
        </div>
        <div class="row">
            <div class="col-md">
                <img src="{{asset('storage/img/logo compudepot black.png')}}" height="35px" width="75px" alt="logo"/>
            </div>
        </div>
        <div class="row absolute">
            <div class="col-md absolute" style="padding-left:70;">
                {!! DNS2D::getBarcodeHTML($barcode, 'QRCODE', 4, 4) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md" style="font-size: 5px; text-align: center;">* El tiempo es posible que varie según las condiciones del equipo, y en el caso que requiera alguna pieza o servicio adicional.</div>
        </div>
        <div class="row">
            <div class="col-md firma">
            </div>
        </div>
        <div class="row">
            <div class="col-md" style="font-size: 5px; text-align: center;">
                Firma del cliente
            </div>
        </div>
        <div class="row">
            <div class="col-lg" style="font-size: 5px; text-align: center; padding-left:20;">
                Al término de 30 días de concluir el servicio de su equipo, éste será puesto en venta para recuperar los gastos de su reparación. Después de 30 días no nos hacemos responsables de ningun equipo.
            </div>
        </div>
        <div class="row">
            <div class="col-xl" style="font-size: 5px; text-decoration: underline;">
                <b>HORARIO LUNES A VIERNES 10AM A 6:30PM Y SÁBADOS 10AM A 5:30PM</b>
            </div>
        </div>
        <div class="page-break"></div>
        <div class="row">
            <div class="col-lg"><b>Nombre: </b>{{$cliente}}</div>
            <div class="col-md" style="padding-left:20px;"><b  style="text-decoration: underline;"><i>CPD04 </i></b><b style="font-size: 10px;">LP011</b></div>
        </div>
        <div class="row">
            <div class="col-md"><b>Teléfono: </b>{{$telefono}}</div>
            <div class="col-md" style="padding-left:50px;">
                {!! DNS1D::getBarcodeHTML($barcode, "C128",1,15) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md"><b>Fecha: </b>{{$fecha}}</div>
            <div class="col-lg" style="padding-left:65px;">
                No. de Servicio: {{$barcode}}
            </div>
        </div>
        <div class="row">
            <div class="col-md"><b>Marca: </b>{{$marca}}</div>
            <div class="col-lg" style="padding-left:50px;">
                <b>Mod. Técnico: </b>{{$modelo}}
            </div>
        </div>
        <div class="row">
            <div class="col-sm">

            </div>
            <div class="col-md" style="padding-left:10px;">
                {!! DNS1D::getBarcodeHTML($barcode_2, "C39",1,18) !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md">
                <img src="{{asset('storage/img/logo compudepot black.png')}}" height="35px" width="75px" alt="logo"/>
            </div>
            <div class="col-md" style="padding-left:40px;"><b>Precio: </b><b style="font-size: 10px;">{{$monto}}</b></div>
        </div>
        <div class="row">
            <div class="col-lg" style="font-size: 5px; text-align: center; padding-left:20;">
                Al término de 30 días de concluir el servicio de su equipo, éste será puesto en venta para recuperar los gastos de su reparación. Después de 30 días no nos hacemos responsables de ningun equipo.
            </div>
        </div>
        <div class="row">
            <div class="col-xl" style="font-size: 5px; text-decoration: underline;">
                <b>HORARIO LUNES A VIERNES 10AM A 6:30PM Y SÁBADOS 10AM A 5:30PM</b>
            </div>
        </div>
    </body>
</html>

