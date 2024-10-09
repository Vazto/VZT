<?php 
session_start();
if (isset($_SESSION["usuario"]) && isset($_SESSION["contraseña"])) {
    header("Location: menu.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("bd.php"); // Asegúrate de incluir tu archivo de conexión a la base de datos

    $usuario = $_POST["usuario"];
    $contraseña = $_POST["contraseña"];

    if (!empty($usuario) && !empty($contraseña)) {
        // Consulta para verificar el usuario y la contraseña
        $query = "SELECT * FROM usuario WHERE Usuario = '$usuario' AND Contraseña = '$contraseña'";
        $result = mysqli_query($bd, $query);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION["usuario"] = $usuario;
            $_SESSION["contraseña"] = $contraseña;
            header("Location: menu.php");
            exit();
        } else {
            // Manejo de intentos fallidos
            if (!isset($_SESSION["intentos"])) {
                $_SESSION["intentos"] = 3; // Establece el límite de intentos
            }
            $_SESSION["intentos"]--;
            if ($_SESSION["intentos"] <= 0) {
                $_SESSION["bloq"] = true; // Bloqueo del usuario
                header("Location: acceso.php?causa=bloq");
            } else {
                header("Location: acceso.php?causa=err");
            }
            exit();
        }
    } else {
        header("Location: acceso.php?causa=textovacio");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/OjeVazt/css/acceso.css">
    <title>Acceso</title>
</head>
<body>
    <div class="envoltorio">
        <form method="POST" action="">
            <h1>Acceso</h1>
            <div class="entrada">
                <input type="text" name="usuario" placeholder="Usuario" <?php if (isset($_SESSION['bloq'])) { echo "disabled"; } ?>>
            </div>
            <div class="entrada">
                <input type="password" name="contraseña" placeholder="Contraseña">
            </div>

            <div class="recordar">
                <label><input type="checkbox" name="recordar"> Recordarme</label>
                <a href="#">¿Olvidaste tu contraseña?</a>
            </div>

            <?php
            if (isset($_GET['causa'])) {
                switch ($_GET['causa']) {
                    case "err":
                        echo "<p>Contraseña o usuario incorrectos<br> " . ($_SESSION["intentos"] + 1) . " intentos restantes</p>";
                        break;
                    case "bloq":
                        echo '<p>Usuario bloqueado</p>';
                        break;
                    case "textovacio":
                        echo '<p>Debes completar todos los campos</p>';
                        break;
                }
            }
            ?>

            <button type="submit" class="boton">Acceder</button>

            <div class="enlace">
                <p>¿No tienes una cuenta? <a href="registro.php">Registrarse</a></p>
            </div>
        </form>
    </div>
    <?php include("footer.html"); ?>
</body>
</html>
