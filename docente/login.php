<?php
$servername = "localhost"; 
$username = "root"; 
$password = "";
$database = "hda"; 

// Obtener datos del formulario de login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

  
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    // Sanitizar los datos (opcional dependiendo del origen del dato)
    $correo = $conn->real_escape_string($correo);
    $contrasena = $conn->real_escape_string($contrasena);

    // Consulta SQL para verificar las credenciales
    $sql = "SELECT id_login, correo FROM login WHERE correo = '$correo' AND contraseña = '$contrasena'";

    $resultado = $conn->query($sql);

    // Verificar si se encontró un usuario
    if ($resultado->num_rows > 0) {
        // Usuario encontrado, iniciar sesión (aquí podrías establecer sesiones o cookies)
        $fila = $resultado->fetch_assoc();
        header("Location: enviar.html");
    } else {
        // Usuario no encontrado o credenciales incorrectas
        echo "Correo electrónico o contraseña incorrectos.";
    }

    // Cerrar conexión
    $conn->close();
}
?>

<!-- Enlace al final del script -->
<br>
<a href="http://localhost:3000/inicio.html">Volver a la página de docentes.</a>