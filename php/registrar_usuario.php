<?php
session_start();
include 'conexion.php';

// Recoger y limpiar los datos del formulario
$nombre   = trim($_POST['nombre']);
$email    = trim($_POST['email']);
$password = $_POST['password'];

// Validación: Verificar que todos los campos estén completos
if (empty($nombre) || empty($email) || empty($password)) {
    $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
    header("Location: ../index.php#modalRegistro");
    exit();
}

// Verificar si el correo ya existe en la base de datos
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['mensaje_error'] = "El correo electrónico ya está registrado.";
    $stmt->close();
    header("Location: ../index.php#modalRegistro");
    exit();
}
$stmt->close();

// Encriptar la contraseña
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la base de datos con rol "user"
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $nombre, $email, $password_hash);

if ($stmt->execute()) {
    // Obtener el ID del usuario recién insertado
    $usuario_id = $conn->insert_id;

    // Iniciar sesión automáticamente: almacenar los datos del usuario en la sesión
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['nombre']     = $nombre;
    $_SESSION['rol']        = 'user';
    $_SESSION['mensaje_exito'] = "Usuario registrado exitosamente. ¡Bienvenido, $nombre!";

    header("Location: ../index.php");
    exit();
} else {
    $_SESSION['mensaje_error'] = "Error al registrar el usuario. Intenta de nuevo.";
    header("Location: ../index.php#modalRegistro");
    exit();
}

$stmt->close();
$conn->close();
?>
