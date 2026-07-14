<?php
require_once __DIR__ . '/auth.php';
requireLogin();
require_once __DIR__ . '/db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id === false || $id === null) {
    setFlash('Identificador inválido.');
    header('Location: dashboard.php');
    exit;
}

$pdo = getDatabase();
if (deleteParticipant($pdo, $id)) {
    setFlash('Registro eliminado.');
} else {
    setFlash('No se encontró el registro para eliminar.');
}

header('Location: dashboard.php');
exit;
