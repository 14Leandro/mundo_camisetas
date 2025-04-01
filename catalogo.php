<?php
session_start();
include 'php/conexion.php';

// Recuperar parámetros del GET
$busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
$filtro   = isset($_GET['filtro']) ? $_GET['filtro'] : '';

// Definimos los filtros permitidos: precio_asc, precio_desc, antiguo (más antiguo) o nuevo (más nuevo)
$allowedFilters = ["precio_asc", "precio_desc", "antiguo", "nuevo"];
if (!in_array($filtro, $allowedFilters)) {
    $filtro = "";
}

// Construir la consulta principal
$query = "SELECT id, equipo, liga, precio, imagen FROM camisetas";
$params = [];
$types  = "";

if (!empty($busqueda)) {
    // Se busca coincidencias en el campo equipo o liga
    $query .= " WHERE equipo LIKE ? OR liga LIKE ? ";
    $searchParam = "%" . $busqueda . "%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types   .= "ss";
}

// Agregar cláusula de ordenamiento según el filtro elegido
if ($filtro === "precio_asc") {
    $query .= " ORDER BY precio ASC ";
} elseif ($filtro === "precio_desc") {
    $query .= " ORDER BY precio DESC ";
} elseif ($filtro === "antiguo") {
    $query .= " ORDER BY id ASC "; // Los registros con id menor son los más antiguos
} elseif ($filtro === "nuevo") {
    $query .= " ORDER BY id DESC "; // Los registros con id mayor son los más nuevos
}

$stmt = $conn->prepare($query);
if ($stmt === false) {
    die("Error en la preparación de la consulta: " . $conn->error);
}

if (!empty($busqueda)) {
    // En PHP 5.6+ podemos desempaquetar el array de parámetros con "..."
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
  <!-- Archivo CSS personalizado (con query string para evitar caché) -->
  <link rel="stylesheet" href="assets/css/style.css?v=1.0">
  <style>
    /* Ajustamos la imagen para que se muestre completa en la card */
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
  <header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="index.php">Mundo Camisetas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCatalogo">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCatalogo">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
            <li class="nav-item"><a class="nav-link" href="catalogo.php">Catálogo</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>
  
  <!-- Main Content -->
  <main class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Catálogo de Camisetas</h2>
      
      <!-- Filtro y Buscador -->
      <form method="GET" action="catalogo.php" class="mb-4">
        <div class="row g-2">
          <div class="col-md-4">
            <input 
              type="text" 
              name="buscar" 
              class="form-control" 
              placeholder="Buscar por equipo o liga" 
              value="<?php echo htmlspecialchars($busqueda); ?>">
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
      </form>

      <!-- Resultados -->
      <div class="row">
        <?php
        if ($result && $result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $equipo  = htmlspecialchars($row['equipo'] ?? 'Sin información');
            $liga    = htmlspecialchars($row['liga'] ?? '');
            $precio  = number_format($row['precio'] ?? 0, 2);
            $imagen  = htmlspecialchars($row['imagen'] ?? '');
        ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100 shadow-sm">
            <?php if (!empty($imagen)) { ?>
              <img src="uploads/camisetas/<?php echo $imagen; ?>" class="card-img-top" alt="Imagen de <?php echo $equipo; ?>">
            <?php } else { ?>
              <img src="assets/img/camiseta-placeholder.jpg" class="card-img-top" alt="Imagen no disponible">
            <?php } ?>
            <div class="card-body">
              <h5 class="card-title"><?php echo $equipo; ?></h5>
              <p class="card-text text-muted"><?php echo $liga; ?></p>
              <p class="card-text fw-bold">$<?php echo $precio; ?></p>
              <a href="#" class="btn btn-outline-primary btn-sm">Ver más</a>
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
  <footer class="site-footer py-3 bg-dark text-white">
    <div class="container text-center">
      <p class="mb-0">&copy; <?php echo date("Y"); ?> Mundo Camisetas. Todos los derechos reservados.</p>
    </div>
  </footer>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>
