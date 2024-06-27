<?php

class informeGastos
{

    public function displayReport()
    {

        session_start();

        // Incluimos el archivo de conexión a la base de datos.
        include '../config/dbconnection.php';

        // Verificamos si el usuario ha iniciado sesión.
        if (!isset($_SESSION['detsuid'])) {
            // Si no ha iniciado, redirige a la página de inicio de la aplicación.
            header('location: ../index.php');
            exit;
        }

        // Recuperar los datos del formulario.
        $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
        $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;

        // Obtener los gastos dentro del rango de fechas especificado.
        $sql = "SELECT * FROM tb_expense WHERE User_ID = '{$_SESSION['detsuid']}' AND Expen_Date BETWEEN '$start_date' AND '$end_date'";
        $result = mysqli_query($con, $sql);

        if ($result) {
            // Mostrar reporte si hay resultados.
            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<meta charset='UTF-8'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
            echo "<title>SISTEMA DE GESTIÓN DE GASTOS - INFORME DE GASTOS</title>";
            echo "<style>
        .footer-container {
            padding-top: 250px;
            padding-bottom: 20px; 
        }
      </style>"; // CSS personalizado para el pie de página
            echo "</head>";

            // Incluimos el encabezado. 
            include_once '../view/layout/header.php';


            echo "<div class='container-fluid'>";
            // Incluimos la barra lateral.
            echo "<div class='row vh-100'>";
            include '../view/layout/sidebar.php';


            // Contenedor para la tabla.
            echo "<div class='col-md-9 col-lg-10'>";
            // Mostrar el contenido del reporte basado en los resultados.
            if (mysqli_num_rows($result) > 0) {
                $this->displayExpenseTable($result, $start_date, $end_date); // Pasamos start_date y end_date al método.
            } else {
                echo "<div class='col-md-9 col-lg-10'>";
                echo "<div class='container mt-5'>";
                echo "<h2 class='mb-4'>Informe de gastos</h2>";

                // Mostrar un mensaje de error si existe.
                if (isset($_SESSION['expenses_report'])) {
                    echo "<div class='alert alert-info' role='alert'>";
                    echo $_SESSION['expenses_report'];
                    echo "</div>";
                    unset($_SESSION['expenses_report']); // Elimina después de mostrar.
                } else {
                    // Mostrar mensaje para cuando no se encuentren resultados para la fecha seleccionada.
                    echo "<div class='alert alert-danger text-center' role='alert'>";
                    echo "No se encontraron gastos para el rango de fechas seleccionado.";
                    echo "</div>";

                }

                echo "<a href='../view/report/report_form.php' class='btn btn-secondary mt-4 mb-4'>Generar nuevo informe</a>";
                echo "</div>";
                echo "</div>";
            }


            echo "</div>";

            // Cerrar contenedor principal.
            echo "</div>";

            echo "<div class='container-fluid footer-container'>";
            include_once '../view/layout/footer.php';
            echo "</div>";
            // Incluir pie de página y las etiquetas de cierre.
            echo "<script>
                setTimeout(function() {
                    document.querySelector('.alert').style.display = 'none';
                }, 5000);
            </script>";
            echo "</body>";
            echo "</html>";
        } else {
            // Manejamos error de la consulta.
            $_SESSION['expenses_report'] = "Error en la consulta de la base de datos.";
            header('location: gen_report.php');
            exit;
        }

        // Cerrar conexión a la base de datos.
        mysqli_close($con);
    }

    private function displayExpenseTable($result, $start_date, $end_date)
    {
        // Muestra la tabla de gastos.
        echo "<div class='col-md-9 col-lg-10'>";
        echo "<div class='container mt-5'>";
        echo "<h2 class='mb-4'>Informe de gastos</h2>";

        // Mostrar mensaje de error si existe.
        if (isset($_SESSION['expenses_report'])) {
            echo "<div class='alert alert-danger' role='alert'>";
            echo $_SESSION['expenses_report'];
            echo "</div>";
            unset($_SESSION['expenses_report']); // Eliminar después de mostrar.
        } else {
            echo "<div class='alert alert-info' role='alert'>";
            echo "Has generado un informe de gastos. Revísalo a continuación.";
            echo "</div>";
        }

        echo "<div class='table-responsive'>";
        echo "<h4 class='text-center text-info small py-3'>Informe de gastos desde $start_date a $end_date</h4>"; // Muesta rango de fechas seleccionado.
        echo "<table class='table table-striped table-bordered'>";
        echo "<thead class='table-light'><tr><th>ID</th><th>ID del usuario</th><th>Fecha del gasto</th><th>Nombre del artículo</th><th>Precio</th></tr></thead>";
        echo "<tbody>";
        $total_expense = 0; // Almacenamos gasto total.
        $row_count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $row_count++;
            $row_class = $row_count % 2 == 0 ? 'even' : 'odd';
            // Filas de la tabla.
            echo "<tr class='$row_class'>";
            echo "<td>" . $row['ID'] . "</td>";
            echo "<td>" . $row['User_ID'] . "</td>";
            echo "<td>" . $row['Expen_Date'] . "</td>";
            echo "<td>" . $row['Expen_item_name'] . "</td>";
            echo "<td>" . number_format($row['Expen_Price'], 2, ',', ' ') . " €</td>";
            echo "</tr>";
            $total_expense += $row['Expen_Price'];
        }

        // Muestra la fila del total general.
        echo "<tr><td colspan='4' style='text-align: right;'><strong>Suma Total:</strong></td><td><strong>" . number_format($total_expense, 2, ',', '.') . " €</strong></td></tr>";
        echo "</tbody></table>";
        echo "</div>";
    }
}

// Crea una instancia de la clase.
$expenseReport = new informeGastos();

// Muestra el informe.
$expenseReport->displayReport();
