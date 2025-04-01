<?php
// Iniciar la sesión si aún no está iniciada.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Determinar la página actual para los enlaces activos.
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Archivo CSS personalizado -->
  <link rel="stylesheet" href="assets/css/style.css?v=1.0">
</head>
<body>
  <!-- Header -->
  <header class="site-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <div class="container">
        <a class="navbar-brand" href="index.php">Mundo Camisetas</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
          <!-- Menú principal -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>" href="index.php">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'catalogo.php') ? 'active' : ''; ?>" href="catalogo.php">Catálogo</a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php echo ($current_page == 'contacto.php') ? 'active' : ''; ?>" href="contacto.php">Contacto</a>
            </li>
          </ul>
          <!-- Menú de usuario -->
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <?php if (isset($_SESSION['nombre']) && !empty($_SESSION['nombre'])): ?>
              <li class="nav-item">
                <span class="navbar-text me-3">Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="php/logout.php">Cerrar Sesión</a>
              </li>
            <?php else: ?>
              <li class="nav-item">
                <!-- Dispara el modal de login -->
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalLogin">Iniciar Sesión</a>
              </li>
              <li class="nav-item">
                <!-- Dispara el modal de registro -->
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#modalRegistro">Registrarse</a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <?php if (!isset($_SESSION['nombre']) || empty($_SESSION['nombre'])): ?>
    <!-- Modal de Iniciar Sesión -->
    <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="modalLoginLabel">Iniciar Sesión</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <!-- Mostrar mensaje de error, si lo hay -->
            <?php if (isset($_SESSION['mensaje_error_login']) && !empty($_SESSION['mensaje_error_login'])): ?>
              <div class="alert alert-danger" role="alert">
                <?php
                  echo htmlspecialchars($_SESSION['mensaje_error_login']);
                  unset($_SESSION['mensaje_error_login']);
                ?>
              </div>
            <?php endif; ?>

            <form action="php/validar_login.php" method="POST">
              <div class="mb-3">
                <label for="login-email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="login-email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="login-password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="login-password" class="form-control" required>
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
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <!-- Mostrar mensaje de error de registro, si lo hay -->
            <?php if (isset($_SESSION['mensaje_error']) && !empty($_SESSION['mensaje_error'])): ?>
              <div class="alert alert-danger" role="alert">
                <?php
                  echo htmlspecialchars($_SESSION['mensaje_error']);
                  unset($_SESSION['mensaje_error']);
                ?>
              </div>
            <?php endif; ?>
            <!-- Mostrar mensaje de éxito en el registro, si lo hay -->
            <?php if (isset($_SESSION['mensaje_exito']) && !empty($_SESSION['mensaje_exito'])): ?>
              <div class="alert alert-success" role="alert">
                <?php
                  echo htmlspecialchars($_SESSION['mensaje_exito']);
                  unset($_SESSION['mensaje_exito']);
                ?>
              </div>
            <?php endif; ?>

            <form action="php/registrar_usuario.php" method="POST">
              <div class="mb-3">
                <label for="registro-nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="registro-nombre" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="registro-email" class="form-label">Correo Electrónico</label>
                <input type="email" name="email" id="registro-email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="registro-password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="registro-password" class="form-control" required>
              </div>
              <button type="submit" class="btn btn-success w-100">Registrarse</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
