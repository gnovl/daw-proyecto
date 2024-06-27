<?php
// Inicia la sesión.
session_start();

// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Verifica si el usuario ha iniciado sesión.
if (!isset($_SESSION['detsuid'])) {
    // Si no ha iniciado sesión, redirige a la página de inicio de inicio.
    header('location: ../../index.php');
    exit;
}

// Recupera el ID del usuario.
$user_id = $_SESSION['detsuid'];

// Consulta para calcular el total de gastos del usuario.
$sql = "SELECT SUM(Expen_Price) AS total_expenses FROM tb_expense WHERE User_ID = $user_id";

// Ejecuta la consulta.
$result = mysqli_query($con, $sql);

// Verifica si la consulta fue exitosa.
if ($result) {
    // Obtiene el total de gastos.
    $row = mysqli_fetch_assoc($result);
    $total_expenses = $row['total_expenses'];

    // Verifica si el total de gastos es nulo (no hay gastos registrados).
    if ($total_expenses === null) {
        $total_expenses = 0;
    }
} else {
    // Maneja el fallo de la consulta.
    echo "Error: " . mysqli_error($con);
    // Establece el total de gastos en 0 en caso de fallo de la consulta.
    $total_expenses = 0;
}

// Cierra la conexión a la base de datos.
mysqli_close($con);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA DE GESTIÓN DE GASTOS - ILERNA 2024 - PANEL DE CONTROL</title>
    <!-- Incluye el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Incluye el encabezado -->
    <?php include_once '../layout/header.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Incluye la barra lateral -->
            <?php include '../layout/sidebar.php'; ?>
            <!-- Contenido panel de control -->
            <div class="col-md-6 col-lg-8">
                <div class="container mt-5 mb-5">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4">
                            <!-- Resumen de gastos -->
                            <h3 class="mb-4 text-center bg-light text-info py-2">Resumen de gastos</h3>
                            <div class="card border border-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Gastos Totales</h5>
                                    <p class="card-text">
                                        <?php echo number_format($total_expenses, 2, ',', '.'); ?> €
                                    </p>
                                    <p>Desde el menu puedes consultar tus gastos en detalle. Tambien puedes ver un
                                        informe de tus gastos en un periodo determinado.</p>
                                    <a href="../expenses/my_expenses.php" class="btn btn-light">Ver detalles</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluye el pie de página -->
    <?php include_once '../layout/footer.php'; ?>
</body>


</html>