<!-- Modal para gestionar productos de una categoría -->
<div class="modal fade" id="manageCategoryProductsModal" tabindex="-1" aria-labelledby="manageCategoryProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="manageCategoryProductsModalLabel">
                    Gestionar Productos - Categoría: <span id="categoryName"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProductCostForm">
                    <input type="hidden" id="categoryId" name="categoryId">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="categoryProductsTable">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Costo Actual</th>
                                    <th>Registrar Costo</th>
                                </tr>
                            </thead>
                            <tbody id="categoryProductsTableBody">
                                <!-- Los productos se cargarán dinámicamente -->
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="saveProductCosts">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    let tableCategoryProducts; // Variable global para el DataTable

    // Abrir el modal para gestionar productos de una categoría
    $(document).on("click", ".manageCategoryBtn", function() {
        const categoryId = $(this).data("id");
        const categoryName = $(this).data("name");

        // Establecer datos de la categoría en el modal
        $("#categoryName").text(categoryName);
        $("#categoryId").val(categoryId);

        // Limpiar el cuerpo de la tabla
        $("#categoryProductsTableBody").empty();

        // Destruir instancia previa del DataTable si existe
        if ($.fn.DataTable.isDataTable("#categoryProductsTable")) {
            tableCategoryProducts.destroy();
        }

        // Hacer una solicitud AJAX para obtener los productos de la categoría
        $.ajax({
            url: "config/modules.php", // Ruta correcta del archivo backend
            type: "POST",
            data: {
                process: "inventario_process",
                action: "getProductsByCategory",
                categoryId: categoryId,
            },
            dataType: "json",
            success: function(response) {
                if (response && response.length > 0) {
                    response.forEach((producto) => {
                        $("#categoryProductsTableBody").append(`
                        <tr>
                            <td>${producto.name}</td>
                            <td>${producto.quantity}</td>
                            <td>${producto.net_cost}</td>
                            <td>
                                <input type="number" 
                                       class="form-control productCostInput" 
                                       name="productCost[${producto.id}]" 
                                       placeholder="Ingrese el costo" 
                                       data-product-id="${producto.id}">
                            </td>
                        </tr>
                    `);
                    });
                } else {
                    alert("xd, no hay productos dentro de esta categoria")
                }

                // Inicializar DataTable
                tableCategoryProducts = $("#categoryProductsTable").DataTable({
                    pageLength: 50,
                    lengthChange: true,
                    // language: {
                    //     url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json",
                    // },
                });

                // Enfocar automáticamente el primer campo de costo
                $(".productCostInput:first").focus();
            },
            error: function(xhr, status, error) {
                console.error("Error al cargar productos: ", error);
                alert("Ocurrió un error al cargar los productos.");
            },
        });

        // Mostrar el modal
        $("#manageCategoryProductsModal").modal("show");
    });

    // Detectar el evento de Enter en los campos de costo
    $(document).on("keydown", ".productCostInput", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            $("#saveProductCosts").trigger("click");
        }
    });

    // Guardar los costos actualizados
    $("#saveProductCosts").on("click", function() {
        const categoryId = $("#categoryId").val();
        const updatedCosts = {};

        // Recorrer los inputs de costo para capturar valores
        $(".productCostInput").each(function() {
            const productId = $(this).data("product-id");
            const productCost = $(this).val().trim();

            if (productCost !== "") {
                updatedCosts[productId] = productCost;
            }
        });

        if (Object.keys(updatedCosts).length === 0) {
            alert("Por favor, registre al menos un costo antes de guardar.");
            return;
        }

        // Enviar los datos al servidor
        $.ajax({
            url: "config/modules.php", // Ruta correcta del archivo backend
            type: "POST",
            data: {
                process: "inventario_process",
                action: "updateProductCosts",
                categoryId: categoryId,
                costs: updatedCosts,
            },
            success: function(response) {
                if (response == 1) {
                    $.toast({
                        heading: "Éxito",
                        text: "Los costos se han actualizado correctamente.",
                        showHideTransition: "slide",
                        icon: "success",
                        hideAfter: 2000,
                        position: "bottom-center",
                    });
                    $("#manageCategoryProductsModal").modal("hide");
                    location.reload();
                } else {
                    console.error("Error: ", response);
                    alert("Ocurrió un error al guardar los costos.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX: ", error);
                alert("Ocurrió un error al comunicarse con el servidor.");
            },
        });
    });
</script>