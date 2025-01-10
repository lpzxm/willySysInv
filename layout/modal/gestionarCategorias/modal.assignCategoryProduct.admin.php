<!-- Modal para asignar productos a una categoría -->
<div class="modal fade" id="assignProductsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="assignProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="assignProductsModalLabel">Asignar Productos a Categoría: <span id="categoriaNombre"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmAssignProducts">Asignar Productos</button>
                <form id="assignProductsForm">
                    <input type="hidden" id="categoriaId" name="categoriaId">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="tablaProductosinCategoria">
                            <thead>
                                <tr>
                                    <th>Seleccionar</th>
                                    <th>Nombre del Producto</th>
                                    <th>Cantidad</th>
                                    <th>Costo</th>
                                </tr>
                            </thead>
                            <tbody id="productosTableBody">
                                <!-- Los productos se cargarán aquí dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>

<script>
    let tablaProductos;
    // Abrir el modal para asignar productos a una categoría
    $(document).on("click", ".assignProductsBtn", function() {

        const categoriaId = $(this).data("id");
        const categoriaNombre = $(this).data("name");
        $("#categoriaNombre").text(categoriaNombre);
        $("#categoriaId").val(categoriaId);

        $("#productosTableBody").empty();

        if ($.fn.DataTable.isDataTable("#tablaProductosinCategoria")) {
            tablaProductos.destroy();
        }

        // Hacer una solicitud AJAX para obtener los productos sin categoría
        $.ajax({
            url: "config/modules.php", // Ruta correcta del archivo backend
            type: "POST",
            data: {
                process: "inventario_process",
                action: "getUnassignedProducts",
            },
            dataType: "json",
            success: function(response) {
                if (response && response.length > 0) {
                    // Generar filas dinámicas para cada producto
                    response.forEach((producto) => {
                        $("#productosTableBody").append(`
                        <tr>
                            <td><input type="checkbox" class="productCheckbox" style="width: 30px; height: 30px;" value="${producto.id}"></td>
                            <td>${producto.name}</td>
                            <td>${producto.quantity}</td>
                            <td>${producto.net_cost}</td>
                        </tr>
                    `);
                    });
                } else {
                    //     // Mostrar mensaje si no hay productos disponibles
                    //     $("#productosTableBody").append(`
                    //     <tr>
                    //         <td colspan="4" class="text-center">No hay productos disponibles para asignar.</td>
                    //     </tr>
                    // `);
                }
                // Inicializar el DataTable después de agregar las filas dinámicas
                tablaProductos = $("#tablaProductosinCategoria").DataTable({
                    pageLength: 25, // Número de filas por página
                    lengthChange: true, // Mostrar opciones de longitud de página
                    language: {
                        url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json", // Traducción al español
                    },
                });
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar productos: ", error);
                alert("Ocurrió un error al cargar los productos.");
            },
        });

        // Mostrar el modal
        $("#assignProductsModal").modal("show");
    });

    // Confirmar la asignación de productos
    $("#confirmAssignProducts").on("click", function() {
        const categoriaId = $("#categoriaId").val();
        const selectedProducts = [];

        // Obtener los productos seleccionados
        $(".productCheckbox:checked").each(function() {
            selectedProducts.push($(this).val());
        });

        if (selectedProducts.length === 0) {
            alert("Por favor, seleccione al menos un producto.");
            return;
        }

        // Enviar los productos seleccionados al servidor
        $.ajax({
            url: "config/modules.php", // Ruta correcta del archivo backend
            type: "POST",
            data: {
                process: "inventario_process",
                action: "assignProductsToCategory",
                categoriaId: categoriaId,
                productos: selectedProducts,
            },
            success: function(response) {
                if (response == 1) {
                    $.toast({
                        heading: "Éxito",
                        text: "Productos asignados correctamente.",
                        showHideTransition: "slide",
                        icon: "success",
                        hideAfter: 2000,
                        position: "bottom-center",
                    });
                    $("#assignProductsModal").modal("hide");
                    location.reload();
                } else {
                    console.error("Error: ", response);
                    alert("Ocurrió un error al asignar los productos.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX: ", error);
                alert("Ocurrió un error al comunicarse con el servidor.");
            },
        });
    });
</script>