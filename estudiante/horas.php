<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; 
$username = "root";
$password = ""; 
$database = "hda"; 

if (isset($_POST['id'])) {
    $id_a_consultar = $_POST['id'];

   
    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    $id_a_consultar = $conn->real_escape_string($id_a_consultar);

    $sql = "SELECT horas_sociales, horas_constitucionales FROM hojas WHERE id = '$id_a_consultar'";

    $resultado = $conn->query($sql);
    if ($resultado) {
        if ($resultado->num_rows > 0) {
            $fila = $resultado->fetch_assoc();
            echo "Horas Sociales: " . $fila["horas_sociales"] . "<br>";
            echo "Horas Constitucionales: " . $fila["horas_constitucionales"];
        } else {
            echo "No se encontraron resultados para el documento: $id_a_consultar";
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
    }

    
    $conn->close();
} else {
    echo "No se recibió el documento a consultar.";
}
?>

<!-- Enlace al final del script -->
<br>
<a href="http://localhost:3000/estudiante/estudiantes.html">Volver a la página de estudiantes</a>