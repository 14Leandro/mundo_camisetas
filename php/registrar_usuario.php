<?php
session_start();
include 'conexion.php';  // Archivo de conexión

// Recoger datos del formulario
$nombre = trim($_POST['nombre']);
$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($nombre) || empty($email) || empty($password)) {
    $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
    header("Location: ../index.php#modalRegistro");
    exit();
}

// Verificar si el correo ya existe
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['mensaje_error'] = "El correo ya está registrado.";
    $stmt->close();
    header("Location: ../index.php#modalRegistro");
    exit();
}
$stmt->close();

// Encriptar la contraseña
$pass_hash = password_hash($password, PASSWORD_DEFAULT);

// Registrar nuevo usuario
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $nombre, $email, $pass_hash);

if ($stmt->execute()) {
    $_SESSION['mensaje_exito'] = "Usuario registrado exitosamente.";
    header("Location: ../index.php#modalRegistro");
    exit();
} else {
    $_SESSION['mensaje_error'] = "Hubo un error al registrar el usuario.";
    header("Location: ../index.php#modalRegistro");
    exit();
}

$stmt->close();
$conn->close();
?>