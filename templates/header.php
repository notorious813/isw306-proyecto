<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$currentPage = basename($_SERVER['PHP_SELF']);

function navClass(string $page): string
{
    global $currentPage;
    return $currentPage === $page ? ' active' : '';
}

$loggedIn = !empty($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8') : 'ISW-306 · Proyecto Integrador' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-PE0aS81VYC1wRJTioW31QCp2LrJUZleaQbBnntw5WtX1o7t1cZZjltI75VyQaqa4" crossorigin="anonymous" />
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/theme.css" />
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-navy shadow-sm">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">
      <span class="text-orange">ISW</span><span class="text-white">·306</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Abrir menú">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
        <li class="nav-item"><a class="nav-link<?= navClass('index.php') ?>" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link<?= navClass('registro.php') ?>" href="registro.php">Registro</a></li>
        <?php if ($loggedIn): ?>
          <li class="nav-item"><a class="nav-link<?= navClass('dashboard.php') ?>" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link<?= navClass('login.php') ?>" href="login.php">Iniciar sesión</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="py-5">
  <div class="container">