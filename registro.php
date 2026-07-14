<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/db.php';

$pageTitle = 'Registro de participante';
$pdo = getDatabase();
$errors = [];
$values = [
    'nombre' => '',
    'apellido' => '',
    'matricula' => '',
    'correo' => '',
    'seccion' => '',
    'periodo' => '',
    'repo_nombre' => '',
    'repo_url' => '',
    'plataforma' => 'github',
    'privado' => 0,
];
$editingId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editingId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $values = [
        'nombre' => sanitizeValue($_POST['nombre'] ?? ''),
        'apellido' => sanitizeValue($_POST['apellido'] ?? ''),
        'matricula' => sanitizeValue($_POST['matricula'] ?? ''),
        'correo' => sanitizeValue($_POST['correo'] ?? ''),
        'seccion' => sanitizeValue($_POST['seccion'] ?? ''),
        'periodo' => sanitizeValue($_POST['periodo'] ?? ''),
        'repo_nombre' => sanitizeValue($_POST['repo_nombre'] ?? ''),
        'repo_url' => sanitizeValue($_POST['repo_url'] ?? ''),
        'plataforma' => sanitizeValue($_POST['plataforma'] ?? 'github'),
        'privado' => isset($_POST['privado']) ? 1 : 0,
    ];

    if ($values['nombre'] === '') {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }
    if ($values['apellido'] === '') {
        $errors['apellido'] = 'El apellido es obligatorio.';
    }
    if ($values['matricula'] === '' || !preg_match('/^\d{4}-\d{4}$/', $values['matricula'])) {
        $errors['matricula'] = 'Formato requerido: AAAA-NNNN.';
    }
    if ($values['correo'] === '' || !filter_var($values['correo'], FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = 'Ingresa un correo válido.';
    }
    if ($values['seccion'] === '') {
        $errors['seccion'] = 'Selecciona una sección.';
    }
    if ($values['periodo'] === '') {
        $errors['periodo'] = 'Selecciona un periodo académico.';
    }
    if ($values['repo_nombre'] === '') {
        $errors['repo_nombre'] = 'El nombre del repositorio es obligatorio.';
    }
    if ($values['repo_url'] === '' || !filter_var($values['repo_url'], FILTER_VALIDATE_URL)) {
        $errors['repo_url'] = 'Ingresa una URL válida.';
    }
    if (!isset($_POST['acepta_terminos'])) {
        $errors['acepta_terminos'] = 'Debes aceptar los términos antes de guardar.';
    }

    if (empty($errors)) {
        try {
            if ($editingId !== null) {
                updateParticipant($pdo, $editingId, $values);
                setFlash('Registro actualizado con éxito.');
            } else {
                createParticipant($pdo, $values);
                setFlash('Registro creado con éxito.');
            }
            header('Location: dashboard.php');
            exit;
        } catch (PDOException $exception) {
            if (strpos($exception->getMessage(), 'UNIQUE') !== false) {
                $errors['matricula'] = 'Ya existe un participante con esa matrícula.';
            } else {
                $errors['general'] = 'Ocurrió un error al guardar los datos.';
            }
        }
    }
} else {
    $editingId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($editingId !== false && $editingId !== null) {
        $record = fetchParticipant($pdo, $editingId);
        if (!$record) {
            setFlash('Registro no encontrado.');
            header('Location: dashboard.php');
            exit;
        }
        $values = array_merge($values, $record);
    }
}

require_once __DIR__ . '/templates/header.php';
?>
<div class="row justify-content-center">
  <div class="col-xl-9">
    <div class="card shadow-sm">
      <div class="card-body p-5">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3 mb-4">
          <div>
            <h1 class="h3 mb-1"><?= $editingId ? 'Editar participante' : 'Registro de participante' ?></h1>
            <p class="text-muted mb-0">Completa los detalles del proyecto para el seguimiento académico.</p>
          </div>
          <a href="dashboard.php" class="btn btn-outline-secondary">Volver al panel</a>
        </div>

        <?php if (!empty($errors['general'])): ?>
          <div class="alert alert-danger" role="alert"><?= htmlspecialchars($errors['general']) ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
          <?php if ($editingId !== null): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($editingId) ?>">
          <?php endif; ?>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label" for="nombre">Nombre *</label>
              <input id="nombre" name="nombre" class="form-control<?= isset($errors['nombre']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['nombre']) ?>" required>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['nombre'] ?? 'Ingresa el nombre.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="apellido">Apellido *</label>
              <input id="apellido" name="apellido" class="form-control<?= isset($errors['apellido']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['apellido']) ?>" required>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['apellido'] ?? 'Ingresa el apellido.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="matricula">Matrícula *</label>
              <input id="matricula" name="matricula" class="form-control<?= isset($errors['matricula']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['matricula']) ?>" placeholder="2025-0001" required>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['matricula'] ?? 'Formato AAAA-NNNN.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="correo">Correo *</label>
              <input id="correo" name="correo" type="email" class="form-control<?= isset($errors['correo']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['correo']) ?>" placeholder="usuario@institucion.edu" required>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['correo'] ?? 'Ingresa un correo válido.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="seccion">Sección *</label>
              <select id="seccion" name="seccion" class="form-select<?= isset($errors['seccion']) ? ' is-invalid' : '' ?>" required>
                <option value="">Selecciona...</option>
                <?php foreach (['01', '02', '03', '04'] as $section): ?>
                  <option value="<?= $section ?>"<?= $values['seccion'] === $section ? ' selected' : '' ?>>Sección <?= $section ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['seccion'] ?? 'Selecciona una sección.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="periodo">Periodo *</label>
              <select id="periodo" name="periodo" class="form-select<?= isset($errors['periodo']) ? ' is-invalid' : '' ?>" required>
                <option value="">Selecciona...</option>
                <option value="2025-1"<?= $values['periodo'] === '2025-1' ? ' selected' : '' ?>>2025 — Trimestre I</option>
                <option value="2025-2"<?= $values['periodo'] === '2025-2' ? ' selected' : '' ?>>2025 — Trimestre II</option>
                <option value="2025-3"<?= $values['periodo'] === '2025-3' ? ' selected' : '' ?>>2025 — Trimestre III</option>
              </select>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['periodo'] ?? 'Selecciona un periodo.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="repo_nombre">Repositorio *</label>
              <input id="repo_nombre" name="repo_nombre" class="form-control<?= isset($errors['repo_nombre']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['repo_nombre']) ?>" placeholder="isw306-proyecto" required>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['repo_nombre'] ?? 'Ingresa el nombre del repositorio.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label" for="repo_url">URL del repositorio *</label>
              <input id="repo_url" name="repo_url" type="url" class="form-control<?= isset($errors['repo_url']) ? ' is-invalid' : '' ?>" value="<?= htmlspecialchars($values['repo_url']) ?>" placeholder="https://github.com/usuario/isw306-proyecto" required>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['repo_url'] ?? 'Ingresa una URL válida.') ?></div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Plataforma</label>
              <div class="btn-group w-100" role="group" aria-label="Plataforma">
                <?php foreach (['github' => 'GitHub', 'gitlab' => 'GitLab', 'otro' => 'Otro'] as $key => $label): ?>
                  <input type="radio" class="btn-check" name="plataforma" id="platform-<?= $key ?>" value="<?= $key ?>"<?= $values['plataforma'] === $key ? ' checked' : '' ?>>
                  <label class="btn btn-outline-secondary" for="platform-<?= $key ?>"><?= $label ?></label>
                <?php endforeach; ?>
              </div>
            </div>
            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input<?= isset($errors['acepta_terminos']) ? ' is-invalid' : '' ?>" type="checkbox" id="acepta_terminos" name="acepta_terminos" <?= isset($_POST['acepta_terminos']) ? 'checked' : '' ?>>
                <label class="form-check-label" for="acepta_terminos">
                  Confirmo que el repositorio es de mi autoría y cumple con los requisitos del proyecto.
                </label>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['acepta_terminos'] ?? 'Debes aceptar los términos.') ?></div>
              </div>
            </div>
          </div>

          <div class="mt-4 d-flex flex-column flex-sm-row gap-3">
            <button type="submit" class="btn btn-primary">Guardar registro</button>
            <a href="dashboard.php" class="btn btn-outline-secondary">Cancelar</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php';
