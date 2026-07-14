<?php
require_once __DIR__ . '/auth.php';
requireAuth();
require_once __DIR__ . '/db.php';

$id = trim($_GET['id'] ?? '');
$participant = getParticipantById($id);

if (!$participant) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$values = [
    'nombre' => $participant['nombre'],
    'apellido' => $participant['apellido'],
    'matricula' => $participant['matricula'],
    'correo' => $participant['correo'],
    'seccion' => $participant['seccion'],
    'periodo' => $participant['periodo'],
    'repo-nombre' => $participant['repo_nombre'],
    'repo-url' => $participant['repo_url'],
    'plataforma' => $participant['plataforma'],
    'privacidad' => $participant['privacidad'] === 'Privado' ? 'Privado' : 'Público',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values['nombre'] = trim($_POST['nombre'] ?? '');
    $values['apellido'] = trim($_POST['apellido'] ?? '');
    $values['matricula'] = trim($_POST['matricula'] ?? '');
    $values['correo'] = trim($_POST['correo'] ?? '');
    $values['seccion'] = trim($_POST['seccion'] ?? '');
    $values['periodo'] = trim($_POST['periodo'] ?? '');
    $values['repo-nombre'] = trim($_POST['repo-nombre'] ?? '');
    $values['repo-url'] = trim($_POST['repo-url'] ?? '');
    $values['plataforma'] = trim($_POST['plataforma'] ?? 'github');
    $values['privacidad'] = isset($_POST['privacidad']) ? 'Privado' : 'Público';

    if ($values['nombre'] === '') {
        $errors['nombre'] = 'El nombre es obligatorio.';
    }

    if ($values['apellido'] === '') {
        $errors['apellido'] = 'El apellido es obligatorio.';
    }

    if (!preg_match('/^\d{4}-\d{4}$/', $values['matricula'])) {
        $errors['matricula'] = 'Formato requerido: AAAA-NNNN (ej. 2023-0001).';
    }

    if (!filter_var($values['correo'], FILTER_VALIDATE_EMAIL)) {
        $errors['correo'] = 'Ingresa un correo institucional válido.';
    }

    if ($values['seccion'] === '') {
        $errors['seccion'] = 'Selecciona una sección.';
    }

    if ($values['periodo'] === '') {
        $errors['periodo'] = 'Selecciona un período académico.';
    }

    if (!preg_match('/^[a-z0-9-]+$/', $values['repo-nombre'])) {
        $errors['repo-nombre'] = 'Solo letras minúsculas, números y guiones.';
    }

    if (!filter_var($values['repo-url'], FILTER_VALIDATE_URL)) {
        $errors['repo-url'] = 'Ingresa una URL válida (ej. https://github.com/...).';
    }

    if (empty($errors)) {
        updateParticipant($id, [
            'nombre' => $values['nombre'],
            'apellido' => $values['apellido'],
            'matricula' => $values['matricula'],
            'correo' => $values['correo'],
            'seccion' => $values['seccion'],
            'periodo' => $values['periodo'],
            'repo_nombre' => $values['repo-nombre'],
            'repo_url' => $values['repo-url'],
            'plataforma' => $values['plataforma'],
            'privacidad' => $values['privacidad'],
        ]);

        $_SESSION['flash'] = 'El registro se actualizó correctamente.';
        header('Location: dashboard.php');
        exit;
    }
}

$pageTitle = 'Editar participante | ISW-306';
include __DIR__ . '/templates/header.php';
?>
<div class="row justify-content-center">
  <div class="col-lg-8">
    <div class="card shadow-sm border-0">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <div>
            <h1 class="h4 mb-1">Editar participante</h1>
            <p class="text-muted mb-0">Actualiza los datos del registro seleccionado.</p>
          </div>
          <a href="dashboard.php" class="btn btn-outline-secondary">Volver</a>
        </div>

        <form method="post" novalidate>
          <div class="row g-3">
            <div class="col-md-6">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($values['nombre'], ENT_QUOTES, 'UTF-8') ?>" class="form-control<?= isset($errors['nombre']) ? ' is-invalid' : '' ?>" required>
              <div class="invalid-feedback"><?= $errors['nombre'] ?? '' ?></div>
            </div>
            <div class="col-md-6">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" id="apellido" name="apellido" value="<?= htmlspecialchars($values['apellido'], ENT_QUOTES, 'UTF-8') ?>" class="form-control<?= isset($errors['apellido']) ? ' is-invalid' : '' ?>" required>
              <div class="invalid-feedback"><?= $errors['apellido'] ?? '' ?></div>
            </div>
          </div>

          <div class="mb-3 mt-3">
            <label for="matricula" class="form-label">Matrícula</label>
            <input type="text" id="matricula" name="matricula" value="<?= htmlspecialchars($values['matricula'], ENT_QUOTES, 'UTF-8') ?>" class="form-control<?= isset($errors['matricula']) ? ' is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['matricula'] ?? '' ?></div>
          </div>

          <div class="mb-3">
            <label for="correo" class="form-label">Correo institucional</label>
            <input type="email" id="correo" name="correo" value="<?= htmlspecialchars($values['correo'], ENT_QUOTES, 'UTF-8') ?>" class="form-control<?= isset($errors['correo']) ? ' is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['correo'] ?? '' ?></div>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label for="seccion" class="form-label">Sección</label>
              <select id="seccion" name="seccion" class="form-select<?= isset($errors['seccion']) ? ' is-invalid' : '' ?>" required>
                <option value="" disabled <?= $values['seccion'] === '' ? 'selected' : '' ?>>Selecciona…</option>
                <option value="01" <?= $values['seccion'] === '01' ? 'selected' : '' ?>>Sección 01</option>
                <option value="02" <?= $values['seccion'] === '02' ? 'selected' : '' ?>>Sección 02</option>
                <option value="03" <?= $values['seccion'] === '03' ? 'selected' : '' ?>>Sección 03</option>
                <option value="04" <?= $values['seccion'] === '04' ? 'selected' : '' ?>>Sección 04</option>
              </select>
              <div class="invalid-feedback"><?= $errors['seccion'] ?? '' ?></div>
            </div>
            <div class="col-md-6">
              <label for="periodo" class="form-label">Período académico</label>
              <select id="periodo" name="periodo" class="form-select<?= isset($errors['periodo']) ? ' is-invalid' : '' ?>" required>
                <option value="" disabled <?= $values['periodo'] === '' ? 'selected' : '' ?>>Selecciona…</option>
                <option value="2025-1" <?= $values['periodo'] === '2025-1' ? 'selected' : '' ?>>2025 — Trimestre I</option>
                <option value="2025-2" <?= $values['periodo'] === '2025-2' ? 'selected' : '' ?>>2025 — Trimestre II</option>
                <option value="2025-3" <?= $values['periodo'] === '2025-3' ? 'selected' : '' ?>>2025 — Trimestre III</option>
              </select>
              <div class="invalid-feedback"><?= $errors['periodo'] ?? '' ?></div>
            </div>
          </div>

          <hr class="my-4">
          <div class="mb-3">
            <label for="repo-nombre" class="form-label">Nombre del repositorio</label>
            <input type="text" id="repo-nombre" name="repo-nombre" value="<?= htmlspecialchars($values['repo-nombre'], ENT_QUOTES, 'UTF-8') ?>" class="form-control<?= isset($errors['repo-nombre']) ? ' is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['repo-nombre'] ?? '' ?></div>
          </div>
          <div class="mb-3">
            <label for="repo-url" class="form-label">URL del repositorio</label>
            <input type="url" id="repo-url" name="repo-url" value="<?= htmlspecialchars($values['repo-url'], ENT_QUOTES, 'UTF-8') ?>" class="form-control<?= isset($errors['repo-url']) ? ' is-invalid' : '' ?>" required>
            <div class="invalid-feedback"><?= $errors['repo-url'] ?? '' ?></div>
          </div>

          <div class="mb-3">
            <label class="form-label d-block">Plataforma</label>
            <div class="btn-group" role="group" aria-label="Plataforma">
              <?php foreach (['github' => 'GitHub', 'gitlab' => 'GitLab', 'otro' => 'Otro'] as $key => $label): ?>
                <input type="radio" class="btn-check" name="plataforma" id="plataforma-<?= $key ?>" value="<?= $key ?>" <?= $values['plataforma'] === $key ? 'checked' : '' ?> autocomplete="off">
                <label class="btn btn-outline-secondary" for="plataforma-<?= $key ?>"><?= $label ?></label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="mb-4 form-check form-switch">
            <input class="form-check-input" type="checkbox" id="privacidad" name="privacidad" <?= $values['privacidad'] === 'Privado' ? 'checked' : '' ?> />
            <label class="form-check-label" for="privacidad">Repositorio privado</label>
          </div>

          <button type="submit" class="btn btn-orange">Actualizar registro</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include __DIR__ . '/templates/footer.php';
