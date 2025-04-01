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
$query = "DELETE FROM camisetas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "Camiseta eliminada con éxito.";
} else {
    echo "Error al eliminar la camiseta.";
}

$stmt->close();
$conn->close();
?>
