<?php
// Verifica si la sesión no está activa.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Desactiva la visualización de errores para los usuarios.
error_reporting(0);
// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Verifica si el usuario está autenticado.
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
    <!-- Incluye el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg">
        <div class="container-fluid">
            <!-- Enlace de la barra de navegación que lleva al panel de control -->
            <a class="navbar-brand mx-auto" href="/daw_project/view/dashboard/dashboard.php">SISTEMA DE GESTIÓN DE
                GASTOS | ILERNA 2024</a>
        </div>
    </nav>
</body>

</html>