<!-- Modal para agregar usuario -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editProductModalLabel">Editar Producto - <span id="name"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeModaleditProduct"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="editnameProduct" class="form-label">Nombre del producto<span class="text-danger">(*)</span></label>
                            <textarea class="form-control" name="editnameProduct" id="editnameProduct" cols="10" rows="2" style="resize: none;" required></textarea>
                        </div>
                        <div class="w-100">
                            <label for="editdescProduct" class="form-label">Descripción del producto:</label>
                            <textarea class="form-control" name="editdescProduct" id="editdescProduct" cols="10" rows="2" style="resize: none;" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="editcategoryBrand" class="form-label">Categoria a la que pertenece: <span class="text-danger">(*)</span></label>
                            <select class="form-select select-example" name="editcategoryBrand" id="editcategoryBrand" required>
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
                        <div class="w-100">
                            <label for="editbrandProduct" class="form-label">Marca del producto: <span class="text-danger">(*)</span><span class="text-success" id="editsuccessBrand"></span></label>
                            <select class="form-select select-example2" id="editbrandProduct" required>
                                <!-- <option value="">Seleccione</option> -->
                                <!-- Las marcas se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="editcostProduct" class="form-label">Costo Neto del Producto: <span class="text-danger">(*)</span></label>
                            <input class="form-control" type="number" name="editcostProduct" id="editcostProduct" required>
                        </div>
                        <div class="w-100">
                            <label for="editquantityProduct" class="form-label">Cantidad Existente del Producto: </label>
                            <input class="form-control" type="number" name="editquantityProduct" id="editquantityProduct" required>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3">
                        <label for="editstatusProduct" class="form-label">Estado<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="editstatusProduct" required>
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="editProductRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successeditProduct" style="display:none;" disabled><span
                            class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const categorySelect = new TomSelect("#editcategoryBrand", {
        allowEmptyOption: true,
        create: false,
        searchField: ['text'],
    });

    const brandSelect = new TomSelect("#editbrandProduct", {
        allowEmptyOption: true,
        create: false,
        searchField: ['text'],
    });

    $(document).on("click", ".editProductBtn", function() {
        brandSelect.clear();
        categorySelect.clear();

        var button = $(this);
        var idProduct = button.data("id");
        var nameProduct = button.data("name");
        var productDescription = button.data("description");
        var idCategoryProduct = button.data("category");
        var idBrandProduct = button.data("brand");
        var costProduct = button.data("cost");
        var quantityProduct = button.data("quantity");
        var statusProduct = button.data("status");

        $("#name").text(nameProduct);
        $("#editnameProduct").val(nameProduct);
        $("#editdescProduct").val(productDescription);
        $("#editcategoryBrand").val(idCategoryProduct);
        $("#editbrandProduct").val(idBrandProduct);
        $("#editcostProduct").val(costProduct);
        $("#editquantityProduct").val(quantityProduct);
        $("#editstatusProduct").val(statusProduct);

        // Manejo de #editcategoryBrand
        $.ajax({
            url: "config/modules.php",
            type: "POST",
            data: {
                process: "inventario_process",
                action: "getCategories", // Cambia según tu backend
            },
            success: function(response) {
                try {
                    const categories = JSON.parse(response);

                    // Limpiar opciones anteriores y añadir las nuevas
                    categorySelect.clearOptions();
                    categories.forEach(category => {
                        categorySelect.addOption({
                            value: category.id,
                            text: `${category.name} - CODE: ${category.code}`
                        });
                    });

                    // Establecer la opción seleccionada
                    categorySelect.setValue(idCategoryProduct);

                    // Cargar las marcas asociadas a la categoría
                    loadBrandsByCategory(idCategoryProduct, idBrandProduct);
                } catch (error) {
                    console.error("Error procesando categorías: ", error);
                    alert("Error al cargar las categorías.");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en AJAX de categorías: ", error);
            }
        });

        $("#editProductModal").modal('show');

        $("#editcategoryBrand").on("change", function() {
            const selectedCategoryId = $(this).val();

            // Limpiar el valor seleccionado previamente en marcas
            brandSelect.clearOptions();
            brandSelect.addOption({
                value: "",
                text: "Seleccione"
            });
            brandSelect.setValue("");

            // Cargar marcas asociadas a la nueva categoría
            loadBrandsByCategory(selectedCategoryId, "");
        });

        function loadBrandsByCategory(categoryId, selectedBrandId) {
            if (categoryId) {
                $.ajax({
                    url: "config/modules.php", // Cambia a la ruta correcta en tu backend
                    type: "POST",
                    data: {
                        process: "inventario_process",
                        action: "getBrandsByCategory", // Acción que se manejará en el backend
                        idCategory: categoryId
                    },
                    success: function(response) {
                        try {
                            const brands = JSON.parse(response);

                            // Limpiar opciones anteriores y añadir las nuevas
                            brandSelect.clearOptions();
                            brandSelect.addOption({
                                value: "",
                                text: "Seleccione"
                            });

                            brands.forEach(brand => {
                                brandSelect.addOption({
                                    value: brand.id,
                                    text: brand.name
                                });
                            });

                            // Establecer la opción seleccionada si se especifica
                            if (selectedBrandId) {
                                brandSelect.setValue(selectedBrandId);
                            }

                        } catch (error) {
                            console.error("Error procesando marcas: ", error);
                            alert("Error al cargar las marcas.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en AJAX de marcas: ", error);
                    }
                });
            } else {
                brandSelect.clearOptions();
                brandSelect.addOption({
                    value: "",
                    text: "Seleccione"
                });
                brandSelect.refreshOptions(false);
            }
        }

        $("#editProductRegistro").off("click").on("click", function() {
            let hasErrors = false;
            const fields = [{
                    id: "#editnameProduct"
                },
                // {
                //     id: "#editcategoryBrand"
                // },
                // {
                //     id: "#editbrandProduct"
                // },
                // {
                //     id: "#editcostProduct"
                // },
                {
                    id: "#editstatusProduct"
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
            $("#editProductRegistro").hide();
            $("#successeditProduct").show();
            const formData = new FormData();
            formData.append("process", "inventario_process");
            formData.append("action", "editProductRegister");
            formData.append("idProductEdit", idProduct);
            formData.append("nameProductEdit", $("#editnameProduct").val());
            formData.append("productDescriptionEdit", $("#editdescProduct").val());
            formData.append("idCategoryProductEdit", $("#editcategoryBrand").val());
            formData.append("idBrandProductEdit", $("#editbrandProduct").val());
            formData.append("costProductEdit", $("#editcostProduct").val());
            formData.append("quantityProductEdit", $("#editquantityProduct").val());
            formData.append("statusProductEdit", $("#editstatusProduct").val());
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
                            text: 'Producto Editado con Éxito!!',
                            showHideTransition: 'slide',
                            icon: 'success',
                            hideAfter: 3000,
                            position: 'bottom-center'
                        });
                        $("#editProductRegistro").show();
                        $("#successeditProduct").hide();
                        $("#closeModaleditProduct").click();
                        $(".table-responsive").load("../../../layout/tables/products/table.products.admin.php");
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