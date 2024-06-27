<?php
session_start(); //  Inicia la sesión para mantener la información del usuario entre las páginas.
include '../../config/dbconnection.php';

class Admin
{
    private $con;

    public function __construct($con)
    {
        $this->con = $con;
        // Comprueba si el usuario ha iniciado sesión y es un administrador.
        if (!isset($_SESSION['detsuid']) || $_SESSION['role'] !== 'admin') {
            // Si el usuario no tiene el rol admin, redirige a la página de inicio de sesión.
            $_SESSION['access_denied'] = "Acceso restringido. Debes iniciar sesión.";
            header('Location: ../../index.php');
            exit;
        }
    }

    public function handleRoleAssignment()
    {
        if (isset($_POST['user_id']) && isset($_POST['role'])) {
            $user_id = $_POST['user_id'];
            $role = $_POST['role'];

            // Comprueba si el usuario está intentando revocar su propio rol de administrador.
            if ($_SESSION['detsuid'] == $user_id && $role == 'usuario registrado') {
                // Evita la acción y redirige a la página de inicio.
                header('Location: ../../index.php');
                exit;
            }

            // Actualiza el rol del usuario en la base de datos.
            $update_query = "UPDATE tb_user SET role_id = (SELECT role_id FROM tb_role WHERE role_name = '$role') WHERE ID = $user_id";
            if (mysqli_query($this->con, $update_query)) {
                // Rol actualizado correctamente.
            } else {
                // Error al actualizar el rol.
                echo "Error: " . mysqli_error($this->con);
            }
        }
    }

    public function handleUserDeletion()
    {
        // Comprueba si se envió el formulario de eliminación de usuario.
        if (isset($_POST['delete_user_submit'])) {
            // Comprueba si se estableció el ID de usuario a eliminar.
            if (isset($_POST['delete_user_id'])) {
                $delete_user_id = $_POST['delete_user_id'];

                // Elimina primero los gastos relacionados.
                $delete_expense_query = "DELETE FROM tb_expense WHERE User_ID = $delete_user_id";
                if (mysqli_query($this->con, $delete_expense_query)) {
                    // Procede a eliminar el usuario de la tabla tb_user.
                    $delete_user_query = "DELETE FROM tb_user WHERE ID = $delete_user_id";
                    if (mysqli_query($this->con, $delete_user_query)) {
                        // Usuario eliminado correctamente.
                        // Redirige para actualizar la página.
                        header('Location: admin_management.php');
                        exit;
                    } else {
                        // Error al eliminar el usuario.
                        echo "Error: " . mysqli_error($this->con);
                    }
                } else {
                    // Error al eliminar los gastos relacionados.
                    echo "Error: " . mysqli_error($this->con);
                }
            }
        }
    }

    public function fetchUsers()
    {
        // Obtiene todos los usuarios de la base de datos.
        $users_query = "SELECT u.ID, u.Full_Name, u.Email, u.signup_date, r.role_name 
                        FROM tb_user u 
                        INNER JOIN tb_role r ON u.role_id = r.role_id";
        $users_result = mysqli_query($this->con, $users_query);
        return $users_result;
    }
}

// Crea una instancia de AdminManagement
$adminManagement = new Admin($con);

// Llama a los métodos para manejar la asignación o revocación de roles y la eliminación de usuarios.
$adminManagement->handleRoleAssignment();
$adminManagement->handleUserDeletion();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA DE GESTIÓN DE GASTOS - PANEL DE ADMINISTRACIÓN</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .alternate-row-colors tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- Incluye el encabezado -->
    <?php include_once '../layout/header.php'; ?>
    <div class="container-fluid">
        <div class="row vh-100">
            <!-- Incluye la barra lateral -->
            <?php include '../layout/sidebar.php'; ?>
            <!-- Contenido de administración -->
            <div class="col-md-9 col-lg-10">
                <div class="container mt-5">
                    <h2 class="mb-4">Panel de administración</h2>
                    <table class="table table-striped alternate-row-colors">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Fecha de registro</th>
                                <th>Rol</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $users_result = $adminManagement->fetchUsers();
                            while ($row = mysqli_fetch_assoc($users_result)):
                                ?>
                                <tr>
                                    <td><?php echo $row['ID']; ?></td>
                                    <td><?php echo $row['Full_Name']; ?></td>
                                    <td><?php echo $row['Email']; ?></td>
                                    <td><?php echo $row['signup_date']; ?></td>
                                    <td><?php echo $row['role_name']; ?></td>
                                    <td>
                                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo $row['ID']; ?>">
                                            <input type="hidden" name="delete_user_id" value="<?php echo $row['ID']; ?>">
                                            <button type="submit" class="btn btn-danger" name="delete_user_submit"
                                                onclick="return confirm('Estás seguro que quieres eliminar este usuario?')">Eliminar
                                                usuario</button>
                                            <?php if ($row['role_name'] === 'usuario registrado'): ?>
                                                <button type="submit" class="btn btn-success" name="role" value="admin">Dar
                                                    Admin</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn btn-warning" name="role"
                                                    value="usuario registrado">Quitar Admin</button>
                                            <?php endif; ?>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Incluir pie de página -->
    <?php include '../layout/footer.php'; ?>
</body>

</html>