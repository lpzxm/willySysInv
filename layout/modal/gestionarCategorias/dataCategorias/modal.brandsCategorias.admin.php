<!-- Modal para ver marcas y productos dentro de una categoría -->
<div class="modal fade" id="viewBrandsProductsModal" tabindex="-1" aria-labelledby="viewBrandsProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewBrandsProductsModalLabel">Marcas y Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="categoryContent">
                    <!-- Aquí se cargará dinámicamente el contenido de marcas y productos -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", ".viewBrandsintoCategory", function() {
        const categoryId = $(this).data("id"); // ID de la categoría desde el botón
        $("#viewBrandsProductsModal").modal("show"); // Mostrar el modal
        $("#categoryContent").html(
            '<div class="text-center"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Cargando...</div>'
        ); // Indicador de carga

        // Solicitar datos al servidor
        $.ajax({
            url: "config/modules.php",
            type: "POST",
            data: {
                process: "inventario_process",
                action: "getBrandsAndProducts",
                categoryId: categoryId,
            },
            success: function(response) {
                try {
                    const data = JSON.parse(response); // Convertir respuesta en JSON
                    let content = "";

                    // Título con el nombre de la categoría
                    content += `<h4 class="text-center mb-4">Categoría: ${data.categoryName}</h4>`;

                    // Verificar si hay marcas registradas
                    if (data.brands.length > 0) {
                        // Generar contenido para cada marca
                        data.brands.forEach((brand) => {
                            content += `
                        <div class="mb-4">
                            <h5>Marca: ${brand.name}</h5>
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
                                        brand.products.length > 0
                                            ? brand.products
                                                  .map(
                                                      (product) => `
                                            <tr>
                                                <td>${product.name}</td>
                                                <td>${product.net_cost}</td>
                                                <td>${product.quantity}</td>
                                                <td>${product.status == 1 ? "Inactivo" : "Activo"}</td>
                                            </tr>`
                                                  )
                                                  .join("")
                                            : `<tr><td colspan="5" class="text-center">No hay productos registrados</td></tr>`
                                    }
                                </tbody>
                            </table>
                        </div>
                    `;
                        });
                    } else {
                        // Mostrar mensaje si no hay marcas registradas
                        content += `<div class="text-center text-muted">No hay marcas registradas en esta categoría.</div>`;
                    }

                    $("#categoryContent").html(content); // Insertar contenido en el modal
                } catch (error) {
                    console.error("Error al procesar datos:", error);
                    $("#categoryContent").html("<div class='text-danger'>Error al cargar los datos</div>");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error AJAX:", error);
                $("#categoryContent").html("<div class='text-danger'>Error al cargar los datos</div>");
            },
        });
    });
</script>