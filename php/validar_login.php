<?php
session_start();
include 'conexion.php';

// Recoger y limpiar datos del formulario
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

// Verificar que los campos no estén vacíos
if (empty($email) || empty($password)) {
    $_SESSION['mensaje_error_login'] = "Por favor, completa todos los campos.";
    header("Location: ../index.php#modalLogin");
    exit();
}

// Preparar la consulta para buscar el usuario
$stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    // Verificar la contraseña
    if (password_verify($password, $usuario['password'])) {
        // Iniciar sesión: guardar datos en sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre']     = $usuario['nombre'];
        $_SESSION['rol']        = $usuario['rol'];
        
        // Redirigir según el rol
        if ($usuario['rol'] === 'admin') {
            header("Location: ../admin/index.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        // Contraseña incorrecta
        $_SESSION['mensaje_error_login'] = "Correo o contraseña incorrectos.";
        header("Location: ../index.php#modalLogin");
        exit();
    }
} else {
    // No se encontró usuario
    $_SESSION['mensaje_error_login'] = "Correo o contraseña incorrectos.";
    header("Location: ../index.php#modalLogin");
    exit();
}

$stmt->close();
$conn->close();
?>