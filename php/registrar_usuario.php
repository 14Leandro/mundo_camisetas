<?php
session_start();
include 'conexion.php';  // Asegúrate de que la conexión esté configurada correctamente

// Recoger y limpiar los datos del formulario
$nombre   = trim($_POST['nombre']);
$email    = trim($_POST['email']);
$password = $_POST['password'];

// Validar que ningún campo esté vacío
if (empty($nombre) || empty($email) || empty($password)) {
    $_SESSION['mensaje_error'] = "Todos los campos son obligatorios.";
    header("Location: ../users/registro.php");
    exit();
}

// Verificar si el correo ya está registrado
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['mensaje_error'] = "El correo ya está registrado.";
    $stmt->close();
    header("Location: ../users/registro.php");
    exit();
}
$stmt->close();

// Encriptar la contraseña
$pass_hash = password_hash($password, PASSWORD_DEFAULT);

// Insertar el nuevo usuario en la base de datos con rol 'user'
$stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $nombre, $email, $pass_hash);

if ($stmt->execute()) {
    // Registro exitoso, iniciar sesión automáticamente (opcional)
    $_SESSION['usuario_id'] = $stmt->insert_id;
    $_SESSION['nombre']     = $nombre;
    $_SESSION['mensaje_exito'] = "Usuario creado correctamente.";
    header("Location: ../index.php");
    exit();
} else {
    $_SESSION['mensaje_error'] = "Error en la creación del usuario, por favor intenta de nuevo.";
    header("Location: ../users/registro.php");
    exit();
}

$stmt->close();
$conn->close();
?>