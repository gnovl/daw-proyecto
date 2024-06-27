<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro exitoso</title>
    <!-- Incluye el CDN de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Estilos personalizados -->
    <style>
        /* Estilo para el margen superior del contenedor */
        .container {
            margin-top: 50px;
        }

        /* Estilo para las alertas */
        .alert {
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        /* Estilo específico para la alerta de éxito */
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Título de la página -->
                <h2 class="text-center mb-4 bg-dark text-white py-2">SISTEMA DE GESTIÓN DE GASTOS</h2>
                <!-- Mensaje de alerta para registro exitoso -->
                <div class="alert alert-success" role="alert">
                    <!-- Encabezado de la alerta -->
                    <h4 class="alert-heading">Registo exitoso!</h4>
                    <p class="mb-0">Tu cuenta ha sido registrada exitosamente.</p>
                    <hr>
                    <!-- Instrucción para iniciar sesión -->
                    <p class="mb-0">Ahora puedes <a href="../../index.php" class="alert-link">iniciar sesión</a> en tu
                        cuenta.
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>