<?php
session_start();
require 'admin/config.php';
require 'functions.php';

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $usuario = limpiarDatos($_POST['usuario']);
   $password = limpiarDatos($_POST['password']);
   $password = hash('sha512', $password);

   $conexion = conexion($bd_config);

   if ($conexion) {
      $statement = $conexion->prepare('SELECT * FROM usuarios WHERE usuarios = :usuario AND password = :password');
      $statement->execute([
         ':usuario' => $usuario,
         ':password' => $password
      ]);
      $resultado = $statement->fetch();

      if ($resultado != false) {
         $_SESSION['usuario'] = $usuario;
         header('Location: ' . RUTA . 'index.php');
         exit;
      } else {
         $errores .= '<li class="error">Usuario y/o contraseña incorrectos</li>';
      }
   }
}

require 'views/login.view.php';
