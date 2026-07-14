<?php
require_once __DIR__ . '/auth.php';
requireAuth();
require_once __DIR__ . '/db.php';

$participants = loadParticipants();
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

$pageTitle = 'Dashboard | ISW-306';
include __DIR__ . '/templates/header.php';
?>
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
  <div>
    <h1 class="h3 mb-1">Panel de Administración</h1>
    <p class="text-muted mb-0">Gestiona los registros de participantes usando el ciclo CRUD completo.</p>
  </div>
  <a href="registro.php" class="btn btn-orange">Agregar participante</a>
</div>

<?php if ($flash): ?>
  <div class="alert alert-success" role="alert"><?= htmlspecialchars($flash, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<div class="row g-4 mb-4">
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h2 class="h5">Participantes registrados</h2>
        <p class="display-5 mb-0"><?= count($participants) ?></p>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <h2 class="h5">Último registro</h2>
        <p class="mb-0 text-muted"><?= count($participants) ? htmlspecialchars(end($participants)['fecha_registro'], ENT_QUOTES, 'UTF-8') : 'N/A' ?></p>
      </div>
    </div>
  </div>
</div>

<div class="card shadow-sm border-0">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Nombre</th>
            <th>Matrícula</th>
            <th>Correo</th>
            <th>Repositorio</th>
            <th>Visibilidad</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($participants)): ?>
            <tr>
              <td colspan="6" class="text-center text-muted py-4">No hay registros disponibles.</td>
            </tr>
          <?php else: ?>
            <?php foreach ($participants as $participant): ?>
              <tr>
                <td><?= htmlspecialchars($participant['nombre'] . ' ' . $participant['apellido'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($participant['matricula'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($participant['correo'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><a href="<?= htmlspecialchars($participant['repo_url'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" rel="noopener noreferrer"><?= htmlspecialchars($participant['repo_nombre'], ENT_QUOTES, 'UTF-8') ?></a></td>
                <td><?= htmlspecialchars($participant['privacidad'], ENT_QUOTES, 'UTF-8') ?></td>
                <td class="text-nowrap">
                  <a href="edit.php?id=<?= urlencode($participant['id']) ?>" class="btn btn-sm btn-outline-primary">Editar</a>
                  <form method="post" action="delete.php" class="d-inline-block ms-1">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($participant['id'], ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Eliminar este registro?');">Eliminar</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include __DIR__ . '/templates/footer.php';
