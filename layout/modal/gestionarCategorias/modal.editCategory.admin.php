<!-- Modal para agregar usuario -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editCategoryModalLabel">Editar Categoria - <span id="name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModaleditCategory"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="w-100 me-2">
                            <label for="editnameCategory" class="form-label">Nombre <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="editnameCategory" required>
                        </div>

                    </div>
                    <div class="mb-3">
                        <div class="w-100">
                            <label for="editcodeCategory" class="form-label">Código Inicial</label>
                            <input type="text" class="form-control" id="editcodeCategory" required>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3">
                        <label for="editstatusCategory" class="form-label">Estado<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="editstatusCategory" required>
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="editCategoriaRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successeditCategory" style="display:none;" disabled><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".editCategoryBtn", function() {
        $("#editCategoryModal").modal('show');
        var button = $(this);
        var idCategory = button.data("id");
        var name = button.data("name");
        var code = button.data("code");
        var state = button.data("status");

        $("#name").text(name);
        $("#editnameCategory").val(name);
        $("#editcodeCategory").val(code);
        $("#editstatusCategory").val(state);

        $("#editCategoriaRegistro").off("click").on("click", function() {
            let hasErrors = false;
            const fields = [{
                    id: "#editnameCategory"
                },
                {
                    id: "#editcodeCategory"
                },
                {
                    id: "#editstatusCategory"
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


            //!!! esto me va a servir para restringir la cantidad de digitos en el codigo a solicitud de la empresa
            // if ($("#numberDUI").val().length < 9) {
            //     $.toast({
            //         heading: 'Error',
            //         text: 'El DUI debe presentar 9 numeros',
            //         showHideTransition: 'slide',
            //         icon: 'error',
            //         hideAfter: 4000,
            //         position: 'bottom-center'
            //     });
            //     $("#numberDUI").addClass("is-invalid");
            //     hasErrors = true;
            // }

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
            $("#editCategoriaRegistro").hide();
            $("#successeditCategory").show();
            const formData = new FormData();
            formData.append("process", "inventario_process");
            formData.append("action", "editCategoryRegister");
            formData.append("idCodigoCategoria", idCategory);
            formData.append("name", $("#editnameCategory").val());
            formData.append("code", $("#editcodeCategory").val());
            formData.append("status", $("#editstatusCategory").val());
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
                            text: 'Categoria Editada con Éxito!!',
                            showHideTransition: 'slide',
                            icon: 'success',
                            hideAfter: 3000,
                            position: 'bottom-center'
                        });
                        $("#editCategoriaRegistro").show();
                        $("#successeditCategory").hide();
                        $("#closeModaleditCategory").click();
                        $(".table-responsive").load("../../../layout/tables/categories/table.categories.admin.php");
                    } else {
                        console.error("Error: " + response);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error AJAX: " + error);
                }
            });
        });
    });
</script>