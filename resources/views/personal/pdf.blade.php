<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Personal</title>
    <style>
        @page {
            margin: 100px 30px 60px 30px;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #2b2b2b;
            margin: 0;
        }

        /* Encabezado fijo en cada página */
        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 70px;
            border-bottom: 2px solid #1a3c6e;
        }

        header .logo {
            position: absolute;
            left: 0;
            top: 5px;
        }

        header .logo img {
            height: 55px;
        }

        header .titulo {
            position: absolute;
            left: 75px;
            right: 0;
            top: 8px;
        }

        header .titulo .institucion {
            font-size: 13px;
            font-weight: bold;
            color: #1a3c6e;
            text-transform: uppercase;
        }

        header .titulo .reporte {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        /* Pie de página fijo en cada página */
        footer {
            position: fixed;
            bottom: -35px;
            left: 0;
            right: 0;
            height: 30px;
            border-top: 1px solid #ccc;
            padding-top: 5px;
            font-size: 9px;
            color: #666;
        }

        /* Espacio para que el contenido no quede debajo del header */
        .contenido {
            margin-top: 0;
        }

        .contenido h2 {
            text-align: center;
            font-size: 15px;
            color: #1a3c6e;
            margin-bottom: 2px;
        }

        .subtitulo {
            text-align: center;
            font-size: 10px;
            color: #777;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead th {
            background-color: #1a3c6e;
            color: #fff;
            text-transform: uppercase;
            font-size: 9px;
            padding: 6px;
            text-align: left;
        }

        tbody td {
            padding: 6px;
            border-bottom: 1px solid #ddd;
            word-wrap: break-word;
        }

        tbody tr:nth-child(even) {
            background-color: #f4f6f9;
        }

        .col-item {
            width: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

    <header>
        <div class="logo">
            <img src="{{ public_path('Admin/images/logo-udea.png') }}" alt="Logo">
        </div>
        <div class="titulo">
            <div class="institucion">Universidad para el Desarrollo Andino</div>
            <div class="reporte">Sistema de Inventario &mdash; Reporte de Personal</div>
        </div>
    </header>

    <footer>
        <div class="fecha">Generado el {{ now()->format('d/m/Y H:i') }}</div>
    </footer>

    <div class="contenido">
        <h2>Listado de Personal</h2>
        <div class="subtitulo">Total de registros: {{ $personales->count() }}</div>

        <table>
            <thead>
                <tr>
                    <th class="col-item">N°</th>
                    <th>DNI</th>
                    <th>Nombre completo</th>
                    <th>Categoría</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Descripción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($personales as $key => $personal)
                    <tr>
                        <td class="col-item">{{ $key + 1 }}</td>
                        <td>{{ $personal->dni }}</td>
                        <td>{{ $personal->nombre_completo }}</td>
                        <td>{{ $personal->categoriaPersonal->nombre_categoria_personal ?? '—' }}</td>
                        <td>{{ $personal->correo ?: '—' }}</td>
                        <td>{{ $personal->telefono ?: '—' }}</td>
                        <td>{{ $personal->descripcion ?: '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding: 15px;">No hay personal registrado</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>
</html>
