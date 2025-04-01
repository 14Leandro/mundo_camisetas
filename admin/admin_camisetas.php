<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
include 'includes/header.php';
include '../php/conexion.php';
?>
<main class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Gestionar Camisetas</h2>
    <a href="agregar_camiseta.php" class="btn btn-success">
      <i class="fas fa-plus me-1"></i> Agregar Nueva Camiseta
    </a>
  </div>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Equipo</th>
          <th>Liga</th>
          <th>Precio</th>
          <th>Imagen</th>
          <th>Descripción</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $query = "SELECT * FROM camisetas";
        $result = $conn->query($query);
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . ($row["id"] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row["equipo"] ?? '') . '</td>';
            echo '<td>' . htmlspecialchars($row["liga"] ?? '') . '</td>';
            echo '<td>$' . number_format($row["precio"] ?? 0, 2) . '</td>';
            echo '<td>';
            if (!empty($row["imagen"])) {
              echo '<img src="../uploads/camisetas/' . htmlspecialchars($row["imagen"]) . '" alt="Imagen de la camiseta" style="max-width:100px; height:auto;">';
            } else {
              echo 'Sin imagen';
            }
            echo '</td>';
            echo '<td>' . htmlspecialchars($row["descripcion"] ?? '') . '</td>';
            echo '<td>';
            echo '<a href="editar_camiseta.php?id=' . ($row["id"] ?? '') . '" class="btn btn-sm btn-primary me-1">Editar</a>';
            echo '<button class="btn btn-sm btn-danger" onclick="confirmarEliminacion(' . ($row["id"] ?? '') . ')">Eliminar</button>';
            echo '</td>';
            echo '</tr>';
          }
        } else {
          echo '<tr><td colspan="7" class="text-center">No se encontraron camisetas.</td></tr>';
        }
        $conn->close();
        ?>
      </tbody>
    </table>
  </div>
</main>

<!-- Modal de Confirmación -->
<div class="modal fade" id="modalConfirmar" tabindex="-1" aria-labelledby="modalConfirmarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalConfirmarLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        ¿Está seguro que desea eliminar esta camiseta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Éxito Mejorado -->
<div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-body">
        <div class="alert alert-success d-flex align-items-center" role="alert" style="font-size: 1.25rem;">
          <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Éxito:">
            <use xlink:href="#check-circle-fill"/>
          </svg>
          ¡Camiseta eliminada exitosamente!
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal" onclick="window.location.reload()">Aceptar</button>
      </div>
    </div>
  </div>
</div>

<script>
  let camisetaId = null;

  function confirmarEliminacion(id) {
    camisetaId = id;
    const modal = new bootstrap.Modal(document.getElementById('modalConfirmar'));
    modal.show();
  }

  document.getElementById('btnConfirmarEliminar').addEventListener('click', function () {
    if (camisetaId) {
      fetch(`php/eliminar_camiseta.php?id=${camisetaId}`)
        .then(response => response.text())
        .then(data => {
          const modalConfirmar = bootstrap.Modal.getInstance(document.getElementById('modalConfirmar'));
          modalConfirmar.hide();

          const modalExito = new bootstrap.Modal(document.getElementById('modalExito'));
          modalExito.show();
        })
        .catch(err => {
          alert('Ocurrió un error al eliminar la camiseta.');
        });
    }
  });
</script>

<?php include 'includes/footer.php'; ?>
