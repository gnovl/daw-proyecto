<?php
// Incluir archivo de conexión a la base de datos.
include '../../config/dbconnection.php';

// Generar una contraseña nueva hasheada para el usuario admin.
$new_admin_password = password_hash("admin", PASSWORD_DEFAULT);

// Actualizar contraseña hash en la base de datos
$update_query = "UPDATE tb_user SET Password = ? WHERE Email = 'admin@example.com'";
$stmt = $con->prepare($update_query);
$stmt->bind_param("s", $new_admin_password);
$stmt->execute();
$stmt->close();

echo "Contraseña actualizada correctamente!";