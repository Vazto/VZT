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
        <table id="tabla-productos">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Nombre</td>
                    <td>Precio Neto</td>
                    <td>Código de Barras</td>
                    <td>Descripción</td>
                    <td>Marca</td>
                    <td>Cantidad</td>
                    <td>Imagen</td>
                    <td>Acción</td>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <script src="Librerias/jQuery/jquery-3.7.1.min.js"></script>
    <script>

    function cargarProductos(buscar = '') {
        $.ajax({
            url: 'apiproductos.php',
            method: 'GET',
            data: { buscar: buscar },
            success: function(data) {
                const tbody = $('#tabla-productos tbody');
                tbody.empty();

                if (data.length === 0) {
                    window.location.href = 'insertarproducto.php';
                    return;
                }
                data.forEach(function(Producto) {
                    const fila = `<tr>
                        <td>${Producto.ID_PRODUCTO}</td>
                        <td>${Producto.Nombre}</td>
                        <td>${Producto.Precio_Neto}</td>
                        <td>${Producto.Código_de_Barras}</td>
                        <td>${Producto.Descripción}</td>
                        <td>${Producto.Marca}</td>
                        <td>${Producto.Cantidad}</td>
                        <td><img src="${Producto.Imagen}" width="50"></td>
                        <td>
                        <button class="editar" data-id="${Producto.ID_PRODUCTO}">Editar</button>
                        <button class="eliminar" data-id="${Producto.ID_PRODUCTO}">Eliminar</button>
                        </td>
                    </tr>`;
                    tbody.append(fila);
                });
            }
        });
    }

    function eliminarProducto(id) {
        if (confirm("¿Seguro que deseas eliminar este producto?")) {
            $.ajax({
                url: 'eliminarproductos.php',
                method: 'POST',
                data: { id: id },
                success: function(response) {
                    alert("Producto eliminado");
                    cargarProductos();
                }
            });
        }
    }

    function editarProducto(id) {
        window.location.href = `editarproducto.php?id=${id}`;
    }

    $(document).on('click', '.eliminar', function() {
        const id = $(this).data('id');
        eliminarProducto(id);
    });

    $(document).on('click', '.editar', function() {
        const id = $(this).data('id');
        editarProducto(id);
    });

    $(document).ready(function() {
        cargarProductos();

        $('#buscar').on('input', function() {
            const terminoBusqueda = $(this).val();
            cargarProductos(terminoBusqueda);
        });
    });
    </script>
    <script src="js/script.js"></script>
</div>
</body>
</html>
