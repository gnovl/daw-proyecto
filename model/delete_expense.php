<?php
// Iniciar la sesión.
session_start();

// Incluyo archivo de conexión a la base de datos.
include '../config/dbconnection.php';


class eliminadorGastos
{
    private $con;
    // Constructor para inicializar la conexión a la base de datos.
    public function __construct($con)
    {
        $this->con = $con;
    }
    // Método para eliminar un gasto.
    public function removeExpense()
    {
        // Verifica si el usuario ha iniciado sesión.
        if (!isset($_SESSION['detsuid'])) {
            // Si no ha iniciado sesión, lo redirige a la página de inicio.
            header('location: ../index.php');
            exit;
        }

        // Verifica si se proporciona el ID del gasto en los parámetros de la consulta.
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            // ID de gasto inválido o faltante, se redirige a my_expenses.php
            header('location: ../view/expenses/my_expenses.php');
            exit;
        }

        // Recupera el ID del gasto de los parámetros de la consulta.
        $expense_id = $_GET['id'];

        // Construye la consulta para eliminar el gasto correspondiente al ID proporcionado.
        $sql = "DELETE FROM tb_expense WHERE ID = '$expense_id'";

        // Ejecuta la consulta DELETE en la base de datos.
        if (mysqli_query($this->con, $sql)) {
            // Si el gasto se elimina correctamente, muestra un mensaje de éxito y redirige al usuario a la página de sus gastos.
            $_SESSION['expense_removed_success'] = "Has eliminado un gasto de tu lista.";
            header('location: ../view/expenses/my_expenses.php');
            exit;
        } else {
            // Si ocurre un error al eliminar el gasto, muestra un mensaje de error.
            echo "Error: " . mysqli_error($this->con);
        }

        // Cierra la conexión a la base de datos.
        mysqli_close($this->con);
    }
}

// Verifica si la solicitud es del tipo GET.
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Crea una instancia del eliminadorGastos y llama al método removeExpense para procesar la eliminación del gasto.
    // Crea un objeto de la clase eliminadorGastos y le pasa la conexión a la base de datos.
    $expenseRemover = new eliminadorGastos($con);
    // Llama al método removeExpense para eliminar el gasto.
    $expenseRemover->removeExpense();
}