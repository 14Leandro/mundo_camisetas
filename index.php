<?php
session_start();
// Recoger mensajes de sesión (si existen)
$mensaje_error = isset($_SESSION['mensaje_error']) ? $_SESSION['mensaje_error'] : "";
$mensaje_exito = isset($_SESSION['mensaje_exito']) ? $_SESSION['mensaje_exito'] : "";
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
if (!empty($mensaje_error)) unset($_SESSION['mensaje_error']);
if (!empty($mensaje_exito)) unset($_SESSION['mensaje_exito']);
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
                <!-- Botón para abrir el modal de Login -->
                <button class="btn btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#modalLogin">Login</button>
              </li>
              <li class="nav-item">
                <!-- Botón para abrir el modal de Registro -->
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro">Registro</button>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Mensajes de éxito y error -->
  <main class="container my-5">
    <?php if (!empty($mensaje_exito)) { ?>
      <div class="alert alert-success text-center" role="alert">
        <?php echo htmlspecialchars($mensaje_exito); ?>
      </div>
    <?php } ?>
    <?php if (!empty($mensaje_error)) { ?>
      <div class="alert alert-danger text-center" role="alert">
        <?php echo htmlspecialchars($mensaje_error); ?>
      </div>
    <?php } ?>

    <!-- Espacio para contenido principal -->
    <section class="hero">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="hero__title">Bienvenido a Mundo Camisetas</h1>
          <p class="hero__subtitle">Encuentra la mejor selección de camisetas de fútbol de tus equipos favoritos.</p>
          <a href="#" class="btn hero__cta btn-lg btn-primary">Ver Catálogo</a>
        </div>
        <div class="col-md-6">
          <img src="assets/img/hero.jpg" alt="Camisetas de fútbol" class="img-fluid hero__img">
        </div>
      </div>
    </section>
  </main>

  <!-- Modales -->
  <!-- Modal de Login -->
  <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalLoginLabel">Iniciar Sesión</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body bg-light">
          <!-- Mostrar mensaje de error -->
          <?php if (!empty($mensaje_error)) { ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
          <?php } ?>
          <form action="php/validar_login.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" name="email" id="email" class="form-control form-control-lg shadow-sm" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" name="password" id="password" class="form-control form-control-lg shadow-sm" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm">Ingresar</button>
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
        <div class="modal-body bg-light">
          <!-- Mostrar mensaje de éxito -->
          <?php if (!empty($mensaje_exito)) { ?>
            <div class="alert alert-success text-center" role="alert">
              <?php echo htmlspecialchars($mensaje_exito); ?>
            </div>
          <?php } ?>
          <!-- Mostrar mensaje de error -->
          <?php if (!empty($mensaje_error)) { ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo htmlspecialchars($mensaje_error); ?>
            </div>
          <?php } ?>
          <form action="php/registrar_usuario.php" method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" name="nombre" id="nombre" class="form-control form-control-lg shadow-sm" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" name="email" id="email" class="form-control form-control-lg shadow-sm" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" name="password" id="password" class="form-control form-control-lg shadow-sm" required>
            </div>
            <button type="submit" class="btn btn-success w-100 btn-lg shadow-sm">Registrarse</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="site-footer text-center py-3">
    <div class="container">
      <p>© 2025 Mundo Camisetas. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Activar el modal correspondiente si hay un hash en la URL
    const hash = window.location.hash;
    if (hash === "#modalLogin") {
      const loginModal = new bootstrap.Modal(document.getElementById('modalLogin'));
      loginModal.show();
    } else if (hash === "#modalRegistro") {
      const registroModal = new bootstrap.Modal(document.getElementById('modalRegistro'));
      registroModal.show();
    }
  </script>
</body>
</html>