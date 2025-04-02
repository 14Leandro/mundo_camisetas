<?php
session_start();

// Verificar que el usuario tenga el rol de admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$adminName = htmlspecialchars($_SESSION['nombre']);
include 'includes/header.php'; // Header común del admin
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  <link rel="stylesheet" href="css/admin.css?v=<?php echo time(); ?>">
</head>
<body>
  <div class="dashboard-container">
    <header>
      <h1>Bienvenido, <?php echo $adminName; ?></h1>
      <p class="subheader">Panel de Control - Resumen de Actividades</p>
    </header>
    
    <!-- Tarjetas de estadísticas -->
    <section class="stats">
      <div class="stat-card">
        <h3>Total de Camisetas</h3>
        <p id="totalCamisetas">0</p>
      </div>
      <div class="stat-card">
      <h3>Total de Usuarios</h3>
        <p id="totalUsuarios">0</p>
      </div>
      <div class="stat-card">
        <h3>Ventas del Mes</h3>
        <p id="ventasMes">0</p>
      </div>
      <div class="stat-card">
        <h3>Ingresos</h3>
        <p id="ingresos">0</p>
      </div>
    </section>

    <!-- Gráficos -->
    <section class="charts">
      <div class="chart-container">
        <h4>Ventas Semanales</h4>
        <canvas id="ventasChart"></canvas>
      </div>
      <div class="chart-container">
        <h4>Usuarios por Rol</h4>
        <canvas id="usuariosChart"></canvas>
      </div>
    </section>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="js/admin.js?v=<?php echo time(); ?>"></script>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
