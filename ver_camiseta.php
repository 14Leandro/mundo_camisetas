<?php
session_start();
include 'php/conexion.php';

// Validar que se haya pasado un ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Recuperar los datos de la camiseta
$query = "SELECT * FROM camisetas WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    echo "Camiseta no encontrada.";
    exit();
}

$camiseta = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detalle de <?php echo htmlspecialchars($camiseta['equipo']); ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Archivo CSS personalizado -->
  <link rel="stylesheet" href="assets/css/style.css?v=1.0">
  <style>
    .detalle-img {
      width: 100%;
      max-height: 400px;
      object-fit: contain;
      background-color: #fff;
    }
  </style>
</head>
<body>
  <!-- Puedes incluir tu header reutilizando un archivo shared si lo tienes -->
  <?php include 'includes/header.php'; ?>
  
  <div class="container my-5">
    <div class="row">
      <div class="col-md-6">
        <?php if(!empty($camiseta['imagen'])): ?>
          <img src="uploads/camisetas/<?php echo htmlspecialchars($camiseta['imagen']); ?>" class="detalle-img img-fluid" alt="Imagen de <?php echo htmlspecialchars($camiseta['equipo']); ?>">
        <?php else: ?>
          <img src="assets/img/camiseta-placeholder.jpg" class="detalle-img img-fluid" alt="Imagen no disponible">
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <h2><?php echo htmlspecialchars($camiseta['equipo']); ?></h2>
        <p class="text-muted"><?php echo htmlspecialchars($camiseta['liga']); ?></p>
        <p class="fw-bold">$<?php echo number_format($camiseta['precio'], 2); ?></p>
        <p><?php echo htmlspecialchars($camiseta['descripcion'] ?? 'Sin descripción'); ?></p>
        <a href="catalogo.php" class="btn btn-primary">Volver al Catálogo</a>
      </div>
    </div>
  </div>
  
  <!-- Puedes incluir tu footer reutilizando un archivo shared si lo tienes -->
  <?php include 'includes/footer.php'; ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
