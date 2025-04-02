<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../../index.php");
    exit();
}
include '../../php/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre']);
    $liga = trim($_POST['liga']);
    $precio = trim($_POST['precio']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($nombre) || empty($liga) || empty($precio)) {
        $_SESSION['mensaje_error'] = "Los campos de nombre del producto, liga y precio son obligatorios.";
        header("Location: ../editar_camiseta.php?id=" . $id);
        exit();
    }

    $updateImage = false;
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
                $updateImage = true;
            } else {
                $_SESSION['mensaje_error'] = "Error al mover la imagen subida.";
                header("Location: ../editar_camiseta.php?id=" . $id);
                exit();
            }
        } else {
            $_SESSION['mensaje_error'] = "Extensión de imagen no permitida.";
            header("Location: ../editar_camiseta.php?id=" . $id);
            exit();
        }
    }
    
    if ($updateImage) {
        $query = "UPDATE camisetas SET nombre = ?, liga = ?, precio = ?, imagen = ?, descripcion = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $_SESSION['mensaje_error'] = "Error en preparación de consulta: " . $conn->error;
            header("Location: ../editar_camiseta.php?id=" . $id);
            exit();
        }
        $stmt->bind_param("ssdssi", $nombre, $liga, $precio, $imagenPath, $descripcion, $id);
    } else {
        $query = "UPDATE camisetas SET nombre = ?, liga = ?, precio = ?, descripcion = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            $_SESSION['mensaje_error'] = "Error en preparación de consulta: " . $conn->error;
            header("Location: ../editar_camiseta.php?id=" . $id);
            exit();
        }
        $stmt->bind_param("ssdsi", $nombre, $liga, $precio, $descripcion, $id);
    }
    
    if ($stmt->execute()) {
        $_SESSION['mensaje_exito'] = "Camiseta actualizada exitosamente.";
        header("Location: ../admin_camisetas.php");
        exit();
    } else {
        $_SESSION['mensaje_error'] = "Error al actualizar la camiseta.";
        header("Location: ../editar_camiseta.php?id=" . $id);
        exit();
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: ../admin_camisetas.php");
    exit();
}
?>