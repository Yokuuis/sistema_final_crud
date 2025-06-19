<?php
session_start();
session_destroy();
require 'admin/config.php';
header('Location: ' . RUTA . 'login.php');
