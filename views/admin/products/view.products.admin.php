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

    <!-- Tabla de marcas -->
    <div class="table-responsive"></div>
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
        $('.table-responsive').load("../../../layout/tables/products/table.products.admin.php");
    })
</script>