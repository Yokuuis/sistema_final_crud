<?php

function conexion($bd_config)
{
   try {
      $conexion = new PDO('mysql:host=localhost;dbname=' . $bd_config['db_name'], $bd_config['usuario'], $bd_config['password']);
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conexion;
   } catch (PDOException $e) {
      return false;
   }
}

function limpiarDatos($datos)
{
   $datos = trim($datos);
   $datos = htmlspecialchars($datos);
   $datos = filter_var($datos, FILTER_SANITIZE_STRING);
   return $datos;
}

function iniciarSession($usuario, $conexion)
{
   $statement = $conexion->prepare("SELECT * FROM usuarios WHERE usuarios = :usuario");
   $statement->execute([':usuario' => $usuario]);
   return $statement->fetch(PDO::FETCH_ASSOC);
}

function subirImagen($archivo)
{
   $directorio = 'img/';

   // Verificar si el directorio existe, si no, crearlo
   if (!is_dir($directorio)) {
      if (!mkdir($directorio, 0755, true)) {
         return false;
      }
   }

   // Verificar que el archivo se subió correctamente
   if (!isset($archivo['tmp_name']) || !is_uploaded_file($archivo['tmp_name'])) {
      return false;
   }

   // Obtener la extensión del archivo
   $extension = strtolower(pathinfo($archivo['name'], PATHINFO_EXTENSION));

   // Verificar que la extensión sea válida
   $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
   if (!in_array($extension, $extensionesPermitidas)) {
      return false;
   }

   // Generar nombre único para el archivo
   $nombreArchivo = uniqid() . '.' . $extension;
   $rutaCompleta = $directorio . $nombreArchivo;

   // Intentar mover el archivo
   if (move_uploaded_file($archivo['tmp_name'], $rutaCompleta)) {
      return $nombreArchivo;
   }

   return false;
}

function obtenerProductos($conexion)
{
   $statement = $conexion->prepare("SELECT * FROM productos ORDER BY id DESC");
   $statement->execute();
   return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerProveedores($conexion)
{
   $statement = $conexion->prepare("SELECT * FROM proveedores ORDER BY id DESC");
   $statement->execute();
   return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function crearProducto($conexion, $datos)
{
   $statement = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio, proveedor, imagen) VALUES (:nombre, :descripcion, :precio, :proveedor, :imagen)");
   return $statement->execute($datos);
}

function actualizarProducto($conexion, $datos)
{
   $statement = $conexion->prepare("UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, proveedor = :proveedor, imagen = :imagen WHERE id = :id");
   return $statement->execute($datos);
}

function eliminarProducto($conexion, $id)
{
   $statement = $conexion->prepare("DELETE FROM productos WHERE id = :id");
   return $statement->execute([':id' => $id]);
}

function crearProveedor($conexion, $datos)
{
   $statement = $conexion->prepare("INSERT INTO proveedores (nombre, contacto, telefono, email) VALUES (:nombre, :contacto, :telefono, :email)");
   return $statement->execute($datos);
}

function actualizarProveedor($conexion, $datos)
{
   $statement = $conexion->prepare("UPDATE proveedores SET nombre = :nombre, contacto = :contacto, telefono = :telefono, email = :email WHERE id = :id");
   return $statement->execute($datos);
}

function eliminarProveedor($conexion, $id)
{
   $statement = $conexion->prepare("DELETE FROM proveedores WHERE id = :id");
   return $statement->execute([':id' => $id]);
}
