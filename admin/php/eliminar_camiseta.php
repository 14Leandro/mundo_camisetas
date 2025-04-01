<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("HTTP/1.1 403 Forbidden");
    exit();
}
include '../../php/conexion.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("HTTP/1.1 400 Bad Request");
    exit();
}

$id = intval($_GET['id']);

// Primero, recuperar el nombre de la imagen asociada a la camiseta
$querySelect = "SELECT imagen FROM camisetas WHERE id = ?";
$stmtSelect = $conn->prepare($querySelect);
$stmtSelect->bind_param("i", $id);
$stmtSelect->execute();
$resultSelect = $stmtSelect->get_result();
$imagen = "";
if ($resultSelect && $resultSelect->num_rows > 0) {
    $row = $resultSelect->fetch_assoc();
    $imagen = $row['imagen'] ?? "";
}
$stmtSelect->close();

// Eliminar el registro de la base de datos
$queryDelete = "DELETE FROM camisetas WHERE id = ?";
$stmtDelete = $conn->prepare($queryDelete);
$stmtDelete->bind_param("i", $id);
if ($stmtDelete->execute()) {
    // Si se eliminó la camiseta, eliminar la imagen del directorio (si existe y no está vacía)
    if (!empty($imagen)) {
        $filePath = "../../uploads/camisetas/" . $imagen;
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    echo "Camiseta eliminada con éxito.";
} else {
    echo "Error al eliminar la camiseta.";
}

$stmtDelete->close();
$conn->close();
?>