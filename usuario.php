<?php
session_start();
require 'admin/config.php';
require 'functions.php';

if (!isset($_SESSION['usuario'])) {
   header('Location: ' . RUTA . 'login.php');
   exit;
}

$conexion = conexion($bd_config);
$user = iniciarSession($_SESSION['usuario'], $conexion);

if (!$user || $user['tipo_usuario'] !== 'usuario') {
   header('Location: ' . RUTA . 'admin.php');
   exit;
}

// Redirect to dashboard
header('Location: ' . RUTA . 'dashboard.php');
exit;
