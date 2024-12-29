<!-- Modal para agregar usuario -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="editUserModalLabel">Editar Información del Empleado</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalEditEmployee"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Primer Nombre <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="editfirstName" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Segundo Nombre</label>
                            <input type="text" class="form-control" id="editsecondName" required>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Primer Apellido <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="editfirstLastName" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Segundo Apellido</label>
                            <input type="text" class="form-control" id="editsecondLastName" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Número de DUI</label>
                        <input type="text" class="form-control" name="editDUInumber" id="editnumberDUI">
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="userName" class="form-label">Fecha de Nacimiento <span class="text-danger">(*)</span></label>
                            <input type="date" class="form-control" id="editbirthDay" required>
                        </div>
                        <div class="w-100">
                            <label for="userName" class="form-label">Fecha de inicio de labores</label>
                            <input type="date" class="form-control" id="editstartDay" required>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Rol<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="editemployeeRole" required>
                            <option value="">Seleccione</option>
                            <option value="admin">Administrador</option>
                            <option value="employee">Empleado</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="editEmpleadoRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successeditEmployee" style="display:none;" disabled><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".editEmployeeBtn", function() {
        $("#editUserModal").modal('show');
        var button = $(this);
        var idEmployee = button.data("id");
        var firstname = button.data("firstname");
        var secondname = button.data("secondname");
        var lastname1 = button.data("lastname1");
        var lastname2 = button.data("lastname2");
        var dui = button.data("dui");
        var birthday = button.data("birthday");
        var startday = button.data("startday");
        var rol = button.data("rol");

        $("#editfirstName").val(firstname);
        $("#editsecondName").val(secondname);
        $("#editfirstLastName").val(lastname1);
        $("#editsecondLastName").val(lastname2);
        $("#editnumberDUI").val(dui);
        $("#editbirthDay").val(birthday);
        $("#editstartDay").val(startday);
        $("#editemployeeRole").val(rol);

        $("#editEmpleadoRegistro").off("click").on("click", function() {
            let hasErrors = false;
            const fields = [{
                    id: "#editfirstName",
                },

                {
                    id: "#editfirstLastName",
                },
                {
                    id: "#editbirthDay",
                },
                {
                    id: "#editemployeeRole"
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

            if ($("#editnumberDUI").val().length < 9) {
                $.toast({
                    heading: 'Error',
                    text: 'El DUI debe presentar 9 numeros',
                    showHideTransition: 'slide',
                    icon: 'error',
                    hideAfter: 4000,
                    position: 'bottom-center'
                });
                $("#editnumberDUI").addClass("is-invalid");
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
            $("#editEmpleadoRegistro").hide();
            $("#successeditEmployee").show();
            const formData = new FormData();
            formData.append("process", "inventario_process");
            formData.append("action", "updateRegisterEmployee");
            formData.append("idCodigoEmpleado", idEmployee);
            formData.append("firstName", $("#editfirstName").val());
            formData.append("secondName", $("#editsecondName").val());
            formData.append("firstLastName", $("#editfirstLastName").val());
            formData.append("secondLastName", $("#editsecondLastName").val());
            formData.append("rolEmployee", $("#editemployeeRole").val());
            formData.append("birthDay", $("#editbirthDay").val());
            formData.append("DUInumber", $("#editnumberDUI").val());
            formData.append("startTime", $("#editstartDay").val());

            $.ajax({
                url: "config/modules.php",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response == 1) {
                        $("#editEmpleadoRegistro").show();
                        $("#successeditEmployee").hide();
                        $.toast({
                            heading: 'Finalizado',
                            text: 'Empleado Editado con Éxito!!',
                            showHideTransition: 'slide',
                            icon: 'success',
                            hideAfter: 4000,
                            position: 'bottom-center'
                        });
                        $("#closeModalEditEmployee").click();
                        $(".table-responsive").load("../../../layout/tables/employee/table.employee.admin.php");
                    } else {
                        console.error("Error: " + response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX: " + error);
                }
            });
        });

    })




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
</script>