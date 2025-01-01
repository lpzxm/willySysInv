<!-- Modal de Cambiar Estado Marca -->
<div id="cambiarEstadoMarca" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="background-color: white;">Confirmar Cambio de Estado</h5>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas cambiar el estado de esta marca a: <span id="currentStatus"
                        class="fw-bold"></span>? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary dismiss" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmChangeStatusBrand" class="btn btn-danger">Cambiar Estado</button>
                <button type="button" class="btn btn-success" id="successChangeStatusBrand" style="display:none;"
                    disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".changeStatusBrand", function() {
        var button = $(this);
        var idBrand = button.data("id");
        var statusBrand = button.data("status")
        $('#currentStatus').text(statusBrand);
        $("#cambiarEstadoMarca").modal("show");

        $(".dismiss").click(function() {
            $("#cambiarEstadoMarca").modal("hide");
        })

        $("#confirmChangeStatusBrand").off("click").on("click", function() {
            $("#confirmChangeStatusBrand").hide();
            $("#successChangeStatusBrand").show();

            $.post("config/modules.php", {
                    process: "inventario_process",
                    action: "updateStatusBrand",
                    idcodigoMarca: idBrand
                },
                function(response) {
                    $("#cambiarEstadoMarca").modal("hide");
                    $("#confirmChangeStatusBrand").show();
                    $("#successChangeStatusBrand").hide();
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Marca Actualizada',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'bottom-center'
                    });
                    $(".table-responsive").load("../../../layout/tables/brands/table.brands.admin.php");
                }).fail(function() {
                console.log("Error al procesar la solicitud.");
            });
        });
    })
</script>