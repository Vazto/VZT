<?php
if (isset($_POST['agregar'])) {
    header("Location: insertarsorteo.php");
    exit();
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
    <div class="barra">
        <div class="alternar">
            <img src="Imágenes/Iconos/Alternar.svg" alt="Alternar">
        </div>
        <div class="buscar">
            <label>
            <input type="text" placeholder="Buscar aquí" id="buscar">
            <img src="Imágenes/Iconos/Buscar.svg" alt="Buscar">
            </label>
        </div>
    </div>
    <div class="usuario">
        <img src="" alt="Usuario">
    </div>

    <div class="detalles">
        <table id="tabla-sorteos">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Premio</th>
                    <th>Cantidad de ganadores</th>
                    <th>Fecha de realización</th>
                    <th>Ganador(es)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <form method="post" action="">
        <button type="submit" name="agregar" class="agregar" aria-label="Agregar sorteo">+</button>
    </form>

    <script src="Librerias/jQuery/jquery-3.7.1.min.js"></script>
    <script>
    function cargarSorteos(buscar = '') {
        $.ajax({
            url: 'apis/apisorteos.php',
            method: 'GET',
            data: { buscar: buscar },
            dataType: 'json',
            success: function(data) {
                const tbody = $('#tabla-sorteos tbody');
                tbody.empty();
                data.forEach(function(Sorteo) {
                    const fila = `<tr>
                        <td>${Sorteo.ID_SORTEO}</td>
                        <td>${Sorteo.Premio}</td>
                        <td>${Sorteo.Cantidad_Ganadores}</td>
                        <td>${Sorteo.Fecha_realización}</td>
                        <td>${Sorteo.Nombres_Ganadores}</td>
                        <td>
                        <button class="editar" data-id="${Sorteo.ID_SORTEO}">Editar</button>
                        <button class="eliminar" data-id="${Sorteo.ID_SORTEO}">Eliminar</button>
                        <button class="sortear" data-id="${Sorteo.ID_SORTEO}">Sortear</button>
                        </td>
                    </tr>`;
                    tbody.append(fila);
                });
            }
        });
    }

    function eliminarSorteo(id) {
        if (confirm("¿Seguro que deseas eliminar este sorteo?")) {
            $.ajax({
                url: 'eliminarsorteo.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    cargarSorteos();
                }
            });
        }
    }

    function editarSorteo(id) {
        window.location.href = `editarsorteo.php?id=${id}`;
    }

    function sortearSorteo(id) {
        $.ajax({
            url: 'sortearsorteo.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                cargarSorteos();
            }
        });
    }

    $(document).on('click', '.eliminar', function() {
        const id = $(this).data('id');
        eliminarSorteo(id);
    });

    $(document).on('click', '.editar', function() {
        const id = $(this).data('id');
        editarSorteo(id);
    });

    $(document).on('click', '.sortear', function() {
        const id = $(this).data('id');
        sortearSorteo(id);
    });

    $(document).ready(function() {
        cargarSorteos();

        $('#buscar').on('input', function() {
            const terminoBusqueda = $(this).val();
            cargarSorteos(terminoBusqueda);
        });
    });
    
    </script>
    <script src="js/script.js"></script>
</div>
</body>
</html>