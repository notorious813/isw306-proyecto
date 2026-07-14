<?php
require_once __DIR__ . '/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeValue($_POST['username'] ?? '');
    $password = sanitizeValue($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Por favor ingresa usuario y contraseña.';
    } elseif (!loginUser($username, $password)) {
        $error = 'Usuario o contraseña incorrectos.';
    } else {
        setFlash('Sesión iniciada correctamente.');
        header('Location: dashboard.php');
        exit;
    }
}

$pageTitle = 'Iniciar sesión';
require_once __DIR__ . '/templates/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-8 col-lg-6">
    <div class="card shadow-sm">
      <div class="card-body p-5">
        <h1 class="h3 mb-3">Iniciar sesión</h1>
        <p class="text-muted">Accede al panel para gestionar los registros del proyecto.</p>
        <?php if ($error): ?>
          <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
          <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input id="username" name="username" type="text" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
          </div>
          <div class="mb-4">
            <label for="password" class="form-label">Contraseña</label>
            <input id="password" name="password" type="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <div class="mt-4 text-muted small">
          <p>Usuario de prueba: <strong>admin</strong></p>
          <p>Contraseña: <strong>Proyecto2026!</strong></p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php';
