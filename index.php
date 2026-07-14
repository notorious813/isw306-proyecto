<?php
require_once __DIR__ . '/auth.php';
$pageTitle = 'ISW-306 | Panel Principal';
require_once __DIR__ . '/templates/header.php';
?>
<div class="row align-items-center gy-4">
  <div class="col-lg-7">
    <div class="p-4 p-md-5 bg-white rounded-4 shadow-sm">
      <span class="badge bg-secondary mb-3">Proyecto Integrador · Etapa Final</span>
      <h1 class="display-5 fw-bold page-title">Aplicación Web Profesional</h1>
      <p class="lead text-muted">Sistema de registro académico con autentificación de sesión y gestión completa de registros usando Bootstrap.</p>
      <div class="d-flex flex-column flex-sm-row gap-3">
        <?php if (isLoggedIn()): ?>
          <a href="dashboard.php" class="btn btn-primary btn-lg">Ir al panel</a>
          <a href="registro.php" class="btn btn-outline-secondary btn-lg">Nuevo participante</a>
        <?php else: ?>
          <a href="login.php" class="btn btn-primary btn-lg">Iniciar sesión</a>
          <a href="registro.php" class="btn btn-outline-secondary btn-lg">Crear cuenta de prueba</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="col-lg-5">
    <div class="card border-0 shadow-sm bg-soft-primary">
      <div class="card-body">
        <h2 class="h5 card-title">Criterios de evaluación</h2>
        <ul class="list-group list-group-flush mt-3">
          <li class="list-group-item">Uso de Bootstrap para estandarizar UI</li>
          <li class="list-group-item">CRUD completo con creación, lectura, actualización y eliminación</li>
          <li class="list-group-item">Autenticación segura con sesiones PHP</li>
          <li class="list-group-item">Rutas privadas protegidas por login</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<section class="mt-5">
  <div class="row g-4">
    <div class="col-md-6">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Etapas acumulativas</h3>
          <p class="text-muted">Cada etapa se integra al flujo de trabajo final: interfaz, lógica, backend y despliegue.</p>
          <div class="d-flex flex-wrap gap-2">
            <span class="badge bg-primary">Maquetación</span>
            <span class="badge bg-primary">Interactividad</span>
            <span class="badge bg-primary">Backend</span>
            <span class="badge bg-primary">Entrega final</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Acceso rápido</h3>
          <ul class="list-unstyled mb-0">
            <li class="mb-2"><strong>Usuario:</strong> admin</li>
            <li><strong>Contraseña:</strong> Proyecto2026!</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/templates/footer.php';
