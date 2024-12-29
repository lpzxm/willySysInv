<?php

if ($action == 'addNewEmployee') {
    try {
        $query = "INSERT INTO employee VALUES (NULL, :n1, :n2, :n3, :n4, :n5, :n6, :n7, :n8, :n9, :n10, CURRENT_TIMESTAMP, 1)";
        $insert = $pdo->prepare($query);

        // Asignar los valores a variables antes de pasarlos a bindParam
        $firstName = htmlspecialchars($_POST['firstName']);
        $secondName = htmlspecialchars($_POST['secondName']);
        $firstLastName = htmlspecialchars($_POST['firstLastName']);
        $secondLastName = htmlspecialchars($_POST['secondLastName']);
        $email = htmlspecialchars($_POST['email']) . "@willy.com";
        $hashedPassword = password_hash(htmlspecialchars($_POST['password']), PASSWORD_BCRYPT);
        $rolEmployee = htmlspecialchars($_POST['rolEmployee']);
        $birthDay = htmlspecialchars($_POST['birthDay']);
        $DUInumber = htmlspecialchars($_POST['DUInumber']);
        $startTime = !empty($_POST['startTime']) ? htmlspecialchars($_POST['startTime']) : NULL;

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $firstName);
        $insert->bindParam(':n2', $secondName);
        $insert->bindParam(':n3', $firstLastName);
        $insert->bindParam(':n4', $secondLastName);
        $insert->bindParam(':n5', $email);
        $insert->bindParam(':n6', $hashedPassword);
        $insert->bindParam(':n7', $rolEmployee);
        $insert->bindParam(':n8', $birthDay);
        $insert->bindParam(':n9', $DUInumber);
        $insert->bindParam(':n10', $startTime);
        $insert->execute();

        echo 1;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'changePasswordEmployee') {
    try {
        $query = "UPDATE employee set password = :n1 WHERE id = :n2";
        $insert = $pdo->prepare($query);
        $hashedPassword = password_hash(htmlspecialchars($_POST['newEditPassword']), PASSWORD_BCRYPT);
        $idEmployee = htmlspecialchars($_POST['idCodigoEmpleado']);

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $hashedPassword);
        $insert->bindParam(':n2', $idEmployee);
        $insert->execute();

        echo 1;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'updateStatusEmployee') {
    try {
        $queryState = "SELECT status FROM employee WHERE id = ?";
        $stmt = $pdo->prepare($queryState);
        $stmt->execute([$_POST['idcodigoEmpleado']]);

        if ($stmt->rowCount() > 0) {
            $estadoActual = $stmt->fetchColumn();
            if ($estadoActual == 1) {
                // Si el estado es 1, cambia a 0
                $updateQuery = "UPDATE employee SET status = 0 WHERE id = ?";
            } else {
                // Si el estado es 0, cambia a 1
                $updateQuery = "UPDATE employee SET status = 1 WHERE id = ?";
            }

            $updateStmt = $pdo->prepare($updateQuery);
            $updateStmt->execute([$_POST['idcodigoEmpleado']]);
            echo 1;
        } else {
            echo "Factura no encontrada.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else if ($action == 'updateRegisterEmployee') {
    try {
        $query = "UPDATE employee set name1 = :n1, name2 = :n2, lastname1 = :n3, lastname2 = :n4, type = :n6, birthday = :n7, DUI = :n8, startTime = :n9 where id = :n10";

        // Asignar los valores a variables antes de pasarlos a bindParam
        $idEmployee = htmlspecialchars(intval($_POST['idCodigoEmpleado']));
        $firstName = htmlspecialchars($_POST['firstName']);
        $secondName = htmlspecialchars($_POST['secondName']);
        $firstLastName = htmlspecialchars($_POST['firstLastName']);
        $secondLastName = htmlspecialchars($_POST['secondLastName']);
        $rolEmployee = htmlspecialchars($_POST['rolEmployee']);
        $birthDay = htmlspecialchars($_POST['birthDay']);
        $DUInumber = htmlspecialchars($_POST['DUInumber']);
        $startTime = !empty($_POST['startTime']) ? htmlspecialchars($_POST['startTime']) : NULL;

        $insert = $pdo->prepare($query);
        $insert->bindParam(':n1', $firstName);
        $insert->bindParam(':n2', $secondName);
        $insert->bindParam(':n3', $firstLastName);
        $insert->bindParam(':n4', $secondLastName);
        $insert->bindParam(':n6', $rolEmployee);
        $insert->bindParam(':n7', $birthDay);
        $insert->bindParam(':n8', $DUInumber);
        $insert->bindParam(':n9', $startTime);
        $insert->bindParam(':n10', $idEmployee);
        $insert->execute();
        echo 1;
    } catch (Exception $e) {
        echo "Error :" . $e->getMessage();
    }
} else if ($action == 'addNewCategory') {
    try {
        $query = "INSERT INTO product_category VALUES (NULL, :n1, :n2, CURRENT_TIMESTAMP, :n3)";
        $insert = $pdo->prepare($query);

        // Asignar los valores a variables antes de pasarlos a bindParam
        $nameCategory = htmlspecialchars($_POST['name']);
        $codeCategory = htmlspecialchars($_POST['code']);
        $statusCategory = htmlspecialchars($_POST['status']);

        // Pasar las variables a bindParam
        $insert->bindParam(':n1', $nameCategory);
        $insert->bindParam(':n2', $codeCategory);
        $insert->bindParam(':n3', $statusCategory);
        $insert->execute();

        echo 1;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
