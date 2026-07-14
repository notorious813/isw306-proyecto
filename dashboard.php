<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/db.php';

$pageTitle = 'Panel de registros';
$pdo = getDatabase();
$participants = fetchParticipants($pdo);

require_once __DIR__ . '/templates/header.php';
?>
<div class="d-flex flex-column flex-md-row align-items-start justify-content-between gap-3 mb-4">
  <div>
    <h1 class="h2 mb-1">Panel de participantes</h1>
    <p class="text-muted mb-0">Gestiona los registros del proyecto con actualizaciones y eliminaciones seguras.</p>
  </div>
  <a href="registro.php" class="btn btn-primary">Nuevo registro</a>
</div>

<div class="card shadow-sm">
  <div class="card-body p-0">
    <?php if (empty($participants)): ?>
      <div class="p-5 text-center">
        <h2 class="h5 mb-3">No hay registros aún</h2>
        <p class="text-muted mb-3">Agrega el primer participante usando el formulario.</p>
        <a href="registro.php" class="btn btn-secondary">Crear registro</a>
      </div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
          <thead class="text-muted">
            <tr>
              <th>ID</th>
              <th>Nombre</th>
              <th>Matrícula</th>
              <th>Sección</th>
              <th>Repositorio</th>
              <th>Creado</th>
              <th class="text-end">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($participants as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td>
                  <strong><?= htmlspecialchars($user['nombre'] . ' ' . $user['apellido']) ?></strong>
                  <div class="text-muted small"><?= htmlspecialchars($user['correo']) ?></div>
                </td>
                <td><?= htmlspecialchars($user['matricula']) ?></td>
                <td><?= htmlspecialchars($user['seccion']) ?></td>
                <td>
                  <a href="<?= htmlspecialchars($user['repo_url']) ?>" target="_blank" rel="noreferrer noopener" class="link-primary"><?= htmlspecialchars($user['repo_nombre']) ?></a>
                </td>
                <td><?= htmlspecialchars($user['creado_en']) ?></td>
                <td class="text-end">
                  <a href="registro.php?id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-sm btn-outline-primary me-2">Editar</a>
                  <a href="delete.php?id=<?= htmlspecialchars($user['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que deseas eliminar este registro?');">Eliminar</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php';
