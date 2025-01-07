<!-- Modal para agregar productos -->
<div class="modal fade" id="addProductQuantityModal" tabindex="-1" aria-labelledby="addProductQuantityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addProductQuantityModalLabel">Añadir Productos - <span id="addProductName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    <div class="mb-3">
                        <div class="mb-3">
                            <label for="addCurrentQuantity" class="form-label">Cantidad Actual</label>
                            <input type="number" class="form-control" id="addCurrentQuantity" readonly disabled>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="addProductQuantity" class="form-label">Cantidad a añadir: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="addProductQuantity" name="addProductQuantity" placeholder="Ingrese la cantidad" required autofocus>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="confirmAddProduct">Confirmar</button>
                <button type="button" class="btn btn-success" id="addingProductSpinner" style="display: none;" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    selectedProductId = null;
    $(document).on("click", ".addProductIncoming", function() {
        const productName = $(this).data("name");
        selectedProductId = $(this).data("id");
        const currentQuantityAdd = $(this).data("quantity");

        $("#addProductName").text(productName);
        $("#addProductQuantity").val('');
        $("#addCurrentQuantity").val(currentQuantityAdd);
        $("#addProductQuantityModal").modal("show");

        // Enfocar el input cuando se abra el modal
        $("#addProductQuantityModal").on("shown.bs.modal", function() {
            $("#addProductQuantity").focus();
        });
    });

    // Confirmar la suma de productos
    function confirmAddProduct() {
        const quantityToAdd = parseInt($("#addProductQuantity").val().trim());

        // Validar el campo de cantidad
        if (isNaN(quantityToAdd) || quantityToAdd <= 0) {
            $("#addProductQuantity").addClass("is-invalid");
            return;
        } else {
            $("#addProductQuantity").removeClass("is-invalid");
        }

        // Preparar el spinner y ocultar el botón de confirmación
        $("#confirmAddProduct").hide();
        $("#addingProductSpinner").show();

        // Enviar datos al servidor
        $.ajax({
            url: "config/modules.php", // Cambiar a la ruta correcta
            type: "POST",
            data: {
                process: "inventario_process",
                action: "addProductQuantity",
                productId: selectedProductId,
                quantity: quantityToAdd,
            },
            success: function(response) {
                if (response == 1) {
                    $.toast({
                        heading: "Éxito",
                        text: "La cantidad se ha añadido correctamente.",
                        showHideTransition: "slide",
                        icon: "success",
                        hideAfter: 3000,
                        position: "bottom-center",
                    });
                    $("#addProductQuantityModal").modal("hide");
                    // $(".table-responsive").load("../../../layout/tables/products/table.products.admin.php");
                } else {
                    console.error("Error: ", response);
                    alert("Ocurrió un error al procesar la solicitud.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX: ", error);
                alert("Ocurrió un error al comunicarse con el servidor.");
            },
            complete: function() {
                $("#confirmAddProduct").show();
                $("#addingProductSpinner").hide();
            },
        });
    }

    // Evento click en el botón de confirmar
    $("#confirmAddProduct").on("click", confirmAddProduct);

    // Ejecutar la acción al presionar Enter
    $("#addProductForm").on("keydown", function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evitar el envío predeterminado del formulario
            confirmAddProduct(); // Ejecutar la acción
        }
    });
</script>