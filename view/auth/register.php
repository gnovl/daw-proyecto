<?php
// Inicia la sesión para manejar variables de sesión.
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA DE GESTIÓN DE GASTOS- REGISTRARSE</title>
    <!-- Incluye el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <!-- Título de la página -->
        <h2 class="text-center mb-4 bg-dark text-white py-2"">SISTEMA DE GESTIÓN DE GASTOS</h1>
        <a href=" /daw_project/">←volver</a>
            <div class=" row justify-content-center mt-3">
                <div class="col-md-6">
                    <!-- Mensaje de error -->
                    <?php if (isset($_SESSION['register_error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['register_error']; ?>
                        </div>
                        <?php unset($_SESSION['register_error']); ?>
                    <?php endif; ?>
                    <div class="card">
                        <div class="mx-auto mt-2">
                            <h5 class="card-title">Registrarse</h5>
                        </div>
                        <div class="card-body">
                            <form action="../../controller/register_process.php" method="post" novalidate>
                                <div class="form-group">
                                    <label for="fullName">Nombre</label>
                                    <input type="text" class="form-control" id="fullName" name="fullName" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        autocomplete="email">
                                </div>
                                <div class="form-group mt-3">
                                    <label for="mobile">Teléfono</label>
                                    <input type="text" class="form-control" id="mobile" name="mobile"
                                        autocomplete="mobile" required>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="password">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        autocomplete="current-password">
                                </div>
                                <div class=" form-group mt-3">
                                    <label for="confirmPassword">Confirmar contraseña</label>
                                    <input type="password" class="form-control" id="confirmPassword"
                                        name="confirmPassword" required autocomplete="current-password">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" class="btn btn-secondary mt-3">Registrarse</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <script>
        // Código JavaScript para ocultar las alertas después de 5 segundos.
        document.addEventListener('DOMContentLoaded', function () {

            const errorAlert = document.querySelector('.alert-danger');
            if (errorAlert) {
                setTimeout(function () {
                    errorAlert.style.display = 'none';
                }, 5000);
            }
        });

    </script>
</body>

</html>