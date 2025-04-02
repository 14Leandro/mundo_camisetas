<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
include 'includes/header.php';
include '../php/conexion.php';

// Procesar actualización de stock
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_stock'])) {
  $product_id = intval($_POST['product_id']);
  $new_stock  = intval($_POST['stock']);

  // Obtener el nombre del nombre para mostrar en el mensaje
  $stmtNombre = $conn->prepare("SELECT nombre FROM camisetas WHERE id = ?");
  if ($stmtNombre === false) {
      die("Error en la consulta: " . $conn->error);
  }
  $stmtNombre->bind_param("i", $product_id);
  $stmtNombre->execute();
  $stmtNombre->bind_result($nombre);
  $stmtNombre->fetch();
  $stmtNombre->close();

  // Actualizar el stock del producto
  $stmt = $conn->prepare("UPDATE camisetas SET stock = ? WHERE id = ?");
  if ($stmt === false) {
      die("Error en la consulta: " . $conn->error);
  }
  $stmt->bind_param("ii", $new_stock, $product_id);
  if ($stmt->execute()) {
      $_SESSION['message'] = "Stock actualizado para la camiseta: " . htmlspecialchars($nombre);
  } else {
      $_SESSION['message'] = "Error actualizando stock: " . $stmt->error;
  }
  $stmt->close();
  header("Location: admin_camisetas.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrar Camisetas - Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Archivo CSS personalizado -->
  <link rel="stylesheet" href="assets/css/style.css?v=1.0">
</head>
<body>
  <main class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Gestionar Camisetas</h2>
      <a href="agregar_camiseta.php" class="btn btn-success">
        <i class="fas fa-plus me-1"></i> Agregar Nueva Camiseta
      </a>
    </div>

    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?php 
          echo htmlspecialchars($_SESSION['message']); 
          unset($_SESSION['message']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>

    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre del producto</th>
            <th>Liga</th>
            <th>Precio</th>
            <th>Stock</th>
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
                  echo '<td>' . htmlspecialchars($row["nombre"] ?? '') . '</td>';
                  echo '<td>' . htmlspecialchars($row["liga"] ?? '') . '</td>';
                  echo '<td>$' . number_format($row["precio"] ?? 0, 2) . '</td>';

                  // Columna Stock con formulario inline para actualizar
                  echo '<td>';
                    echo '<form method="POST" action="admin_camisetas.php" class="d-flex align-items-center">';
                        echo '<input type="hidden" name="product_id" value="' . $row["id"] . '">';
                        echo '<input type="number" name="stock" value="' . htmlspecialchars($row["stock"]) . '" class="form-control" style="width:80px;" required>';
                        echo '<button type="submit" name="update_stock" class="btn btn-sm btn-primary ms-2">Actualizar</button>';
                    echo '</form>';
                  echo '</td>';

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
              echo '<tr><td colspan="8" class="text-center">No se encontraron camisetas.</td></tr>';
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
</body>
</html>
