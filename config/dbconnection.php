<?php
// Estableciendo la conexión con la base de datos utilizando la función mysqli_connect.
// Parametros: host, nombre de usuario, contraseña, nombre base de datos.
$con = mysqli_connect("localhost:3306", "root", "", "db_expenses");

// Comprobamos que la conexión haya sido satisfactoria.
if (mysqli_connect_errno()) {
    // Si falla la conexión, se muestra un mensaje de error.
    echo "Connection Fail" . mysqli_connect_error();
}


