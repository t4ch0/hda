<?php
$servername = "localhost"; 
$username = "root"; 
$password = "";
$database = "hda"; 

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$comentario = $_POST['comentario'];

$sql = "SELECT * FROM formulario WHERE nombre = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombre); // Cambiar "i" a "s" para cadenas
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nuevas_email = $row['email'];
    $nuevas_comentario = $row['comentario'] . $comentario;

    $sql = "UPDATE formulario SET email = ?, comentario = ? WHERE nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nuevas_email, $nuevas_comentario, $nombre); // Cambiar "i" a "s" para cadenas
    if ($stmt->execute()) {
        echo "Registro actualizado correctamente";
    } else {
        echo "Error actualizando el registro: " . $conn->error;
    }
} else {
    $sql = "INSERT INTO formulario (nombre, email, comentario) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $comentario); // Cambiar "i" a "s" para cadenas
    if ($stmt->execute()) {
        echo "Registro agregado correctamente";
    } else {
        echo "Error agregando el registro: " . $conn->error;
    }
}

$conn->close();
?>
<br>
<br>
<a href="http://localhost:3000/inicio/inicio.html">Volver a la página de inicio.</a>
<br>
<br>
<a href="http://localhost:3000/inicio/formulario.html">Ingresar nuevo comentario.</a>


