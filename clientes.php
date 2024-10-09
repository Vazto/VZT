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

    <div class="detalles">
        <table id="tabla-clientes">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Cédula</td>
                    <td>Nombre</td>
                    <td>Deuda</td>
                    <td>Fecha de Nacimiento</td>
                    <td>Tickets</td>
                    <td>Contacto</td>
                    <td>RUT</td>
                    <td>Acción</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="Librerias/jQuery/jquery-3.7.1.min.js"></script>
    <script>
    function cargarClientes(buscar = '') {
        $.ajax({
            url: 'apiclientes.php',
            method: 'GET',
            data: { buscar: buscar },
            success: function(data) {
                const tbody = $('#tabla-clientes tbody');
                tbody.empty();

                if (data.length === 0) {
                    window.location.href = 'insertarclientes.php';
                    return;
                }

                data.forEach(function(Cliente) {
                    const fila = `<tr>
                        <td>${Cliente.ID_CLIENTE}</td>
                        <td>${Cliente.Cédula}</td>
                        <td>${Cliente.Nombre}</td>
                        <td>${Cliente.Deuda}</td>
                        <td>${Cliente.Fecha_de_Nacimiento}</td>
                        <td>${Cliente.Tickets_de_Sorteo}</td>
                        <td>${Cliente.Contacto}</td>
                        <td>${Cliente.RUT}</td>
                        <td>
                        <button class="editar" data-id="${Cliente.ID_CLIENTE}">Editar</button>
                        <button class="eliminar" data-id="${Cliente.ID_CLIENTE}">Eliminar</button>
                        </td>
                    </tr>`;
                    tbody.append(fila);
                });
            }
        });
    }

    function eliminarCliente(id) {
        if (confirm("¿Seguro que deseas eliminar este cliente?")) {
            $.ajax({
                url: 'eliminarclientes.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    alert("Cliente eliminado");
                    cargarClientes();
                }
            });
        }
    }

    function editarCliente(id) {
        window.location.href = `editarcliente.php?id=${id}`;
    }

    $(document).on('click', '.eliminar', function() {
        const id = $(this).data('id');
        eliminarCliente(id);
    });

    $(document).on('click', '.editar', function() {
        const id = $(this).data('id');
        editarCliente(id);
    });

    $(document).ready(function() {
        cargarClientes();

        $('#buscar').on('input', function() {
            const terminoBusqueda = $(this).val();
            cargarClientes(terminoBusqueda);
        });
    });
    </script>
    <script src="js/script.js"></script>
</div>
</body>
</html>