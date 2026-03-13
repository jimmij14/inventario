<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <style>
        body {
            font-family: Arial, sans-serif;
        }

        /* ETIQUETA */
        .etiqueta {
            width: 30%;
            height: 90px;
            border: 1px solid #000;
            padding: 5px;
            margin: 1%;
            display: inline-block;
            vertical-align: top;
        }

        /* TABLA INTERNA */
        .tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla td {
            vertical-align: middle;
        }

        /* LOGO */
        .logo {
            width: 70px;
            height: auto;
        }

        /* NOMBRE EQUIPO */
        .nombre {
            font-size: 12px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 3px;
        }

        /* CODIGO DE BARRAS */
        .barcode{
            text-align:center;
        }

        .barcode div{
            margin: 0 auto;
        }


        /* CODIGO TEXTO */
        .codigo {
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }

        /* FECHA */
        .fecha {
            font-size: 9px;
            text-align: center;
        }
    </style>
</head>

<body>
    @foreach($inventarios as $inv)
        <div class="etiqueta">
            <table class="tabla">
                <tr>
                    <td style="width:30%; text-align:center;">
                        <img src="{{ public_path('Admin/images/logo-udea.png') }}" class="logo">
                    </td>
                    <td>
                        <div class="nombre">
                            {{ $inv->equipo->nombre_equipo ?? '' }}
                        </div>
                        <div class="barcode">
                            {!! DNS1D::getBarcodeHTML($inv->codigo_inventario, 'C128',1,40) !!}
                        </div>
                        <div class="codigo">
                            {{ $inv->codigo_inventario }}
                        </div>
                        <div class="fecha">
                            {{ \Carbon\Carbon::now()->locale('es')->translatedFormat('F Y') }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
</body>

</html>
