<!-- Modal para cambiar contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="changePasswordForm">
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">Nueva Contraseña</label>
                        <input type="text" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="submitPasswordChange">Guardar Cambios</button>
                <button type="button" class="btn btn-success" id="successChangePassword" style="display:none;" disabled><span
                        class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".changePasswordBtn", function() {
        var button = $(this);
        var idEmpleado = button.data("id");
        $("#changePasswordModal").modal('show');
        console.log(idEmpleado);

        $("#submitPasswordChange").off("click").on("click", function() {
            $("#changePasswordModal").modal("hide");
            $("#submitPasswordChange").hide();
            $("#successChangePassword").show();

            $.post("config/modules.php", {
                    process: "inventario_process",
                    action: "changePasswordEmployee",
                    idCodigoEmpleado: idEmpleado,
                    newEditPassword: $("#newPassword").val()
                },
                function(response) {
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Contraseña Editada con exito!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'bottom-center'
                    });
                }).fail(function() {
                console.log("Error al procesar la solicitud.");
            });
        });
    });
</script>