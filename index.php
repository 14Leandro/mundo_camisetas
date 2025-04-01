<?php
session_start();
$nombreUsuario = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : "";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Archivo CSS personalizado -->
  <link rel="stylesheet" href="assets/css/style.css?v=1.0">
</head>
<body>
  <!-- Header -->
  <?php include("includes/header.php"); ?>
  
  <!-- Mensaje Flash de registro exitoso -->
  <?php if (isset($_SESSION['mensaje_exito']) && !empty($_SESSION['mensaje_exito'])): ?>
    <div class="flash-message-container">
      <div class="flash-message" id="flashMessage">
        <i class="bi bi-check-circle-fill"></i>
        <span><?php echo htmlspecialchars($_SESSION['mensaje_exito']); unset($_SESSION['mensaje_exito']); ?></span>
        <button type="button" class="close-btn" aria-label="Cerrar mensaje" onclick="document.getElementById('flashMessage').style.display='none';">&times;</button>
      </div>
    </div>
  <?php endif; ?>
  
  <!-- Main Content -->
  <main>
    <!-- Hero Section -->
    <section class="hero">
      <div class="container">
        <h1>Descubre las Camisetas de tus Sueños</h1>
        <p>Tenemos la mejor selección de camisetas de fútbol para los verdaderos aficionados.</p>
        <a href="catalogo.php" class="btn btn-light btn-lg">Ver Catálogo</a>
      </div>
    </section>
    
    <!-- Catálogo Destacado -->
    <section class="catalogo py-5">
      <div class="container">
        <h2 class="text-center mb-5">Camisetas Destacadas</h2>
        <div class="row">
          <?php
          include 'php/conexion.php';
          // Incluir el campo "id" en la consulta para identificar cada camiseta.
          $query = "SELECT id, equipo, liga, precio, imagen FROM camisetas LIMIT 4";
          $result = $conn->query($query);
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-3 mb-4">';
                echo '  <div class="card shadow-sm h-100">';
                // Mostrar la imagen o una placeholder si no existe.
                if (!empty($row['imagen'])) {
                  echo '    <img src="uploads/camisetas/' . htmlspecialchars($row['imagen']) . '" class="card-img-top" alt="Imagen de ' . htmlspecialchars($row['equipo']) . '">';
                } else {
                  echo '    <img src="assets/img/camiseta-placeholder.jpg" class="card-img-top" alt="Imagen no disponible">';
                }
                echo '    <div class="card-body">';
                echo '      <h5 class="card-title">' . htmlspecialchars($row['equipo']) . '</h5>';
                echo '      <p class="card-text text-muted">' . htmlspecialchars($row['liga']) . '</p>';
                echo '      <p class="card-text fw-bold">$' . number_format($row['precio'], 2) . '</p>';
                // Incorporamos el id en el enlace para dirigir al detalle de la camiseta.
                echo '      <a href="ver_camiseta.php?id=' . $row['id'] . '" class="btn btn-outline-primary btn-sm">Ver más</a>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
              }
          } else {
            echo '<p class="text-center">No hay camisetas disponibles en este momento.</p>';
          }
          $conn->close();
          ?>
        </div>
      </div>
    </section>
  </main>
  
  <?php
  // Footer
  include("includes/footer.php");
  ?>
  
  <!-- Modals -->
  <!-- Modal de Iniciar Sesión -->
  <div class="modal fade" id="modalLogin" tabindex="-1" aria-labelledby="modalLoginLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="modalLoginLabel">Iniciar Sesión</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <?php if (isset($_SESSION['mensaje_error_login']) && $_SESSION['mensaje_error_login'] != "") { ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo htmlspecialchars($_SESSION['mensaje_error_login']); ?>
            </div>
          <?php } ?>
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
          <?php if (isset($_SESSION['mensaje_error']) && $_SESSION['mensaje_error'] != "") { ?>
            <div class="alert alert-danger text-center" role="alert">
              <?php echo htmlspecialchars($_SESSION['mensaje_error']); ?>
            </div>
          <?php } ?>
          <?php if (isset($_SESSION['mensaje_exito']) && $_SESSION['mensaje_exito'] != "") { ?>
            <div class="alert alert-success" role="alert">
              <?php echo htmlspecialchars($_SESSION['mensaje_exito']); ?>
            </div>
          <?php } ?>
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
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/script.js" lang="javascript"></script>
</body>
</html>