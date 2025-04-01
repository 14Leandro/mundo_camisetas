<?php
session_start();
include 'php/conexion.php';

// Verificar que el id esté presente y sea numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);

// Consulta para obtener todos los datos de la camiseta
$stmt = $conn->prepare("SELECT equipo, liga, precio, imagen, descripcion FROM camisetas WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 0) {
    echo "<div class='container mt-5'><h3 class='text-center'>Camiseta no encontrada.</h3></div>";
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
</head>
<body>
  <!-- Header (Incluye tu header reutilizable) -->
  <?php include("includes/header.php"); ?>
  
  <!-- Detalle de la Camiseta -->
  <!-- Detalle de la Camiseta -->
<div class="container my-5">
  <div class="row g-4">
    <!-- Columna de la imagen (usando el contenedor que ya definimos) -->
    <div class="col-md-6">
      <div class="img-container">
        <?php if(!empty($camiseta['imagen'])): ?>
          <img src="uploads/camisetas/<?php echo htmlspecialchars($camiseta['imagen']); ?>" class="img-fluid" alt="Imagen de <?php echo htmlspecialchars($camiseta['equipo']); ?>">
        <?php else: ?>
          <img src="assets/img/camiseta-placeholder.jpg" class="img-fluid" alt="Imagen no disponible">
        <?php endif; ?>
      </div>
    </div>
    
    <!-- Columna de detalles (nombre, precio, descripción, botón de comprar) -->
    <div class="col-md-6">
      <h2 class="mb-3"><?php echo htmlspecialchars($camiseta['equipo']); ?></h2>
      <p class="text-muted h5"><?php echo htmlspecialchars($camiseta['liga']); ?></p>
      <p class="fw-bold fs-4 text-success">$<?php echo number_format($camiseta['precio'], 2); ?></p>
      <hr>
      <p class="lead"><?php echo nl2br(htmlspecialchars($camiseta['descripcion'] ?? 'Sin descripción.')); ?></p>
      <div class="mt-4">
      <a href="comprar.php?id=<?php echo $id; ?>" class="btn-compra">
        <i class="bi bi-cart-check-fill me-2"></i> Comprar
      </a>
      </div>
    </div>
  </div>
</div>

  
  <!-- Sección de Comentarios -->
  <div class="container my-5">
    <h3 class="mb-4">Comentarios</h3>
    
    <!-- Formulario para agregar un comentario (funcionalidad a programar posteriormente) -->
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">Añade tu comentario</h5>
        <form action="#" method="post" id="comentarioForm">
          <div class="mb-3">
            <textarea class="form-control" name="comentario" id="comentario" rows="3" placeholder="Escribe aquí tu comentario..."></textarea>
          </div>
          <button type="submit" class="btn btn-success">Publicar comentario</button>
        </form>
        <small class="text-muted">Funcionalidad en construcción</small>
      </div>
    </div>
    
    <!-- Listado de comentarios -->
    <div id="listaComentarios">
      <!-- Aquí se cargarán los comentarios cuando programes la funcionalidad; por ahora mostramos un mensaje -->
      <div class="alert alert-info" role="alert">
        No hay comentarios por el momento. ¡Sé el primero en comentar!
      </div>
    </div>
  </div>
  
  <!-- Footer (Incluye tu footer reutilizable) -->
  <?php include("includes/footer.php"); ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Puedes agregar un script para manejar el envío del comentario en el futuro -->
  <script>
    // Ejemplo: Previene el envío del formulario y muestra un mensaje (para recodificar la funcionalidad)
    document.getElementById('comentarioForm').addEventListener('submit', function(e) {
      e.preventDefault();
      alert('La funcionalidad de comentarios se implementará próximamente.');
    });
  </script>
</body>
</html>
