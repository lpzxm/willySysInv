<?php
if (isset($_SESSION['user_id'])) {
    // redirigir a la vista ya autorizada mediante la sesion
    echo "<script>window.location.href = 'http://localhost/?view=main';</script>";
}
?>

<style>
    body {
        background-color: #f4f7fc;
        font-family: 'Arial', sans-serif;
    }

    .login-container {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-card {
        background-color: #fff;
        padding: 50px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
    }

    .login-card h3 {
        color: #007bff;
        margin-bottom: 30px;
    }

    .form-control {
        border-radius: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }

    .forgot-password {
        text-align: center;
        margin-top: 10px;
    }

    .forgot-password a {
        color: #007bff;
        text-decoration: none;
    }

    .forgot-password a:hover {
        text-decoration: underline;
    }
</style>
<div class="login-container">
    <div class="login-card">
        <h3 class="text-center">Iniciar Sesión</h3>

        <!-- Correo electrónico -->
        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" class="form-control mb-2" id="email" name="email" placeholder="Introduce tu correo" required>
        </div>
        <!-- Contraseña -->
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña" required>
        </div>
        <!-- Botón de login -->
        <button type="submit" class="btn btn-primary btn-block mt-2" id="logginBtn">Iniciar sesión</button>
    </div>
</div>
<script>
    $('#logginBtn').click(function() {
        let email = $("#email").val();
        let password = $("#password").val();

        $.post("config/modules.php", {
            process: "login",
            action: "login",

            email: email,
            password: password
        }, function(response) {
            if (response == 1) {
                window.location.href = "http://localhost/?view=main";
            } else {
                $.toast({
                    heading: 'Advertencia',
                    text: 'El usuario o contraseña ingresados son incorrectos',
                    showHideTransition: 'slide',
                    icon: 'warning',
                    textColor: 'white',
                    hideAfter: 5000,
                    bgColor: '#B80000',
                    position: 'top-center'
                });
            }
        })
    });
</script>