<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contacto - Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons (opcional, para redes sociales) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:400,500&display=swap">
  <!-- Estilos personalizados -->
   <link rel="stylesheet" href="assets/css/style.css">
   
</head>
<body>
  <!-- Header / Navegación -->
  <?php
  include("includes/header.php");
  ?>
  
  <!-- Sección de Encabezado -->
  <section class="contact-header">
    <div class="container">
      <h1>Contáctanos</h1>
      <p>Estamos aquí para ayudarte a encontrar tu camiseta ideal y responder tus dudas.</p>
    </div>
  </section>
  <!-- Sección de Información y Formulario de Contacto -->
  <section class="contact-form py-5">
    <div class="container">
      <div class="row g-4">
        <!-- Información de contacto -->
        <div class="col-md-6">
          <h2>Información de Contacto</h2>
          <p>Si tienes alguna pregunta, comentario o sugerencia, no dudes en comunicarte con nosotros.</p>
          <div class="contact-info">
            <p><i class="bi bi-telephone-fill"></i> Teléfono: +54 9 11 1234 5678</p>
            <p><i class="bi bi-envelope-fill"></i> Email: info@mundocamisetas.com</p>
            <p><i class="bi bi-geo-alt-fill"></i> Dirección: Av. del Fútbol 123, Buenos Aires, Argentina</p>
          </div>
          <div class="mt-4">
            <a href="#" class="text-danger me-3"><i class="bi bi-facebook"></i></a>
            <a href="#" class="text-danger me-3"><i class="bi bi-instagram"></i></a>
            <a href="#" class="text-danger"><i class="bi bi-twitter"></i></a>
          </div>
        </div>
        <!-- Formulario de contacto -->
        <div class="col-md-6">
          <h2>Envíanos un Mensaje</h2>
          <form action="procesar_contacto.php" method="post">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre Completo</label>
              <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="tuemail@dominio.com" required>
            </div>
            <div class="mb-3">
              <label for="asunto" class="form-label">Asunto</label>
              <input type="text" class="form-control" id="asunto" name="asunto" placeholder="Asunto del mensaje" required>
            </div>
            <div class="mb-3">
              <label for="mensaje" class="form-label">Mensaje</label>
              <textarea class="form-control" id="mensaje" name="mensaje" rows="5" placeholder="Escribe tu mensaje aquí" required></textarea>
            </div>
            <button type="submit" class="btn btn-contact btn-lg w-100">Enviar Mensaje</button>
          </form>
        </div>
      </div>
    </div>
  </section>
  
  <!-- Footer -->
  <?php
  include("includes/footer.php");
  ?>
  
  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
