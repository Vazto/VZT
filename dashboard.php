<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard de Productos y Ventas</title>
</head>
<body>
<?php include("barra.php"); ?>
<div class="principal">
    <div class="barra">
        <div class="alternar">
            <img src="Imágenes/Iconos/Alternar.svg" alt="Alternar menú">
        </div>
        <div class="buscar">
            <label>
                <input type="text" placeholder="Buscar aquí" id="buscar">
                <img src="Imágenes/Iconos/Buscar.svg" alt="Buscar">
            </label>
        </div>
    </div>
    <div class="usuario">
        <img src="" alt="Usuario">
    </div>

    <div class="estadisticas">
        <div id="total-ventas" class="estadistica-item">
            <h3>Total de Ventas</h3>
            <p>Cargando...</p>
        </div>
    </div>

    <div class="graficos">
        <div id="grafico-ventas" class="grafico-item">
            <h3>Ventas por Fecha</h3>
            <canvas id="ventas-chart"></canvas>
            <div class="fechas">
                <input type="date" id="fecha-inicial" name="fecha-inicial">
                <input type="date" id="fecha-final" name="fecha-final">
            </div>
        </div>
        <div id="grafico-productos" class="grafico-item">
            <h3>Productos Más Vendidos</h3>
            <canvas id="productos-chart"></canvas>
        </div>
    </div>

    <div class="detalles">
        <h3>Ventas Recientes</h3>
        <table id="tabla-ventas">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Productos</th>
                    <th>Precio</th>
                    <th>Deuda</th>
                    <th>Cliente</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div class="detalles">
        <h3>Productos</h3>
        <table id="tabla-productos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Precio Neto</th>
                    <th>Código de Barras</th>
                    <th>Descripción</th>
                    <th>Marca</th>
                    <th>Cantidad</th>
                    <th>Imagen</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="Librerias/jQuery/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="js/dashboard.js"></script>
</div>
</body>
</html>