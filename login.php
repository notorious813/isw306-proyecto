<?php
require_once __DIR__ . '/auth.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
$usuario = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $contrasena = trim($_POST['password'] ?? '');

    if (!$usuario || !$contrasena) {
        $error = 'Por favor completa ambos campos.';
    } elseif (authenticateUser($usuario, $contrasena)) {
        loginUser($usuario);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}

$pageTitle = 'Iniciar sesión | ISW-306';
include __DIR__ . '/templates/header.php';
?>
<div class="row justify-content-center">
  <div class="col-md-7 col-lg-5">
    <div class="card shadow-sm">
      <div class="card-body p-4">
        <h1 class="h4 mb-3">Iniciar sesión</h1>
        <p class="text-muted mb-4">Accede al panel de administración para ver y administrar participantes.</p>

        <?php if ($error): ?>
          <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endif; ?>

        <form method="post" novalidate>
          <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" id="usuario" name="usuario" class="form-control" value="<?= htmlspecialchars($usuario, ENT_QUOTES, 'UTF-8') ?>" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" id="password" name="password" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-orange w-100">Ingresar</button>
        </form>

        <hr />
        <p class="small text-muted mb-0">Credenciales de prueba: <strong>admin</strong> / <strong>ISW306!</strong></p>
      </div>
    </div>
  </div>
</div>
<?php include __DIR__ . '/templates/footer.php';
