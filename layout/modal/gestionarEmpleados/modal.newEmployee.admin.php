<!-- Modal para agregar usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Nuevo Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="closeModalNewEmployee"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Primer Nombre <span
                                    class="text-danger">(*)</span></label>
                            <input type="text" class="form-control validateOnlyText" id="firstName" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control validateOnlyText" id="secondName" required>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Primer Apellido <span
                                    class="text-danger">(*)</span></label>
                            <input type="text" class="form-control validateOnlyText" id="firstLastName" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control validateOnlyText" id="secondLastName" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Número de DUI</label>
                        <input type="text" class="form-control" name="DUInumber" id="numberDUI" maxlength="10">
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Fecha de Nacimiento <span
                                    class="text-danger">(*)</span></label>
                            <input type="date" class="form-control" id="birthDay" max="<?php echo date('Y-m-d') ?>"
                                required>
                            <small id="birthDayError" class="text-danger" style="display: none;">Debes tener al menos 18
                                años para registrarte.</small>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Fecha de inicio de labores</label>
                            <input type="date" class="form-control" id="startDay" max="<?php echo date('Y-m-d') ?>"
                                required>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-3">
                            <label for="email" class="form-label">Correo <span class="text-danger">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="usuario"
                                    oninput="validateEmailInput(this)" id="email">
                                <span class="input-group-text">@willy.com</span>
                            </div>
                        </div>
                        <div class="w-100">
                            <label for="userPassword" class="form-label">Contraseña <span
                                    class="text-danger">(*)</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" placeholder="Contraseña"
                                    required oninput="checkPasswordStrength()">
                                <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                            <div class="progress mt-2" style="height: 5px;">
                                <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"
                                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small id="passwordHelp" class="form-text text-muted">La contraseña debe tener al menos 8
                                caracteres, incluyendo letras y números.</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Rol<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="employeeRole" required>
                            <option value="">Seleccione</option>
                            <option value="admin">Administrador</option>
                            <option value="employee">Empleado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="nuevoEmpleadoRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successNewEmployee" style="display:none;"
                        disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".validateOnlyText").on("input", function () {
        // Permitir solo letras y espacios
        const regex = /^[a-zA-Z\s]*$/;
        const value = $(this).val();

        if (!regex.test(value)) {
            $(this).val(value.replace(/[^a-zA-Z\s]/g, "")); // Reemplaza caracteres no válidos
        }
    });

    function validateEmailInput(input) {
        // Eliminar cualquier carácter que no sea letra o número
        input.value = input.value.replace(/[^a-zA-Z0-9]/g, '');
    };

    $("#birthDay").on("change", function () {
        const birthDayInput = $(this);
        const errorElement = $("#birthDayError");

        // Obtener la fecha seleccionada
        const birthDate = new Date(birthDayInput.val());
        const today = new Date();

        // Calcular la edad
        let age = today.getFullYear() - birthDate.getFullYear();
        const monthDifference = today.getMonth() - birthDate.getMonth();
        const dayDifference = today.getDate() - birthDate.getDate();

        // Ajustar la edad si el mes o día no han llegado
        if (monthDifference < 0 || (monthDifference === 0 && dayDifference < 0)) {
            age--;
        }

        // Validar si es menor de 18 años
        if (age < 18) {
            birthDayInput.val(""); // Limpiar el campo
            errorElement.show();  // Mostrar mensaje de error
        } else {
            errorElement.hide();  // Ocultar mensaje de error
        }
    });

    $("#numberDUI").on("input", function () {
        let input = $(this).val();
        // Eliminar cualquier caracter no numérico
        input = input.replace(/\D/g, "");
        // Aplicar el formato con guion
        if (input.length > 8) {
            input = input.replace(/(\d{8})(\d{1})/, "$1-$2");
        }
        $(this).val(input);
    });

    // Función para alternar la visibilidad de la contraseña
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordField = document.getElementById('password');
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

    // Función para verificar la fortaleza de la contraseña
    function checkPasswordStrength() {
        const password = document.getElementById('password').value;
        const strengthBar = document.getElementById('passwordStrengthBar');
        const passwordHelp = document.getElementById('passwordHelp');
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


    $("#nuevoEmpleadoRegistro").click(function (e) {
        e.preventDefault();

        let hasErrors = false;
        const fields = [{
            id: "#firstName",
        },
        {
            id: "#firstLastName",
        },
        {
            id: "#birthDay",
        },
        {
            id: "#email",
        },
        {
            id: "#password"
        },
        {
            id: "#employeeRole"
        }
        ];

        fields.forEach((field) => {
            if ($(field.id).val().trim() === "") {
                hasErrors = true;
                $(field.id).addClass("is-invalid");
            } else {
                $(field.id).removeClass("is-invalid");
            }
        });

        if ($("#numberDUI").val().length < 9) {
            $.toast({
                heading: 'Error',
                text: 'El DUI debe presentar 9 numeros',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 4000,
                position: 'bottom-center'
            });
            $("#numberDUI").addClass("is-invalid");
            hasErrors = true;
        }

        if ($("#password").val().length < 8) {
            $.toast({
                heading: 'Error',
                text: 'La contraseña debe presentar al menos 8 caracteres',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 4000,
                position: 'bottom-center'
            });
            $("#password").addClass("is-invalid");
            hasErrors = true;
        }

        if (hasErrors) {
            $.toast({
                heading: 'Error',
                text: 'Debe completar los campos requeridos correctamente',
                showHideTransition: 'slide',
                icon: 'error',
                hideAfter: 4000,
                position: 'bottom-center'
            });
            return;
        };

        //envio de datos mientras todo sea true
        $("#nuevoEmpleadoRegistro").hide();
        $("#successNewEmployee").show();
        const formData = new FormData();
        formData.append("process", "inventario_process");
        formData.append("action", "addNewEmployee");
        formData.append("firstName", $("#firstName").val());
        formData.append("secondName", $("#secondName").val());
        formData.append("firstLastName", $("#firstLastName").val());
        formData.append("secondLastName", $("#secondLastName").val());
        formData.append("email", $("#email").val());
        formData.append("password", $("#password").val());
        formData.append("rolEmployee", $("#employeeRole").val());
        formData.append("birthDay", $("#birthDay").val());
        formData.append("DUInumber", $("#numberDUI").val());
        formData.append("startTime", $("#startDay").val());

        $.ajax({
            url: "config/modules.php",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response == 1) {
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Empleado Registrado con Éxito!!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 4000,
                        position: 'bottom-center'
                    });
                    $("#nuevoEmpleadoRegistro").show();
                    $("#successNewEmployee").hide();
                    $("#closeModalNewEmployee").click();
                    $(".table-responsive").load("../../../layout/tables/employee/table.employee.admin.php");
                } else {
                    console.error("Error: " + response);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX: " + error);
            }
        });

        //pa debuguear xd
        // let firstName = $("#firstName").val();
        // let secondName = $("#secondName").val();
        // let firstLastName = $("#firstLastName").val();
        // let secondLastName = $("#secondLastName").val();
        // let DUI = $("#numberDUI").val();
        // let birthDay = $("#birthDay").val();
        // let startDay = $("#startDay").val();
        // let correo = $("#email").val();
        // let password = $("#password").val();
        // let role = $("#employeeRole").val();

        // // Mostrando valores en la consola
        // console.log("Formulario Capturado:");
        // console.log("Primer Nombre: " + firstName);
        // console.log("Segundo Nombre: " + secondName);
        // console.log("Primer Apellido: " + firstLastName);
        // console.log("Segundo Apellido: " + secondLastName);
        // console.log("Número DUI: " + DUI);
        // console.log("Fecha de Nacimiento: " + birthDay);
        // console.log("Fecha de Inicio: " + startDay);
        // console.log("Correo Electrónico: " + correo);
        // console.log("Contraseña: " + password);
        // console.log("Rol del Empleado: " + role);
    });
</script>