<?php
// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

class actualizarPerfil
{
    private $con;
    private $user_id;
    private $user;
    private $user_role;

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

        // Obtiene el ID del usuario.
        $this->user_id = $_SESSION['detsuid'];

        // Obtiene los datos del usuario.
        $this->fetchUserData();
    }

    private function fetchUserData()
    {
        // Consulta para obtener la información del usuario.
        $query = "SELECT u.*, r.role_name FROM tb_user u LEFT JOIN tb_role r ON u.role_id = r.role_id WHERE u.ID = ?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("i", $this->user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtiene los datos del usuario.
        $this->user = $result->fetch_assoc();
        $this->user_role = $this->user['role_name'];
    }

    public function updateUserProfile()
    {
        // Procesa el envío del formulario.
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Valida los campos de entrada.
            if (empty($_POST['fullname']) || empty($_POST['email']) || empty($_POST['phone'])) {
                $error_message = "Por favor rellena los campos obligatorios.";
                $this->redirectWithError($error_message);
            } else {
                // Actualiza los datos del perfil del usuario en la base de datos.
                $fullname = $_POST['fullname'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];

                $update_query = "UPDATE tb_user SET Full_Name = ?, Email = ?, Phone_Num = ? WHERE ID = ?";
                $stmt = $this->con->prepare($update_query);
                $stmt->bind_param("sssi", $fullname, $email, $phone, $this->user_id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    // Redirecciona de nuevo a la página de perfil de usuario después de la actualización.
                    header("Location: user_profile.php?success=true");
                    exit;
                } else {
                    $error_message = "Tu perfil no se ha actualizado. Por favor intentalo de nuevo.";
                    $this->redirectWithError($error_message);
                }
            }
        }
    }

    private function redirectWithError($message)
    {
        header("Location: user_profile.php?error=true&message=" . urlencode($message));
        exit;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getUserRole()
    {
        return $this->user_role;
    }
}

// Instancia actualizarPerfil
$userProfileUpdater = new actualizarPerfil($con);

// Llama al método updateUserProfile
$userProfileUpdater->updateUserProfile();

// Obtiene los datos del usuario
$user = $userProfileUpdater->getUser();
$user_role = $userProfileUpdater->getUserRole();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SISTEMA DE GESTIÓN DE GASTOS - PERFIL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .wrapper {
            width: 350px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <!-- Incluye encabezado -->
    <?php include '../layout/header.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Incluye la barra lateral -->
            <?php include '../layout/sidebar.php'; ?>
            <!-- Formulario perfil de usuario -->
            <div class="col-md-8">
                <div class="container mt-5 col-md-8">
                    <!-- Mensaje de éxito -->
                    <div id="success-message" class="alert alert-success d-none mt-2  d-flex justify-content-center"
                        role="alert">
                        Tu perfil se ha actualizado.
                    </div>
                    <div id="error-message" class="alert alert-danger d-none mt-2 d-flex justify-content-center"
                        role="alert">
                        <?php echo isset($_GET['message']) ? $_GET['message'] : ''; ?>
                    </div>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" novalidate>
                        <h2>Actualizar perfil</h2>

                        <div class="mb-3">
                            <label for="fullname" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                value="<?php echo $user['Full_Name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="<?php echo $user['Email']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="<?php echo $user['Phone_Num']; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="user_role" class="form-label">Tipo de usuario</label>
                            <input type="text" class="form-control" id="user_role" name="user_role"
                                value="<?php echo $user_role; ?>" readonly style="background-color: #eee;">
                        </div>
                        <div class="mb-3">
                            <label for="signup_date" class="form-label">Fecha de registro</label>
                            <input type="text" class="form-control" id="signup_date"
                                value="<?php echo $user['signup_date']; ?>" readonly style="background-color: #eee;">
                        </div>
                        <button type="submit" class="btn btn-secondary">Actualizar</button>
                    </form>
                </div>
            </div>
            <!-- Incluye el pie de página -->
            <?php include '../layout/footer.php'; ?>
        </div>
    </div>
    <script>
        // Verifica si la URL tiene un parámetro de éxito.
        const urlParams = new URLSearchParams(window.location.search);
        const successParam = urlParams.get('success');
        const errorParam = urlParams.get('error');


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

        // Si el parámetro de error está presente y es true, muestra el mensaje de error.
        if (errorParam === 'true') {
            document.addEventListener('DOMContentLoaded', function () {
                const errorMessage = document.getElementById('error-message');
                errorMessage.classList.remove('d-none');

                // Oculta el mensaje de error después de 5 segundos.
                setTimeout(function () {
                    errorMessage.classList.add('d-none');
                }, 5000);

            });
        }
    </script>
</body>

</html>