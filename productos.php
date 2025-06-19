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

// Crear producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['crear_producto'])) {
   $nombre = limpiarDatos($_POST['nombre']);
   $descripcion = limpiarDatos($_POST['descripcion']);
   $precio = limpiarDatos($_POST['precio']);
   $proveedor = limpiarDatos($_POST['proveedor']);

   $imagen = '';
   if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
      $imagen = subirImagen($_FILES['imagen']);
   }

   $datos = [
      ':nombre' => $nombre,
      ':descripcion' => $descripcion,
      ':precio' => $precio,
      ':proveedor' => $proveedor,
      ':imagen' => $imagen
   ];

   if (crearProducto($conexion, $datos)) {
      $mensaje = 'Producto creado exitosamente';
      $tipo_mensaje = 'success';
   } else {
      $mensaje = 'Error al crear el producto';
      $tipo_mensaje = 'error';
   }
}

// Actualizar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar_producto']) && $es_admin) {
   $id = $_POST['id'];
   $nombre = limpiarDatos($_POST['nombre']);
   $descripcion = limpiarDatos($_POST['descripcion']);
   $precio = limpiarDatos($_POST['precio']);
   $proveedor = limpiarDatos($_POST['proveedor']);

   $imagen = $_POST['imagen_actual'];
   if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
      $nueva_imagen = subirImagen($_FILES['imagen']);
      if ($nueva_imagen) {
         $imagen = $nueva_imagen;
      }
   }

   $datos = [
      ':id' => $id,
      ':nombre' => $nombre,
      ':descripcion' => $descripcion,
      ':precio' => $precio,
      ':proveedor' => $proveedor,
      ':imagen' => $imagen
   ];

   if (actualizarProducto($conexion, $datos)) {
      $mensaje = 'Producto actualizado exitosamente';
      $tipo_mensaje = 'success';
   } else {
      $mensaje = 'Error al actualizar el producto';
      $tipo_mensaje = 'error';
   }
}

// Eliminar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['eliminar_producto']) && $es_admin) {
   $id = $_POST['id'];

   if (eliminarProducto($conexion, $id)) {
      $mensaje = 'Producto eliminado exitosamente';
      $tipo_mensaje = 'success';
   } else {
      $mensaje = 'Error al eliminar el producto';
      $tipo_mensaje = 'error';
   }
}

$productos = obtenerProductos($conexion);
$proveedores = obtenerProveedores($conexion);

require 'views/productos.view.php';
