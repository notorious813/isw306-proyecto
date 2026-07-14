<?php
require_once __DIR__ . '/auth.php';
requireAuth();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = trim($_POST['id']);
    if (deleteParticipant($id)) {
        $_SESSION['flash'] = 'El registro fue eliminado correctamente.';
    } else {
        $_SESSION['flash'] = 'No fue posible eliminar el registro.';
    }
}

header('Location: dashboard.php');
exit;
