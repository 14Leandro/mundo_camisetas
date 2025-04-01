<?php
session_start();
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
$mensaje_exito = "";
if (isset($_SESSION['mensaje_exito'])) {
    $mensaje_exito = $_SESSION['mensaje_exito'];
    unset($_SESSION['mensaje_exito']);
}
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
        <a class="navbar-brand" href="index.php">Mundo Camisetas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <?php if ($nombreUsuario !== "") { ?>
              <li class="nav-item">
                <span class="nav-link">Bienvenido, <?php echo htmlspecialchars($nombreUsuario); ?></span>
              </li>
            <?php } else { ?>
              <!-- Si no hay sesión de usuario, mostramos las opciones de Login/Registro -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="loginRegisterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Login / Registro
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="loginRegisterDropdown">
                  <li><a class="dropdown-item" href="users/login.php">Iniciar Sesión</a></li>
                  <li><a class="dropdown-item" href="users/registro.php">Registrarse</a></li>
                </ul>
              </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Si existe un mensaje de éxito, se muestra aquí -->
  <?php if (!empty($mensaje_exito)) { ?>
    <div class="alert alert-success text-center" role="alert">
      <?php echo htmlspecialchars($mensaje_exito); ?>
    </div>
  <?php } ?>

  <!-- Resto del contenido de la página -->
  <main class="container my-5">
    <section class="hero">
      <div class="row align-items-center">
        <div class="col-md-6">
          <h1 class="hero__title">Bienvenido a Mundo Camisetas</h1>
          <p class="hero__subtitle">Encuentra la mejor selección de camisetas de fútbol de tus equipos favoritos.</p>
          <a href="#" class="btn hero__cta">Ver Catálogo</a>
        </div>
        <div class="col-md-6">
          <img src="assets/img/hero.jpg" alt="Camisetas de fútbol" class="img-fluid hero__img">
        </div>
      </div>
    </section>
  </main>

  <!-- Footer -->
  <footer class="site-footer">
    <div class="container text-center">
      <p>© 2025 Mundo Camisetas. Todos los derechos reservados.</p>
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>