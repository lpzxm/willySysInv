<!-- Modal para restar productos -->
<div class="modal fade" id="subtractProductModal" tabindex="-1" aria-labelledby="subtractProductModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="subtractProductModalLabel">Restar Productos - <span
                        id="subtractProductName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="subtractProductForm">
                    <input type="hidden" id="subtractProductId">
                    <div class="mb-3">
                        <label for="subtractCurrentQuantity" class="form-label">Cantidad Actual</label>
                        <input type="number" class="form-control" id="subtractCurrentQuantity" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label for="subtractQuantity" class="form-label">Cantidad a Restar <span
                                class="text-danger">(*)</span></label>
                        <input type="number" class="form-control" id="subtractQuantity" oninput="onlyNumbersDot(this)" required>
                    </div>
                    <div class="alert alert-danger d-none" id="subtractErrorAlert">La cantidad a restar no puede ser
                        mayor que la cantidad actual.</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="subtractProductSubmit">Restar</button>
                <button type="button" class="btn btn-danger d-none" id="subtractLoadingButton" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Procesando...
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function onlyNumbersDot(input) {
        const regex = /^\d+(\.\d{0,2})?$/;
        if (!regex.test(input.value)) {
            input.value = input.value.slice(0, -1);
        };
    };

    $(document).on("click", ".addProductSale", function () {
        const productId = $(this).data("id");
        const productName = $(this).data("name");
        const currentQuantity = $(this).data("quantity");

        // Configurar valores iniciales en el modal
        $("#subtractProductId").val(productId);
        $("#subtractProductName").text(productName);
        $("#subtractCurrentQuantity").val(currentQuantity);
        $("#subtractQuantity").val('');
        $("#subtractErrorAlert").addClass("d-none");

        $("#subtractProductModal").modal("show");
    });

    $("#subtractProductSubmit").on("click", function () {
        const productId = $("#subtractProductId").val();
        const currentQuantity = parseInt($("#subtractCurrentQuantity").val());
        const quantityToSubtract = parseInt($("#subtractQuantity").val());

        if (quantityToSubtract > currentQuantity || quantityToSubtract <= 0) {
            $("#subtractErrorAlert").removeClass("d-none");
            return;
        }

        // Mostrar botón de carga y deshabilitar el botón principal
        $("#subtractProductSubmit").addClass("d-none");
        $("#subtractLoadingButton").removeClass("d-none");

        $.ajax({
            url: "config/modules.php", // Ruta al backend
            type: "POST",
            data: {
                process: "inventario_process",
                action: "subtractProduct",
                productId: productId,
                quantity: quantityToSubtract
            },
            success: function (response) {
                if (response == 1) {
                    $.toast({
                        heading: "Éxito",
                        text: "Cantidad restada correctamente.",
                        icon: "success",
                        position: "bottom-center",
                        hideAfter: 3000
                    });
                    $("#subtractProductModal").modal("hide");
                    // Recargar tabla de productos
                    $(".table-responsive").load("../../../layout/tables/products/table.products.admin.php");
                } else {
                    console.error("Error: ", response);
                    $.toast({
                        heading: "Error",
                        text: "Hubo un problema al restar la cantidad.",
                        icon: "error",
                        position: "bottom-center",
                        hideAfter: 4000
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX: ", error);
            },
            complete: function () {
                // Restaurar botones
                $("#subtractProductSubmit").removeClass("d-none");
                $("#subtractLoadingButton").addClass("d-none");
            }
        });
    });
</script>