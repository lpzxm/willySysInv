<!-- Modal para agregar usuario -->
<div class="modal fade" id="addBrandModal" tabindex="-1" aria-labelledby="addBrandModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addBrandModalLabel">Agregar Nueva Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModalNewBrand"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="nameBrand" class="form-label">Nombre <span class="text-danger">(*)</span></label>
                            <input type="text" class="form-control" id="nameBrand" required>
                        </div>
                        <div class="w-100">
                            <label for="categoryBrand" class="form-label">Categoria a la que pertenece:</label>
                            <select class="form-select select-example" name="categoryBrand" id="categoryBrand" required>
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
                        <label for="statusBrand" class="form-label">Estado<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="statusBrand" required>
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="nuevaMarcaRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successNewBrand" style="display:none;" disabled><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const tomSelectInstance = new TomSelect(".select-example", {
        allowEmptyOption: true,
        create: false,
        searchField: ['text'],
    });

    $("#nuevaMarcaRegistro").click(function(e) {
        e.preventDefault();

        let hasErrors = false;
        const fields = [{
                id: "#nameBrand",
            },

            {
                id: "#categoryBrand",
            },
            {
                id: "#statusBrand",
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
        $("#nuevaMarcaRegistro").hide();
        $("#successNewBrand").show();
        const formData = new FormData();
        formData.append("process", "inventario_process");
        formData.append("action", "addNewBrand");
        formData.append("name", $("#nameBrand").val());
        formData.append("idCategory", $("#categoryBrand").val());
        formData.append("status", $("#statusBrand").val());
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
                        text: 'Marca Registrada con Éxito!!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 4000,
                        position: 'bottom-center'
                    });
                    $("#nuevaMarcaRegistro").show();
                    $("#successNewBrand").hide();
                    $("#closeModalNewBrand").click();
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
</script>