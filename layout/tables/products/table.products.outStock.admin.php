<?php
include("../../../config/net.php");
try {
    // Consulta a la base de datos para imprimir productos (solo y exclusivamente productos)
    $queryProducts = "SELECT * FROM products WHERE status = 1 AND net_cost IS NULL or net_cost = 0";
    $stmtProducts = $pdo->prepare($queryProducts);
    $stmtProducts->execute();
    $products = $stmtProducts->fetchAll(PDO::FETCH_ASSOC);
    $count = count($products);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$totalProductos = 0;
$totalCantidad = 0;
?>
<table class="table table-striped table-hover" id="tablaProductosCost">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre del Producto</th>
            <th>Descripción del producto</th>
            <th>Categoria Perteneciente</th>
            <th>Marca</th>
            <th>Costo Neto</th>
            <th>Cantidad</th>
            <th>Fecha de Registro</th>
            <th>Estado</th>
            <th>Total Invertido</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                    <td><?= htmlspecialchars($product['name']); ?></td>
                    <td><?= !empty($product['description']) ? htmlspecialchars($product['description']) : "<span class='text-info'>Sin Info</span>"; ?></td>
                    <td>
                        <?php

                        if (!empty($product['id_category'])) {
                            //consulta para obtener la categoria a la que pertenece
                            $queryCategory = "SELECT * FROM product_category WHERE id = :n1 AND status = 1";
                            $stmtCategory = $pdo->prepare($queryCategory);
                            $stmtCategory->bindParam(":n1", $product['id_category'], PDO::PARAM_INT);
                            $stmtCategory->execute();
                            $category = $stmtCategory->fetch(PDO::FETCH_ASSOC);
                            echo $category['name'];
                        } else {
                            echo "Sin Categoria";
                        }

                        ?>
                    </td>
                    <td>
                        <?php

                        if (!empty($product['id_brand'])) {
                            //consulta para obtener la categoria a la que pertenece
                            $queryBrand = "SELECT * FROM product_brand WHERE id = :n1 AND status = 1";
                            $stmtBrand = $pdo->prepare($queryBrand);
                            $stmtBrand->bindParam(":n1", $product['id_brand'], PDO::PARAM_INT);
                            $stmtBrand->execute();
                            $brand = $stmtBrand->fetch(PDO::FETCH_ASSOC);
                            echo $brand['name'];
                        } else {
                            echo "Sin Marca";
                        }

                        ?>
                    </td>
                    <td>$<?= !empty($product['net_cost']) ? number_format($product['net_cost'], 2) : "<span class='text-info'>Sin registro</span>"; ?></td>
                    <td><?= !empty($product['quantity']) ? htmlspecialchars($product['quantity']) : "<span class='text-info'>Sin registro</span>"; ?></td>
                    <td><?= htmlspecialchars((new DateTime($product['date_register']))->format('d/m/y')); ?></td>
                    <td><?= ($product['status'] === 1) ? "Activo" : "<span class='text-secondary'>Inactivo</span>" ?></td>
                    <td>$
                        <?php
                        $totalProducto = $product['net_cost'] * $product['quantity'];
                        echo number_format($totalProducto, 2) ?>
                    </td>
                    <td class="d-flex col">
                        <button class="btn btn-warning btn-sm me-2 editProductBtn" data-id="<?= $product['id']; ?>" data-name="<?= htmlspecialchars($product['name']); ?>" data-description="<?= $product['description']; ?>" data-category="<?= $product['id_category']; ?>" data-brand="<?= $product['id_brand']; ?>" data-cost="<?= number_format($product['net_cost'], 2); ?>" data-quantity="<?= $product['quantity']; ?>" data-status="<?= $product['status'] ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-success btn-sm me-2 addProductIncoming" data-id="<?= htmlspecialchars($product['id']); ?>" data-name="<?= htmlspecialchars($product['name']); ?>" data-quantity="<?= $product['quantity']; ?>">
                            <i class="bi bi-plus-lg"></i>
                        </button>
                        <button class="btn btn-danger btn-sm me-2 addProductSale" data-id="<?= htmlspecialchars($product['id']); ?>" data-name="<?= htmlspecialchars($product['name']); ?>" data-quantity="<?= $product['quantity']; ?>">
                            <i class="bi bi-dash-lg"></i>
                        </button>
                        <button class="btn btn-secondary btn-sm changeStatusProduct" data-id="<?= htmlspecialchars($product['id']); ?>" data-status="<?= ($product['status'] === 1) ? "Inactivo" : "Activo" ?>">
                            <i class="bi bi-eye-fill"></i>
                        </button>
                    </td>
                </tr>
                <?php $totalProductos += $totalProducto ?>
                <?php $totalCantidad += $product['quantity'] ?>

            <?php endforeach; ?>

        <?php else: ?>
        <?php endif; ?>
    </tbody>
</table>
<span><b><?php echo "Total Invertido en Productos: " . $totalProductos ?></b></span>
<br>
<span><b><?php echo "Total de cantidad de Productos: " . $totalCantidad ?></b></span>
<br>
<span><b><?php echo "Total de cantidad de Registros de Productos sin cantidad: " . $count ?></b></span>

<script>
    $(document).ready(function() {
        $('#tablaProductosCost').DataTable();
    })
</script>