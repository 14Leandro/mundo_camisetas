<?php
$servername = "localhost";
$username   = "root";           // o el usuario que uses
$password   = "";  // la contraseña correspondiente
$dbname     = "camisetas_futbol";  // asegúrate que coincide con el dump

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Fallo en la conexión: " . $conn->connect_error);
}
?>

