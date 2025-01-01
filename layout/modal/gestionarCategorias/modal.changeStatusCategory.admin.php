<!-- Modal de Cambiar Estado Categoria -->
<div id="cambiarEstadoCategoria" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="background-color: white;">Confirmar Cambio de Estado</h5>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas cambiar el estado de esta categoria a: <span id="currentStatus"
                        class="fw-bold"></span>? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary dismiss" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmChangeStatusCategory" class="btn btn-danger">Cambiar Estado</button>
                <button type="button" class="btn btn-success" id="successChangeStatusCategory" style="display:none;"
                    disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".changeStatusCategory", function() {
        var button = $(this);
        var idCategory = button.data("id");
        var statusCategory = button.data("status");
        $('#currentStatus').text(statusCategory);
        $("#cambiarEstadoCategoria").modal("show");

        $(".dismiss").click(function() {
            $("#cambiarEstadoCategoria").modal("hide");
        });

        $("#confirmChangeStatusCategory").off("click").on("click", function() {
            $("#confirmChangeStatusCategory").hide();
            $("#successChangeStatusCategory").show();

            $.post("config/modules.php", {
                    process: "inventario_process",
                    action: "updateStatusCategory",
                    idcodigoCategory: idCategory
                },
                function(response) {
                    $("#cambiarEstadoCategoria").modal("hide");
                    $("#confirmChangeStatusCategory").show();
                    $("#successChangeStatusCategory").hide();
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Categoria Actualizada',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'bottom-center'
                    });
                    $(".table-responsive").load("../../../layout/tables/categories/table.categories.admin.php");
                }).fail(function() {
                console.log("Error al procesar la solicitud.");
            });
        });
    })
</script>