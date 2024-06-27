<?php
// Iniciamos la sesión.
session_start();
// Incluye el archivo de conexión a la base de datos.
include '../config/dbconnection.php';

class Login
{
    private $con;

    // Constructor para inicializar la conexión a la base de datos.
    public function __construct($con)
    {
        $this->con = $con;
    }

    // Con este método manejamos el proceso de inicio de sesión.
    public function loginUser($email, $password)
    {
        // Verificar si los campos de email y contraseña están vacios.
        if (empty($email) || empty($password)) {
            $_SESSION['login_error'] = "Por favor, complete todos los campos obligatorios.";
            header('location: ../index.php');
            exit;
        }
        // Preparamos y ejecutamos la consulta para obtener el usuario con el email proporcionado.
        $stmt = $this->con->prepare("SELECT ID, Password, role_id FROM tb_user WHERE Email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        // Verificamos si se ha encontrado un usuario con el email proporcionado.
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashed_password = $user['Password'];
            // Verificar si la contraseña proporcionada coincide con la contraseña almacenada en la base de datos.
            if (password_verify($password, $hashed_password)) {
                // Establece las variables de sesión para el ID de usuario y el rol. 
                $_SESSION['detsuid'] = $user['ID'];
                $_SESSION['role'] = ($user['role_id'] == 1) ? 'admin' : 'user';
                // Redirigir a la página de éxito del inicio de sesión.
                header('location: ../view/dashboard/success_login.php');
                exit;
            } else {
                // Si la contraseña no coincide, se muestra un mensaje de error.
                $_SESSION['login_error'] = "Contraseña o email incorrecto.";
                header('location: ../index.php');
                exit;
            }
        } else {
            // Si no se encuentra ningún usuario con el email proporcionado, muestra un mensaje de error.
            $_SESSION['login_error'] = "No se ha encontrado el usuario para el email: $email";
            header('location: ../index.php');
            exit;
        }
    }
}


if (isset($_POST['login'])) {
    // Crea una instancia de la clase Login y llama al método loginUser
    $login = new Login($con);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $login->loginUser($email, $password);
}
