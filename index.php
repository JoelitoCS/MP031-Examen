<?php
session_start();

require 'config.php'; // incluimos la conexión

if(!isset($_SESSION['user_id'])){
    // Si el usuario no ha iniciado sesión, redirigir al panel correspondiente
    header("Location: login.php");
    exit();
}


$stmt = $mysqli->query("SELECT * FROM visitas");

if (!$stmt) {
  die("Error en la consulta: " . $mysqli->error);
}


$visitas = $stmt->fetch_all(MYSQLI_ASSOC); // obtenemos todos los resultados


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>HappyPets - Panel</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 70px; background-color: #f8f9fa; }
        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table th { background-color: #0d6efd; color: white; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">HappyPets</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <?php if ($_SESSION['user_rol']=='admin'): ?>
            <li class="nav-item"><a class="nav-link" href="adminPanel.php">Panel Admin</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="veterinarioPanel.php">Panel Veterinari</a></li>
        <li class="nav-item"><a class="nav-link" href="login.php">Iniciar Sesión</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Registrate</a></li>
        <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
      </ul>
    </div>
  </div>
</nav>



<div class="container">
    <h1>¡Bienvenido a HappyPets!</h1>
    <h2>
        Aqui podrás ver las visitas.
    </h2>
    <h1 class="mb-4">Visitas</h1>

    <?php if(empty($visitas)): ?>
        <p>No hay visitas registradas.</p>
    <?php else: ?>
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($visitas as $v): ?>
            <tr>
                <td><?= $v['fecha'] ?></td>
                <td><?= $v['diagnostico'] ?></td>
                <td><?= $v['tratamiento'] ?></td>
                <?php if ($_SESSION['user_rol']=='veterinario' || 'admin'): ?>
                <td><a href="editVisitas.php?id=">Editar</a></td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>