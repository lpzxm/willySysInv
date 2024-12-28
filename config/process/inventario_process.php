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
}
