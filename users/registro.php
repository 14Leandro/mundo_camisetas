<?php
session_start();
$mensaje_error = "";
if (isset($_SESSION['mensaje_error'])) {
    $mensaje_error = $_SESSION['mensaje_error'];
    unset($_SESSION['mensaje_error']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro de Usuario - Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Estilos personalizados -->
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card form form--registro p-4 shadow" style="max-width: 400px; width: 100%;">
      <h3 class="form__title text-center mb-4">Registro de Usuario</h3>
      
      <!-- Mostrar el mensaje de error en caso de existir -->
      <?php if (!empty($mensaje_error)) { ?>
        <div class="alert alert-danger" role="alert">
          <?php echo htmlspecialchars($mensaje_error); ?>
        </div>
      <?php } ?>

      <form class="form__body" action="../php/registrar_usuario.php" method="POST">
        <div class="form__group mb-3">
          <label for="nombre" class="form__label">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control form__input" required>
        </div>
        <div class="form__group mb-3">
          <label for="email" class="form__label">Correo Electrónico</label>
          <input type="email" name="email" id="email" class="form-control form__input" required>
        </div>
        <div class="form__group mb-3">
          <label for="password" class="form__label">Contraseña</label>
          <input type="password" name="password" id="password" class="form-control form__input" required>
        </div>
        <button type="submit" class="btn form__button w-100">Registrarse</button>
      </form>
      <div class="text-center mt-3">
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a></p>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>