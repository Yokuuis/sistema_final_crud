<?php
session_start();
require 'admin/config.php';
require 'functions.php';

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $usuario = limpiarDatos($_POST['usuario']);
   $password = limpiarDatos($_POST['password']);
   $password = hash('sha512', $password);
   $rol = $_POST['rol'];

   if (empty($usuario) || empty($password) || empty($rol)) {
      $errores .= '<li class="error">Rellene todos los campos</li>';
   } else {
      $conexion = conexion($bd_config);
      if ($conexion) {
         $statement = $conexion->prepare("SELECT * FROM usuarios WHERE usuarios = :usuario LIMIT 1");
         $statement->execute([':usuario' => $usuario]);
         $resultado = $statement->fetch();

         if ($resultado) {
            $errores .= '<li class="error">Este usuario ya existe</li>';
         } else {
            $statement = $conexion->prepare("INSERT INTO usuarios(id, usuarios, password, tipo_usuario) VALUES (NULL, :usuario, :password, :rol)");
            $statement->execute([
               ':usuario' => $usuario,
               ':password' => $password,
               ':rol' => $rol
            ]);
            header('Location: ' . RUTA . 'login.php');
            exit;
         }
      }
   }
}

require 'views/registro.view.php';
