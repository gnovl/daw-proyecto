<?php
// Iniciar la sesión.
session_start();
// Incluimos el archivo de conexión a la base de datos.
include '../config/dbconnection.php';

// Verifica si se han enviado los datos del forumario.
if (isset($_POST['fullName']) && isset($_POST['email']) && isset($_POST['mobile']) && isset($_POST['password']) && isset($_POST['confirmPassword'])) {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $phone = $_POST['mobile'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Se comprueba que no haya ningun campo obligatorio sin rellenar.
    if (empty($fullName) || empty($email) || empty($phone) || empty($password) || empty($confirmPassword)) {
        $_SESSION['register_error'] = "Por favor, complete todos los campos obligatorios."; // Mensaje de error para campos sin completar.
        header('location: ../view/auth/register.php');
        exit;
    }


    // Verifica si las contraseñas coinciden.
    if ($password !== $confirmPassword) {
        $_SESSION['register_error'] = "La contraseña no coincide."; // Mensaje de error para contraseña incorrecta.
        header('location: ../view/auth/register.php');
        exit;
    }

    // Verifica si el email ya está registrado en la base de datos.
    $check_email_query = "SELECT * FROM tb_user WHERE Email='$email'";
    $check_email_result = mysqli_query($con, $check_email_query);
    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['register_error'] = "El email ya existe."; // Mensaje de error para email que ya existe en la base de datos.
        header('location: ../view/auth/register.php');
        exit;
    }

    // Hashea la contraseña.
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar los datos del usuario en la base de datos.
    $insert_query = "INSERT INTO tb_user (Full_Name, Email, Phone_Num, Password, signup_date, role_id) VALUES ('$fullName', '$email', '$phone', '$hashed_password', NOW(), 2)";
    if (mysqli_query($con, $insert_query)) {
        // Redirige a la página de éxito después de un registro exitoso.
        header('Location: ../view/auth/success_register.php');
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
