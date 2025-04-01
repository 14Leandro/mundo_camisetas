<?php
session_start();
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
include 'includes/header.php';
?>
<main class="container mt-4">
  <h2>Agregar Nueva Camiseta</h2>
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
  <form action="php/insertar_camiseta.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="equipo" class="form-label">Equipo</label>
      <input type="text" name="equipo" id="equipo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="liga" class="form-label">Liga</label>
      <input type="text" name="liga" id="liga" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="precio" class="form-label">Precio</label>
      <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control" rows="4" placeholder="Descripción de la camiseta"></textarea>
    </div>
    <div class="mb-3">
      <label for="imagen" class="form-label">Imagen</label>
      <input type="file" name="imagen" id="imagen" class="form-control" accept="image/*">
    </div>
    <button type="submit" class="btn btn-success">Agregar Camiseta</button>
    <a href="admin_camisetas.php" class="btn btn-secondary">Cancelar</a>
  </form>
</main>
<?php include 'includes/footer.php'; ?>