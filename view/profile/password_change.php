<?php

// Incluye archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

class cambiarContrasenia
{
    private $con;

    public function __construct($con)
    {
        // Verifica si la sesión no está activa.
        if (session_status() === PHP_SESSION_NONE) {
            session_start(); // Inicia la sesión si no está activa.
        }

        $this->con = $con;

        // Verifica si el usuario está autenticado.
        if (!isset($_SESSION['detsuid'])) {
            // Si no está autenticado, redirecciona a la página de inicio de sesión.
            header('location: ../../index.php');
            exit; // Finaliza la ejecución del script.
        }
    }

    public function changePassword()
    {
        // Procesa el cambio de contraseña si el método de solicitud es POST.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];

            // Verifica si todos los campos se han rellenado.
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $_SESSION['password_change_error'] = "Por favor rellena todos los campos.";
                header("Location: password_change.php");
                exit;
            }

            // Verifica si la nueva contraseña coincide con la confirmación de contraseña.
            if ($new_password !== $confirm_password) {
                $_SESSION['password_change_error'] = "La contraseña nueva no coincide con la de confirmación.";
                header("Location: password_change.php");
                exit;
            }

            // Obtiene el ID del usuario.
            $user_id = $_SESSION['detsuid'];

            // Verifica si la contraseña actual coincide con la almacenada en la base de datos.
            $query = "SELECT Password FROM tb_user WHERE ID = ?";
            $stmt = $this->con->prepare($query);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if (!password_verify($current_password, $user['Password'])) {
                $_SESSION['password_change_error'] = "La contraseña actual es incorrecta.";
                header("Location: password_change.php");
                exit;
            }

            // Actualiza la contraseña en la base de datos.
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE tb_user SET Password = ? WHERE ID = ?";
            $stmt = $this->con->prepare($update_query);
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $_SESSION['password_change_success'] = "Has cambiado tu contraseña exitosamente.";
                header("Location: password_change.php?success=true");
                exit;
            }
        }
    }
}

// Instancia cambiarContrasenia
$userPasswordChanger = new cambiarContrasenia($con);

// Llama al método changePassword
$userPasswordChanger->changePassword();


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SISTEMA DE GESTIÓN DE GASTOS - CAMBIAR CONTRASEÑA</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

</head>

<body>
    <!-- Incluye encabezado -->
    <?php include '../layout/header.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Incluye la barra lateral -->
            <?php include '../layout/sidebar.php'; ?>
            <!-- Formulario de cambio de contraseña -->
            <div class="col-md-8">
                <div class="container mt-5 col-md-8">
                    <!-- Mensaje de error -->
                    <?php if (isset($_SESSION['password_change_error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['password_change_error']; ?>
                        </div>
                        <?php unset($_SESSION['password_change_error']); ?>
                    <?php endif; ?>
                    <!-- Mensaje de éxito -->
                    <div id="success-message" class="alert alert-success d-none" role="alert">
                        Has cambiado tu contraseña correctamente.
                    </div>
                    <h2>Cambiar contraseña</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Tu contraseña actual</label>
                            <input type="password" class="form-control" id="current_password" name="current_password"
                                autocomplete="current-password" required>
                        </div>
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña</label>
                            <input type="password" class="form-control" id="new_password" name="new_password"
                                autocomplete="new-password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                                autocomplete="new-password" required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Cambiar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluye pie de página -->
    <?php include '../layout/footer.php'; ?>
    <script>
        // Verifica si la URL tiene un parámetro de éxito.
        const urlParams = new URLSearchParams(window.location.search);
        const successParam = urlParams.get('success');

        // Si el parámetro de éxito está presente y es true, muestra el mensaje de éxito.
        if (successParam === 'true') {
            document.addEventListener('DOMContentLoaded', function () {
                const successMessage = document.getElementById('success-message');
                successMessage.classList.remove('d-none');


                // Oculta el mensaje de éxito después de 5 segundos.
                setTimeout(function () {
                    successMessage.classList.add('d-none');
                }, 5000);


            });
        }

        // Verifica si el mensaje de error está presente y luego lo muestra y oculta después de 5 segundos.
        const errorMessage = document.querySelector('.alert-danger');
        if (errorMessage) {
            errorMessage.classList.remove('d-none');

            // Oculta el mensaje de error después de 5 segundos.
            setTimeout(function () {
                errorMessage.classList.add('d-none');
            }, 5000);
        }
    </script>
</body>

</html>