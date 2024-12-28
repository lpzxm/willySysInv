<!-- Modal para agregar usuario -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalNewEmployee"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Primer Nombre <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="secondName" required>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Primer Apellido <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="firstLastName" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="secondLastName" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Número de DUI</label>
                        <input type="text" class="form-control" name="DUInumber" id="numberDUI">
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Fecha de Nacimiento <span class="text-danger">(*)</span></label>
                            <input type="date" class="form-control" id="birthDay" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Fecha de inicio de labores</label>
                            <input type="date" class="form-control" id="startDay" required>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-3">
                            <label for="email" class="form-label">Correo <span class="text-danger">(*)</span></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="usuario" id="email">
                                <span class="input-group-text">@willy.com</span>
                            </div>
                        </div>
                        <div class="w-100">
                            <label for="userPassword" class="form-label">Contraseña <span class="text-danger">(*)</span></label>
                            <input type="password" class="form-control" id="password" required>
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
                    <button type="button" class="btn btn-success" id="successNewEmployee" style="display:none;" disabled><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $("#nuevoEmpleadoRegistro").click(function(e) {
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
                text: 'La contraseña debe presentar al menos 9 caracteres',
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
            success: function(response) {
                if (response == 1) {
                    $.toast({
                        heading: 'Finalizado',
                        text: 'Empleado Registrado con Éxito!!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 4000,
                        position: 'bottom-center'
                    });
                    $("#closeModalNewEmployee").click();
                    $(".table-responsive").load("../../tables/employee/table.employee.admin.php")
                } else {
                    console.error("Error: " + response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX: " + error);
            }
        });



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
    })
</script>