<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$database = "hda"; 

// Verificar si se recibió el valor del ID
if (isset($_POST['id'])) {
    $id_a_consultar = $_POST['id'];

   
    $conn = new mysqli($servername, $username, $password, $database);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("La conexión ha fallado: " . $conn->connect_error);
    }

    // Sanitizar el ID (opcional dependiendo del origen del dato)
    $id_a_consultar = $conn->real_escape_string($id_a_consultar);

    // Consulta SQL para seleccionar horas_sociales y horas_constitucionales del documento específico
    $sql = "SELECT horas_sociales, horas_constitucionales FROM hojas WHERE id = '$id_a_consultar'";

    // Ejecutar la consulta
    $resultado = $conn->query($sql);

    // Verificar si hay resultados
    if ($resultado) {
        // Mostrar los resultados
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

    // Cerrar conexión
    $conn->close();
} else {
    echo "No se recibió el documento a consultar.";
}
?>