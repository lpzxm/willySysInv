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
                        <div class="input-group">
                            <input type="password" class="form-control" id="newPassword" name="newPassword" required
                                oninput="checkPasswordStrength()">
                            <span class="input-group-text" id="toggleNewPassword" style="cursor: pointer;">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        </div>
                        <div class="progress mt-2" style="height: 5px;">
                            <div id="newPasswordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small id="newPasswordHelp" class="form-text text-muted">La contraseña debe tener al menos 8
                            caracteres, incluyendo letras y números.</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="submitPasswordChange">Guardar Cambios</button>
                <button type="button" class="btn btn-success" id="successChangePassword" style="display:none;"
                    disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Cargando...</button>
            </div>
        </div>
    </div>
</div>

<script>

    document.getElementById('toggleNewPassword').addEventListener('click', function () {
        const passwordField = document.getElementById('newPassword');
        const icon = this.querySelector('i');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            passwordField.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    });

    // Función para verificar la fortaleza de la nueva contraseña
    function checkPasswordStrength() {
        const password = document.getElementById('newPassword').value;
        const strengthBar = document.getElementById('newPasswordStrengthBar');
        const passwordHelp = document.getElementById('newPasswordHelp');
        let strength = 0;

        // Verificar la longitud mínima
        if (password.length >= 8) strength += 25;
        // Verificar la presencia de letras mayúsculas y minúsculas
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
        // Verificar la presencia de números
        if (/\d/.test(password)) strength += 25;
        // Verificar la presencia de caracteres especiales
        if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 25;

        // Actualizar la barra de progreso
        strengthBar.style.width = strength + '%';
        strengthBar.setAttribute('aria-valuenow', strength);

        // Actualizar el mensaje de ayuda
        if (strength === 100) {
            passwordHelp.textContent = 'Contraseña segura.';
            passwordHelp.classList.remove('text-muted');
            passwordHelp.classList.add('text-success');
        } else {
            passwordHelp.textContent = 'La contraseña debe tener al menos 8 caracteres, incluyendo letras y números.';
            passwordHelp.classList.remove('text-success');
            passwordHelp.classList.add('text-muted');
        }
    };

    $(document).on("click", ".changePasswordBtn", function () {
        var button = $(this);
        var idEmpleado = button.data("id");
        $("#changePasswordModal").modal('show');
        console.log(idEmpleado);

        $("#submitPasswordChange").off("click").on("click", function () {
            $("#changePasswordModal").modal("hide");
            $("#submitPasswordChange").hide();
            $("#successChangePassword").show();

            $.post("config/modules.php", {
                process: "inventario_process",
                action: "changePasswordEmployee",
                idCodigoEmpleado: idEmpleado,
                newEditPassword: $("#newPassword").val()
            },
                function (response) {
                    $("#submitPasswordChange").show();
                    $("#successChangePassword").hide();
                    newEditPassword: $("#newPassword").val("");
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Contraseña Editada con exito!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 2000,
                        position: 'bottom-center'
                    });
                }).fail(function () {
                    console.log("Error al procesar la solicitud.");
                });
        });
    });
</script>