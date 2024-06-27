<?php
// Verifica si la sesión no está activa.
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está activa.
}
// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['detsuid'])) {
    // Si el usuario no está autenticado, redirecciona a la página de inicio de sesión.
    header('location: ../../index.php');
    exit; // Termina la ejecución del script.
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluye el CDN de la librería Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>

    <footer class="bg-dark text-center text-sm text-light py-2">
        <div class="container">
            <!-- Pie de página con información sobre el sistema -->
            <p class="m-0" style="font-size: smaller;">Sistema de Gestión de Gastos. Desarrollado para ILERNA. 2024</p>
        </div>
    </footer>
</body>

</html>