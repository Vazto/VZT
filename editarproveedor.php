<?php
include ("bd.php");

$id_proveedor = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Contacto = $_POST['contacto'];
    $Razon_Social = $_POST['razon_social'];
    $RUT = $_POST['rut'];

    $consulta = mysqli_query($bd, "UPDATE proveedor SET Contacto = '$Contacto', Razón_Social = '$Razon_Social', RUT = '$RUT' WHERE ID_PROVEEDOR = $id_proveedor");

    if ($consulta) {
        header("Location: proveedores.php");
        exit;
    }
} else {
    $sql = mysqli_query($bd,"SELECT * FROM proveedor WHERE Activo = 1 AND ID_PROVEEDOR = $id_proveedor");
    
    if ($sql->num_rows > 0) {
        $proveedor = $sql->fetch_assoc();
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
    <h2>Editar Proveedor</h2>

    <form method="POST">
        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto" value="<?php echo $proveedor['Contacto']; ?>" required><br>

        <label for="razon_social">Razón Social:</label>
        <input type="text" id="razon_social" name="razon_social" value="<?php echo $proveedor['Razón_Social']; ?>" required><br>

        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" value="<?php echo $proveedor['RUT']; ?>" required><br>

        <input type="submit" value="Actualizar Proveedor">
    </form>

    <a href="proveedores.php">Volver a la lista de proveedores</a>
</body>
</html>