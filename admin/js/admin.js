document.addEventListener('DOMContentLoaded', function () {
    function updateStats() {
      fetch('php/dashboard_stats.php')
        .then(response => response.json())
        .then(data => {
          // Actualizar estadísticas
          document.getElementById('totalCamisetas').textContent = data.totalCamisetas;
          document.getElementById('totalUsuarios').textContent = data.totalUsuarios; // Actualiza total usuarios
          document.getElementById('ventasMes').textContent = Object.values(data.ventasPorSemana).reduce((a, b) => a + b, 0);
          document.getElementById('ingresos').textContent = "$" + Object.values(data.ventasPorSemana).reduce((a, b) => a + b, 0);
  
          // Crear gráficos
          createVentasChart(data.ventasPorSemana);
          createUsuariosChart(data.usuariosPorRol);
        })
        .catch(error => console.error('Error al cargar estadísticas:', error));
    }
  
    function createVentasChart(ventasPorSemana) {
      const semanas = Object.keys(ventasPorSemana);
      const totales = Object.values(ventasPorSemana);
  
      const ctx = document.getElementById('ventasChart').getContext('2d');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: semanas.map(semana => `Semana ${semana}`),
          datasets: [{
            label: 'Ventas',
            data: totales,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderWidth: 2
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    }
  
    function createUsuariosChart(usuariosPorRol) {
      const roles = Object.keys(usuariosPorRol);
      const cantidades = Object.values(usuariosPorRol);
  
      const ctx = document.getElementById('usuariosChart').getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: roles,
          datasets: [{
            data: cantidades,
            backgroundColor: ['rgba(255, 99, 132, 0.6)', 'rgba(54, 162, 235, 0.6)']
          }]
        },
        options: {
          responsive: true,
          plugins: { legend: { position: 'bottom' } }
        }
      });
    }
  
    updateStats();
  });
  