<?php
include ("bd.php");

$id_cliente = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Cedula = $_POST['cedula'];
    $Nombre = $_POST['nombre'];
    $Deuda = $_POST['deuda'];
    $Fecha_de_Nacimiento = $_POST['fecha_nacimiento'];
    $Tickets_de_Sorteo = $_POST['tickets'];
    $Contacto = $_POST['contacto'];
    $RUT = $_POST['rut'];

    $consulta = mysqli_query($bd, "UPDATE cliente SET Cédula = '$Cedula', Nombre = '$Nombre', Deuda = '$Deuda', Fecha_de_Nacimiento = '$Fecha_de_Nacimiento', Tickets_de_Sorteo = '$Tickets_de_Sorteo', Contacto = '$Contacto', RUT = '$RUT' WHERE ID_CLIENTE = $id_cliente");

    if ($consulta) {
        header("Location: clientes.php");
        exit;
    }
} else {
    $sql = mysqli_query($bd,"SELECT * FROM cliente WHERE Activo = 1 AND ID_CLIENTE = $id_cliente");
    
    if ($sql->num_rows > 0) {
        $cliente = $sql->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Editar Cliente</h2>

    <form method="POST">
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

    <a href="clientes.php">Volver a la lista de clientes</a>
</body>
</html>