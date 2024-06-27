<?php
session_start();


// Incluimos el archivo de conexión a la base de datos.
include '../config/dbconnection.php';

class eliminarCuenta
{
    private $con;

    public function __construct($con)
    {
        // Comprobamos si la sesión aún no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->con = $con;

        // Comprobar si el usuario ha iniciado sesión.
        if (!isset($_SESSION['detsuid'])) {
            header('location: ../index.php');
            exit;
        }
    }

    public function deleteAccount()
    {
        // Procesamos la solicitud de eliminación de la cuenta de usuario.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['confirm_delete'])) {
                // Recuperamos ID del usuario.
                $user_id = $_SESSION['detsuid'];

                // Eliminamos los gastos del usuario antes de proceder con la eliminación de la cuenta.
                $delete_expenses_query = "DELETE FROM tb_expense WHERE User_ID = ?";
                $stmt = $this->con->prepare($delete_expenses_query);
                $stmt->bind_param("i", $user_id);
                if ($stmt->execute()) {
                    // Elminamos cuenta de usuario.
                    $delete_user_query = "DELETE FROM tb_user WHERE ID = ?";
                    $stmt = $this->con->prepare($delete_user_query);
                    $stmt->bind_param("i", $user_id);
                    if ($stmt->execute()) {
                        // Establecemos variable de sesión para notificar con un mensaje al usuario.
                        $_SESSION['delete_account_success'] = "Tu cuenta se ha eliminado correctamente.";
                    }
                }
                // Redirigir a la página de inicio de la aplicación.
                header('location: ../index.php');
                exit;
            } else {
                // Redirige de vuelta a la página de eliminación de cuenta si no se ha confirmado la eliminación.
                $_SESSION['delete_account_error'] = "Por favor, confirma que quieres eliminar tu cuenta.";
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    }
}

// Instancia un objeto de la clase eliminarCuenta y pasa la conexión a la base de datos como argumento.
$accountDeleter = new eliminarCuenta($con);

// Llama al método deleteAccount para procesar la eliminación de la cuenta.
$accountDeleter->deleteAccount();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SISTEMA DE GESTIÓN DE GASTOS - ELIMINAR CUENTA</title>
    <!-- Incluye la hoja de estilos de Bootstrap desde un CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <?php include '../view/layout/header.php'; ?>
    <!-- Contenedor principal -->
    <div class="container-fluid">
        <div class="row vh-100">
            <?php include '../view/layout/sidebar.php'; ?>
            <div class="col-md-10">
                <!-- Contenedor interno -->
                <div class="container mt-5 d-flex justify-content-center border py-4">
                    <!-- Formulario para eliminar la cuenta -->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <?php if (isset($_SESSION['delete_account_error'])): ?>
                            <!-- Mostramos mensaje de error si existe -->
                            <div id="error-message" class="alert alert-danger" role="alert">
                                <?php echo $_SESSION['delete_account_error']; ?>
                            </div>
                            <?php unset($_SESSION['delete_account_error']); ?>
                        <?php endif; ?>
                        <h2>Eliminar cuenta</h2>
                        <!-- Mensaje de confirmación -->
                        <p>Estás seguro/a de que quieres eliminar tu cuenta?</p>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="confirm_delete"
                                name="confirm_delete" required>
                            <label class="form-check-label" for="confirm_delete">
                                Sí, quiero eliminar mi cuenta.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-danger mt-3">Eliminar cuenta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Pie de página -->
    <?php include '../view/layout/footer.php'; ?>
    <!-- Script para ocultar el mensaje de error después de unos segundos -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>

</html>