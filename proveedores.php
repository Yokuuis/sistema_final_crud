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
$es_admin = $usuario['tipo_usuario'] === 'administrador';

$mensaje = '';
$tipo_mensaje = '';

// Crear proveedor (todos los usuarios pueden crear)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_proveedor'])) {
   $nombre = limpiarDatos($_POST['nombre']);
   $contacto = limpiarDatos($_POST['contacto']);
   $telefono = limpiarDatos($_POST['telefono']);
   $email = limpiarDatos($_POST['email']);

   $datos = [
      ':nombre' => $nombre,
      ':contacto' => $contacto,
      ':telefono' => $telefono,
      ':email' => $email
   ];

   if (crearProveedor($conexion, $datos)) {
      $mensaje = 'Proveedor creado exitosamente';
      $tipo_mensaje = 'success';
   } else {
      $mensaje = 'Error al crear el proveedor';
      $tipo_mensaje = 'error';
   }
}

// Actualizar proveedor (solo administradores)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_proveedor']) && $es_admin) {
   $id = $_POST['id'];
   $nombre = limpiarDatos($_POST['nombre']);
   $contacto = limpiarDatos($_POST['contacto']);
   $telefono = limpiarDatos($_POST['telefono']);
   $email = limpiarDatos($_POST['email']);

   $datos = [
      ':id' => $id,
      ':nombre' => $nombre,
      ':contacto' => $contacto,
      ':telefono' => $telefono,
      ':email' => $email
   ];

   if (actualizarProveedor($conexion, $datos)) {
      $mensaje = 'Proveedor actualizado exitosamente';
      $tipo_mensaje = 'success';
   } else {
      $mensaje = 'Error al actualizar el proveedor';
      $tipo_mensaje = 'error';
   }
}

// Eliminar proveedor (solo administradores)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_proveedor']) && $es_admin) {
   $id = $_POST['id'];

   if (eliminarProveedor($conexion, $id)) {
      $mensaje = 'Proveedor eliminado exitosamente';
      $tipo_mensaje = 'success';
   } else {
      $mensaje = 'Error al eliminar el proveedor';
      $tipo_mensaje = 'error';
   }
}

$proveedores = obtenerProveedores($conexion);

require 'views/proveedores.view.php';
