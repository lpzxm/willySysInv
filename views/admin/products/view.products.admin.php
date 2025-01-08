<!-- DataTables -->
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.6/r-2.5.0/datatables.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/2.1.7/css/dataTables.bootstrap5.css" rel="stylesheet">
<script src="https://cdn.datatables.net/v/bs5/dt-1.13.6/r-2.5.0/datatables.min.js"></script>

<!-- Contenido principal -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Gestión de Productos</h2>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="mb-0">Administra los productos registrados dentro del sistema.</p>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addproductModal">
            <i class="bi bi-plus-circle"></i> Agregar Nuevo Producto
        </button>
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Productos Activos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="hiddenproducts-tab" data-bs-toggle="tab" data-bs-target="#hiddenproducts-tab-pane" type="button" role="tab" aria-controls="hiddenproducts-tab-pane" aria-selected="false">Productos Ocultos</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="productoutstock-tab" data-bs-toggle="tab" data-bs-target="#productoutstock-tab-pane" type="button" role="tab" aria-controls="productoutstock-tab-pane" aria-selected="false">Productos Sin Cantidad</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab" data-bs-target="#disabled-tab-pane" type="button" role="tab" aria-controls="disabled-tab-pane" aria-selected="false" disabled>En desarrollo...</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <div id="activeProductsTable" class="mt-4"></div>
        </div>
        <div class="tab-pane fade" id="hiddenproducts-tab-pane" role="tabpanel" aria-labelledby="hiddenproducts-tab" tabindex="0">
            <div id="hiddenProductsTable" class="mt-4"></div>
        </div>
        <div class="tab-pane fade" id="productoutstock-tab-pane" role="tabpanel" aria-labelledby="productoutstock-tab" tabindex="0">
            <div id="outStockProductsTable" class="mt-4"></div>
        </div>
        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">...</div>
    </div>
</div>

<?php include("./layout/modal/gestionarProductos/modal.newProduct.admin.php");
?>
<?php include("./layout/modal/gestionarProductos/modal.changeStatusProduct.admin.php");
?>
<?php include("./layout/modal/gestionarProductos/modal.editProduct.admin.php");
?>
<?php include("./layout/modal/gestionarProductos/dataProductos/modal.substractProducts.admin.php");
?>
<?php include("./layout/modal/gestionarProductos/dataProductos/modal.addProductQuantity.admin.php");
?>

<script>
    $(document).ready(function() {
        $('#activeProductsTable').load("../../../layout/tables/products/table.products.active.admin.php");
        $('#hiddenProductsTable').load("../../../layout/tables/products/table.products.hidden.admin.php");
        $('#outStockProductsTable').load("../../../layout/tables/products/table.products.outStock.admin.php");
    })
</script>