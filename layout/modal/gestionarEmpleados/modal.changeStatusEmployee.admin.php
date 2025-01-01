<!-- Modal de Cambiar Estado Empleado -->
<div id="cambiarEstadoEmpleado" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" class="background-color: white;">Confirmar Cambio de Estado</h5>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas cambiar el estado de este empleado a: <span id="currentStatus"
                        class="fw-bold"></span>? </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary dismiss" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmChangeStatusEmployee" class="btn btn-danger">Cambiar Estado</button>
                <button type="button" class="btn btn-success" id="successChangeStatusEmployee" style="display:none;"
                    disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".changeStatusEmployee", function() {
        var button = $(this);
        var idEmployee = button.data("id");
        var statusEmployee = button.data("status")
        $('#currentStatus').text(statusEmployee);
        $("#cambiarEstadoEmpleado").modal("show");

        $(".dismiss").click(function() {
            $("#cambiarEstadoEmpleado").modal("hide");
        })

        $("#confirmChangeStatusEmployee").off("click").on("click", function() {
            $("#confirmChangeStatusEmployee").hide();
            $("#successChangeStatusEmployee").show();

            $.post("config/modules.php", {
                    process: "inventario_process",
                    action: "updateStatusEmployee",
                    idcodigoEmpleado: idEmployee
                },
                function(response) {
                    $("#cambiarEstadoEmpleado").modal("hide");
                    $("#confirmChangeStatusEmployee").show();
                    $("#successChangeStatusEmployee").hide();
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Empleado Actualizado',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'bottom-center'
                    });
                    $(".table-responsive").load("../../../layout/tables/employee/table.employee.admin.php");
                }).fail(function() {
                console.log("Error al procesar la solicitud.");
            });
        });
    })
</script>