<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $equipo = trim($_POST['equipo']);
    $liga = trim($_POST['liga']);
    $precio = trim($_POST['precio']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($equipo) || empty($liga) || empty($precio)) {
        $_SESSION['mensaje_error'] = "Los campos de equipo, liga y precio son obligatorios.";
        header("Location: ../agregar_camiseta.php");
        exit();
    }

    $imagenPath = "";
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['imagen']['tmp_name'];
        $fileName = $_FILES['imagen']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = array("jpg", "jpeg", "png", "gif", "webp");
        if (in_array($fileExtension, $allowedExtensions)) {
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = "../../uploads/camisetas/" . $newFileName;
            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imagenPath = $newFileName;
            } else {
                $_SESSION['mensaje_error'] = "Error al mover la imagen subida.";
                header("Location: ../agregar_camiseta.php");
                exit();
            }
        } else {
            $_SESSION['mensaje_error'] = "Extensión de imagen no permitida.";
            header("Location: ../agregar_camiseta.php");
            exit();
        }
    }

    $query = "INSERT INTO camisetas (equipo, liga, precio, imagen, descripcion) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    if (!$stmt) {
        $_SESSION['mensaje_error'] = "Error en preparación de consulta: " . $conn->error;
        header("Location: ../agregar_camiseta.php");
        exit();
    }
    $stmt->bind_param("ssdss", $equipo, $liga, $precio, $imagenPath, $descripcion);
    
    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "Camiseta agregada exitosamente.";
        header("Location: ../admin_camisetas.php");
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Error al agregar la camiseta.";
        header("Location: ../agregar_camiseta.php");
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../agregar_camiseta.php");
    exit();
}
?>