<!-- Modal para agregar usuario -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addCategoryModalLabel">Agregar Nueva Categoria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="closeModalNewCategory"></button>
            </div>
            <form id="categoryForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="w-100 me-2">
                            <label for="nameCategory" class="form-label">Nombre <span
                                    class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="nameCategory" required autofocus>
                        </div>

                    </div>
                    <div class="mb-3">
                        <div class="w-100">
                            <label for="codeCategory" class="form-label">Código Inicial</label>
                            <input type="text" class="form-control" id="codeCategory" required>
                        </div>
                    </div>

                    <br>
                    <hr>
                    <br>
                    <div class="mb-3">
                        <label for="statusCategory" class="form-label">Estado<span
                                class="text-danger">(*)</span></label>
                        <select class="form-select" id="statusCategory" required>
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="nuevaCategoriaRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successNewCategory" style="display:none;"
                        disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Focus
    $('#addCategoryModal').on('shown.bs.modal', function() {
        $('#nameCategory').focus();
    });

    // Submit form on Enter key press
    $('#categoryForm').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent default form submission
            $('#nuevaCategoriaRegistro').click(); // Trigger click event of guardar button
        }
    });

    $("#nuevaCategoriaRegistro").click(function(e) {
        e.preventDefault();

        let hasErrors = false;
        const fields = [{
                id: "#nameCategory",
            },

            // {
            //     id: "#codeCategory",
            // },
            {
                id: "#statusCategory",
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
        $("#nuevaCategoriaRegistro").hide();
        $("#successNewCategory").show();
        const formData = new FormData();
        formData.append("process", "inventario_process");
        formData.append("action", "addNewCategory");
        formData.append("name", $("#nameCategory").val());
        formData.append("code", $("#codeCategory").val());
        formData.append("status", $("#statusCategory").val());
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
                        text: 'Categoria Registrada con Éxito!!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 4000,
                        position: 'bottom-center'
                    });
                    $("#nuevaCategoriaRegistro").show();
                    $("#successNewCategory").hide();
                    $("#closeModalNewCategory").click();
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
</script>