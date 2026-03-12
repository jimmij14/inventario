<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: Arial, sans-serif;
}

.etiqueta{
    width:31%;
    height:150px;
    border:1px solid #000;
    padding:8px;
    margin:1%;
    display:inline-block;
    text-align:center;
    vertical-align:top;
}


.logo{
    width:80px;
}

.titulo{
    font-size:10px;
    font-weight:bold;
}

.codigo{
    font-size:12px;
    font-weight:bold;
    margin-top:4px;
}

.barcode{
    margin-top:6px;
    display:flex;
    justify-content:center;
}


</style>

</head>

<body>

@foreach($inventarios as $inv)

<div class="etiqueta">

    <img src="{{ public_path('Admin/images/logo-udea.png') }}" class="logo">

    <div class="titulo">
        INVENTARIO
    </div>

    <div style="font-size:15px;">
        <b>{{ $inv->equipo->nombre_equipo ?? '' }}</b>
    </div>

    <div class="barcode">
        <div style="margin:0 auto; display:table;">
            {!! DNS1D::getBarcodeHTML($inv->codigo_inventario, 'C128') !!}
        </div>
    </div>


    <div class="codigo">
        {{ $inv->codigo_inventario }}
    </div>

</div>

@endforeach

</body>
</html>
