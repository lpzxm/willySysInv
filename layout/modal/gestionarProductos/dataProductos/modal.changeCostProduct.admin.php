<!-- Modal para cambiar el costo del producto -->
<div class="modal fade" id="changeProductCostModal" tabindex="-1" aria-labelledby="changeProductCostModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="changeProductCostModalLabel">Cambiar Costo - <span
                        id="productCostName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changeCostForm">
                    <div class="mb-3">
                        <label for="currentCost" class="form-label">Costo Actual</label>
                        <input type="number" class="form-control" id="currentCost" readonly disabled>
                    </div>
                    <div class="mb-3">
                        <label for="newCost" class="form-label">Nuevo Costo: <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="newCost" name="newCost"
                            placeholder="Ingrese el nuevo costo" oninput="validateCostInput(this)" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmChangeCost">Confirmar</button>
                <button type="button" class="btn btn-primary" id="changingCostSpinner" style="display: none;" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Procesando...
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para validar la entrada del costo (solo números y dos decimales)
    function validateCostInput(input) {
        const regex = /^\d+(\.\d{0,4})?$/; // Permitir hasta dos decimales
        if (!regex.test(input.value)) {
            input.value = input.value.slice(0, -1); // Eliminar el carácter no válido
        }
    }

    let selectedProductId = null;

    // Abrir el modal y rellenar los datos del producto
    $(document).on("click", ".changeCostProduct", function () {
        const productName = $(this).data("name");
        selectedProductId = $(this).data("id");
        const currentProductCost = $(this).data("cost");

        $("#productCostName").text(productName);
        $("#currentCost").val(currentProductCost.toFixed(2));
        $("#newCost").val(''); // Limpiar el campo del nuevo costo
        $("#changeProductCostModal").modal("show");

        // Enfocar el input cuando se abra el modal
        $("#changeProductCostModal").on("shown.bs.modal", function () {
            $("#newCost").focus();
        });
    });

    // Confirmar el cambio de costo
    function confirmChangeCost() {
        const newCost = $("#newCost").val().trim();

        // Validar el campo del nuevo costo
        if (isNaN(newCost) || newCost <= 0) {
            $("#newCost").addClass("is-invalid");
            return;
        } else {
            $("#newCost").removeClass("is-invalid");
        }

        // Preparar el spinner y ocultar el botón de confirmación
        $("#confirmChangeCost").hide();
        $("#changingCostSpinner").show();

        // Enviar datos al servidor
        $.ajax({
            url: "config/modules.php", // Cambiar a la ruta correcta
            type: "POST",
            data: {
                process: "inventario_process",
                action: "changeProductCost",
                productId: selectedProductId,
                newCost: newCost,
            },
            success: function (response) {
                if (response == 1) {
                    $.toast({
                        heading: "Éxito",
                        text: "El costo del producto se ha actualizado correctamente.",
                        showHideTransition: "slide",
                        icon: "success",
                        hideAfter: 3000,
                        position: "bottom-center",
                    });
                    $("#changeProductCostModal").modal("hide");
                    // Aquí puedes recargar la tabla para actualizar los datos
                    // $(".table-responsive").load("../../../layout/tables/products/table.products.admin.php");
                } else {
                    console.error("Error: ", response);
                    alert("Ocurrió un error al procesar la solicitud.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX: ", error);
                alert("Ocurrió un error al comunicarse con el servidor.");
            },
            complete: function () {
                $("#confirmChangeCost").show();
                $("#changingCostSpinner").hide();
            },
        });
    }

    // Evento click en el botón de confirmar
    $("#confirmChangeCost").on("click", confirmChangeCost);

    // Ejecutar la acción al presionar Enter
    $("#changeCostForm").on("keydown", function (event) {
        if (event.key === "Enter") {
            event.preventDefault(); // Evitar el envío predeterminado del formulario
            confirmChangeCost(); // Ejecutar la acción
        }
    });

</script>