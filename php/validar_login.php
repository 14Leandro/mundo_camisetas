<?php
session_start();
include 'conexion.php';

// Recoger y limpiar los datos del formulario
$email    = trim($_POST['email']);
$password = trim($_POST['password']);

// Verificar que los campos no estén vacíos
if (empty($email) || empty($password)) {
    $_SESSION['mensaje_error_login'] = "Por favor, completa todos los campos.";
    header("Location: ../index.php#modalLogin");
    exit();
}

// Preparar la consulta para buscar el usuario con ese email
$stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
    // Verificar la contraseña utilizando password_verify
    if (password_verify($password, $usuario['password'])) {
        // Credenciales correctas. Iniciar sesión.
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre']     = $usuario['nombre'];
        // Redirigir sin hash para que el modal no se abra.
        header("Location: ../index.php");
        exit();
    } else {
        // Contraseña incorrecta
        $_SESSION['mensaje_error_login'] = "Correo o contraseña incorrectos.";
        header("Location: ../index.php#modalLogin");
        exit();
    }
} else {
    // No se encontró el usuario
    $_SESSION['mensaje_error_login'] = "Correo o contraseña incorrectos.";
    header("Location: ../index.php#modalLogin");
    exit();
}

$stmt->close();
$conn->close();
?>
