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
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($empleados)): ?>
            <?php foreach ($empleados as $empleado): ?>
                <tr>
                    <td><?php echo htmlspecialchars($empleado['id']); ?></td>
                    <td><?= htmlspecialchars($empleado['name1'] . " " . $empleado['name2'] . " " . $empleado['name2'] . " " . $empleado['lastname1'] . " " . $empleado['lastname2']); ?></td>
                    <td><?= htmlspecialchars($empleado['email']); ?></td>
                    <td><?= htmlspecialchars($empleado['type']); ?></td>
                    <td><?= htmlspecialchars($empleado['birthday']); ?></td>
                    <td><?= $empleado['startTime'] ?></td>
                    <td><?= htmlspecialchars($empleado['DUI']); ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#editUserModal" data-id="<?= htmlspecialchars($empleado['id']); ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-primary btn-sm me-2 changePasswordBtn"  data-id="<?= htmlspecialchars($empleado['id']); ?>">
                            <i class="bi bi-key"></i>
                        </button>

                        <button class="btn btn-danger btn-sm" data-id="<?= htmlspecialchars($empleado['id']); ?>">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
    </tbody>
</table>