
<html>
    <head>
        <style>
            html {
                margin: 0;
                font-size: 14px;
                font-family: Arial, Helvetica, sans-serif;
            }
            body {
                margin: -2mm -5mm 0mm 2mm;
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
            img {
            -webkit-filter: invert(1);
            filter: invert(1);
            }

            .firma{
                height: 20px;
                width: 80px;
                border-color: black;
                border-style: solid;
                border-width: 1px;
            }
            .absolute{
                top: 10px;
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
            <div class="col-lg" style="padding-left:-60px; text-align: center;font-size: 50px">
                <b style="font-size: 9px;">Desde:</b><b> ${{$precio}}</b>
            </div>
            <div class="col-sm absolute">
                <img src="{{asset('storage/sucursales/InCase.png')}}" height="35px" width="25px" alt="logo"/>
                <!--<img src="{{ public_path('storage/sucursales/CompuDepot.png')}}" height="35px" width="25px" alt="logo"/>-->
            </div>
        </div>
        <div class="row">
            <div class="col-xl" style="padding-left:-60px; text-align: center;">
                <b>{{$categoria}}<br> {{$marca}} {{$modelo}} {{$color}}<br> {{$compatibilidad}}<br></b>
            </div>
        </div>
        <!--<div class="page-break"></div>-->
    </body>
</html>
