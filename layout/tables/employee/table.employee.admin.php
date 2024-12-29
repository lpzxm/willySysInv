<?php
include("../../../config/net.php");
try {
    // Consulta a la base de datos
    $queryEmpleados = "SELECT * FROM employee";
    $stmtEmpleados = $pdo->prepare($queryEmpleados);
    $stmtEmpleados->execute();
    $empleados = $stmtEmpleados->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

<table class="table table-striped table-hover" id="tablaEmpleadosData">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Fecha de nacimiento</th>
            <th>Fecha de inicio en labores</th>
            <th>DUI</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($empleados)): ?>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($empleado['id']); ?></td>
                    <td><?= htmlspecialchars($empleado['name1'] . " " . $empleado['name2'] . " " . $empleado['lastname1'] . " " . $empleado['lastname2']); ?></td>
                    <td><?= htmlspecialchars($empleado['email']); ?></td>
                    <td><?= htmlspecialchars($empleado['type']); ?></td>
                    <td><?= htmlspecialchars((new DateTime($empleado['birthday']))->format('d/m/y')); ?></td>
                    <td><?= ($empleado['startTime'] === NULL) ? "" : (new DateTime($empleado['startTime']))->format('d/m/y'); ?></td>
                    <td><?= htmlspecialchars($empleado['DUI']); ?></td>
                    <td><?= ($empleado['status'] === 1) ? "Activo" : "Inactivo" ?></td>
                    <td class="d-flex col">
                        <button class="btn btn-primary btn-sm me-2 editEmployeeBtn" data-id="<?= $empleado['id']; ?>" data-firstname="<?= $empleado['name1']; ?>" data-secondname="<?= $empleado['name2']; ?>" data-lastname1="<?= $empleado['lastname1']; ?>" data-lastname2="<?= $empleado['lastname2']; ?>" data-dui="<?= $empleado['DUI']; ?>" data-birthday="<?= $empleado['birthday']; ?>" data-startday="<?= $empleado['startTime']; ?>" data-email="<?= $empleado['email']; ?>" data-rol="<?= $empleado['type']; ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-primary btn-sm me-2 changePasswordBtn" data-id="<?= htmlspecialchars($empleado['id']); ?>">
                            <i class="bi bi-key"></i>
                        </button>
                        <button class="btn btn-danger btn-sm changeStatusEmployee" data-id="<?= htmlspecialchars($empleado['id']); ?>" data-status="<?= ($empleado['status'] === 1) ? "Inactivo" : "Activo" ?>">
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
        $('#tablaEmpleadosData').DataTable();
    })
</script>