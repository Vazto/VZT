<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title></title>
</head>
<body>
    <div class="contenedor">
        <div class="navegar">
            <ul>
                <li>
                    <a href="menu.php">
                        <span class="icono"><img src="Imágenes/Iconos/Menu.svg"></span>
                        <span class="titulo">Menú</span>
                    </a>
                </li>
                <li>
                    <a href="cobros.php">
                        <span class="icono"><img src="Imágenes/Iconos/Cobros.svg"></span>
                        <span class="titulo">Cobros</span>
                    </a>
                </li>
                <li>
                    <a href="pagos.php">
                        <span class="icono"><img src="Imágenes/Iconos/Pagos.svg"></span>
                        <span class="titulo">Pagos</span>
                    </a>
                </li>
                <li>
                    <a href="proveedores.php">
                        <span class="icono"><img src="Imágenes/Iconos/Proveedores.svg"></span>
                        <span class="titulo">Proveedores</span>
                    </a>
                </li>
                <li>
                    <a href="productos.php">
                        <span class="icono"><img src="Imágenes/Iconos/Productos.svg"></span>
                        <span class="titulo">Productos</span>
                    </a>
                </li>
                <li>
                    <a href="clientes.php">
                        <span class="icono"><img src="Imágenes/Iconos/Clientes.svg"></span>
                        <span class="titulo">Clientes</span>
                    </a>
                </li>
                <li>
                    <a href="resumen.php">
                        <span class="icono"><img src="Imágenes/Iconos/Resumen.svg"></span>
                        <span class="titulo">Resumen</span>
                    </a>
                </li>
                <li>
                    <a href="sorteos.php">
                        <span class="icono"><img src="Imágenes/Iconos/Sorteos.svg"></span>
                        <span class="titulo">Sorteos</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <script>
        let lista = document.querySelectorAll('.navegar li');
    function enlaceActivo() {
        lista.forEach((item) =>
            item.classList.remove(''));
        this.classList.add('hovered');
    }
    lista.forEach((item) =>
        item.addEventListener('mouseover', enlaceActivo));
    </script>
</body>
</html>
