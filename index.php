<?php
session_start();
// Recuperar información de la sesión
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mundo Camisetas - Inicio</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <!-- Header -->
  <header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="#">Mundo Camisetas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <?php if ($nombreUsuario !== "") { ?>
              <li class="nav-item">
                <span class="nav-link">Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></span>
              </li>
              <li class="nav-item">
                <a href="php/logout.php" class="btn btn-outline-danger">Cerrar Sesión</a>
              </li>
            <?php } else { ?>
              <li class="nav-item">
                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</button>
              </li>
              <li class="nav-item">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">Registro</button>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Hero Section -->
  <main class="container my-5">
    <section class="hero text-center">
      <h1 class="display-4">Bienvenido a Mundo Camisetas</h1>
      <p class="lead">Encuentra la mejor selección de camisetas de fútbol de tus equipos favoritos.</p>
      <a href="#" class="btn btn-primary btn-lg">Ver Catálogo</a>
    </section>

    <!-- Catálogo Destacado -->
    <section class="catalogo mt-5">
      <h2 class="text-center mb-4">Camisetas Destacadas</h2>
      <div class="row">
        <?php
        include 'php/conexion.php';
        $query = "SELECT equipo, liga, precio FROM camisetas LIMIT 4";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            echo '
              <div class="col-md-3 mb-4">
                <div class="card shadow">
                  <div class="card-body text-center">
                    <h5 class="card-title">' . htmlspecialchars($row['equipo']) . '</h5>
                    <p class="card-text text-muted">' . htmlspecialchars($row['liga']) . '</p>
                    <p class="card-text fw-bold">$' . number_format($row['precio'], 2) . '</p>
                    <a href="#" class="btn btn-sm btn-primary">Ver más</a>
                  </div>
                </div>
              </div>
            ';
          }
        } else {
          echo '<p class="text-center">No hay camisetas disponibles en este momento.</p>';
        }
        $conn->close();
        ?>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="site-footer bg-light py-3">
    <div class="container text-center">
      <p>© 2025 Mundo Camisetas. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Modales -->
  <!-- Modal de Login -->
  <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalLoginLabel">Iniciar Sesión</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="php/validar_login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Ingresar</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Registro -->
  <div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success text-white">
          <h5 class="modal-title" id="modalRegistroLabel">Registrarse</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="php/registrar_usuario.php" method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrarse</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
