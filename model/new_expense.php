<?php
// Inicia la sesión si aún no está activa.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluye el archivo de conexión a la base de datos.
include '../config/dbconnection.php';

// Verifica si el usuario ha iniciado sesión.
if (!isset($_SESSION['detsuid'])) {
    // Si el usuario no ha iniciado sesión, lo redirige a la página de inicio.
    header('location: ../index.php');
    exit;
}

class agregarGastos
{
    // Variable para almacenar la conexión a la base de datos.
    private $con;
    // Constructor para inicializar la conexión a la base de datos
    public function __construct($con)
    {
        $this->con = $con; // Asigna la conexión proporcionada a la variable de la clase.
    }

    // Método para agregar un gasto.
    public function addExpense()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return; // No continuar si el formulario no se ha enviado.
        }

        // Función para validar la fecha.
        function validateDate($date, $format = 'Y-m-d')
        {
            $dateTime = DateTime::createFromFormat($format, $date);
            return $dateTime && $dateTime->format($format) === $date;
        }

        // Recupera los datos del formulario y los limpia.
        $date = mysqli_real_escape_string($this->con, $_POST['date']);
        $item_name = mysqli_real_escape_string($this->con, $_POST['item_name']);
        $item_cost = mysqli_real_escape_string($this->con, $_POST['item_cost']);

        // Valida y limpia los datos.
        if (empty($date)) {
            $_SESSION['new_expense_error'] = "Por favor, rellena todos los campos.";
        } elseif (!validateDate($date) || strtotime($date) > time()) {
            $_SESSION['new_expense_error'] = "La fecha del gasto debe ser igual o anterior a la fecha actual.";
        } elseif (empty($item_name) || empty($item_cost)) {
            $_SESSION['new_expense_error'] = "Por favor, rellena todos los campos.";
        } elseif ($item_cost <= 0) {
            $_SESSION['new_expense_error'] = "El precio del artículo debe ser positivo.";
        } else {
            // Inserta los datos en la base de datos.
            $user_id = $_SESSION['detsuid'];
            $query = "INSERT INTO tb_expense (User_ID, Expen_Date, Expen_item_name, Expen_Price) 
                      VALUES('$user_id', '$date', '$item_name', '$item_cost')";
            mysqli_query($this->con, $query);
            $_SESSION['new_expense'] = "Has agregado un nuevo gasto.";
            header('location: new_expense.php');
            exit;
        }
    }
}

// Verifica si la solicitud es del tipo POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crea una instancia de agregarGastos y llama al método addExpense.
    $expenseManager = new agregarGastos($con);
    $expenseManager->addExpense();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de gestión de gastos - Nuevo gasto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <!-- Incluir encabezado -->
    <?php include_once '../view/layout/header.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Incluye la barra lateral -->
            <?php include '../view/layout/sidebar.php'; ?>
            <!-- Formulario para agregar un nuevo gasto -->
            <div class="col-md-8">
                <div class="container mt-5 d-flex justify-content-center">
                    <div>
                        <h2>Agregar un nuevo gasto</h2>
                        <!-- Mensaje de éxito -->
                        <?php if (isset($_SESSION['new_expense'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $_SESSION['new_expense']; ?>
                            </div>
                            <?php unset($_SESSION['new_expense']); ?>
                        <?php endif; ?>
                        <!-- Mensaje de error -->
                        <?php if (isset($_SESSION['new_expense_error'])): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['new_expense_error']; ?>
                            </div>
                            <?php unset($_SESSION['new_expense_error']); ?>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                            <div class="mb-3 mt-3">
                                <label for="date" class="form-label">Fecha del gasto</label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="item_name" class="form-label">Nombre del artículo</label>
                                <input type="text" class="form-control" id="item_name" name="item_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="item_cost" class="form-label">Precio del artículo</label>
                                <input type="number" class="form-control" id="item_cost" name="item_cost" required
                                    step="0.01">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-secondary">Enviar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluir pie de página -->
    <?php include_once '../view/layout/footer.php'; ?>
    <script>
        // Código JavaScript para ocultar las alertas después de un tiempo.
        document.addEventListener('DOMContentLoaded', function () {

            // Oculta la alerta de éxito después de 5 segundos.
            const successAlert = document.querySelector('.alert-success');
            if (successAlert) {
                setTimeout(function () {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        });

        document.addEventListener('DOMContentLoaded', function () {

            // Oculta la alerta de error después de 5 segundos.
            const successAlert = document.querySelector('.alert-danger');
            if (successAlert) {
                setTimeout(function () {
                    successAlert.style.display = 'none';
                }, 5000);
            }
        });

    </script>
</body>

</html>