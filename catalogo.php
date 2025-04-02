<?php
session_start();
include 'php/conexion.php';

// Recuperar parámetros del GET
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$filtro   = isset($_GET['filtro']) ? $_GET['filtro'] : '';
$liga     = isset($_GET['liga']) ? trim($_GET['liga']) : '';

// Definir filtros permitidos para el ordenamiento
$allowedFilters = ["precio_asc", "precio_desc", "antiguo", "nuevo"];
if (!in_array($filtro, $allowedFilters)) {
    $filtro = "";
}

// Construir la consulta principal
$query = "SELECT id, nombre, liga, precio, imagen FROM camisetas";
$params = [];
$types  = "";
$conditions = [];

// Condición para búsqueda (nombre o liga)
if (!empty($busqueda)) {
    $conditions[] = "(nombre LIKE ? OR liga LIKE ?)";
    $searchParam = "%" . $busqueda . "%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= "ss";
}

// Condición para filtrar por liga
if (!empty($liga)) {
    $conditions[] = "liga = ?";
    $params[] = $liga;
    $types .= "s";
}

// Incorporar condiciones a la consulta
if (!empty($conditions)) {
    $query .= " WHERE " . implode(" AND ", $conditions);
}

// Agregar ordenamiento según el filtro seleccionado
if ($filtro === "precio_asc") {
    $query .= " ORDER BY precio ASC ";
} elseif ($filtro === "precio_desc") {
    $query .= " ORDER BY precio DESC ";
} elseif ($filtro === "antiguo") {
    $query .= " ORDER BY id ASC ";
} elseif ($filtro === "nuevo") {
    $query .= " ORDER BY id DESC ";
}

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}
if (!empty($conditions)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Catálogo de Camisetas - Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Archivo CSS personalizado -->
  <link rel="stylesheet" href="assets/css/style.css?v=1.0">
  <style>
    /* Ajusta la imagen para que se muestre completa dentro de las cards */
    .card-img-top {
      width: 100%;
      height: 200px !important;
      object-fit: contain !important;
      background-color: #fff;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <?php include("includes/header.php"); ?>
  
  <!-- Main Content -->
  <main class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Catálogo de Camisetas</h2>
      <?php if (!empty($liga)): ?>
        <p class="text-center text-muted liga-busqueda">
          Mostrando productos de la liga: <strong><?php echo htmlspecialchars(ucfirst($liga)); ?></strong>
        </p>
      <?php endif; ?>
      
      <!-- Filtro y Buscador -->
      <form method="GET" action="catalogo.php" class="mb-4">
        <div class="row g-2">
          <div class="col-md-4">
            <input type="text" name="buscar" class="form-control" placeholder="Buscar por equipo o liga" value="<?php echo htmlspecialchars($busqueda); ?>">
          </div>
          <div class="col-md-4">
            <select name="filtro" class="form-select">
              <option value="">Ordenar por:</option>
              <option value="precio_asc" <?php if($filtro == 'precio_asc'){ echo 'selected'; } ?>>Menor precio</option>
              <option value="precio_desc" <?php if($filtro == 'precio_desc'){ echo 'selected'; } ?>>Mayor precio</option>
              <option value="antiguo" <?php if($filtro == 'antiguo'){ echo 'selected'; } ?>>Más Antiguo</option>
              <option value="nuevo" <?php if($filtro == 'nuevo'){ echo 'selected'; } ?>>Más Nuevo</option>
            </select>
          </div>
          <div class="col-md-4">
            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
          </div>
        </div>
        <?php if(!empty($liga)): ?>
          <!-- Se conserva el filtro por liga al realizar una búsqueda -->
          <input type="hidden" name="liga" value="<?php echo htmlspecialchars($liga); ?>">
        <?php endif; ?>
      </form>

      <!-- Resultados -->
      <div class="row">
        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $nombre   = htmlspecialchars($row['nombre'] ?? 'Sin información');
            $ligaName = htmlspecialchars($row['liga'] ?? '');
            $precio   = number_format($row['precio'] ?? 0, 2);
            $imagen   = htmlspecialchars($row['imagen'] ?? '');
        ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($imagen)) { ?>
              <img src="uploads/camisetas/<?php echo $imagen; ?>" class="card-img-top" alt="Imagen de <?php echo $nombre; ?>">
            <?php } else { ?>
              <img src="assets/img/camiseta-placeholder.jpg" class="card-img-top" alt="Imagen no disponible">
            <?php } ?>
            <div class="card-body">
              <h5 class="card-title"><?php echo $nombre; ?></h5>
              <p class="card-text text-muted"><?php echo $ligaName; ?></p>
              <p class="card-text fw-bold">$<?php echo $precio; ?></p>
              <a href="ver_camiseta.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">Ver más</a>
            </div>
          </div>
        </div>
        <?php
          }
        } else {
          echo '<p class="text-center">No se encontraron camisetas.</p>';
        }
        $stmt->close();
        $conn->close();
        ?>
      </div>
    </div>
  </main>
  
  <!-- Footer -->
  <?php include("includes/footer.php"); ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>
