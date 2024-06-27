<?php
// Inicia la sesión de PHP.
session_start();

// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Definición de la clase verGastos
class verGastos
{
    private $con;
    // Constructor que recibe la conexión a la base de datos.

    public function __construct($con)
    {
        $this->con = $con;
    }
    // Método para mostrar los gastos del usuario.
    public function displayExpenses()
    {
        // Verifica si el usuario está autenticado.
        if (!isset($_SESSION['detsuid'])) {
            // Si el usuario no está autenticado, redirecciona a la página de inicio de sesión.
            header('location: ../../index.php');
            exit;
        }

        // Obtiene el ID del usuario de la sesión.
        $user_id = $_SESSION['detsuid'];

        // Consulta los gastos del usuario actual
        $sql = "SELECT * FROM tb_expense WHERE User_ID = '$user_id'";
        $result = mysqli_query($this->con, $sql);

        // Verifica si se encontraron gastos.
        if (mysqli_num_rows($result) == 0) {
            // Establece una variable de sesión para el mensaje.
            $_SESSION['no_expenses_message'] = "No se encontraron gastos. Añade tus gastos desde la sección 'Gastos'";
        }

        // Calcula el total de gastos.
        $total_expenses = 0;
        $expensesHtml = '';
        // Itera sobre los resultados de la consulta.
        while ($row = mysqli_fetch_assoc($result)) {
            // Construye filas HTML de la tabla de gastos.
            $expensesHtml .= "<tr>";
            $expensesHtml .= "<td>" . $row['ID'] . "</td>";
            $expensesHtml .= "<td>" . $row['User_ID'] . "</td>";
            $expensesHtml .= "<td>" . $row['Expen_Date'] . "</td>";
            $expensesHtml .= "<td>" . $row['Expen_item_name'] . "</td>";
            $expensesHtml .= "<td>" . number_format($row['Expen_Price'], 2, ',', '.') . " €</td>";
            // Agrega un botón para eliminar con un diálogo de confirmación.
            $expensesHtml .= "<td class='d-flex justify-content-center'><button onclick='confirmDelete(" . $row['ID'] . ")' class='btn btn-danger'>Eliminar</button></td>";
            $expensesHtml .= "</tr>";

            // Actualiza el total de gastos.
            $total_expenses += $row['Expen_Price'];
        }

        // Agrega una fila para mostrar el total de gastos.
        $expensesHtml .= "<tr>";
        $expensesHtml .= "<td colspan='4' class='text-end'><strong>Total:</strong></td>";
        $expensesHtml .= "<td><strong>" . number_format($total_expenses, 2, ',', '.') . " €</strong></td>";
        $expensesHtml .= "<td></td>"; // Celda vacía para la columna de acciones.
        $expensesHtml .= "</tr>";

        // Cierra la conexión a la base de datos.
        mysqli_close($this->con);
        // Retorna el HTML generado para mostrar los gastos.
        return $expensesHtml;
    }
}

// Creación de una instancia de la clase verGastos.
$expenseDisplay = new verGastos($con);
// Llama al método para mostrar los gastos y guarda el HTML resultante.
$expensesHtml = $expenseDisplay->displayExpenses();
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>SISTEMA DE GESTION DE GASTOS - Todos mis gastos</title>
    <!-- Incluye el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Incluye el encabezado -->
    <?php include_once '../layout/header.php'; ?>
    <div class='container-fluid'>
        <div class='row vh-100'>
            <!-- Incluye la barra lateral -->
            <?php include_once '../layout/sidebar.php'; ?>
            <div class='col-md-9 col-lg-10'>
                <div class='container mt-5'>
                    <!-- Mensaje de éxito -->
                    <?php if (isset($_SESSION['expense_removed_success'])): ?>
                        <div class="alert alert-info" role="alert">
                            <?php echo $_SESSION['expense_removed_success']; ?>
                        </div>
                        <?php unset($_SESSION['expense_removed_success']); ?>
                    <?php endif; ?>
                    <h2 class='mb-4'>Todos mis gastos</h2>
                    <div class='table-responsive'>
                        <!-- Mensaje de error -->
                        <?php if (isset($_SESSION['no_expenses_message'])): ?>
                            <div class="alert alert-info" role="alert">
                                <?php echo $_SESSION['no_expenses_message']; ?>
                            </div>
                            <?php unset($_SESSION['no_expenses_message']); ?>
                        <?php endif; ?>
                        <table class='table table-striped table-bordered'>
                            <thead class='table-light'>
                                <tr>
                                    <th>ID</th>
                                    <th>ID del Usuario</th>
                                    <th>Fecha del gasto</th>
                                    <th>Nombre del artículo</th>
                                    <th>Precio</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php echo $expensesHtml; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- Incluye el pie de página -->
            <?php include_once '../layout/footer.php'; ?>
        </div>
    </div>
    <script>
        // Función para confirmar la eliminación de un gasto
        function confirmDelete(expenseId) {
            if (confirm("¿Estás seguro de que quieres eliminar este gasto?")) {
                // Si el usuario confirma, redirecciona a delete_expense.php con el ID del gasto
                window.location.href = "../../model/delete_expense.php?id=" + expenseId;
            }
        }

        // Código JavaScript para ocultar las alertas después de 5 segundos.
        document.addEventListener('DOMContentLoaded', function () {

            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function (alert) {
                setTimeout(function () {
                    alert.style.display = 'none';
                }, 5000);
            });
        });
    </script>

</body>

</html>