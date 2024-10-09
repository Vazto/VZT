<?php
include("bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Contacto = $_POST['contacto'];
    $Razon_Social = $_POST['razon_social'];
    $RUT = $_POST['rut'];

    $consulta = mysqli_query($bd, "INSERT INTO proveedor (Contacto, Razón_social, Rut, Activo) VALUES ('$Contacto', '$Razon_social', '$RUT', 1)");
        if ($consulta) {
            header("Location: proveedores.php");
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
<form action="insertarproveedor.php" method="POST">
        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto" required><br>

        <label for="razon_social">Razón Social:</label>
        <input type="text" id="razon_social" name="razon_social" required><br>

        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut" required><br>

        <input type="submit" value="Insertar Proveedor">

    </form>

</div>
</div>
</body>
</html>
