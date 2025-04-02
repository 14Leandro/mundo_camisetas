<?php
session_start();
include '../php/conexion.php'; // Ajusta la ruta según la estructura de tu proyecto

// Procesar actualización del stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['product_id'], $_POST['stock'])) {
        $product_id = intval($_POST['product_id']);
        $stock = intval($_POST['stock']);

        // Actualizamos el stock de producto
        $stmt = $conn->prepare("UPDATE camisetas SET stock = ? WHERE id = ?");
        if ($stmt === false) {
            die("Error en la consulta: " . $conn->error);
        }
        $stmt->bind_param("ii", $stock, $product_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['message'] = "Stock actualizado correctamente.";
        header("Location: stock.php");
        exit();
    }
}

// Obtener la lista de productos con su stock
$result = $conn->query("SELECT id, nombre, stock FROM camisetas");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administrar Stock - Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Archivo CSS personalizado (opcional) -->
  <link rel="stylesheet" href="../assets/css/style.css?v=1.0">
</head>
<body>
  <!-- Puedes incluir tu header de administración si lo tengas -->
  <?php include("includes/admin_header.php"); ?>
  
  <div class="container my-5">
    <h1 class="mb-4">Administrar Stock</h1>
    
    <?php if (isset($_SESSION['message'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php 
          echo htmlspecialchars($_SESSION['message']); 
          unset($_SESSION['message']);
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
      </div>
    <?php endif; ?>
    
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo htmlspecialchars($row['nombre']); ?></td>
              <td>
                <!-- Formulario para actualizar el stock para este producto -->
                <form method="POST" action="stock.php" class="d-flex align-items-center">
                  <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                  <input type="number" name="stock" value="<?php echo $row['stock']; ?>" class="form-control" style="width: 100px;" required>
              </td>
              <td>
                  <button type="submit" class="btn btn-primary btn-sm">Actualizar</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="4" class="text-center">No se encontraron productos.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  
  <!-- Footer o scripts adicionales -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
