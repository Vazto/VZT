<?php
include ("bd.php");

$id_producto = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Nombre = $_POST['nombre'];
    $Precio_Neto = $_POST['precio_neto'];
    $Codigo_de_Barras = $_POST['codigo_barras'];
    $Descripcion = $_POST['descripcion'];
    $Marca = $_POST['marca'];
    $Cantidad = $_POST['cantidad'];
    $Imagen = $_POST['imagen'];

    $consulta = mysqli_query($bd, "UPDATE producto SET Nombre = '$Nombre', Precio_Neto = '$Precio_Neto', Código_de_Barras = '$Codigo_de_Barras', Descripción = '$Descripcion', Marca = '$Marca', Cantidad = '$Cantidad', Imagen = '$Imagen' WHERE ID_PRODUCTO = $id_producto");

    if ($consulta) {
        header("Location: productos.php");
        exit;
    }
} else {
    $sql = mysqli_query($bd,"SELECT * FROM producto WHERE Activo = 1 AND ID_PRODUCTO = $id_producto");

    if ($sql->num_rows > 0) {
        $producto = $sql->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <h2>Editar Producto</h2>

    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?php echo $producto['Nombre']; ?>" required><br>

        <label for="precio_neto">Precio Neto:</label>
        <input type="number" id="precio_neto" name="precio_neto" value="<?php echo $producto['Precio_Neto']; ?>" step="0.01" required><br>

        <label for="codigo_barras">Código de Barras:</label>
        <input type="text" id="codigo_barras" name="codigo_barras" value="<?php echo $producto['Código_de_Barras']; ?>" required><br>

        <label for="descripcion">Descripción:</label>
        <textarea id="descripcion" name="descripcion" required><?php echo $producto['Descripción']; ?></textarea><br>

        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" value="<?php echo $producto['Marca']; ?>" required><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" value="<?php echo $producto['Cantidad']; ?>" required><br>

        <label for="imagen">URL de la Imagen:</label>
        <input type="text" id="imagen" name="imagen" value="<?php echo $producto['Imagen']; ?>" required><br>

        <input type="submit" value="Actualizar Producto">
    </form>

    <a href="productos.php">Volver a la lista de productos</a>
</body>
</html>
