<?php
function getVentasRecientes($conexion) {
    $consulta = "SELECT v.ID_VENTA, GROUP_CONCAT(p.Nombre SEPARATOR ', ') AS Productos, SUM(v.Precio_Final) AS Precio, SUM(c.Deuda) AS Deuda, c.Nombre AS Cliente FROM Venta v JOIN Productos_Vendidos pv ON v.ID_VENTA = pv.ID_VENTA JOIN Producto p ON pv.ID_PRODUCTO = p.ID_PRODUCTO JOIN Cliente c ON v.ID_CLIENTE = c.ID_CLIENTE GROUP BY v.ID_VENTA LIMIT 10";
    return mysqli_query($conexion, $consulta);
}

function getCantidadVentas($conexion) {
    $consulta = "SELECT COUNT(*) AS Ventas FROM Venta";
    $resultado = mysqli_query($conexion, $consulta);
    $fila = mysqli_fetch_assoc($resultado);
    return $fila['Ventas'];
}

function obtenerDatosVentas($conexion, $fecha_inicial, $fecha_final) {
    $fecha_inicial = mysqli_real_escape_string($conexion, $fecha_inicial);
    $fecha_final = mysqli_real_escape_string($conexion, $fecha_final);
    
    $consulta = "
        SELECT DATE(Fecha_Venta) as Fecha, COUNT(*) as Total 
        FROM Venta 
        WHERE Fecha_Venta BETWEEN '$fecha_inicial' AND '$fecha_final'
        GROUP BY DATE(Fecha_Venta)
        ORDER BY Fecha_Venta
    ";
    $resultado = mysqli_query($conexion, $consulta);

    $etiquetas = [];
    $datos = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $etiquetas[] = $fila['Fecha'];
        $datos[] = $fila['Total'];
    }

    return ['etiquetas' => $etiquetas, 'datos' => $datos];
}

function obtenerDatosProductosVendidos($conexion, $fecha_inicial, $fecha_final) {
    $fecha_inicial = mysqli_real_escape_string($conexion, $fecha_inicial);
    $fecha_final = mysqli_real_escape_string($conexion, $fecha_final);

    $consulta = "
        SELECT p.Nombre as Nombre, SUM(pv.Cantidad_de_Venta) as Total 
        FROM Productos_Vendidos pv
        JOIN Producto p ON pv.ID_PRODUCTO = p.ID_PRODUCTO
        JOIN Venta v ON pv.ID_VENTA = v.ID_VENTA
        WHERE v.Fecha_Venta BETWEEN '$fecha_inicial' AND '$fecha_final'
        GROUP BY p.ID_PRODUCTO
        ORDER BY Total DESC 
        LIMIT 5
    ";
    $resultado = mysqli_query($conexion, $consulta);

    $nombres = [];
    $totales = [];

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $nombres[] = $fila['Nombre'];
        $totales[] = $fila['Total'];
    }

    return ['nombres' => $nombres, 'totales' => $totales];
}
?>
