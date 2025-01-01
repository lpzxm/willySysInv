<div class="modal fade" id="viewProductsByCategoryModal" tabindex="-1" aria-labelledby="viewProductsByCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewProductsByCategoryLabel">Productos de la Marca</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="brandContent">
                <!-- Aquí se insertará dinámicamente el contenido -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".viewProductsintoBrand", function() {
        const brandId = $(this).data("id"); // ID de la marca desde el botón
        $("#viewProductsByCategoryModal").modal("show"); // Mostrar el modal
        $("#brandContent").html(
            '<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...</div>'
        ); // Indicador de carga

        // Solicitar datos al servidor
        $.ajax({
            url: "config/modules.php",
            type: "POST",
            data: {
                process: "inventario_process",
                action: "getProductsByBrand",
                brandId: brandId,
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response); // Convertir respuesta en JSON
                    let content = "";

                    // Título con el nombre de la marca
                    content += `<h4 class="text-center mb-4">Marca: ${data.brandName}</h4>`;

                    // Verificar si hay categorías registradas
                    if (data.categories.length > 0) {
                        // Generar contenido para cada categoría
                        data.categories.forEach((category) => {
                            content += `
                        <div class="mb-4">
                            <h5>Categoría: ${category.name}</h5>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${
                                        category.products.length > 0
                                            ? category.products
                                                  .map(
                                                      (product) => `
                                            <tr>
                                                <td>${product.name}</td>
                                                <td>${product.net_cost}</td>
                                                <td>${product.quantity}</td>
                                                <td>${product.status === 1 ? "Activo" : "Inactivo"}</td>
                                            </tr>`
                                                  )
                                                  .join("")
                                            : `<tr><td colspan="4" class="text-center">No hay productos registrados</td></tr>`
                                    }
                                </tbody>
                            </table>
                        </div>
                    `;
                        });
                    } else {
                        // Mostrar mensaje si no hay categorías registradas
                        content += `<div class="text-center text-muted">No hay categorías registradas en esta marca.</div>`;
                    }

                    $("#brandContent").html(content); // Insertar contenido en el modal
                } catch (error) {
                    console.error("Error al procesar datos:", error);
                    $("#brandContent").html("<div class='text-danger'>Error al cargar los datos</div>");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX:", error);
                $("#brandContent").html("<div class='text-danger'>Error al cargar los datos</div>");
            },
        });
    });
</script>