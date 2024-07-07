<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hda";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener los datos del formulario
$id = $_POST['id'];
$horas_sociales = $_POST['horas_sociales'];
$horas_constitucionales = $_POST['horas_constitucionales'];

// Comprobar si el ID ya existe en la base de datos
$sql = "SELECT * FROM hojas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // El ID existe, se suman las horas sociales y constitucionales
    $row = $result->fetch_assoc();
    $nuevas_horas_sociales = $row['horas_sociales'] + $horas_sociales;
    $nuevas_horas_constitucionales = $row['horas_constitucionales'] + $horas_constitucionales;

    // Actualizar el registro en la base de datos
    $sql = "UPDATE hojas SET horas_sociales = ?, horas_constitucionales = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $nuevas_horas_sociales, $nuevas_horas_constitucionales, $id);
    if ($stmt->execute()) {
        echo "Registro actualizado correctamente";
    } else {
        echo "Error actualizando el registro: " . $conn->error;
    }
} else {
    // El ID no existe, se inserta un nuevo registro
    $sql = "INSERT INTO hojas (id, horas_sociales, horas_constitucionales) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id, $horas_sociales, $horas_constitucionales);
    if ($stmt->execute()) {
        echo "Registro agregado correctamente";
    } else {
        echo "Error agregando el registro: " . $conn->error;
    }
}

// Cerrar conexión
$conn->close();
?>