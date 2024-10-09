<?php
include("bd.php");
if (!file_exists("fotoperfil")) {
    mkdir("fotoperfil");
}

$clavemaestra = "ojevazt2024"; // Clave maestra del software

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombre"]) && isset($_POST["usuario"]) && isset($_POST["pass"]) && isset($_POST["pass2"]) && isset($_POST["correo"]) && isset($_POST["fecha"]) && isset($_FILES["fotoperfil"]) && isset($_POST["clavamaestra"])) {
        if ($_POST["nombre"] != "" && $_POST["usuario"] != "" && $_POST["pass"] != "" && $_POST["pass2"] != "" && $_POST["correo"] != "" && $_POST["fecha"] != "" && $_FILES["fotoperfil"]["tmp_name"] != "" && $_POST["clavamaestra"] != "") {
            if ($_POST["pass"] == $_POST["pass2"]) { // Chequea que las contraseñas sean iguales
                if (strlen($_POST["pass"]) >= 6) { // Longitud mínima de la contraseña
                    if ($_POST["fecha"] < "2020-01-01") {
                        if ($_POST["clavamaestra"] == $clavemaestra) { // Verifica la clave maestra
                            $chek = mysqli_query($bd, 'SELECT * FROM usuario WHERE usuario="' . $_POST["usuario"] . '"');

                            if (mysqli_num_rows($chek) == 0) { // Verifica que el usuario no exista
                                $fileName = $_FILES['fotoperfil']['name'];
                                $targetFilePath = 'fotoperfil/' . $fileName;

                                if (!file_exists($targetFilePath)) {
                                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], $targetFilePath);
                                } else {
                                    $fileName = $_POST["usuario"] . '_' . $fileName; // Renombrar si el archivo ya existe
                                    move_uploaded_file($_FILES['fotoperfil']['tmp_name'], 'fotoperfil/' . $fileName);
                                }

                                mysqli_query($bd, 'INSERT INTO Usuario (Usuario, Contraseña, Nombre, Correo, Foto_Perfil, Fecha_Nacimiento) VALUES ("' . $_POST["usuario"] . '","' . $_POST["pass"] . '","' . $_POST["nombre"] . '","' . $_POST["correo"]  . '","' . $fileName . '","' . $_POST["fecha"] . '");');
                                header("Location:index.php?causa=reg");
                            } else {
                                header('Location:registro.php?causa=yaregistrado&nombre=' . $_POST["nombre"] . '&correo=' . $_POST["correo"] . '&fecha=' . $_POST["fecha"]);
                            }
                        } else {
                            header('Location:registro.php?causa=clavemaestram&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' . $_POST["fecha"]);
                        }
                    } else {
                        header('Location:registro.php?causa=menor&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"]);
                    }
                } else {
                    header('Location:registro.php?causa=contraseñacorta&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' . $_POST["fecha"]);
                }
            } else {
                header('Location:registro.php?causa=contraseñasdistintas&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' . $_POST["fecha"]);
            }
        } else {
            header('Location:registro.php?causa=campovacio&nombre=' . $_POST["nombre"] . '&usuario=' . $_POST["usuario"] . '&correo=' . $_POST["correo"] . '&fecha=' . $_POST["fecha"]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarme</title>
    <link rel="stylesheet" href="/Ojevazt/css/registro.css">
</head>
<body>
    <div class="envoltorio">
        <form method="POST" enctype="multipart/form-data">
            <h1>Registrar usuario</h1>
            <div class="entrada">
                <input type="text" name="nombre" placeholder="Ingrese su nombre" <?php if (isset($_GET["nombre"])) { echo "value='" . $_GET["nombre"] . "'"; } ?>>
            </div>
            <div class="entrada">
                <input type="text" name="usuario" placeholder="Ingrese su usuario" <?php if (isset($_GET["usuario"])) { echo "value='" . $_GET["usuario"] . "'"; } ?>>
            </div>
            <div class="entrada">
                <input type="password" name="pass" placeholder="Ingrese contraseña">
            </div>
            <div class="entrada">
                <input type="password" name="pass2" placeholder="Repita contraseña">
            </div>
            <div class="entrada">
                <input type="email" name="correo" placeholder="Ingrese su correo" <?php if (isset($_GET["correo"])) { echo "value='" . $_GET["correo"] . "'"; } ?>>
            </div>
            <div class="entrada">
                <input type="date" max="2019-12-31" name="fecha" <?php if (isset($_GET["fecha"])) { echo "value='" . $_GET["fecha"] . "'"; } ?>>
            </div>
            <div class="entrada">
                <input type="file" name="fotoperfil" accept="image/*">
            </div>
            <div class="entrada">
                <input type="password" name="clavamaestra" placeholder="Clave maestra">
            </div>
            
            <?php
            if (isset($_GET["causa"])) {
                switch ($_GET['causa']) {
                    case "yaregistrado":
                        echo "<p>Ese nombre de usuario ya está registrado</p>";
                        break;
                    case "contraseñasdistintas":
                        echo '<p>Las contraseñas no coinciden</p>';
                        break;
                    case "campovacio":
                        echo '<p>Debes rellenar todos los campos</p>';
                        break;
                    case "contraseñacorta":
                        echo '<p>La contraseña debe tener al menos 6 caracteres</p>';
                        break;
                    case "clavemaestram":
                        echo '<p>La clave maestra está mal</p>';
                        break;
                    case "menor":
                        echo '<p>Debes haber nacido antes del 2020 para registrarte</p>';
                        break;
                }
            }
            ?>
            <button type="submit" class="boton">Registrarme</button>
            <hr id="linea">
            <h4>¿Ya tienes cuenta?</h4>
            <a href="index.php" class="linkk">Iniciar Sesión</a>
        </form>
    </div>
    <?php include("footer.html"); ?>
</body>
<script src="/Ojevazt/Proyecto/js/script.js" type="module"></script>
</html>
