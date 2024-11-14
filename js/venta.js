$(document).ready(function() {
    let actual = 1;
    let total = 1;
    const limite = 50;

    $('#seleccionar-cliente').select2({
        placeholder: 'Buscar cliente...',
        ajax: {
            url: 'api/clientes.php',
            delay: 250,
            data: function (params) {
                return {
                    buscar: params.term,
                    pagina: params.page || 1,
                    limite: 50
                };
            },
            processResults: function (data) {
                return {
                    results: data.elementos.map(function (cliente) {
                        return {
                            id: cliente.id_cliente,
                            text: cliente.nombre + ' (' + cliente.cedula + ')'
                        };
                    }),
                    pagination: {
                        more: data.pagina < data.paginas
                    }
                };
            },
            cache: true
        }
    }).on('select2:select', function (e) {
        var data = e.params.data;
        $('#id_cliente').val(data.id);
    });

    cargarProductos();

    $('#buscar').on('input', function () {
        cargarProductos($(this).val(), 1);
    });

    $('#anterior').click(function () {
        if (actual > 1) {
            cargarProductos($('#buscar').val(), actual - 1);
        }
    });

    $('#siguiente').click(function () {
        if (actual < total) {
            cargarProductos($('#buscar').val(), actual + 1);
        }
    });

    $(document).on('click', '.eliminar-producto', function() {
        $(this).closest('tr').remove();
        actualizarIdsProductos();
    });

    $('#formulario-venta').on('submit', function(e) {
        e.preventDefault();
        
        const clienteId = $('#id_cliente').val();
        const productosIds = $('#ids_productos').val().split(',').filter(Boolean);
        const cantidades = $('#tabla-transaccion tbody tr').map(function() {
            return $(this).find('.cantidad').val();
        }).get();

        if (!clienteId) {
            alert('Por favor, selecciona un cliente.');
            return;
        }

        if (productosIds.length === 0) {
            alert('No hay productos en la lista de venta.');
            return;
        }

        if (cantidades.some(cantidad => !cantidad || cantidad <= 0)) {
            alert('Por favor, asegúrate de que todas las cantidades sean válidas.');
            return;
        }

        if (productosIds.length !== cantidades.length) {
            alert('Error: La cantidad de productos no coincide con las cantidades proporcionadas.');
            return;
        }

        const formData = new FormData(this);
        formData.set('id_cliente', clienteId);
        formData.set('ids_productos', productosIds.join(','));
        formData.set('cantidades', cantidades.join(','));

        $.ajax({
            url: 'gestionar_ventas/confirmar.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                document.open();
                document.write(response);
                document.close();
            }
        });
    });

    function cargarProductos(buscar = '', pagina = 1) {
        $.ajax({
            url: 'api/productos.php',
            method: 'GET',
            data: { buscar: buscar, pagina: pagina, limite: limite },
            success: function (data) {
                const tbody = $('#tabla-productos tbody');
                tbody.empty();
                
                data.elementos.forEach(function (producto) {
                    if (producto.cantidad > 0) {
                        const fila = `
                            <tr>
                                <td>${producto.nombre}</td>
                                <td>${producto.precio_venta}</td>
                                <td>${producto.codigo}</td>
                                <td>${producto.descripcion}</td>
                                <td>${producto.marca}</td>
                                <td>
                                    <button class="agregar" data-id="${producto.id_producto}" data-cantidad="${producto.cantidad}">Agregar</button>
                                </td>
                            </tr>
                        `;
                        tbody.append(fila);
                    }
                });

                actual = parseInt(data.pagina);
                total = parseInt(data.paginas);
                actualizarPaginacionTexto();
                
                $('.agregar').off('click').on('click', function () {
                    agregarProducto($(this).data('id'), $(this).data('cantidad'));
                });
            }
        });
    }

    function actualizarPaginacionTexto() {
        $('.paginacion').text(`Página ${actual} de ${total}`);
        $('#anterior').prop('disabled', actual <= 1);
        $('#siguiente').prop('disabled', actual >= total);
    }

    function agregarProducto(id, cantidad) {
        if ($(`#tabla-transaccion tbody tr[data-id="${id}"]`).length > 0) {
            alert("El producto ya está en la lista de la venta");
            return;
        }

        $.ajax({
            url: 'api/productos.php',
            method: 'GET',
            data: { id: id },
            success: function (producto) {
                const fila = `
                    <tr data-id="${producto.id_producto}">
                        <td>${producto.nombre}</td>
                        <td class="precio">${producto.precio_venta}</td>
                        <td><input type="number" class="cantidad" value="1" min="1" max="${cantidad}"></td>
                        <td><button class="eliminar-producto">Eliminar</button></td>
                    </tr>
                `;
                $('#tabla-transaccion tbody').append(fila);
                actualizarIdsProductos();
            }
        });
    }

    function actualizarIdsProductos() {
        const productosIds = $('#tabla-transaccion tbody tr').map(function() {
            return $(this).data('id');
        }).get().join(',');
        $('#ids_productos').val(productosIds);
    }

    $('.confirmar').click(function() {
        $('#panel-transaccion').addClass('active');
        $('.superposicion').show();
    });

    $('.cerrar-panel, .superposicion').click(function() {
        $('#panel-transaccion').removeClass('active');
        $('.superposicion').hide();
    });
});