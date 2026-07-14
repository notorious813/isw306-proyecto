<?php
require_once __DIR__ . '/db.php';

$participants = loadParticipants();
$participantCount = count($participants);
$pageTitle = 'ISW-306 | Panel Principal';
include __DIR__ . '/templates/header.php';
?>
<div class="py-5 hero-banner rounded-4 shadow-sm text-white overflow-hidden">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <p class="badge bg-orange text-dark mb-3">Proyecto Integrador · Trimestre Actual</p>
      <h1 class="display-5 fw-bold">Desarrollo de <em>Aplicación Web</em> Profesional</h1>
      <p class="lead text-white-75">A lo largo del trimestre construirás de forma incremental una aplicación web funcional dividida en <strong>4 etapas</strong> con soporte de backend, CRUD y sesiones.</p>
      <div class="d-flex flex-wrap gap-2">
        <a href="registro.php" class="btn btn-orange btn-lg">Registrar participante</a>
        <a href="login.php" class="btn btn-outline-light btn-lg">Login administrativo</a>
      </div>
    </div>
    <div class="col-lg-5 mt-4 mt-lg-0">
      <div class="card bg-white bg-opacity-15 border-0 text-white shadow-sm p-4">
        <h2 class="h5">Estado del proyecto</h2>
        <p class="mb-3 text-white-75">Total de registros guardados en el sistema.</p>
        <div class="d-flex align-items-center justify-content-between gap-3">
          <div>
            <p class="display-4 mb-0"><?= $participantCount ?></p>
            <small class="text-white-50">participantes</small>
          </div>
          <div class="text-end">
            <span class="badge bg-white text-navy">Etapa 4</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="mt-5">
  <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">
    <div class="col">
      <article class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Etapa 1 · Maquetación</h3>
          <p class="text-muted">HTML5 semántico, CSS externo y diseño responsive para la base visual del proyecto.</p>
        </div>
      </article>
    </div>
    <div class="col">
      <article class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Etapa 2 · Interactividad</h3>
          <p class="text-muted">JavaScript para validación, navegación y comportamiento del formulario.</p>
        </div>
      </article>
    </div>
    <div class="col">
      <article class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Etapa 3 · Backend</h3>
          <p class="text-muted">Servidor con PHP, almacenamiento local y procesamiento de datos.</p>
        </div>
      </article>
    </div>
    <div class="col">
      <article class="card h-100 shadow-sm">
        <div class="card-body">
          <h3 class="h5">Etapa 4 · Profesionalización</h3>
          <p class="text-muted">Framework CSS, autenticación de sesiones y ciclo CRUD completo.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<section class="mt-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <h2 class="card-title">Criterios de la entrega final</h2>
      <p class="text-muted">La versión final integra frontend estandarizado con Bootstrap, login seguro y administración de registros.</p>
      <ul class="list-group list-group-flush">
        <li class="list-group-item">Uso efectivo de un framework CSS</li>
        <li class="list-group-item">Autenticación con sesiones PHP</li>
        <li class="list-group-item">CRUD completo: crear, leer, actualizar y eliminar</li>
        <li class="list-group-item">Código limpio y sin errores en consola</li>
      </ul>
    </div>
  </div>
</section>

<?php include __DIR__ . '/templates/footer.php';
