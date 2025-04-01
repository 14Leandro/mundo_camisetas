<?php
session_start();
include 'conexion.php';

// Recoger datos del formulario
$email = trim($_POST['email']);
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
    header("Location: ../index.php#modalLogin");
    exit();
}

// Consultar credenciales
$stmt = $conn->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();

    if (password_verify($password, $usuario['password'])) {
        // Iniciar sesión
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['rol'] = $usuario['rol'];

        // Redirigir según rol
        if ($usuario['rol'] === 'admin') {
            header("Location: ../admin/panel_admin.php");
        } else {
            header("Location: ../index.php");
        }
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Contraseña incorrecta.";
        header("Location: ../index.php#modalLogin");
        exit();
    }
} else {
    $_SESSION['mensaje_error'] = "No existe una cuenta asociada a este correo.";
    header("Location: ../index.php#modalLogin");
    exit();
}

$stmt->close();
$conn->close();
?>