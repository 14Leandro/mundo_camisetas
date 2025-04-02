<?php
session_start();

// Verificar que el usuario tenga el rol de admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    http_response_code(403);
    echo json_encode(['error' => 'Acceso denegado']);
    exit();
}

include_once '../../php/conexion.php';

$data = [];

// Consulta: Total de camisetas
$query1 = "SELECT COUNT(*) as totalCamisetas FROM camisetas";
$result1 = $conn->query($query1);
$data['totalCamisetas'] = ($result1 && $row = $result1->fetch_assoc()) ? (int)$row['totalCamisetas'] : 0;

// Consulta: Usuarios agrupados por rol
$queryRolesUsuarios = "
    SELECT rol, COUNT(*) AS total
    FROM usuarios
    GROUP BY rol
";
$resultRolesUsuarios = $conn->query($queryRolesUsuarios);

$usuariosPorRol = [];
$totalUsuarios = 0; // Variable para almacenar el total de usuarios
if ($resultRolesUsuarios) {
    while ($row = $resultRolesUsuarios->fetch_assoc()) {
        $usuariosPorRol[$row['rol']] = (int)$row['total'];
        $totalUsuarios += (int)$row['total']; // Sumar el total de todos los roles
    }
}
$data['usuariosPorRol'] = $usuariosPorRol;
$data['totalUsuarios'] = $totalUsuarios; // Guardar el total

// Ventas por semana (asumiendo que tienes pedidos con fechas y totales)
$queryVentas = "SELECT WEEK(creado_en) AS semana, SUM(total) AS totalVentas FROM pedidos WHERE MONTH(creado_en) = MONTH(NOW()) GROUP BY semana";
$resultVentas = $conn->query($queryVentas);
$data['ventasPorSemana'] = [];
if ($resultVentas) {
    while ($row = $resultVentas->fetch_assoc()) {
        $data['ventasPorSemana'][(int)$row['semana']] = (float)$row['totalVentas'];
    }
}

header('Content-Type: application/json');
echo json_encode($data);
exit();
?>
