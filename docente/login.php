<?php
$servername = "localhost"; 
$username = "root"; 
$password = "";
$database = "hda"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

  
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    $correo = $conn->real_escape_string($correo);
    $contrasena = $conn->real_escape_string($contrasena);

    $sql = "SELECT id_login, correo FROM login WHERE correo = '$correo' AND contraseña = '$contrasena'";

    $resultado = $conn->query($sql);

    if ($resultado->num_rows > 0) {
        $fila = $resultado->fetch_assoc();
        header("Location: enviar.html");
    } else {
        echo "Correo electrónico o contraseña incorrectos.";
    }

    $conn->close();
}
?>

<!-- Enlace al final del script -->
<br>
<a href="http://localhost:3000/inicio.html">Volver a la página de docentes.</a>