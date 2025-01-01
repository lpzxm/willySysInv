<?php
include("../../../config/net.php");
try {
    // Consulta a la base de datos para imprimir categorias (solo y exclusivamente categorias)
    $queryBrands = "SELECT * FROM product_brand";
    $stmtBrands = $pdo->prepare($queryBrands);
    $stmtBrands->execute();
    $brands = $stmtBrands->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<table class="table table-striped table-hover" id="tablaMarcasData">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Categoria Perteneciente</th>
            <th>Fecha de Registro</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($brands)): ?>
            <?php foreach ($brands as $brand): ?>
                <tr>
                    <td><?php echo htmlspecialchars($brand['id']); ?></td>
                    <td><?= htmlspecialchars($brand['name']); ?></td>
                    <td>
                        <?php
                        //consulta para obtener la categoria a la que pertenece
                        $queryCategory = "SELECT * FROM product_category WHERE id = :n1";
                        $stmtCategory = $pdo->prepare($queryCategory);
                        $stmtCategory->bindParam(":n1", $brand['id_category'], PDO::PARAM_INT);
                        $stmtCategory->execute();
                        $category = $stmtCategory->fetch(PDO::FETCH_ASSOC);
                        echo $category['name'];
                        ?>
                    </td>
                    <td><?= htmlspecialchars((new DateTime($brand['date_register']))->format('d/m/y')); ?></td>
                    <td><?= ($brand['status'] === 1) ? "Activo" : "Inactivo" ?></td>
                    <td class="d-flex col">
                        <button class="btn btn-primary btn-sm me-2 editBrandBtn" data-id="<?= $brand['id']; ?>" data-name="<?= $brand['name']; ?>" data-category="<?= $brand['id_category']; ?>" data-status="<?= $brand['status'] === 1 ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-primary btn-sm me-2 viewProductsintoBrand" data-id="<?= htmlspecialchars($brand['id']); ?>">
                            <i class="bi bi-tags-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm changeStatusBrand" data-id="<?= htmlspecialchars($brand['id']); ?>" data-status="<?= ($brand['status'] === 1) ? "Inactivo" : "Activo" ?>">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tablaMarcasData').DataTable();
    })
</script>