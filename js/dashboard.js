$(document).ready(function() {
    cargarEstadisticas();
    cargarGraficos();
    cargarVentasRecientes();
    cargarProductos();

    $('#buscar').on('input', function() {
        const terminoBusqueda = $(this).val();
        cargarProductos(terminoBusqueda);
    });

    $('#fecha-inicial, #fecha-final').on('change', function() {
        cargarGraficos();
    });
});

function cargarEstadisticas() {
    $.ajax({
        url: 'api/estadisticas.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#total-ventas p').text(data.totalVentas);
        },
        error: function() {
            $('#total-ventas p').text('Error al cargar');
        }
    });
}

function cargarGraficos() {
    const fechaInicial = $('#fecha-inicial').val();
    const fechaFinal = $('#fecha-final').val();

    $.ajax({
        url: 'api/graficos.php',
        method: 'GET',
        data: { fecha_inicial: fechaInicial, fecha_final: fechaFinal },
        dataType: 'json',
        success: function(data) {
            actualizarGraficoVentas(data.ventas);
            actualizarGraficoProductos(data.productos);
        },
        error: function() {
            console.error('Error al cargar los datos de los gráficos');
        }
    });
}

function actualizarGraficoVentas(data) {
    const ctx = document.getElementById('ventas-chart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: data.etiquetas,
            datasets: [{
                label: 'Ventas por día',
                data: data.datos,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function actualizarGraficoProductos(data) {
    const ctx = document.getElementById('productos-chart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.nombres,
            datasets: [{
                label: 'Cantidad vendida',
                data: data.totales,
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

function cargarVentasRecientes() {
    $.ajax({
        url: 'api/ventas_recientes.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            const tbody = $('#tabla-ventas tbody');
            tbody.empty();
            data.forEach(function(venta) {
                const fila = `<tr>
                    <td>${venta.ID_VENTA}</td>
                    <td>${venta.Productos}</td>
                    <td>${venta.Precio}</td>
                    <td>${venta.Deuda}</td>
                    <td>${venta.Cliente}</td>
                </tr>`;
                tbody.append(fila);
            });
        },
        error: function() {
            console.error('Error al cargar las ventas recientes');
        }
    });
}

function cargarProductos(buscar = '') {
    $.ajax({
        url: 'apiproductos.php',
        method: 'GET',
        data: { buscar: buscar },
        dataType: 'json',
        success: function(data) {
            const tbody = $('#tabla-productos tbody');
            tbody.empty();
            data.forEach(function(Producto) {
                const fila = `<tr>
                    <td>${Producto.ID_PRODUCTO}</td>
                    <td>${Producto.Nombre}</td>
                    <td>${Producto.Precio_Neto}</td>
                    <td>${Producto.Código_de_Barras}</td>
                    <td>${Producto.Descripción}</td>
                    <td>${Producto.Marca}</td>
                    <td>${Producto.Cantidad}</td>
                    <td><img src="${Producto.Imagen}" width="50" alt="${Producto.Nombre}"></td>
                    <td>
                    <button class="editar" data-id="${Producto.ID_PRODUCTO}">Editar</button>
                    <button class="eliminar" data-id="${Producto.ID_PRODUCTO}">Eliminar</button>
                    </td>
                </tr>`;
                tbody.append(fila);
            });
        },
        error: function() {
            console.error('Error al cargar los productos');
        }
    });
}

$(document).on('click', '.eliminar', function() {
    const id = $(this).data('id');
    eliminarProducto(id);
});

$(document).on('click', '.editar', function() {
    const id = $(this).data('id');
    editarProducto(id);
});

function eliminarProducto(id) {
    if (confirm("¿Seguro que deseas eliminar este producto?")) {
        $.ajax({
            url: 'eliminarproductos.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                alert("Producto eliminado");
                cargarProductos();
            },
            error: function() {
                alert("Error al eliminar el producto");
            }
        });
    }
}

function editarProducto(id) {
    window.location.href = `editarproducto.php?id=${id}`;
}