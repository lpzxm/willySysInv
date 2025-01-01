<!-- Modal para agregar usuario -->
<div class="modal fade" id="editBrandModal" tabindex="-1" aria-labelledby="editBrandModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editBrandModalLabel">Editar Marca - <span id="name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModaleditBrand"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="editnameBrand" class="form-label">Nombre<span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="editnameBrand" required>
                        </div>
                        <div class="w-100">
                            <label for="editcategoryBrand" class="form-label">Categoria a la que pertenece:</label>
                            <select class="form-select select-example2" name="editcategoryBrand" id="editcategoryBrand" required>
                                <option value="">Seleccione</option>
                                <?php
                                $queryCategories = "SELECT * FROM product_category WHERE status = 1;";
                                $categoryList = $pdo->prepare($queryCategories);
                                $categoryList->execute();
                                while ($dataAL = $categoryList->fetch()) {
                                    echo "<option value='$dataAL[0]'>$dataAL[1]- CODE: $dataAL[2]</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3">
                        <label for="editstatusBrand" class="form-label">Estado<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="editstatusBrand" required>
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="editBrandRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successeditBrand" style="display:none;" disabled><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const tomSelectInstance2 = new TomSelect(".select-example2", {
        allowEmptyOption: true,
        create: false,
        searchField: ['text'],
    });
    $(document).on("click", ".editBrandBtn", function() {

        $("#editBrandModal").modal('show');
        var button = $(this);
        var idBrand = button.data("id");
        var name = button.data("name");
        var idCategory = button.data("category");
        var state = button.data("status");

        tomSelectInstance2.setValue(idCategory);

        $("#name").text(name);
        $("#editnameBrand").val(name);
        $("#editidCategory").val(idCategory);
        $("#editstatusBrand").val(state);

        $("#editBrandRegistro").off("click").on("click", function() {
            let hasErrors = false;
            const fields = [{
                    id: "#editnameBrand"
                },
                {
                    id: "#editcategoryBrand"
                },
                {
                    id: "#editstatusBrand"
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
            $("#editBrandRegistro").hide();
            $("#successeditBrand").show();
            const formData = new FormData();
            formData.append("process", "inventario_process");
            formData.append("action", "editBrandRegister");
            formData.append("idCodigoMarca", idBrand);
            formData.append("name", $("#editnameBrand").val());
            formData.append("idCategory", $("#editcategoryBrand").val());
            formData.append("status", $("#editstatusBrand").val());
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
                            text: 'Marca Editada con Éxito!!',
                            showHideTransition: 'slide',
                            icon: 'success',
                            hideAfter: 3000,
                            position: 'bottom-center'
                        });
                        $("#editBrandRegistro").show();
                        $("#successeditBrand").hide();
                        $("#closeModaleditBrand").click();
                        $(".table-responsive").load("../../../layout/tables/brands/table.brands.admin.php");
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