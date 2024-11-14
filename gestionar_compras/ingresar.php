<?php
include_once("../bd.php");
include_once("../chequeo.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los parámetros esenciales están en el POST
    if (isset($_POST["monto_pagado"]) && isset($_POST["proveedor_id"]) && isset($_POST["productos_ids"]) && isset($_POST["cantidades"])) {
        $monto_pagado = $_POST["monto_pagado"];
        $proveedor_id = $_POST["proveedor_id"];
        $productos_ids = explode(',', $_POST["productos_ids"]);
        $cantidades = explode(',', $_POST["cantidades"]);
        $total = $_POST["total"];
        $subtotal = $_POST["subtotal"];
        $fecha_compra = date("Y-m-d");

        // Verificar si la fecha de crédito está definida
        if (isset($_POST["fechacredito"]) && $_POST["fechacredito"] != "") {
            $fecha_credito = $_POST["fechacredito"];
            $consulta = mysqli_query($bd, "INSERT INTO compra (precio, fecha, id_proveedor, vencimiento, subtotal) VALUES ('$total', '$fecha_compra', '$proveedor_id', '$fecha_credito', '$subtotal')");
        } else {
            // Si no hay fecha de crédito, solo insertar el subtotal
            $consulta = mysqli_query($bd, "INSERT INTO compra (precio, fecha, id_proveedor, subtotal) VALUES ('$total', '$fecha_compra', '$proveedor_id', '$subtotal')");
        }

        // Comprobar si la inserción fue exitosa
        if ($consulta) {
            $id_compra = mysqli_insert_id($bd); // Obtener el ID de la compra recién insertada

            // Insertar los productos comprados
            foreach ($productos_ids as $i => $producto_id) {
                $cantidad = $cantidades[$i];

                // Obtener los detalles del producto
                $producto_query = mysqli_query($bd, "SELECT p.precio_compra, p.cantidad, i.valor as iva_valor 
                                                     FROM producto p 
                                                     JOIN iva i ON p.id_iva = i.id_iva 
                                                     WHERE p.id_producto = '$producto_id'");
                $producto = mysqli_fetch_assoc($producto_query);

                if ($producto) {
                    $precio_compra = $producto['precio_compra'];
                    $iva_valor = $producto['iva_valor'];
                    
                    // Calcular IVA
                    $iva_producto = ($precio_compra * $cantidad) * ($iva_valor / 100);

                    // Insertar producto comprado
                    $insert_producto = mysqli_query($bd, "INSERT INTO productos_comprados 
                                                         (id_compra, id_producto, cantidad, precio_compra, iva_de_compra) 
                                                         VALUES 
                                                         ('$id_compra', '$producto_id', '$cantidad', '$precio_compra', '$iva_producto')");

                    // Actualizar la cantidad en el inventario
                    $nueva_cantidad = $producto['cantidad'] + $cantidad;
                    $update_producto = mysqli_query($bd, "UPDATE producto SET cantidad = '$nueva_cantidad' WHERE id_producto = '$producto_id'");
                } else {
                    // Si no se encuentra el producto, puedes manejarlo aquí, por ejemplo:
                    echo "Producto no encontrado: $producto_id";
                    exit(); // Detener el proceso si un producto no es válido
                }
            }

            // Registrar el pago
            $consulta_pago = mysqli_query($bd, "INSERT INTO pago (monto, fecha, id_proveedor, id_compra) VALUES ('$monto_pagado', '$fecha_compra', '$proveedor_id', '$id_compra')");

            // Verificar si hay deuda y actualizar la deuda del proveedor
            $deuda = $total - $monto_pagado;
            if ($deuda > 0) {
                $consulta_deuda = mysqli_query($bd, "UPDATE proveedor SET deuda = deuda + '$deuda' WHERE id_proveedor = '$proveedor_id'");
            }

            // Redirigir a la página de pagos
            header("Location: ../pagos.php");
            exit();
        } else {
            // Si no se pudo insertar la compra, muestra un mensaje de error
            echo "Error al registrar la compra.";
            exit();
        }
    }
}

// Redirigir si no se ha enviado el formulario correctamente
header("Location: ../compras.php");
exit();
?>
