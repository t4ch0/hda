<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$id = $_POST['id'];
$horas_sociales = $_POST['horas_sociales'];
$horas_constitucionales = $_POST['horas_constitucionales'];

$sql = "SELECT * FROM hojas WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nuevas_horas_sociales = $row['horas_sociales'] + $horas_sociales;
    $nuevas_horas_constitucionales = $row['horas_constitucionales'] + $horas_constitucionales;

    $sql = "UPDATE hojas SET horas_sociales = ?, horas_constitucionales = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $nuevas_horas_sociales, $nuevas_horas_constitucionales, $id);
    if ($stmt->execute()) {
        echo "Registro actualizado correctamente";
    } else {
        echo "Error actualizando el registro: " . $conn->error;
    }
} else {
    $sql = "INSERT INTO hojas (id, horas_sociales, horas_constitucionales) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id, $horas_sociales, $horas_constitucionales);
    if ($stmt->execute()) {
        echo "Registro agregado correctamente";
    } else {
        echo "Error agregando el registro: " . $conn->error;
    }
}

$conn->close();
?>
<a href="http://localhost:3000/docente/docentes.php">Volver a la página de docentes.</a>
