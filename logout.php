<?php
require_once __DIR__ . '/auth.php';
logoutUser();
setFlash('Sesión cerrada correctamente.');
header('Location: login.php');
exit;
