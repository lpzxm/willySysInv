<?php
include("../../../config/net.php");
try {
    // Consulta a la base de datos para imprimir categorias (solo y exclusivamente categorias)
    $queryCategorias = "SELECT * FROM product_category";
    $stmtCategorias = $pdo->prepare($queryCategorias);
    $stmtCategorias->execute();
    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
<table class="table table-striped table-hover" id="tablaCategoriasData">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
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
                    <td><?= htmlspecialchars($categoria['name']); ?></td>
                    <td><?= htmlspecialchars($categoria['code']); ?></td>
                    <td><?= htmlspecialchars((new DateTime($categoria['date_register']))->format('d/m/y')); ?></td>
                    <td><?= ($categoria['status'] === 1) ? "Activo" : "Inactivo" ?></td>
                    <td class="d-flex col">
                        <button class="btn btn-primary btn-sm me-2 editCategoryBtn" data-id="<?= $categoria['id']; ?>" data-name="<?= $categoria['name']; ?>" data-code="<?= $categoria['code']; ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-primary btn-sm me-2 viewBrandsintoCategory" data-id="<?= htmlspecialchars($categoria['id']); ?>">
                            <i class="bi bi-key"></i>
                        </button>
                        <button class="btn btn-danger btn-sm changeStatusCategory" data-id="<?= htmlspecialchars($categoria['id']); ?>" data-status="<?= ($categoria['status'] === 1) ? "Inactivo" : "Activo" ?>">
                            <i class="bi bi-person-dash-fill"></i>
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
        $('#tablaCategoriasData').DataTable();
    })
</script>