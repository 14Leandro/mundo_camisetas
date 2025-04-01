<?php
$conn = new mysqli("localhost", "root", "", "camisetas_futbol");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Establecer el juego de caracteres a UTF-8
$conn->set_charset("utf8mb4");
?>

