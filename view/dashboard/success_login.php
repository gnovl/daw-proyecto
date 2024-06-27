<?php
session_start();

// Verifica si el usuario está autenticado.
if (!isset($_SESSION['detsuid'])) {
    // Si el usuario no está autenticado, redirecciona a la página de inicio de sesión.
    header('location: ../../index.php');
    exit; // Termina la ejecución del script para evitar que se procese más código.
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gestión de gastos - Ingreso exitoso</title>
    <!-- Se enlaza la hoja de estilos de Bootstrap desde un CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card alert border">
                    <div class="card-body">
                        <!-- Título de la tarjeta -->
                        <h2 class="card-title text-center">Ingreso correcto.</h2>
                        <!-- Mensaje de éxito del inicio de sesión -->
                        <p class="text-center">Has iniciado sesión correctamente en el sistema.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Redirige a la página de inicio después de 3 segundos
        setTimeout(function () {
            window.location.href = 'dashboard.php';
        }, 3000);
    </script>
</body>

</html>