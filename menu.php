<?php
include("bd.php");
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["usuario"] != "" && $_POST["contraseña"] != "") { // si contienen texto
        $usuario = $_POST["usuario"];
        $contraseña = $_POST["contraseña"];
        $consultausuarios = mysqli_query($bd, 'SELECT * FROM Usuario WHERE usuario = "' . $usuario . '" AND contraseña = "' . $contraseña . '"');
        if (mysqli_num_rows($consultausuarios) == 1) { //chequeamos que haya un solo valor(un usuario con ese user y esa contraseña)
            $_SESSION["usuario"] = $usuario;
            $_SESSION["contraseña"] = $contraseña; //si hay las setea a varables de sesion
            foreach ($consultausuarios as $usuario) {
                foreach ($usuario as $indice => $dato) {
                    if ($indice == "Nombre") {
                        $_SESSION["nombre"] = $dato;
                    }
                    if ($indice == "Foto_Perfil") {
                        $_SESSION["fotoperf"] = $dato;
                    }
                }
            }
        } else {
            if (isset($_SESSION["intentos"])) { //chequea que intentos este seteada
                if ($_SESSION["intentos"] <= 0) {
                    $_SESSION["bloq"] = 1;
                    header("Location:index.php?causa=bloq"); //vuelve al index con con la variable de sesion bloq y con la variable causa que avisará que esta bloqueado
                } else { //sino es menor o igual a 0
                    $_SESSION["intentos"] = $_SESSION["intentos"] - 1; // restamos 1 y volvemos a index con la variabla causa seteada en err
                    header("Location:index.php?causa=err");
                }
            } else {
                $_SESSION["intentos"] = 2;
                header("Location:index.php?causa=err");
            }
        }
    } else {
        header("Location:index.php?causa=textovacio");
    }
} else { //SI NO ESTAN seteadas por post 
    if (!isset($_SESSION["usuario"]) && !isset($_SESSION["contraseña"])) {
        header("Location:index.php?causa=nolog");
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
<?php include("barra.php"); ?>
<div class="principal">
    <div class="barra">
        <div class="alternar">
            <img src="Imágenes/Iconos/Alternar.svg">
        </div>
        <div class="buscar">
            <label>
            <input type="text" placeholder="Buscar aquí" id="buscar">
            <img src="Imágenes/Iconos/Buscar.svg">
            </label>
        </div>
    </div>
    <div class="usuario">
        <img src="" alt="Usuario">
    </div>
    <h1>Bienvenido <?php echo $_SESSION["nombre"]; ?></h1>
    <h2 id="titulo_con_fecha"></h2>
    </div>
  
</body>
<script>
    window.onload = () => {
        var hoy = new Date()
        var titulo = document.querySelector("#titulo_con_fecha")

        switch (hoy.getDay()) {
            case 0:
                diasemana = "Domingo ";
                break;
            case 1:
                diasemana = "Lunes ";
                break;
            case 2:
                diasemana = "Martes ";
                break;
            case 3:
                diasemana = "Miercoles ";
                break;
            case 4:
                diasemana = "Jueves ";
                break;
            case 5:
                diasemana = "Viernes ";
                break;
            case 6:
                diasemana = "Sabado ";

        }
        switch (hoy.getMonth()) {
            case 0:
                diames = "Enero"
                break;
            case 1:
                diames = "Febrero"
                break;
            case 2:
                diames = "Marzo"
                break;
            case 3:
                diames = "Abril"
                break;
            case 4:
                diames = "Mayo"
                break;
            case 5:
                diames = "Junio"
                break;
            case 6:
                diames = "Julio"
                break;
            case 7:
                diames = "Agosto"
                break;
            case 8:
                diames = "Septiembre"
                break;
            case 9:
                diames = "Octubre"
                break;
            case 10:
                diames = "Noviembre"
                break;
            case 11:
                diames = "Diciembre"
                break;


        }
        titulo.innerHTML = "Hoy es " + diasemana + hoy.getDate() + " de " + diames + " de " + hoy.getFullYear();

        var contenedordecumpleañeros = document.querySelector(".contenedordecumpleañeros");
        var contenedordeproductos = document.querySelector(".contenedordeproductos");

    }
</script>
<script src="js/script.js"></script>


</html>