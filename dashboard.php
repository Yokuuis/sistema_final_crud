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

if (!$usuario) {
   header('Location: ' . RUTA . 'login.php');
   exit;
}

$es_admin = $usuario['tipo_usuario'] === 'administrador';

// Obtener estadísticas reales
$total_productos = 0;
$total_proveedores = 0;
$productos = obtenerProductos($conexion);
$proveedores = obtenerProveedores($conexion);

if ($productos) {
   $total_productos = count($productos);
}
if ($proveedores) {
   $total_proveedores = count($proveedores);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>🏠 Dashboard - Sistema CRUD Pro</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <style>
      :root {
         --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         --secondary-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
         --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
         --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
         --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
         --sidebar-width: 280px;
      }

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      body {
         font-family: 'Poppins', sans-serif !important;
         background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
         min-height: 100vh;
      }

      /* Sidebar Styles */
      .sidebar {
         position: fixed;
         top: 0;
         left: 0;
         width: var(--sidebar-width);
         height: 100vh;
         background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
         z-index: 1000;
         transition: transform 0.3s ease;
         box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
         overflow-y: auto;
      }

      .sidebar.collapsed {
         transform: translateX(-100%);
      }

      .sidebar-header {
         padding: 2rem 1.5rem;
         border-bottom: 1px solid rgba(255, 255, 255, 0.1);
         text-align: center;
      }

      .sidebar-logo {
         width: 60px;
         height: 60px;
         background: var(--primary-gradient);
         border-radius: 15px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1rem;
         box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
         animation: logoFloat 3s ease-in-out infinite;
      }

      @keyframes logoFloat {

         0%,
         100% {
            transform: translateY(0px);
         }

         50% {
            transform: translateY(-8px);
         }
      }

      .sidebar-logo i {
         font-size: 1.5rem;
         color: white;
      }

      .sidebar-title {
         color: white;
         font-size: 1.2rem;
         font-weight: 700;
         margin-bottom: 0.5rem;
      }

      .sidebar-subtitle {
         color: rgba(255, 255, 255, 0.7);
         font-size: 0.9rem;
      }

      .sidebar-nav {
         padding: 1rem 0;
      }

      .nav-item {
         margin: 0.5rem 1rem;
      }

      .nav-link {
         display: flex;
         align-items: center;
         padding: 1rem 1.5rem;
         color: rgba(255, 255, 255, 0.8);
         text-decoration: none;
         border-radius: 12px;
         transition: all 0.3s ease;
         position: relative;
         overflow: hidden;
      }

      .nav-link::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
         transition: left 0.5s;
      }

      .nav-link:hover::before {
         left: 100%;
      }

      .nav-link:hover,
      .nav-link.active {
         background: rgba(255, 255, 255, 0.1);
         color: white;
         transform: translateX(5px);
      }

      .nav-link i {
         margin-right: 1rem;
         font-size: 1.1rem;
         width: 20px;
      }

      .user-info {
         position: absolute;
         bottom: 0;
         left: 0;
         right: 0;
         padding: 1.5rem;
         border-top: 1px solid rgba(255, 255, 255, 0.1);
         background: rgba(0, 0, 0, 0.1);
         text-align: center;
      }

      .user-avatar {
         width: 50px;
         height: 50px;
         background: #43e97b;
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         margin: 0 auto 0.8rem auto;
         color: white;
         font-weight: bold;
         font-size: 1.1rem;
         position: relative;
         box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
      }

      .crown-badge {
         position: absolute;
         bottom: -5px;
         right: -5px;
         font-size: 1rem;
         filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
      }

      .user-name {
         color: white;
         font-weight: 700;
         margin-bottom: 0.3rem;
         font-size: 1rem;
      }

      .user-role {
         color: #ffd700;
         font-size: 0.85rem;
         font-weight: 600;
      }

      /* Main Content */
      .main-content {
         margin-left: var(--sidebar-width);
         min-height: 100vh;
         transition: margin-left 0.3s ease;
      }

      .main-content.expanded {
         margin-left: 0;
      }

      /* Header */
      .header {
         background: rgba(255, 255, 255, 0.95);
         backdrop-filter: blur(20px);
         padding: 1rem 2rem;
         border-bottom: 1px solid rgba(0, 0, 0, 0.1);
         display: flex;
         align-items: center;
         justify-content: space-between;
         position: sticky;
         top: 0;
         z-index: 100;
      }

      .header-left {
         display: flex;
         align-items: center;
      }

      .sidebar-toggle {
         background: none;
         border: none;
         font-size: 1.2rem;
         color: #6c757d;
         margin-right: 1rem;
         padding: 0.5rem;
         border-radius: 8px;
         transition: all 0.3s ease;
      }

      .sidebar-toggle:hover {
         background: rgba(0, 0, 0, 0.1);
         color: #495057;
      }

      .page-title {
         font-size: 1.5rem;
         font-weight: 700;
         background: var(--primary-gradient);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
      }

      .header-right {
         display: flex;
         align-items: center;
         gap: 1rem;
      }

      .btn-logout {
         background: var(--warning-gradient);
         border: none;
         color: white;
         padding: 0.8rem 2rem;
         border-radius: 25px;
         font-weight: 700;
         font-family: 'Poppins', sans-serif;
         transition: all 0.3s ease;
         text-decoration: none;
         display: inline-flex;
         align-items: center;
         font-size: 1rem;
         box-shadow: 0 8px 25px rgba(250, 112, 154, 0.3);
      }

      .btn-logout:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 35px rgba(250, 112, 154, 0.4);
         color: white;
      }

      /* Content Area */
      .content {
         padding: 2rem;
      }

      /* Hero Section */
      .hero-section {
         background: var(--primary-gradient);
         border-radius: 20px;
         padding: 3rem;
         color: white;
         margin-bottom: 2rem;
         position: relative;
         overflow: hidden;
      }

      .hero-section::before {
         content: '';
         position: absolute;
         top: -50%;
         right: -50%;
         width: 100%;
         height: 100%;
         background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
         animation: pulse 4s ease-in-out infinite;
      }

      @keyframes pulse {

         0%,
         100% {
            transform: scale(1) rotate(0deg);
         }

         50% {
            transform: scale(1.1) rotate(180deg);
         }
      }

      .hero-content {
         position: relative;
         z-index: 1;
      }

      .hero-title {
         font-size: 2rem;
         font-weight: 700;
         margin-bottom: 1rem;
         display: flex;
         align-items: center;
      }

      .hero-title i {
         margin-right: 1rem;
         font-size: 2rem;
      }

      .hero-subtitle {
         font-size: 1rem;
         opacity: 0.9;
         margin-bottom: 2rem;
      }

      .hero-stats {
         display: flex;
         gap: 3rem;
         flex-wrap: wrap;
      }

      .hero-stat {
         text-align: center;
      }

      .hero-stat-number {
         font-size: 2rem;
         font-weight: 900;
         margin-bottom: 0.5rem;
      }

      .hero-stat-label {
         font-size: 0.9rem;
         opacity: 0.8;
      }

      /* Stats Grid */
      .stats-grid {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
         gap: 2rem;
         margin-bottom: 2rem;
      }

      .stat-card {
         background: white;
         border-radius: 20px;
         padding: 2rem;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         transition: all 0.3s ease;
         border: 1px solid rgba(0, 0, 0, 0.05);
         position: relative;
         overflow: hidden;
      }

      .stat-card::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         height: 4px;
         background: var(--primary-gradient);
         transform: scaleX(0);
         transition: transform 0.3s ease;
      }

      .stat-card:hover::before {
         transform: scaleX(1);
      }

      .stat-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
      }

      .stat-icon {
         width: 60px;
         height: 60px;
         border-radius: 15px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         font-size: 1.5rem;
         color: white;
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      }

      .stat-title {
         font-size: 0.9rem;
         color: #6c757d;
         margin-bottom: 0.5rem;
         font-weight: 600;
         text-transform: uppercase;
         letter-spacing: 0.5px;
      }

      .stat-value {
         font-size: 2rem;
         font-weight: 900;
         color: #2c3e50;
         margin-bottom: 0.5rem;
      }

      .stat-change {
         font-size: 0.8rem;
         font-weight: 600;
         display: flex;
         align-items: center;
      }

      .stat-change.positive {
         color: #43e97b;
      }

      /* Quick Actions */
      .quick-actions {
         display: grid;
         grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
         gap: 2rem;
         margin-bottom: 2rem;
      }

      .action-card {
         background: white;
         border-radius: 20px;
         padding: 2rem;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         transition: all 0.3s ease;
         text-decoration: none;
         color: inherit;
         display: block;
         border: 1px solid rgba(0, 0, 0, 0.05);
         position: relative;
         overflow: hidden;
      }

      .action-card::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         height: 4px;
         background: var(--success-gradient);
         transform: scaleX(0);
         transition: transform 0.3s ease;
      }

      .action-card:hover::before {
         transform: scaleX(1);
      }

      .action-card:hover {
         transform: translateY(-5px);
         box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
         color: inherit;
      }

      .action-icon {
         width: 50px;
         height: 50px;
         border-radius: 12px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1rem;
         font-size: 1.2rem;
         color: white;
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
      }

      .action-title {
         font-size: 1.2rem;
         font-weight: 800;
         margin-bottom: 0.5rem;
         color: #2c3e50;
      }

      .action-description {
         color: #6c757d;
         font-size: 0.9rem;
         line-height: 1.5;
         font-weight: 500;
      }

      /* Recent Activity */
      .recent-activity {
         background: white;
         border-radius: 20px;
         padding: 2rem;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .section-title {
         font-size: 1.5rem;
         font-weight: 800;
         color: #2c3e50;
         margin-bottom: 1.5rem;
         display: flex;
         align-items: center;
      }

      .section-title i {
         margin-right: 0.8rem;
         color: #667eea;
      }

      .activity-item {
         display: flex;
         align-items: center;
         padding: 1rem 0;
         border-bottom: 1px solid #f8f9fa;
      }

      .activity-item:last-child {
         border-bottom: none;
      }

      .activity-icon {
         width: 40px;
         height: 40px;
         border-radius: 10px;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-right: 1rem;
         font-size: 1rem;
         color: white;
      }

      .activity-content {
         flex: 1;
      }

      .activity-title {
         font-size: 1rem;
         font-weight: 700;
         color: #2c3e50;
         margin-bottom: 0.2rem;
      }

      .activity-description {
         color: #6c757d;
         font-size: 0.85rem;
      }

      .activity-time {
         color: #8e9aaf;
         font-size: 0.75rem;
         font-weight: 600;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
         .sidebar {
            transform: translateX(-100%);
         }

         .sidebar.show {
            transform: translateX(0);
         }

         .main-content {
            margin-left: 0;
         }

         .header {
            padding: 1rem;
         }

         .content {
            padding: 1rem;
         }

         .hero-section {
            padding: 2rem;
         }

         .hero-title {
            font-size: 2rem;
         }

         .hero-stats {
            gap: 2rem;
         }

         .stats-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
         }

         .quick-actions {
            grid-template-columns: 1fr;
            gap: 1rem;
         }
      }

      .overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(0, 0, 0, 0.5);
         z-index: 999;
         display: none;
         backdrop-filter: blur(5px);
      }

      .overlay.show {
         display: block;
      }
   </style>
</head>

<body>
   <!-- Overlay para móvil -->
   <div class="overlay" id="overlay"></div>

   <!-- Sidebar -->
   <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
         <div class="sidebar-logo">
            <i class="fas fa-cube"></i>
         </div>
         <div class="sidebar-title">Sistema CRUD</div>
         <div class="sidebar-subtitle">Panel de Control</div>
      </div>

      <nav class="sidebar-nav">
         <div class="nav-item">
            <a href="dashboard.php" class="nav-link active">
               <i class="fas fa-home"></i>
               <span>Dashboard</span>
            </a>
         </div>
         <div class="nav-item">
            <a href="productos.php" class="nav-link">
               <i class="fas fa-box"></i>
               <span>Productos</span>
            </a>
         </div>
         <div class="nav-item">
            <a href="proveedores.php" class="nav-link">
               <i class="fas fa-truck"></i>
               <span>Proveedores</span>
            </a>
         </div>
      </nav>

      <div class="user-info">
         <div class="user-avatar">
            <?php echo strtoupper(substr($usuario['usuarios'], 0, 2)); ?>
            <?php if ($es_admin): ?>
               <div class="crown-badge">👑</div>
            <?php endif; ?>
         </div>
         <div class="user-name"><?php echo htmlspecialchars($usuario['usuarios']); ?></div>
         <div class="user-role">
            <?php if ($es_admin): ?>
               👑 Administrador
            <?php else: ?>
               Usuario
            <?php endif; ?>
         </div>
      </div>
   </div>

   <!-- Main Content -->
   <div class="main-content" id="mainContent">
      <!-- Header -->
      <header class="header">
         <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
               <i class="fas fa-bars"></i>
            </button>
            <h1 class="page-title">Dashboard Principal</h1>
         </div>
         <div class="header-right">
            <a href="close.php" class="btn-logout">
               <i class="fas fa-sign-out-alt me-2"></i>
               Cerrar Sesión
            </a>
         </div>
      </header>

      <!-- Content -->
      <main class="content">
         <!-- Hero Section -->
         <div class="hero-section">
            <div class="hero-content">
               <h2 class="hero-title">
                  <i class="fas fa-rocket"></i>
                  ¡Bienvenido, <?php echo htmlspecialchars($usuario['usuarios']); ?>!
                  <?php echo $es_admin ? '👑' : '👋'; ?>
               </h2>
               <p class="hero-subtitle">
                  <?php echo $es_admin ? 'Tienes acceso completo al sistema de gestión' : 'Puedes ver y gestionar productos del sistema'; ?>
               </p>
               <div class="hero-stats">
                  <div class="hero-stat">
                     <div class="hero-stat-number"><?php echo $total_productos; ?></div>
                     <div class="hero-stat-label">Productos Totales</div>
                  </div>
                  <div class="hero-stat">
                     <div class="hero-stat-number"><?php echo $total_proveedores; ?></div>
                     <div class="hero-stat-label">Proveedores Activos</div>
                  </div>
                  <div class="hero-stat">
                     <div class="hero-stat-number">100%</div>
                     <div class="hero-stat-label">Sistema Operativo</div>
                  </div>
               </div>
            </div>
         </div>

         <!-- Stats Grid -->
         <div class="stats-grid">
            <div class="stat-card">
               <div class="stat-icon" style="background: var(--primary-gradient);">
                  <i class="fas fa-box"></i>
               </div>
               <div class="stat-title">Total Productos</div>
               <div class="stat-value"><?php echo $total_productos; ?></div>
               <div class="stat-change positive">
                  <i class="fas fa-arrow-up me-1"></i>
                  +12% este mes
               </div>
            </div>

            <div class="stat-card">
               <div class="stat-icon" style="background: var(--success-gradient);">
                  <i class="fas fa-truck"></i>
               </div>
               <div class="stat-title">Proveedores</div>
               <div class="stat-value"><?php echo $total_proveedores; ?></div>
               <div class="stat-change positive">
                  <i class="fas fa-arrow-up me-1"></i>
                  +2 nuevos
               </div>
            </div>

            <div class="stat-card">
               <div class="stat-icon" style="background: var(--secondary-gradient);">
                  <i class="fas fa-chart-line"></i>
               </div>
               <div class="stat-title">Ventas del Mes</div>
               <div class="stat-value">$15,750</div>
               <div class="stat-change positive">
                  <i class="fas fa-arrow-up me-1"></i>
                  +18% vs anterior
               </div>
            </div>

            <div class="stat-card">
               <div class="stat-icon" style="background: var(--warning-gradient);">
                  <i class="fas fa-star"></i>
               </div>
               <div class="stat-title">Productos Destacados</div>
               <div class="stat-value">24</div>
               <div class="stat-change positive">
                  <i class="fas fa-arrow-up me-1"></i>
                  Más vendidos
               </div>
            </div>
         </div>

         <!-- Quick Actions -->
         <div class="quick-actions">
            <a href="productos.php" class="action-card">
               <div class="action-icon" style="background: var(--primary-gradient);">
                  <i class="fas fa-box"></i>
               </div>
               <div class="action-title">Gestionar Productos</div>
               <div class="action-description">
                  <?php echo $es_admin ? 'Crear, editar y eliminar productos del inventario' : 'Ver y agregar nuevos productos al sistema'; ?>
               </div>
            </a>

            <a href="proveedores.php" class="action-card">
               <div class="action-icon" style="background: var(--success-gradient);">
                  <i class="fas fa-truck"></i>
               </div>
               <div class="action-title">Gestionar Proveedores</div>
               <div class="action-description">
                  <?php echo $es_admin ? 'Administrar información de proveedores y distribuidores' : 'Ver información de proveedores disponibles'; ?>
               </div>
            </a>

            <a href="#" class="action-card">
               <div class="action-icon" style="background: var(--secondary-gradient);">
                  <i class="fas fa-chart-bar"></i>
               </div>
               <div class="action-title">Reportes y Analytics</div>
               <div class="action-description">Analizar ventas, tendencias y generar reportes detallados</div>
            </a>
         </div>

         <!-- Recent Activity -->
         <div class="recent-activity">
            <h3 class="section-title">
               <i class="fas fa-clock"></i>
               Actividad Reciente
            </h3>

            <div class="activity-item">
               <div class="activity-icon" style="background: var(--success-gradient);">
                  <i class="fas fa-plus"></i>
               </div>
               <div class="activity-content">
                  <div class="activity-title">Nuevo producto agregado</div>
                  <div class="activity-description">Se agregó "Laptop Gaming RGB Pro" al inventario</div>
               </div>
               <div class="activity-time">Hace 2 horas</div>
            </div>

            <div class="activity-item">
               <div class="activity-icon" style="background: var(--primary-gradient);">
                  <i class="fas fa-edit"></i>
               </div>
               <div class="activity-content">
                  <div class="activity-title">Producto actualizado</div>
                  <div class="activity-description">Se actualizó el precio de "Mouse Inalámbrico Premium"</div>
               </div>
               <div class="activity-time">Hace 4 horas</div>
            </div>

            <div class="activity-item">
               <div class="activity-icon" style="background: var(--warning-gradient);">
                  <i class="fas fa-truck"></i>
               </div>
               <div class="activity-content">
                  <div class="activity-title">Nuevo proveedor</div>
                  <div class="activity-description">Se registró "TechSupply México" como proveedor</div>
               </div>
               <div class="activity-time">Ayer</div>
            </div>

            <div class="activity-item">
               <div class="activity-icon" style="background: var(--secondary-gradient);">
                  <i class="fas fa-chart-line"></i>
               </div>
               <div class="activity-content">
                  <div class="activity-title">Reporte generado</div>
                  <div class="activity-description">Reporte mensual de ventas completado</div>
               </div>
               <div class="activity-time">Hace 2 días</div>
            </div>
         </div>
      </main>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
      // Sidebar Toggle
      const sidebarToggle = document.getElementById('sidebarToggle');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const overlay = document.getElementById('overlay');

      sidebarToggle.addEventListener('click', function() {
         if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
         } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
         }
      });

      overlay.addEventListener('click', function() {
         sidebar.classList.remove('show');
         overlay.classList.remove('show');
      });

      // Responsive behavior
      window.addEventListener('resize', function() {
         if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
         }
      });

      // Smooth animations
      document.addEventListener('DOMContentLoaded', function() {
         const cards = document.querySelectorAll('.stat-card, .action-card');
         cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.style.animation = 'slideUp 0.6s ease-out forwards';
         });
      });

      // Add slideUp animation
      const style = document.createElement('style');
      style.textContent = `
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
      document.head.appendChild(style);
   </script>
</body>

</html>