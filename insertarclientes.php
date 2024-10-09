<?php
include("bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Cedula = $_POST['cedula'];
    $Nombre = $_POST['nombre'];
    $Deuda = $_POST['deuda'];
    $Fecha_de_Nacimiento = $_POST['fecha_nacimiento'];
    $Tickets_de_Sorteo = $_POST['tickets'];
    $Contacto = $_POST['contacto'];
    $RUT = $_POST['rut'];

    $consulta = mysqli_query($bd, "INSERT INTO cliente (Cédula, Nombre, Deuda, Fecha_de_Nacimiento, Tickets_de_Sorteo, Contacto, Rut, Activo) VALUES ('$Cedula', '$Nombre', '$Deuda', '$Fecha_de_Nacimiento', '$Tickets_de_Sorteo', '$Contacto', '$RUT', 1)");
        if ($consulta) {
            header("Location: clientes.php");
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
    <form action="insertarclientes.php" method="POST">
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br>

        <label for="deuda">Deuda:</label>
        <input type="number" id="deuda" name="deuda" step="0.01" required><br>

        <label for="fecha_nacimiento">Fecha de Nacimiento:</label>
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"><br>

        <label for="tickets">Tickets de Sorteo:</label>
        <input type="number" id="tickets" name="tickets" required><br>

        <label for="contacto">Contacto:</label>
        <input type="text" id="contacto" name="contacto"><br>

        <label for="rut">RUT:</label>
        <input type="text" id="rut" name="rut"><br>

        <input type="submit" value="Insertar Cliente">
    </form>
</div>
</div>
</body>
</html>
