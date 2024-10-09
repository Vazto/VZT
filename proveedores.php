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
        <div class="recientes">
        <table id="tabla-proveedores">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Contacto</td>
                    <td>Razón Social</td>
                    <td>RUT</td>
                    <td>Acción</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        </div>
    </div>
    <button class="agregar">+</button>
        

    <script src="Librerias/jQuery/jquery-3.7.1.min.js"></script>
    <script>
    function cargarProveedores(buscar = '') {
        $.ajax({
            url: 'apiproveedores.php',
            method: 'GET',
            data: { buscar: buscar },
            success: function(data) {
                const tbody = $('#tabla-proveedores tbody');
                tbody.empty();

                if (data.length === 0) {
                    window.location.href = 'insertarproveedor.php';
                    return;
                }
                data.forEach(function(Proveedor) {
                    const fila = `<tr>
                        <td>${Proveedor.ID_PROVEEDOR}</td>
                        <td>${Proveedor.Contacto}</td>
                        <td>${Proveedor.Razón_Social}</td>
                        <td>${Proveedor.RUT}</td>
                        <td>
                        <button class="editar" data-id="${Proveedor.ID_PROVEEDOR}">Editar</button>
                        <button class="eliminar" data-id="${Proveedor.ID_PROVEEDOR}">Eliminar</button>
                        </td>
                    </tr>`;
                    tbody.append(fila);
                });
            }
        });
    }

    function eliminarProveedor(id) {
        if (confirm("¿Seguro que deseas eliminar este proveedor?")) {
            $.ajax({
                url: 'eliminarproveedores.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    alert("Proveedor eliminado");
                    cargarProveedores();
                }
            });
        }
    }

    function editarProveedor(id) {
        window.location.href = `editarproveedor.php?id=${id}`;
    }

    $(document).on('click', '.eliminar', function() {
        const id = $(this).data('id');
        eliminarProveedor(id);
    });

    $(document).on('click', '.editar', function() {
        const id = $(this).data('id');
        editarProveedor(id);
    });

    $(document).ready(function() {
        cargarProveedores();

        $('#buscar').on('input', function() {
            const terminoBusqueda = $(this).val();
            cargarProveedores(terminoBusqueda);
        });
    });
    
    </script>
    <script src="js/script.js"></script>
</div>
</body>
</html>