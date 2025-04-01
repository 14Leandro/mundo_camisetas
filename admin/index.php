<?php
session_start();
// Verificar que el usuario tenga el rol de admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
$adminName = htmlspecialchars($_SESSION['nombre']);
include 'includes/header.php'; // Incluye el header común del admin
?>
<div class="main-content">
  <main class="container mt-4">
    <h2>Dashboard Profesional</h2>
    <p>Bienvenido, <?php echo $adminName; ?>. Aquí se muestran las estadísticas clave y datos de ventas.</p>
    
    <!-- Tarjetas de estadísticas -->
    <div class="row">
      <div class="col-md-3 mb-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Total Camisetas</h5>
            <p class="card-text display-4" id="totalCamisetas">0</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Ventas Este Mes</h5>
            <p class="card-text display-4" id="ventasMes">0</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Usuarios</h5>
            <p class="card-text display-4" id="totalUsuarios">0</p>
          </div>
        </div>
      </div>
      <div class="col-md-3 mb-4">
        <div class="card text-center shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Ingresos</h5>
            <p class="card-text display-4" id="ingresos">0</p>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Gráficos y reportes -->
    <div class="row">
      <!-- Gráfico de ventas -->
      <div class="col-md-8 mb-4">
        <div class="card shadow-sm">
          <div class="card-header">Ventas en el Último Mes</div>
          <div class="card-body">
            <canvas id="ventasChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
      <!-- Gráfico de usuarios por rol -->
      <div class="col-md-4 mb-4">
        <div class="card shadow-sm">
          <div class="card-header">Usuarios por Rol</div>
          <div class="card-body">
            <canvas id="usuariosChart" width="400" height="200"></canvas>
          </div>
        </div>
      </div>
    </div>
    
  </main>
</div>
<?php include 'includes/footer.php'; ?>
<!-- Inclusión de scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Estos datos de ejemplo pueden reemplazarse con datos reales obtenidos desde la base de datos
    const totalCamisetas = 150;
    const ventasMes = 45;
    const totalUsuarios = 200;
    const ingresos = 12500;

    // Actualizar tarjetas con los datos
    document.getElementById("totalCamisetas").textContent = totalCamisetas;
    document.getElementById("ventasMes").textContent = ventasMes;
    document.getElementById("totalUsuarios").textContent = totalUsuarios;
    document.getElementById("ingresos").textContent = "$" + ingresos;
    
    // Gráfico de ventas (Line Chart)
    const ctxVentas = document.getElementById('ventasChart').getContext('2d');
    const ventasChart = new Chart(ctxVentas, {
      type: 'line',
      data: {
          labels: ['Semana 1', 'Semana 2', 'Semana 3', 'Semana 4'],
          datasets: [{
              label: 'Ventas',
              data: [10, 15, 8, 12],
              backgroundColor: 'rgba(54, 162, 235, 0.2)',
              borderColor: 'rgba(54, 162, 235, 1)',
              borderWidth: 2,
              fill: true,
              tension: 0.1
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              }
          },
          plugins: {
              legend: {
                  display: true,
                  position: 'top'
              }
          }
      }
    });
    
    // Gráfico de usuarios (Doughnut Chart)
    const ctxUsuarios = document.getElementById('usuariosChart').getContext('2d');
    const usuariosChart = new Chart(ctxUsuarios, {
      type: 'doughnut',
      data: {
          labels: ['Admin', 'User'],
          datasets: [{
              data: [10, 190],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.8)',
                  'rgba(75, 192, 192, 0.8)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          responsive: true,
          plugins: {
              legend: {
                  position: 'bottom'
              }
          }
      }
    });
});
</script>
