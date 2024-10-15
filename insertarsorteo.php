<?php
include("bd.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Premio = $_POST['premio'];
    $Cantidad_Ganadores = $_POST['cantidad_ganadores'];

    $consulta = mysqli_query($bd, "INSERT INTO  sorteo (Premio, Cantidad_Ganadores) VALUES ('$Premio','$Cantidad_Ganadores')");
        if ($consulta) {
            header("Location: sorteos.php");
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
<form action="insertarsorteo.php" method="POST">
        <label for="premio">Premio:</label>
        <input type="text" id="premio" name="premio" required><br>

        <label for="cantidad_ganadores">Cantidad de Ganadores:</label>
        <input type="text" id="cantidad_ganadores" name="cantidad_ganadores" required><br>

        <input type="submit" value="Insertar Sorteo">

    </form>

</div>
</div>
</body>
</html>
