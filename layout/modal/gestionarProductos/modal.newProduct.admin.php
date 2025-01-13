<!-- Modal para agregar producto -->
<div class="modal fade" id="addproductModal" tabindex="-1" aria-labelledby="addproductModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="addProductModalLabel">Agregar Nueva Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="closeModalNewProduct"></button>
            </div>
            <form>
                <div class="modal-body">
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="nameProduct" class="form-label">Nombre del producto<span
                                    class="text-danger">(*)</span></label>
                            <textarea class="form-control" name="nameProduct" id="nameProduct" cols="10" rows="2"
                                style="resize: none;" required></textarea>
                        </div>
                        <div class="w-100">
                            <label for="descProduct" class="form-label">Descripción del producto:</label>
                            <textarea class="form-control" name="descProduct" id="descProduct" cols="10" rows="2"
                                style="resize: none;" required></textarea>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="categoryBrand" class="form-label">Categoria a la que pertenece: <span
                                    class="text-danger">(*)</span></label>
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
                        <div class="w-100">
                            <label for="brandProduct" class="form-label">Marca del producto: <span
                                    class="text-danger">(*)</span><span class="text-success"
                                    id="successBrand"></span></label>
                            <select class="form-select select-example2" id="brandProduct" required>
                                <!-- <option value="">Seleccione</option> -->
                                <!-- Las marcas se cargarán dinámicamente aquí -->
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 d-flex col">
                        <div class="w-100 me-2">
                            <label for="costProduct" class="form-label">Costo Neto del Producto: <span
                                    class="text-danger">(*)</span></label>
                            <input class="form-control" type="number" name="costProduct" id="costProduct"
                                oninput="onlyNumbersDot(this)" required>
                        </div>
                        <div class="w-100">
                            <label for="quantityProduct" class="form-label">Cantidad Existente del Producto: </label>
                            <input class="form-control" type="number" name="quantityProduct"
                                oninput="onlyNumbersDot(this)" id="quantityProduct" required>
                        </div>
                    </div>
                    <br>
                    <hr>
                    <br>
                    <div class="mb-3">
                        <label for="statusProduct" class="form-label">Estado<span class="text-danger">(*)</span></label>
                        <select class="form-select" id="statusProduct" required>
                            <option value="">Seleccione</option>
                            <option value="1">Activo</option>
                            <option value="0">Oculto</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="nuevoProductoRegistro">Guardar</button>
                    <button type="button" class="btn btn-success" id="successNewProduct" style="display:none;"
                        disabled><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Cargando...</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function onlyNumbersDot(input) {
        const regex = /^\d+(\.\d{0,2})?$/;
        if (!regex.test(input.value)) {
            input.value = input.value.slice(0, -1);
        }
    }

    $(document).ready(function () {



        const categorySelect = new TomSelect("#categoryBrand", {
            allowEmptyOption: true,
            create: false,
            searchField: ['text'],
        });

        const brandSelect = new TomSelect("#brandProduct", {
            allowEmptyOption: true,
            create: false,
            searchField: ['text'],
        });

        brandSelect.clear();
        // Evento cuando se cambia la categoría
        $("#categoryBrand").change(function () {
            const categoryId = $(this).val();

            // Verifica que se haya seleccionado una categoría válida
            if (categoryId) {
                $.ajax({
                    url: "config/modules.php", // Cambia a la ruta correcta en tu backend
                    type: "POST",
                    data: {
                        process: "inventario_process",
                        action: "getBrandsByCategory", // Acción que se manejará en el backend
                        idCategory: categoryId
                    },
                    success: function (response) {
                        try {
                            const brands = JSON.parse(response);
                            brandSelect.clearOptions();
                            brandSelect.addOption({
                                value: "",
                                text: "Seleccione"
                            });

                            // Agrega nuevas opciones dinámicamente
                            brands.forEach(brand => {
                                brandSelect.addOption({
                                    value: brand.id,
                                    text: brand.name
                                });
                            });
                            $("#successBrand").text("OK!")

                            // Refresca el componente TomSelect
                            brandSelect.refreshOptions(false);

                        } catch (error) {
                            console.error("Error procesando respuesta: ", error);
                            alert("Hubo un error al cargar las marcas.");
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX: ", error);
                    }
                });
            } else {
                // Si no hay categoría seleccionada, limpia las opciones de marcas
                brandSelect.clearOptions();
                brandSelect.addOption({
                    value: "",
                    text: "Seleccione"
                }); // Opción predeterminada
                brandSelect.refreshOptions(false);
            }
        });
    });


    $("#nuevoProductoRegistro").click(function (e) {
        e.preventDefault();

        let hasErrors = false;
        const fields = [{
            id: "#nameProduct",
        },
        {
            id: "#categoryBrand",
        },
        // {
        //     id: "#brandProduct",
        // },
        {
            id: "#costProduct",
        },
        {
            id: "#statusProduct",
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
        $("#nuevoProductoRegistro").hide();
        $("#successNewProduct").show();
        const formData = new FormData();
        formData.append("process", "inventario_process");
        formData.append("action", "addNewProduct");
        formData.append("nameProduct", $("#nameProduct").val());
        formData.append("productDescription", $("#descProduct").val());
        formData.append("idCategoryProduct", $("#categoryBrand").val());
        formData.append("idBrandProduct", $("#brandProduct").val());
        formData.append("costProduct", $("#costProduct").val());
        formData.append("quantityProduct", $("#quantityProduct").val());
        formData.append("statusProduct", $("#statusProduct").val());
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
                        text: 'Marca Registrada con Éxito!!',
                        showHideTransition: 'slide',
                        icon: 'success',
                        hideAfter: 4000,
                        position: 'bottom-center'
                    });
                    $("#nuevoProductoRegistro").show();
                    $("#successNewProduct").hide();
                    $("#closeModalNewProduct").click();
                    $("#nameProduct", "#descProduct", "#categoryBrand", "#brandProduct", "#costProduct", "#quantityProduct", "#statusProduct    ").val("");
                    $(".table-responsive").load("../../../layout/tables/products/table.products.admin.php");
                } else {
                    console.error("Error: " + response);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error AJAX: " + error);
            }
        });
    });
</script>