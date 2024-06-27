# Sistema de Gestión de Gastos

Este proyecto es una aplicación web desarrollada como proyecto final para el curso de Desarrollo de Aplicaciones Web (DAW).

![Imagen de la aplicación](./images/app_overview.png)

## Descripción

Esta aplicación permite a los usuarios gestionar sus gastos personales. Los usuarios pueden crear cuentas, administrar sus gastos (agregar, visualizar y eliminar), y eliminar su propia cuenta si lo desean. También incluye un rol de administrador con capacidades adicionales.

### Características principales

- Registro y autenticación de usuarios
- Gestión de gastos personales (agregar, visualizar, eliminar)
- Rol de administrador para gestión de usuarios y permisos
- Interfaz responsiva y amigable

## Tecnologías utilizadas

- PHP
- HTML
- Bootstrap (para estilos)
- CSS
- JavaScript (para alertas)
- MySQL (base de datos)

## Requisitos previos

- Servidor web Apache
- MySQL
- XAMPP (recomendado para entorno de desarrollo local)

## Instalación y ejecución local

1. Descarga e instala XAMPP.
2. Clona este repositorio en la carpeta `htdocs` de XAMPP: htdocs/daw_project/
3. Inicia XAMPP y activa los módulos Apache y MySQL.
4. Importa la base de datos:

- Abre phpMyAdmin (http://localhost/phpmyadmin)
- Ve a la pestaña 'SQL'
- Copia y pega el contenido del archivo `.sql` incluido en este proyecto
- Ejecuta el script SQL

5. Verifica que el puerto de MySQL en el archivo `/config/dbconnection.php` coincida con el puerto que aparece en XAMPP para MySQL.
6. Accede a la aplicación en tu navegador: http://localhost:80/daw_project/

## Propósito del proyecto

Este proyecto se desarrolló como trabajo final para el curso de Desarrollo de Aplicaciones Web (DAW). Se comparte públicamente con el propósito de mostrar un ejemplo de proyecto final para este curso y como parte de mi portafolio personal de desarrollo.

## Atribución y uso

Este proyecto fue creado por Gino Varela como un trabajo académico original.

Está protegido por una licencia MIT y no está permitida su redistribución o uso comercial sin autorización.

Aunque está bajo la Licencia MIT, que permite un uso amplio del código, se requiere lo siguiente:

1. Cualquier uso, modificación o distribución de este código debe mantener el aviso de copyright original y la atribución al autor.
2. Está prohibido presentar este trabajo, en su totalidad o en parte, como propio en contextos académicos o profesionales.
3. Si utilizas este código como base para otro proyecto, se agradece (aunque no se requiere legalmente) una mención o enlace al repositorio original.

El autor no asume ninguna responsabilidad por el uso indebido de este código. Se proporciona "tal cual", sin garantías de ningún tipo.

Recuerda que este es un proyecto educativo y su principal propósito es demostrar habilidades de desarrollo web en un contexto académico y profesional.

## Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo `LICENSE` para más detalles.
