<?php
session_start(); // Inicia la sesión para mantener la información del usuario entre las páginas.

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA DE GESTIÓN DE GASTOS - ILERNA 2024 - INICIO</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">

            <?php
            // Comprueba si el parámetro de mensaje de cierre de sesión está establecido en la URL.
            if (isset($_GET['logout_success']) && $_GET['logout_success'] === 'true') {
                // Muestra el mensaje de cierre de sesión exitoso.
                echo '<div class="alert alert-info text-center" role="alert">Has cerrado sesión correctamente.</div>';
            }

            // Comprueba si se estableció el mensaje de acceso denegado.
            if (isset($_SESSION['access_denied'])) {
                echo '<div class="alert alert-info text-center" role="alert">';
                echo $_SESSION['access_denied'];
                echo '</div>';
                // Elimina la variable de sesión para evitar que se muestre nuevamente al actualizar la página.
                unset($_SESSION['access_denied']);
            }


            // Comprueba si se estableció el mensaje de eliminación de cuenta exitosa.
            if (isset($_SESSION['delete_account_success'])) {
                echo '<div class="alert alert-info text-center" role="alert">';
                echo $_SESSION['delete_account_success'];
                echo '</div>';
                // Elimina la variable de sesión para evitar que se muestre nuevamente al actualizar la página.
                unset($_SESSION['delete_account_success']);
            }
            ?>

            <div class="col-md-6">
                <h2 class="text-center mb-4 bg-dark text-white py-2">SISTEMA DE GESTIÓN DE GASTOS</h2>
                <!-- Mensaje de error -->
                <?php if (isset($_SESSION['login_error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $_SESSION['login_error']; ?>
                    </div>
                    <?php unset($_SESSION['login_error']); ?>
                <?php endif; ?>
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center text-black">Iniciar sesión</h2>
                        <form id="loginForm" action="controller/login_process.php" method="post" autocomplete="on"
                            novalidate>
                            <div class="form-group">
                                <label for="email">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required
                                    autocomplete="email">
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                    autocomplete="current-password">
                            </div>
                            <button type="submit" class="btn btn-secondary btn-block mt-3"
                                name="login">Ingresar</button>
                        </form>
                        <p class="text-center mt-3">No tienes una cuenta? <a href="/daw_project/view/auth/register.php"
                                id="registerLink">Registrarse</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Código JavaScript para ocultar las alertas después de un tiempo.
        document.addEventListener('DOMContentLoaded', function () {

            // Oculta la alerta de error después de 5 segundos.
            const errorAlert = document.querySelector('.alert-danger');
            if (errorAlert) {
                setTimeout(function () {
                    errorAlert.style.display = 'none';
                }, 5000);
            }

            // Oculta la alerta de éxito después de 5 segundos.
            const successAlert = document.querySelector('.alert.alert-info');
            if (successAlert) {
                setTimeout(function () {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        });

    </script>
</body>

</html>