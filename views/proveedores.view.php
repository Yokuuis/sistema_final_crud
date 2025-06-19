<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gestión de Proveedores</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
   <style>
      :root {
         --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         --secondary: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
         --success: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
         --warning: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
         --danger: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
         --dark: #2c3e50;
         --light: #ecf0f1;
         --sidebar-width: 300px;
      }

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
      }

      body {
         font-family: 'Poppins', sans-serif;
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
         box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
         overflow-y: auto;
      }

      .sidebar.collapsed {
         transform: translateX(-100%);
      }

      .sidebar-header {
         padding: 2.5rem 2rem;
         border-bottom: 1px solid rgba(255, 255, 255, 0.1);
         text-align: center;
      }

      .sidebar-logo {
         width: 70px;
         height: 70px;
         background: var(--success);
         border-radius: 20px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         box-shadow: 0 15px 35px rgba(67, 233, 123, 0.4);
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
         font-size: 2rem;
         color: white;
      }

      .sidebar-title {
         color: white;
         font-size: 1.4rem;
         font-weight: 800;
         margin-bottom: 0.5rem;
      }

      .sidebar-subtitle {
         color: rgba(255, 255, 255, 0.7);
         font-size: 1rem;
         font-weight: 500;
      }

      .sidebar-nav {
         padding: 2rem 0;
      }

      .nav-item {
         margin: 0.8rem 1.5rem;
      }

      .nav-link {
         display: flex;
         align-items: center;
         padding: 1.2rem 1.8rem;
         color: rgba(255, 255, 255, 0.8);
         text-decoration: none;
         border-radius: 15px;
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         position: relative;
         overflow: hidden;
         font-weight: 600;
      }

      .nav-link::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
         transition: left 0.6s;
      }

      .nav-link:hover::before {
         left: 100%;
      }

      .nav-link:hover,
      .nav-link.active {
         background: rgba(255, 255, 255, 0.15);
         color: white;
         transform: translateX(8px);
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
      }

      .nav-link i {
         margin-right: 1.2rem;
         font-size: 1.3rem;
         width: 25px;
         text-align: center;
      }

      .user-info {
         position: absolute;
         bottom: 0;
         left: 0;
         right: 0;
         padding: 2rem;
         border-top: 1px solid rgba(255, 255, 255, 0.1);
         background: rgba(0, 0, 0, 0.2);
      }

      .user-avatar {
         width: 60px;
         height: 60px;
         background: var(--success);
         border-radius: 50%;
         display: flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1rem;
         color: white;
         font-weight: bold;
         font-size: 1.4rem;
         box-shadow: 0 8px 25px rgba(67, 233, 123, 0.4);
      }

      .user-name {
         color: white;
         font-weight: 700;
         margin-bottom: 0.3rem;
         font-size: 1.1rem;
      }

      .user-role {
         color: rgba(255, 255, 255, 0.7);
         font-size: 0.95rem;
         font-weight: 500;
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
         backdrop-filter: blur(25px);
         padding: 1.5rem 2.5rem;
         border-bottom: 1px solid rgba(0, 0, 0, 0.08);
         display: flex;
         align-items: center;
         justify-content: space-between;
         position: sticky;
         top: 0;
         z-index: 100;
         box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      }

      .header-left {
         display: flex;
         align-items: center;
      }

      .sidebar-toggle {
         background: none;
         border: none;
         font-size: 1.4rem;
         color: #6c757d;
         margin-right: 1.5rem;
         padding: 0.8rem;
         border-radius: 12px;
         transition: all 0.3s ease;
      }

      .sidebar-toggle:hover {
         background: rgba(67, 233, 123, 0.1);
         color: #43e97b;
         transform: scale(1.1);
      }

      .page-title {
         font-size: 2.2rem;
         font-weight: 900;
         background: var(--success);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         margin-bottom: 0.3rem;
      }

      .page-subtitle {
         color: #6c757d;
         font-size: 1rem;
         font-weight: 500;
      }

      .header-right {
         display: flex;
         align-items: center;
         gap: 1.5rem;
      }

      .btn-logout {
         background: var(--warning);
         border: none;
         color: white;
         padding: 0.8rem 2rem;
         border-radius: 25px;
         font-weight: 700;
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
         padding: 3rem;
      }

      /* Hero Section */
      .hero-section {
         background: var(--success);
         border-radius: 25px;
         padding: 3.5rem;
         color: white;
         margin-bottom: 3rem;
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
         background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
         animation: heroFloat 6s ease-in-out infinite;
      }

      @keyframes heroFloat {

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
         font-size: 3rem;
         font-weight: 900;
         margin-bottom: 1rem;
         display: flex;
         align-items: center;
      }

      .hero-title i {
         margin-right: 1rem;
         font-size: 2.5rem;
      }

      .hero-subtitle {
         font-size: 1.3rem;
         opacity: 0.9;
         margin-bottom: 2rem;
         font-weight: 500;
      }

      .hero-stats {
         display: flex;
         gap: 3rem;
         flex-wrap: wrap;
      }

      .hero-stat-number {
         font-size: 2.5rem;
         font-weight: 900;
         margin-bottom: 0.5rem;
      }

      .hero-stat-label {
         font-size: 1rem;
         opacity: 0.8;
         font-weight: 600;
      }

      /* Controls Section */
      .controls-section {
         background: white;
         border-radius: 20px;
         padding: 2.5rem;
         margin-bottom: 3rem;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         border: 1px solid rgba(0, 0, 0, 0.05);
      }

      .controls-header {
         display: flex;
         justify-content: space-between;
         align-items: center;
         margin-bottom: 2rem;
         flex-wrap: wrap;
         gap: 1.5rem;
      }

      .search-container {
         position: relative;
         flex: 1;
         max-width: 400px;
      }

      .search-input {
         width: 100%;
         padding: 1rem 1rem 1rem 3.5rem;
         border: 2px solid #e9ecef;
         border-radius: 15px;
         font-size: 1.05rem;
         font-weight: 500;
         transition: all 0.3s ease;
         background: rgba(248, 249, 250, 0.8);
      }

      .search-input:focus {
         border-color: #43e97b;
         box-shadow: 0 0 0 0.2rem rgba(67, 233, 123, 0.15);
         background: white;
         transform: translateY(-2px);
      }

      .search-icon {
         position: absolute;
         left: 1.2rem;
         top: 50%;
         transform: translateY(-50%);
         color: #6c757d;
         font-size: 1.1rem;
      }

      .controls-buttons {
         display: flex;
         gap: 1rem;
         flex-wrap: wrap;
      }

      .btn-primary-custom {
         background: var(--success);
         border: none;
         color: white;
         padding: 1rem 2rem;
         border-radius: 15px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1.05rem;
         text-decoration: none;
         box-shadow: 0 8px 25px rgba(67, 233, 123, 0.3);
      }

      .btn-primary-custom:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 35px rgba(67, 233, 123, 0.4);
         color: white;
      }

      .btn-secondary-custom {
         background: #6c757d;
         border: none;
         color: white;
         padding: 1rem 2rem;
         border-radius: 15px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1.05rem;
         text-decoration: none;
      }

      .btn-secondary-custom:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 35px rgba(108, 117, 125, 0.4);
         color: white;
      }

      /* Alert Styles */
      .alert-custom {
         padding: 1.5rem 2rem;
         border-radius: 15px;
         margin-bottom: 2rem;
         font-weight: 600;
         display: flex;
         align-items: center;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      }

      .alert-success {
         background: var(--success);
         color: white;
      }

      .alert-danger {
         background: var(--danger);
         color: white;
      }

      /* Products Grid */
      .products-grid {
         display: grid;
         grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
         gap: 2rem;
         margin-bottom: 3rem;
      }

      .product-card {
         background: #fff;
         border-radius: 20px;
         overflow: hidden;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         border: 1px solid rgba(0, 0, 0, 0.05);
         position: relative;
         padding: 2rem 2rem 1.5rem 2rem;
         margin-bottom: 0;
      }

      .product-header {
         display: flex;
         justify-content: space-between;
         align-items: flex-start;
         margin-bottom: 1rem;
      }

      .product-title {
         font-size: 1.4rem;
         font-weight: 800;
         color: #2c3e50;
         margin-bottom: 0.5rem;
         line-height: 1.3;
      }

      .product-label {
         color: #6c757d;
         font-size: 1rem;
         font-weight: 600;
         display: flex;
         align-items: center;
      }

      .product-description {
         color: #6c757d;
         font-size: 1rem;
         line-height: 1.6;
         margin-bottom: 2rem;
         display: -webkit-box;
         line-clamp: 3;
         -webkit-box-orient: vertical;
         overflow: hidden;
      }

      .product-actions {
         display: flex;
         gap: 1rem;
         margin-top: 1.5rem;
      }

      .btn-edit {
         background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
         border: none;
         color: white;
         padding: 0.8rem 1.5rem;
         border-radius: 12px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1rem;
         flex: 1;
         justify-content: center;
         text-decoration: none;
      }

      .btn-edit:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
         color: white;
      }

      .btn-delete {
         background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
         border: none;
         color: white;
         padding: 0.8rem 1.5rem;
         border-radius: 12px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1rem;
         flex: 1;
         justify-content: center;
         text-decoration: none;
      }

      .btn-delete:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 20px rgba(255, 107, 107, 0.3);
         color: white;
      }

      .btn-view {
         background: #6c757d;
         border: none;
         color: white;
         padding: 0.8rem 1.5rem;
         border-radius: 12px;
         font-weight: 600;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 0.95rem;
         flex: 1;
         justify-content: center;
         text-decoration: none;
         opacity: 0.7;
         cursor: not-allowed;
      }

      /* Modal Styles */
      .modal-content {
         border-radius: 20px;
         border: none;
         box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
      }

      .modal-header {
         background: var(--success);
         color: white;
         border-radius: 20px 20px 0 0;
         padding: 2rem;
         border: none;
      }

      .modal-title {
         font-weight: 800;
         font-size: 1.5rem;
         display: flex;
         align-items: center;
      }

      .modal-title i {
         margin-right: 1rem;
      }

      .modal-body {
         padding: 2rem;
      }

      .modal-footer {
         padding: 2rem;
         border-top: 1px solid #e9ecef;
      }

      .btn-modal-primary {
         background: var(--success);
         border: none;
         color: white;
         padding: 1rem 2rem;
         border-radius: 15px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1.05rem;
      }

      .btn-modal-primary:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 20px rgba(67, 233, 123, 0.3);
         color: white;
      }

      .btn-modal-secondary {
         background: #6c757d;
         border: none;
         color: white;
         padding: 1rem 2rem;
         border-radius: 15px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1.05rem;
      }

      .btn-modal-secondary:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 20px rgba(108, 117, 125, 0.3);
         color: white;
      }

      /* Responsive */
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

         .controls-header {
            flex-direction: column;
            align-items: stretch;
         }

         .search-container {
            max-width: none;
         }

         .products-grid {
            grid-template-columns: 1fr;
         }

         .hero-stats {
            flex-direction: column;
            gap: 1.5rem;
         }
      }

      /* Overlay */
      .overlay {
         position: fixed;
         top: 0;
         left: 0;
         width: 100%;
         height: 100%;
         background: rgba(0, 0, 0, 0.5);
         z-index: 999;
         opacity: 0;
         visibility: hidden;
         transition: all 0.3s ease;
      }

      .overlay.show {
         opacity: 1;
         visibility: visible;
      }
   </style>
</head>

<body>
   <!-- Overlay -->
   <div class="overlay" id="overlay"></div>

   <!-- Sidebar -->
   <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
         <div class="sidebar-logo">
            <i class="fas fa-truck"></i>
         </div>
         <div class="sidebar-title">Sistema CRUD</div>
         <div class="sidebar-subtitle">Panel de Control</div>
      </div>

      <nav class="sidebar-nav">
         <div class="nav-item">
            <a href="dashboard.php" class="nav-link">
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
            <a href="proveedores.php" class="nav-link active">
               <i class="fas fa-truck"></i>
               <span>Proveedores</span>
            </a>
         </div>
      </nav>

      <div class="user-info">
         <div class="user-avatar" style="position:relative;">
            <?php echo strtoupper(substr($usuario['usuarios'], 0, 2)); ?>
            <?php if ($es_admin): ?>
               <span style="position:absolute; bottom:-8px; right:-8px; font-size:1.2rem; color:gold;">
                  <i class="fas fa-crown"></i>
               </span>
            <?php endif; ?>
         </div>
         <div class="user-name"><?php echo htmlspecialchars($usuario['usuarios']); ?></div>
         <div class="user-role" style="font-weight:bold;<?php echo $es_admin ? 'color:gold;' : '' ?>">
            <?php echo $es_admin ? '<i class="fas fa-crown"></i> Administrador' : 'Usuario'; ?>
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
            <div>
               <h1 class="page-title">Gestión de Proveedores</h1>
               <p class="page-subtitle">Administra tus proveedores de manera profesional</p>
            </div>
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
                  <i class="fas fa-truck"></i>
                  ¡Bienvenido al Sistema de Proveedores!
               </h2>
               <p class="hero-subtitle">
                  <?php echo $es_admin ? 'Control total sobre tus proveedores con funciones avanzadas' : 'Gestiona y visualiza proveedores de manera eficiente'; ?>
               </p>
               <div class="hero-stats">
                  <div class="hero-stat">
                     <div class="hero-stat-number"><?php echo count($proveedores); ?></div>
                     <div class="hero-stat-label">Proveedores Totales</div>
                  </div>
                  <div class="hero-stat">
                     <div class="hero-stat-number">100%</div>
                     <div class="hero-stat-label">Sistema Activo</div>
                  </div>
                  <div class="hero-stat">
                     <div class="hero-stat-number">24/7</div>
                     <div class="hero-stat-label">Disponibilidad</div>
                  </div>
               </div>
            </div>
         </div>

         <!-- Mensaje de estado -->
         <?php if (!empty($mensaje)): ?>
            <div class="alert-custom <?php echo $tipo_mensaje === 'success' ? 'alert-success' : 'alert-danger'; ?>">
               <i class="fas <?php echo $tipo_mensaje === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> me-2"></i>
               <strong><?php echo $tipo_mensaje === 'success' ? '¡Éxito!' : '¡Error!'; ?></strong> <?php echo $mensaje; ?>
            </div>
         <?php endif; ?>

         <!-- Controls Section -->
         <div class="controls-section">
            <div class="controls-header">
               <div class="search-container">
                  <input type="text" class="search-input" id="searchInput" placeholder="Buscar proveedores...">
                  <i class="fas fa-search search-icon"></i>
               </div>
               <div class="controls-buttons">
                  <button class="btn-secondary-custom" onclick="location.reload()">
                     <i class="fas fa-sync-alt me-2"></i>
                     Actualizar
                  </button>
                  <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createProviderModal">
                     <i class="fas fa-plus me-2"></i>
                     Nuevo Proveedor
                  </button>
               </div>
            </div>
         </div>

         <!-- Providers Grid -->
         <?php if (empty($proveedores)): ?>
            <div class="text-center py-5">
               <i class="fas fa-truck" style="font-size: 4rem; color: #6c757d; margin-bottom: 1rem;"></i>
               <h3 style="color: #6c757d; margin-bottom: 1rem;">No hay proveedores registrados</h3>
               <p style="color: #6c757d;">Comienza agregando tu primer proveedor al sistema.</p>
            </div>
         <?php else: ?>
            <div class="products-grid">
               <?php foreach ($proveedores as $proveedor): ?>
                  <div class="product-card">
                     <div class="product-header">
                        <div>
                           <h3 class="product-title"><?php echo htmlspecialchars($proveedor['nombre']); ?></h3>
                        </div>
                        <div class="product-id">#<?php echo $proveedor['id']; ?></div>
                     </div>

                     <div class="product-info">
                        <div class="product-detail">
                           <i class="fas fa-user"></i>
                           <strong>Contacto:</strong> <?php echo htmlspecialchars($proveedor['contacto']); ?>
                        </div>
                        <div class="product-detail">
                           <i class="fas fa-phone"></i>
                           <strong>Teléfono:</strong> <?php echo htmlspecialchars($proveedor['telefono']); ?>
                        </div>
                        <div class="product-detail">
                           <i class="fas fa-envelope"></i>
                           <strong>Email:</strong> <?php echo htmlspecialchars($proveedor['email']); ?>
                        </div>
                     </div>

                     <div class="product-actions">
                        <?php if ($es_admin): ?>
                           <button class="btn-edit" onclick="editProvider(<?php echo $proveedor['id']; ?>, '<?php echo addslashes($proveedor['nombre']); ?>', '<?php echo addslashes($proveedor['contacto']); ?>', '<?php echo addslashes($proveedor['telefono']); ?>', '<?php echo addslashes($proveedor['email']); ?>')">
                              <i class="fas fa-edit me-2"></i>
                              Editar
                           </button>
                           <button class="btn-delete" onclick="showDeleteProviderModal(<?php echo $proveedor['id']; ?>, '<?php echo addslashes($proveedor['nombre']); ?>')">
                              <i class="fas fa-trash me-2"></i>
                              Eliminar
                           </button>
                        <?php else: ?>
                           <button class="btn-view" disabled>
                              <i class="fas fa-eye me-2"></i>
                              Solo Lectura
                           </button>
                        <?php endif; ?>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>
      </main>
   </div>

   <!-- Modal Crear Proveedor -->
   <div class="modal fade" id="createProviderModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fas fa-plus"></i>
                  Nuevo Proveedor
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                           <label for="nombre">Nombre del Proveedor</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="contacto" name="contacto" placeholder="Contacto" required>
                           <label for="contacto">Persona de Contacto</label>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Teléfono" required>
                           <label for="telefono">Teléfono</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                           <label for="email">Email</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" name="crear_proveedor" class="btn-modal-primary">
                     <i class="fas fa-save me-2"></i>
                     Crear Proveedor
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal Editar Proveedor -->
   <div class="modal fade" id="editProviderModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fas fa-edit"></i>
                  Editar Proveedor
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
               <div class="modal-body">
                  <input type="hidden" id="edit_id" name="id">

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="edit_nombre" name="nombre" placeholder="Nombre" required>
                           <label for="edit_nombre">Nombre del Proveedor</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="edit_contacto" name="contacto" placeholder="Contacto" required>
                           <label for="edit_contacto">Persona de Contacto</label>
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="tel" class="form-control" id="edit_telefono" name="telefono" placeholder="Teléfono" required>
                           <label for="edit_telefono">Teléfono</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="email" class="form-control" id="edit_email" name="email" placeholder="Email" required>
                           <label for="edit_email">Email</label>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" name="actualizar_proveedor" class="btn-modal-primary">
                     <i class="fas fa-save me-2"></i>
                     Actualizar Proveedor
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal Eliminar Proveedor -->
   <div class="modal fade" id="deleteProviderModal" tabindex="-1">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fas fa-trash"></i>
                  Eliminar Proveedor
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
               <div class="modal-body">
                  <input type="hidden" id="delete_id" name="id">
                  <p>¿Estás seguro de que quieres eliminar el proveedor <strong id="delete_nombre"></strong>?</p>
                  <p class="text-muted">Esta acción no se puede deshacer.</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" name="eliminar_proveedor" class="btn-delete">
                     <i class="fas fa-trash me-2"></i>
                     Eliminar
                  </button>
               </div>
            </form>
         </div>
      </div>
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

      // Search functionality
      document.getElementById('searchInput').addEventListener('input', function() {
         const searchTerm = this.value.toLowerCase();
         const cards = document.querySelectorAll('.product-card');

         cards.forEach(card => {
            const title = card.querySelector('.product-title').textContent.toLowerCase();
            const contact = card.querySelector('.product-detail').textContent.toLowerCase();

            if (title.includes(searchTerm) || contact.includes(searchTerm)) {
               card.style.display = 'block';
            } else {
               card.style.display = 'none';
            }
         });
      });

      // Edit provider function
      function editProvider(id, nombre, contacto, telefono, email) {
         document.getElementById('edit_id').value = id;
         document.getElementById('edit_nombre').value = nombre;
         document.getElementById('edit_contacto').value = contacto;
         document.getElementById('edit_telefono').value = telefono;
         document.getElementById('edit_email').value = email;

         new bootstrap.Modal(document.getElementById('editProviderModal')).show();
      }

      // Delete provider function
      function showDeleteProviderModal(id, nombre) {
         document.getElementById('delete_id').value = id;
         document.getElementById('delete_nombre').textContent = nombre;
         new bootstrap.Modal(document.getElementById('deleteProviderModal')).show();
      }

      // Responsive behavior
      window.addEventListener('resize', function() {
         if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
         }
      });
   </script>
</body>

</html>