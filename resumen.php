<?php
include("bd.php");
include("funciones.php");

$ventas_recientes = getVentasRecientes($bd);
$total_ventas = getCantidadVentas($bd);

$fecha_inicial = isset($_GET['fechainicial']) ? $_GET['fechainicial'] : date('Y-m-d', strtotime('-30 days'));
$fecha_final = isset($_GET['fechafinal']) ? $_GET['fechafinal'] : date('Y-m-d');

$datos_ventas = obtenerDatosVentas($bd, $fecha_inicial, $fecha_final);
$datos_productos = obtenerDatosProductosVendidos($bd, $fecha_inicial, $fecha_final);

$etiquetas_ventas_json = json_encode($datos_ventas['etiquetas']);
$datos_ventas_json = json_encode($datos_ventas['datos']);
$nombres_productos_json = json_encode($datos_productos['nombres']);
$totales_productos_json = json_encode($datos_productos['totales']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title></title>
</head>
<body>
<?php include("barra.php"); ?>

<div class="principal">
    <div class="barra">
        <div class="alternar">
            <img src="Imágenes/Iconos/Alternar.svg">
        </div>
        <div class="fechas">
            <input type="text" id="fechainicial" name="fechainicial" placeholder="Fecha inicial" 
                   onfocus="(this.type='date')" 
                   onblur="if(!this.value)this.type='text'">
            <input type="text" id="fechafinal" name="fechafinal" placeholder="Fecha final" 
                   onfocus="(this.type='date')" 
                   onblur="if(!this.value)this.type='text'" 
                   max="<?php echo date('Y-m-d'); ?>">
        </div>
    </div>

    <div class="usuario">
        <img src="" alt="Usuario">
    </div>

    <div class="caja">
        <div class="tarjeta tarjeta-1">
            <div>
                <div class="numeros"><?php echo $total_ventas; ?></div>
                <div class="nombres">Ventas</div>
            </div>
            <div class="icono-tarjeta">
                <img src="Imágenes/Iconos/Ventas.svg">
            </div>
        </div>
        <!-- Puedes añadir más tarjetas aquí -->
    </div>

    <div class="con">
        <div class="sub">
            <h2>Productos más vendidos</h2>
            <canvas id="PieChart"></canvas>
        </div>
        <div class="sub">
            <canvas id="LineChart"></canvas>
        </div>
    </div>

    <div class="detalles">
        <div class="recientes">
            <div class="encabezado">
                <h2>Ventas recientes</h2>
                <a href="" class="ver">Ver todo</a>
            </div>
            <table>
                <thead>
                    <tr>
                        <td>Producto(s)</td>
                        <td>Precio</td>
                        <td>Deuda</td>
                        <td>Cliente</td>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = mysqli_fetch_assoc($ventas_recientes)) { ?>
                    <tr>
                        <td><?php echo $fila['Productos']; ?></td>
                        <td><?php echo $fila['Precio']; ?></td>
                        <td><?php echo $fila['Deuda']; ?></td>
                        <td><?php echo $fila['Cliente']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="existencias">
            <div class="encabezado">
                <h2>Productos con pocas existencias</h2>
        </div>
    </div>
</div>

<script>
    var etiquetasVentasIniciales = <?php echo $etiquetas_ventas_json; ?>;
    var datosVentasIniciales = <?php echo $datos_ventas_json; ?>;
    var nombresProductosIniciales = <?php echo $nombres_productos_json; ?>;
    var totalesProductosIniciales = <?php echo $totales_productos_json; ?>;
</script>

<script src="js/script.js"></script>
<script src="Librerias/Chart.js/chart.umd.js"></script>
<script src="Librerias/jQuery/jquery-3.7.1.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctxPie = document.getElementById('PieChart').getContext('2d');
        var PieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: nombresProductosIniciales,
                datasets: [{
                    label: 'Productos Vendidos',
                    data: totalesProductosIniciales,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true
            }
        });

        var ctxLine = document.getElementById('LineChart').getContext('2d');
        var LineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: etiquetasVentasIniciales,
                datasets: [{
                    label: 'Número de ventas',
                    data: datosVentasIniciales,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                responsive: true
            }
        });
    });

    $(document).ready(function() {
    function actualizarGraficas() {
        var fechainicial = $('#fechainicial').val();
        var fechafinal = $('#fechafinal').val();

        $.ajax({
            url: 'apiresumen.php',
            type: 'GET',
            data: {
                fechainicial: fechainicial,
                fechafinal: fechafinal
            },
            success: function(response) {
                var data = JSON.parse(response);
                
                LineChart.data.labels = data.etiquetasVentas;
                LineChart.data.datasets[0].data = data.datosVentas;
                LineChart.update();
                
                PieChart.data.labels = data.nombresProductos;
                PieChart.data.datasets[0].data = data.totalesProductos;
                PieChart.update();
            }
        });
    }

    $('#fechainicial, #fechafinal').change(function() {
        if ($('#fechainicial').val() && $('#fechafinal').val()) {
            actualizarGraficas();
        }
    });

    setInterval(function() {
        if ($('#fechainicial').val() && $('#fechafinal').val()) {
            actualizarGraficas();
        }
    }, 5000);
});
</script>
<script src="/Ojevazt/Proyecto/script.js"></script>
</body>
</html>
