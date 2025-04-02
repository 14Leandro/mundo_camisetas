<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
include 'includes/header.php';
include '../php/conexion.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje_error'] = "ID de la camiseta no especificado.";
    header("Location: admin_camisetas.php");
    exit();
}
$id = intval($_GET['id']);
$query = "SELECT * FROM camisetas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    $_SESSION['mensaje_error'] = "Camiseta no encontrada.";
    header("Location: admin_camisetas.php");
    exit();
}
$camiseta = $result->fetch_assoc();
$stmt->close();
?>
<main class="container mt-4">
  <h2>Editar Camiseta</h2>
  <?php if (isset($_SESSION['mensaje_error'])): ?>
    <div class="alert alert-danger" role="alert">
      <?php echo htmlspecialchars($_SESSION['mensaje_error']); unset($_SESSION['mensaje_error']); ?>
    </div>
  <?php endif; ?>
  <?php if (isset($_SESSION['mensaje_exito'])): ?>
    <div class="alert alert-success" role="alert">
      <?php echo htmlspecialchars($_SESSION['mensaje_exito']); unset($_SESSION['mensaje_exito']); ?>
    </div>
  <?php endif; ?>
  <form action="php/actualizar_camiseta.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo $camiseta['id']; ?>">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($camiseta['nombre']); ?>" required>
    </div>
    <div class="mb-3">
      <label for="liga" class="form-label">Liga</label>
      <input type="text" name="liga" id="liga" class="form-control" value="<?php echo htmlspecialchars($camiseta['liga']); ?>" required>
    </div>
    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" step="0.01" name="precio" id="precio" class="form-control" value="<?php echo htmlspecialchars($camiseta['precio']); ?>" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="4"><?php echo htmlspecialchars($camiseta['descripcion']); ?></textarea>
    </div>
    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen</label>
      <?php if (!empty($camiseta["imagen"])): ?>
        <div class="mb-2">
          <img src="../uploads/camisetas/<?php echo htmlspecialchars($camiseta["imagen"]); ?>" alt="Imagen de la camiseta" style="max-width:150px; height:auto;">
        </div>
      <?php endif; ?>
      <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
      <small class="form-text text-muted">Deja vacío si no deseas cambiar la imagen.</small>
    </div>
    <button type="submit" class="btn btn-primary">Actualizar Camiseta</button>
    <a href="admin_camisetas.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php include 'includes/footer.php'; ?>