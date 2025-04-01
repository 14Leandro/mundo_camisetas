<?php
// admin/includes/header.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: ../index.php");
    exit();
}
$adminName = htmlspecialchars($_SESSION['nombre']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Administración - Mundo Camisetas</title>
  <!-- Bootstrap CSS -->
   <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome para íconos -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Estilos personalizados para el header -->
  <style>
    .admin-header {
      background: linear-gradient(135deg, #1e3c72, #2a5298);
      padding: 15px 0;
    }
    .admin-header .brand {
      font-size: 1.5rem;
      font-weight: 700;
      color: #fff;
    }
    .admin-header a.nav-link {
      color: #fff;
      font-weight: 500;
      transition: color 0.3s ease;
    }
    .admin-header a.nav-link:hover {
      color: #ffc107;
    }
    @media (max-width: 767.98px) {
      .admin-header .d-flex {
        flex-direction: column;
        text-align: center;
      }
      .admin-header nav {
        margin: 10px 0;
      }
    }
  </style>
</head>
<body>
  <header class="admin-header">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center flex-wrap">
        <!-- Logo y nombre de la marca -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
          <i class="fas fa-tshirt fa-2x me-2 text-white"></i>
          <span class="brand">Mundo Camisetas Admin</span>
        </div>
        <!-- Menú de navegación -->
        <nav class="d-flex">
          <a href="index.php" class="nav-link px-3">Dashboard</a>
          <a href="admin_camisetas.php" class="nav-link px-3">Camisetas</a>
          <a href="admin_usuarios.php" class="nav-link px-3">Usuarios</a>
        </nav>
        <!-- Información del usuario y botón de logout -->
        <div>
          <span class="text-white me-3">Hola, <?php echo $adminName; ?></span>
          <a href="../php/logout.php" class="btn btn-outline-light btn-sm">Cerrar Sesión</a>
        </div>
      </div>
    </div>
  </header>
