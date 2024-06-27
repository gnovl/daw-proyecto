<?
// Inicia la sesión.
session_start();

// Incluye el archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Verifica si el usuario está autenticado.
if (!isset($_SESSION['detsuid'])) {
    // Si no está autenticado, redirecciona a la página de inicio de sesión.
    header('location: ../../index.php');
    exit; // Termina la ejecución del script.
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluye el CDN de la librería Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Incluye el CDN de la librería Font-Awesome (iconos) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <!-- Barra lateral -->
    <div class="col-md-3 col-lg-2 d-flex flex-column flex-shrink-0 p-3 bg-light">
        <!-- Obtener usuario desde la base de datos -->
        <?php
        // Obtener el nombre completo del usuario
        $uid = $_SESSION['detsuid'];
        $user_query = mysqli_query($con, "SELECT Full_Name FROM tb_user WHERE ID='$uid'");
        $user_row = mysqli_fetch_assoc($user_query);
        $name = $user_row['Full_Name'];
        ?>
        <!-- Saludo al usuario -->
        <a href="/daw_project/view/dashboard/dashboard.php"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
            <div class="row justify-content-center text-center mb-3 mx-auto">
                <div class="small">Hola,</div>
                <h6>
                    <?php echo $name; ?>
                </h6>


            </div>
        </a>
        <!-- Enlace para administradores -->
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <a href="/daw_project/view/admin/admin_management.php" class="nav-link link-primary text-black"><i
                    class="fas fa-user-shield me-2"></i>Admin</a>
        <?php endif; ?>
        <hr> <!-- Línea divisoria -->
        <ul class="nav nav-pills flex-column mb-auto">
            <!-- Enlaces de navegación -->
            <li class="nav-item">
                <a href="/daw_project/view/dashboard/dashboard.php" class="nav-link link-primary text-black"
                    aria-current="page">
                    <i class="fas fa-chart-line me-2"></i>Inicio
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-black link-primary" onclick="toggleSubLinks(event, 'expenses')"><i
                        class="fas fa-dollar-sign me-2"></i>Gastos
                    <i class="fas fa-caret-down ml-auto"></i>
                </a>
                <!-- Sub-enlaces para Gastos -->
                <ul class="nav flex-column sub-links" id="expenses-sublinks" style="display: none;">
                    <li class="nav-item">
                        <a href="/daw_project/model/new_expense.php" class="nav-link link-primary text-black ps-4"><i
                                class="fas fa-plus-circle me-2"></i>Agregar gastos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/daw_project/view/expenses/my_expenses.php"
                            class="nav-link link-primary text-black ps-4"><i class="fas fa-list me-2"></i>Mis gastos</a>
                    </li>
                </ul>

            </li>
            <li class="nav-item">
                <a href="/daw_project/view/report/report_form.php" class="nav-link text-black link-primary"><i
                        class="fas fa-file-alt me-2"></i>Informe de gastos</a>
            </li>
            <li class="nav-item">
                <a href="/daw_project/view/profile/user_profile.php" class="nav-link link-primary text-black"><i
                        class="fas fa-user me-2"></i>Perfil</a>
            </li>
            <li class="nav-item">
                <a href="/daw_project/view/profile/password_change.php" class="nav-link link-primary text-black"><i
                        class="fas fa-key me-2"></i>Cambiar contraseña</a>
            </li>
            <li class="nav-item">
                <a href="/daw_project/controller/logout.php" class="nav-link link-primary text-black"><i
                        class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a>
            </li>
            <li class="nav-item">
                <a href="/daw_project/controller/delete_acc.php" class="nav-link link-danger text-black"><i
                        class="fas fa-trash-alt me-2"></i>Eliminar cuenta</a>
            </li>

        </ul>
    </div>
    <!-- Script para mostrar/ocultar sub-enlaces -->
    <script>
        function toggleSubLinks(event, id) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace.

            // Alterna la visualización de los sub-enlaces.
            const subLinks = document.getElementById(id + '-sublinks');
            subLinks.style.display = subLinks.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>

</html>