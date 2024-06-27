<?php
class LogoutHandler
{
    public function __construct()
    {
        // Inicia la sesión si aún no ha sido iniciada.
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si el usuario ha iniciado sesión.
        if (!isset($_SESSION['detsuid'])) {
            // Si el usuario no ha iniciado sesión, es redirigido a la página de inicio de la aplicación.
            header('location: ../index.php');
            exit;
        }
    }

    public function logout()
    {
        // Elimina todas las variables de sesión.
        $_SESSION = [];

        // Se destruye la sesión.
        session_destroy();

        // Redirige al usuario a la página de inicio con el mensaje de cierre de sesión como parámetro de URL.
        header("Location: ../index.php?logout_success=true");
        exit();
    }
}

// Instancia el objeto LogoutHandler.
$logoutHandler = new LogoutHandler();

// Llama al método logout.
$logoutHandler->logout();

