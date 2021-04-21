
<html>
    <head>
        <style>
            html {
                margin: 0;
                font-size: 10px;
                font-family: Arial, Helvetica, sans-serif;
            }
            body {
                margin: 0mm -5mm 0mm auto;
            }
            .row:after{
                content: "";
                display: table;
                clear: both;
            }
            .col-sm{
                float: right;
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
                top: 0px;
                position: absolute;
                z-index: -1;
            }
            .page-break {
                page-break-after: always;
            }
        </style>
    </head>
    <body>
        @for ($i = 0; $i < $total; $i++)
            <div class="row">
                <div class="col-lg" style=" text-align: right; font-size: 16px">
                    <b style="padding-right:20px;">${{$precio_max}}</b>
                </div>
                <div class="col-sm">
                    <!--<img src='data:image/png;base64,{{$logo}}'' class="absolute" height="45px" width="35px" alt="logo" id="logo"/>-->
                    <img src="{{ public_path('storage/sucursales/'.$imagen)}}" class="absolute" height="35px" width="25px" alt="logo"/>
                </div>
            </div>
            <div class="row" style="padding-left:-60px; text-align: center;">
                <div class="col-xl">
                    <b>{{$categoria}}<br> {{$marca}} {{(strlen($modelo) > 15) ? substr($modelo, 0, -6) : $modelo}} {{(strlen($color) > 10) ? substr($color,0,-5) : $color}}<br> {{$compatibilidad}}<br></b>
                </div>

            </div>
            <div class="row" style="padding-left:80px;">
                @if (strlen($codigo) == 12)
                    {!! DNS1D::getBarcodeHTML($codigo, "UPCA", 2, 25) !!}
                @elseif(strlen($codigo) == 13)
                    {!! DNS1D::getBarcodeHTML($codigo, "EAN13", 2, 25) !!}
                @endif
            </div>
            <div class="row" style="padding-left:-60px;">
                <div class="col-xl" style="text-align: center; font-size: 14px">
                    {{$codigo}}
                </div>
            </div>
            @if ($total > 1 && $i+1 < $total)
            <div class="page-break"></div>
            @endif


        @endfor

        <!--<div class="page-break"></div>-->
    </body>
</html>
