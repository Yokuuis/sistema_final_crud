<?php
session_start();
require 'admin/config.php';
require 'functions.php';

if (!isset($_SESSION['usuario'])) {
   header('Location: ' . RUTA . 'login.php');
   exit;
}

$conexion = conexion($bd_config);
$admin = iniciarSession($_SESSION['usuario'], $conexion);

if (!$admin || $admin['tipo_usuario'] !== 'administrador') {
   header('Location: ' . RUTA . 'usuario.php');
   exit;
}

// Redirect to dashboard
header('Location: ' . RUTA . 'dashboard.php');
exit;
