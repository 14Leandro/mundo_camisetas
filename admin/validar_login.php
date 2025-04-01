<?php
session_start();
include 'conexion.php';

// Capturar los datos del formulario
$usuario = $_POST['usuario'];
$password = $_POST['password'];

// Consulta a la base de datos
$stmt = $conn->prepare("SELECT * FROM administradores WHERE usuario = ? AND password = ?");
$stmt->bind_param("ss", $usuario, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Usuario válido: iniciar sesión
    $_SESSION['admin'] = $usuario;
    header("Location: admin_panel.php");
} else {
    // Usuario inválido: redirigir al login
    echo "<script>alert('Usuario o contraseña incorrectos'); window.location.href='../login.html';</script>";
}

$conn->close();
?>
