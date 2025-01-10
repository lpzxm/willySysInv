<!-- Modal de Cambiar Estado Producto -->
<div id="cambiarEstadoProducto" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="background-color: white;">Confirmar Cambio de Estado</h5>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas cambiar el estado de esta marca a: <span id="currentStatus"
                        class="fw-bold"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary dismiss" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmChangeStatusProduct" class="btn btn-danger">Cambiar Estado</button>
                <button type="button" class="btn btn-success" id="successChangeStatusProduct" style="display:none;"
                    disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".changeStatusProduct", function() {
        var button = $(this);
        var idProduct = button.data("id");
        var statusProduct = button.data("status")
        $('#currentStatus').text(statusProduct);
        $("#cambiarEstadoProducto").modal("show");

        $(".dismiss").click(function() {
            $("#cambiarEstadoProducto").modal("hide");
        })

        $("#confirmChangeStatusProduct").off("click").on("click", function() {
            $("#confirmChangeStatusProduct").hide();
            $("#successChangeStatusProduct").show();

            $.post("config/modules.php", {
                    process: "inventario_process",
                    action: "updateStatusProduct",
                    idcodigoProducto: idProduct
                },
                function(response) {
                    $("#cambiarEstadoProducto").modal("hide");
                    $("#confirmChangeStatusProduct").show();
                    $("#successChangeStatusProduct").hide();
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Producto Actualizado',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'bottom-center'
                    });
                    $(".table-responsive").load("../../../layout/tables/products/table.products.admin.php");
                }).fail(function() {
                console.log("Error al procesar la solicitud.");
            });
        });
    })
</script>