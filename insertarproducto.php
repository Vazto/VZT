<?php
include("bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre = $_POST['nombre'];
    $Precio_Neto = $_POST['precio_neto'];
    $Codigo_de_Barras = $_POST['codigo_barras'];
    $Descripcion = $_POST['descripcion'];
    $Marca = $_POST['marca'];
    $Cantidad = $_POST['cantidad'];
    $Imagen = $_POST['imagen'];

    $consulta = mysqli_query($bd, "INSERT INTO producto (Nombre, Precio_Neto, Código_de_Barras, Descripción, Marca, Cantidad, Imagen, Activo) VALUES ('$Nombre', '$Precio_Neto', '$Codigo_de_Barras', '$Descripcion', '$Marca', '$Cantidad', '$Imagen', 1)");
        if ($consulta) {
            header("Location: productos.php");
            exit;
        }
    }
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
<div class="detalles">
<form action="insertarproducto.php" method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" required>

        <label for="precio_neto">Precio Neto:</label>
        <input type="number" name="precio_neto" id="precio_neto" step="0.01" required>

        <label for="codigo_barras">Código de Barras:</label>
        <input type="text" name="codigo_barras" id="codigo_barras" required>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion" required></textarea>

        <label for="marca">Marca:</label>
        <input type="text" name="marca" id="marca" required>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" id="cantidad" required>

        <label for="imagen">Imagen:</label>
        <input type="text" name="imagen" id="imagen" required>

        <button type="submit">Insertar Producto</button>
    </form>
</div>
</div>
</body>
</html>
