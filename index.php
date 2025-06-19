<?php
session_start();
require 'admin/config.php';
require 'functions.php';

if (!isset($_SESSION['usuario'])) {
   header('Location: ' . RUTA . 'login.php');
   exit;
}

$conexion = conexion($bd_config);
$usuario = iniciarSession($_SESSION['usuario'], $conexion);

if ($usuario['tipo_usuario'] === 'administrador') {
   header('Location: ' . RUTA . 'productos.php');
} else {
   header('Location: ' . RUTA . 'productos.php');
}
