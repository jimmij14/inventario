<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Categorías</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
        }

        /* Encabezado fijo en cada página */
        header {
            position: fixed;
            top: -50px;
            left: 0;
            right: 0;
            height: 70px;
        }

        header .logo {
            position: absolute;
            left: 0;
            top: 10;
        }

        header .logo img {
            height: 60px;
        }

        header .titulo {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding-top: 15px;
        }

        /* Pie de página fijo en cada página */
        footer {
            position: fixed;
            bottom: -30px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 10px;
            color: #555;
        }

        /* Espacio para que el contenido no quede debajo del header */
        .contenido {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="{{ public_path('Admin/images/logo-udea.png') }}" alt="Logo">
        </div>
        <div class="titulo">
            UNIVERSIDAD PARA EL DESARROLLO ANDINO
        </div>
    </header>

    <footer>
        Página <span class="pagenum"></span>
    </footer>

    <div class="contenido">
        <h2 style="text-align:center;">Listado de Categorías</h2>

        <table>
            <thead>
                <tr>
                    <th>Itms</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categorias as $key=> $categoria)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $categoria->nombre_categoria }}</td>
                        <td>{{ $categoria->descripcion }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("DejaVu Sans", "normal");
            $width = $fontMetrics->get_text_width($text, $font, $size);
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 20;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>

</body>
</html>