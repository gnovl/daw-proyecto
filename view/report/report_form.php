<?
// Inicia la sesión.
session_start();

// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Verifica si el usuario está autenticado
if (!isset($_SESSION['detsuid'])) {
    // Si el usuario no está autenticado, redirige a la página de inicio de sesión y finaliza la ejecución del script.
    header('location: ../../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gestión de gastos - Informe de gastos</title>
    <!-- Incluye el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">


</head>

<body>
    <!-- Incluye el encabezado -->
    <?php include_once '../layout/header.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100 ">
            <!-- Incluye la barra lateral -->
            <?php include '../layout/sidebar.php'; ?>
            <!-- Formulario de informe de gastos -->
            <div class="col-md-8">
                <div class="container mt-5 d-flex justify-content-center">
                    <form action="../../controller/gen_report.php" method="POST" novalidate>
                        <!-- Título del formulario -->
                        <h2>Generar un informe de gastos</h2>
                        <!-- Campo de entrada para la fecha de inicio -->
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Fecha de inicio:</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <!-- Campo de entrada para la fecha de fin -->
                        <div class="mb-3">
                            <label for="end_date" class="form-label">Hasta la fecha:</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                        <!-- Botón para enviar el formulario -->
                        <button type="submit" class="btn btn-secondary">Generar informe</button>
                    </form>
                </div>
            </div>
        </div>
    </div>4
    <!-- Incluye el pie de página -->
    <?php include_once '../layout/footer.php'; ?>
</body>

</html>