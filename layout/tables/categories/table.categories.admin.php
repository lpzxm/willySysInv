<?php
include("../../../config/net.php");
try {
    // Consulta a la base de datos para imprimir categorias (solo y exclusivamente categorias)
    $queryCategorias = "SELECT pc.*, (SELECT COUNT(*) FROM products p WHERE p.id_category = pc.id AND (p.net_cost IS NULL OR p.net_cost = 0)) AS productos_sin_costo FROM product_category pc ORDER BY `productos_sin_costo` DESC";
    $stmtCategorias = $pdo->prepare($queryCategorias);
    $stmtCategorias->execute();
    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);

    $totalProductossinCosto = 0;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<table class="table table-striped table-hover" id="tablaCategoriasData">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Productos sin costo</th>
            <th>Nombre</th>
            <th>Codigo Inicial</th>
            <th>Fecha de Registro</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($categorias)): ?>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?php echo htmlspecialchars($categoria['id']); ?></td>
                    <td>
                        <?= htmlspecialchars($categoria['productos_sin_costo']); ?>
                    </td>
                    <td><?= htmlspecialchars($categoria['name']); ?></td>
                    <td><?= !empty($categoria['code']) ? htmlspecialchars($categoria['code']) : "<span class='text-warning'>Vacio</span>"; ?></td>
                    <td><?= htmlspecialchars((new DateTime($categoria['date_register']))->format('d/m/y')); ?></td>
                    <td><?= ($categoria['status'] === 1) ? "Activo" : "Inactivo" ?></td>
                    <td class="d-flex col">
                        <button
                            class="btn btn-primary assignProductsBtn me-2"
                            data-id="<?= $categoria['id']; ?>"
                            data-name="<?= $categoria['name']; ?>">
                            asignar
                        </button>

                        <button class="btn btn-primary btn-sm me-2 editCategoryBtn" data-id="<?= $categoria['id']; ?>" data-name="<?= $categoria['name']; ?>" data-code="<?= $categoria['code']; ?>" data-status="<?= $categoria['status'] === 1 ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-primary btn-sm me-2 manageCategoryBtn" data-id="<?= htmlspecialchars($categoria['id']); ?>" data-name="<?= $categoria['name']; ?>">
                            <i class="bi bi-tags-fill"></i>
                        </button>
                        <button class="btn btn-danger btn-sm changeStatusCategory" data-id="<?= htmlspecialchars($categoria['id']); ?>" data-status="<?= ($categoria['status'] === 1) ? "Inactivo" : "Activo" ?>">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                </tr>
                <?php $totalProductossinCosto += $categoria['productos_sin_costo']; ?>

            <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </tbody>
</table>
<span><?php echo $totalProductossinCosto ?></span>

<script>
    // $(document).ready(function() {
    //     $('#tablaCategoriasData').DataTable();
    // })
</script>