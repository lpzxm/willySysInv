<?php
// include("../config/net.php");
if ($action == 'login') {
    $username = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Preparar la consulta para obtener el usuario
        $query = "SELECT * FROM employee WHERE email = :n1 LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':n1', $username, PDO::PARAM_STR);
        $stmt->execute();

        // Verificar si el usuario existe
        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar la contraseña usando password_verify
            if (password_verify($password, $user['password'])) {

                session_start();
                // Contraseña válida: iniciar sesión
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['status'] = $user['status'];
                $_SESSION['type'] = $user['type'];
                echo true;
            } else {
                echo false;
            }
        } else {
            echo false;
        }
    } catch (PDOException $e) {
        $error = "Error de conexión: " . $e->getMessage();
    }
} else if ($action == 'logout') {
    
}
