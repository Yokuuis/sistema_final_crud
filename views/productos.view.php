<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Gestión de Productos</title>
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
         background: var(--primary);
         border-radius: 20px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
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
         background: rgba(102, 126, 234, 0.1);
         color: #667eea;
         transform: scale(1.1);
      }

      .page-title {
         font-size: 2.2rem;
         font-weight: 900;
         background: var(--primary);
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
         background: var(--primary);
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
         border-color: #667eea;
         box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
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
         box-shadow: 0 8px 25px rgba(67, 233, 123, 0.3);
      }

      .btn-primary-custom:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 35px rgba(67, 233, 123, 0.4);
         color: white;
      }

      .btn-secondary-custom {
         background: var(--secondary);
         border: none;
         color: white;
         padding: 1rem 2rem;
         border-radius: 15px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         font-size: 1.05rem;
         box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
      }

      .btn-secondary-custom:hover {
         transform: translateY(-3px);
         box-shadow: 0 15px 35px rgba(79, 172, 254, 0.4);
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
         background: white;
         border-radius: 20px;
         overflow: hidden;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         border: 1px solid rgba(0, 0, 0, 0.05);
         position: relative;
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
         color: var(--dark);
         margin-bottom: 0.5rem;
         line-height: 1.3;
      }

      .product-supplier {
         color: #6c757d;
         font-size: 1rem;
         font-weight: 600;
         display: flex;
         align-items: center;
      }

      .product-supplier i {
         margin-right: 0.5rem;
         color: #667eea;
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

      .product-image {
         width: 100%;
         height: 200px;
         object-fit: cover;
         transition: transform 0.3s ease;
      }

      .product-card:hover .product-image {
         transform: scale(1.05);
      }

      .product-image-placeholder {
         width: 100%;
         height: 200px;
         background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
         display: flex;
         align-items: center;
         justify-content: center;
         color: #6c757d;
         font-size: 3rem;
      }

      .product-info {
         padding: 2rem;
      }

      .product-label {
         color: #6c757d;
         font-size: 1rem;
         font-weight: 500;
      }

      .product-price {
         background: var(--success);
         color: white;
         padding: 0.5rem 1rem;
         border-radius: 25px;
         font-weight: 800;
         font-size: 1.1rem;
         box-shadow: 0 4px 15px rgba(67, 233, 123, 0.3);
      }

      .product-actions {
         display: flex;
         gap: 1rem;
      }

      .btn-edit {
         flex: 1;
         background: var(--secondary);
         border: none;
         color: white;
         padding: 0.8rem 1.5rem;
         border-radius: 12px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         font-size: 0.95rem;
      }

      .btn-edit:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 25px rgba(79, 172, 254, 0.4);
         color: white;
      }

      .btn-delete {
         flex: 1;
         background: var(--danger);
         border: none;
         color: white;
         padding: 0.8rem 1.5rem;
         border-radius: 12px;
         font-weight: 700;
         transition: all 0.3s ease;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         font-size: 0.95rem;
      }

      .btn-delete:hover {
         transform: translateY(-2px);
         box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
         color: white;
      }

      /* Modal Styles */
      .modal-content {
         border: none;
         border-radius: 25px;
         box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
      }

      .modal-header {
         background: var(--primary);
         color: white;
         border-radius: 25px 25px 0 0;
         padding: 2rem;
         border-bottom: none;
      }

      .modal-title {
         font-size: 1.8rem;
         font-weight: 800;
         display: flex;
         align-items: center;
      }

      .modal-title i {
         margin-right: 1rem;
         font-size: 1.5rem;
      }

      .btn-close {
         background: rgba(255, 255, 255, 0.2);
         border-radius: 50%;
         width: 40px;
         height: 40px;
         display: flex;
         align-items: center;
         justify-content: center;
         opacity: 1;
      }

      .modal-body {
         padding: 2.5rem;
      }

      .form-floating {
         margin-bottom: 2rem;
      }

      .form-control,
      .form-select {
         border: 2px solid #e9ecef;
         border-radius: 15px;
         padding: 1.2rem 1.5rem;
         font-size: 1.05rem;
         font-weight: 500;
         transition: all 0.3s ease;
      }

      .form-control:focus,
      .form-select:focus {
         border-color: #667eea;
         box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
         transform: translateY(-2px);
      }

      .form-floating>label {
         color: #6c757d;
         font-weight: 600;
      }

      .image-upload-area {
         border: 3px dashed #e9ecef;
         border-radius: 15px;
         padding: 2rem;
         text-align: center;
         transition: all 0.3s ease;
         cursor: pointer;
         background: rgba(248, 249, 250, 0.5);
      }

      .image-upload-area:hover {
         border-color: #667eea;
         background: rgba(102, 126, 234, 0.05);
      }

      .image-upload-area.dragover {
         border-color: #43e97b;
         background: rgba(67, 233, 123, 0.1);
      }

      .upload-icon {
         font-size: 3rem;
         color: #6c757d;
         margin-bottom: 1rem;
      }

      .upload-text {
         font-size: 1.1rem;
         font-weight: 600;
         color: #6c757d;
         margin-bottom: 0.5rem;
      }

      .upload-subtext {
         font-size: 0.9rem;
         color: #8e9aaf;
      }

      .image-preview {
         max-width: 200px;
         max-height: 200px;
         border-radius: 15px;
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
         margin-top: 1rem;
      }

      .modal-footer {
         padding: 2rem 2.5rem;
         border-top: 1px solid #f8f9fa;
         border-radius: 0 0 25px 25px;
      }

      .btn-modal-primary {
         background: var(--success);
         border: none;
         color: white;
         padding: 1rem 2.5rem;
         border-radius: 15px;
         font-weight: 700;
         transition: all 0.3s ease;
         font-size: 1.05rem;
         box-shadow: 0 8px 25px rgba(67, 233, 123, 0.3);
      }

      .btn-modal-primary:hover {
         transform: translateY(-2px);
         box-shadow: 0 15px 35px rgba(67, 233, 123, 0.4);
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
         font-size: 1.05rem;
      }

      .btn-modal-secondary:hover {
         background: #5a6268;
         transform: translateY(-2px);
         color: white;
      }

      /* Alert Styles */
      .alert-custom {
         border: none;
         border-radius: 15px;
         padding: 1.5rem 2rem;
         margin-bottom: 2rem;
         font-weight: 600;
         font-size: 1.05rem;
         box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
      }

      .alert-success {
         background: var(--success);
         color: white;
      }

      .alert-danger {
         background: var(--danger);
         color: white;
      }

      /* Empty State */
      .empty-state {
         text-align: center;
         padding: 4rem 2rem;
         background: white;
         border-radius: 20px;
         box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      }

      .empty-icon {
         font-size: 4rem;
         color: #e9ecef;
         margin-bottom: 2rem;
      }

      .empty-title {
         font-size: 1.8rem;
         font-weight: 800;
         color: var(--dark);
         margin-bottom: 1rem;
      }

      .empty-text {
         font-size: 1.1rem;
         color: #6c757d;
         margin-bottom: 2rem;
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
            padding: 1rem 1.5rem;
         }

         .content {
            padding: 1.5rem;
         }

         .hero-section {
            padding: 2.5rem 2rem;
         }

         .hero-title {
            font-size: 2.2rem;
         }

         .hero-stats {
            gap: 2rem;
         }

         .controls-header {
            flex-direction: column;
            align-items: stretch;
         }

         .search-container {
            max-width: none;
         }

         .controls-buttons {
            justify-content: stretch;
         }

         .controls-buttons .btn-primary-custom,
         .controls-buttons .btn-secondary-custom {
            flex: 1;
            justify-content: center;
         }

         .products-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
         }

         .modal-body {
            padding: 2rem 1.5rem;
         }

         .modal-footer {
            padding: 1.5rem;
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

      /* Loading Animation */
      .loading-spinner {
         display: inline-block;
         width: 20px;
         height: 20px;
         border: 3px solid rgba(255, 255, 255, 0.3);
         border-radius: 50%;
         border-top-color: white;
         animation: spin 1s ease-in-out infinite;
      }

      @keyframes spin {
         to {
            transform: rotate(360deg);
         }
      }

      /* Notification Toast */
      .toast-container {
         position: fixed;
         top: 2rem;
         right: 2rem;
         z-index: 9999;
      }

      .toast-custom {
         background: white;
         border: none;
         border-radius: 15px;
         box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
         min-width: 300px;
      }

      .toast-header {
         background: var(--success);
         color: white;
         border-radius: 15px 15px 0 0;
         font-weight: 700;
      }

      .toast-body {
         padding: 1.5rem;
         font-weight: 600;
      }
   </style>
</head>

<body>
   <!-- Toast Container -->
   <div class="toast-container"></div>

   <!-- Overlay para móvil -->
   <div class="overlay" id="overlay"></div>

   <!-- Sidebar -->
   <div class="sidebar" id="sidebar">
      <div class="sidebar-header">
         <div class="sidebar-logo">
            <i class="fas fa-cube"></i>
         </div>
         <div class="sidebar-title">Sistema CRUD</div>
         <div class="sidebar-subtitle">Panel Profesional</div>
      </div>

      <nav class="sidebar-nav">
         <div class="nav-item">
            <a href="dashboard.php" class="nav-link">
               <i class="fas fa-home"></i>
               <span>Dashboard</span>
            </a>
         </div>
         <div class="nav-item">
            <a href="productos.php" class="nav-link active">
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
               <h1 class="page-title">Gestión de Productos</h1>
               <p class="page-subtitle">Administra tu inventario de manera profesional</p>
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
                  <i class="fas fa-rocket"></i>
                  ¡Bienvenido al Sistema de Productos!
               </h2>
               <p class="hero-subtitle">
                  <?php echo $es_admin ? 'Control total sobre tu inventario con funciones avanzadas' : 'Gestiona y visualiza productos de manera eficiente'; ?>
               </p>
               <div class="hero-stats">
                  <div class="hero-stat">
                     <div class="hero-stat-number"><?php echo count($productos); ?></div>
                     <div class="hero-stat-label">Productos Totales</div>
                  </div>
                  <div class="hero-stat">
                     <div class="hero-stat-number"><?php echo count($proveedores); ?></div>
                     <div class="hero-stat-label">Proveedores</div>
                  </div>
                  <div class="hero-stat">
                     <div class="hero-stat-number">100%</div>
                     <div class="hero-stat-label">Sistema Activo</div>
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
                  <input type="text" class="search-input" id="searchInput" placeholder="Buscar productos...">
                  <i class="fas fa-search search-icon"></i>
               </div>
               <div class="controls-buttons">
                  <button class="btn-secondary-custom" onclick="location.reload()">
                     <i class="fas fa-sync-alt me-2"></i>
                     Actualizar
                  </button>
                  <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createProductModal">
                     <i class="fas fa-plus me-2"></i>
                     Nuevo Producto
                  </button>
               </div>
            </div>
         </div>

         <!-- Products Grid -->
         <?php if (empty($productos)): ?>
            <div class="empty-state">
               <div class="empty-icon">
                  <i class="fas fa-box-open"></i>
               </div>
               <h3 class="empty-title">¡No hay productos aún!</h3>
               <p class="empty-text">Comienza agregando tu primer producto al inventario</p>
               <button class="btn-primary-custom" data-bs-toggle="modal" data-bs-target="#createProductModal">
                  <i class="fas fa-plus me-2"></i>
                  Crear Primer Producto
               </button>
            </div>
         <?php else: ?>
            <div class="products-grid" id="productsGrid">
               <?php foreach ($productos as $producto): ?>
                  <div class="product-card" data-name="<?php echo strtolower($producto['nombre']); ?>" data-supplier="<?php echo strtolower($producto['proveedor']); ?>">
                     <?php if (!empty($producto['imagen'])): ?>
                        <img src="img/<?php echo $producto['imagen']; ?>" alt="<?php echo htmlspecialchars($producto['nombre']); ?>" class="product-image">
                     <?php else: ?>
                        <div class="product-image-placeholder">
                           <i class="fas fa-image"></i>
                        </div>
                     <?php endif; ?>

                     <div class="product-info">
                        <div class="product-header">
                           <div>
                              <h3 class="product-name"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                              <p class="product-supplier">
                                 <i class="fas fa-truck"></i>
                                 <?php echo htmlspecialchars($producto['proveedor']); ?>
                              </p>
                           </div>
                           <div class="product-price">
                              $<?php echo number_format($producto['precio'], 2); ?>
                           </div>
                        </div>

                        <?php if (!empty($producto['descripcion'])): ?>
                           <p class="product-description"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                        <?php endif; ?>

                        <div class="product-actions">
                           <?php if ($es_admin): ?>
                              <button class="btn-edit" onclick="editProduct(<?php echo $producto['id']; ?>, '<?php echo addslashes($producto['nombre']); ?>', '<?php echo addslashes($producto['descripcion']); ?>', <?php echo $producto['precio']; ?>, '<?php echo addslashes($producto['proveedor']); ?>', '<?php echo $producto['imagen']; ?>')">
                                 <i class="fas fa-edit me-2"></i>
                                 Editar
                              </button>
                              <button class="btn-delete" onclick="showDeleteProductModal(<?php echo $producto['id']; ?>, '<?php echo addslashes($producto['nombre']); ?>')">
                                 <i class="fas fa-trash me-2"></i>
                                 Eliminar
                              </button>
                           <?php else: ?>
                              <button class="btn-edit" style="flex: 2;" disabled>
                                 <i class="fas fa-eye me-2"></i>
                                 Solo Lectura
                              </button>
                           <?php endif; ?>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            </div>
         <?php endif; ?>
      </main>
   </div>

   <!-- Modal Crear Producto -->
   <div class="modal fade" id="createProductModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header" style="background: var(--primary); color: white;">
               <h5 class="modal-title">
                  <i class="fas fa-plus-circle"></i>
                  Crear Nuevo Producto
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
               <div class="modal-body">
                  <div class="row g-3">
                     <div class="col-md-6">
                        <div class="form-floating mb-3">
                           <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                           <label for="nombre">Nombre del Producto</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating mb-3">
                           <input type="number" class="form-control" id="precio" name="precio" step="0.01" placeholder="Precio" required>
                           <label for="precio">Precio ($)</label>
                        </div>
                     </div>
                  </div>
                  <div class="form-floating mb-3">
                     <select class="form-select" id="proveedor" name="proveedor" required>
                        <option value="">Seleccionar proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                           <option value="<?php echo htmlspecialchars($proveedor['nombre']); ?>">
                              <?php echo htmlspecialchars($proveedor['nombre']); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                     <label for="proveedor">Proveedor</label>
                  </div>
                  <div class="form-floating mb-3">
                     <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción" style="height: 100px"></textarea>
                     <label for="descripcion">Descripción</label>
                  </div>
                  <div class="image-upload-area mb-3" onclick="document.getElementById('imagen').click()">
                     <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                     </div>
                     <div class="upload-text">Subir Imagen del Producto</div>
                     <div class="upload-subtext">Haz clic aquí o arrastra una imagen</div>
                     <input type="file" id="imagen" name="imagen" accept="image/*" style="display: none;" onchange="previewImage(this)">
                     <img id="imagePreview" class="image-preview" style="display: none;">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" name="crear_producto" class="btn-modal-primary">
                     <i class="fas fa-save me-2"></i>
                     Crear Producto
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal Editar Producto -->
   <div class="modal fade" id="editProductModal" tabindex="-1">
      <div class="modal-dialog modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fas fa-edit"></i>
                  Editar Producto
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
               <div class="modal-body">
                  <input type="hidden" id="edit_id" name="id">
                  <input type="hidden" id="edit_imagen_actual" name="imagen_actual">

                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="text" class="form-control" id="edit_nombre" name="nombre" placeholder="Nombre" required>
                           <label for="edit_nombre">Nombre del Producto</label>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-floating">
                           <input type="number" class="form-control" id="edit_precio" name="precio" step="0.01" placeholder="Precio" required>
                           <label for="edit_precio">Precio ($)</label>
                        </div>
                     </div>
                  </div>

                  <div class="form-floating">
                     <select class="form-select" id="edit_proveedor" name="proveedor" required>
                        <option value="">Seleccionar proveedor</option>
                        <?php foreach ($proveedores as $proveedor): ?>
                           <option value="<?php echo htmlspecialchars($proveedor['nombre']); ?>">
                              <?php echo htmlspecialchars($proveedor['nombre']); ?>
                           </option>
                        <?php endforeach; ?>
                     </select>
                     <label for="edit_proveedor">Proveedor</label>
                  </div>

                  <div class="form-floating">
                     <textarea class="form-control" id="edit_descripcion" name="descripcion" placeholder="Descripción" style="height: 100px"></textarea>
                     <label for="edit_descripcion">Descripción</label>
                  </div>

                  <div class="image-upload-area" onclick="document.getElementById('edit_imagen').click()">
                     <div class="upload-icon">
                        <i class="fas fa-cloud-upload-alt"></i>
                     </div>
                     <div class="upload-text">Cambiar Imagen del Producto</div>
                     <div class="upload-subtext">Haz clic aquí o arrastra una nueva imagen</div>
                     <input type="file" id="edit_imagen" name="imagen" accept="image/*" style="display: none;" onchange="previewEditImage(this)">
                     <img id="editImagePreview" class="image-preview" style="display: none;">
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" name="actualizar_producto" class="btn-modal-primary">
                     <i class="fas fa-save me-2"></i>
                     Actualizar Producto
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- Modal Eliminar Producto -->
   <div class="modal fade" id="deleteProductModal" tabindex="-1">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">
                  <i class="fas fa-trash"></i>
                  Eliminar Producto
               </h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
               <div class="modal-body">
                  <input type="hidden" id="delete_product_id" name="id">
                  <p>¿Estás seguro de que quieres eliminar el producto <strong id="delete_product_nombre"></strong>?</p>
                  <p class="text-muted">Esta acción no se puede deshacer.</p>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn-modal-secondary" data-bs-dismiss="modal">Cancelar</button>
                  <button type="submit" name="eliminar_producto" class="btn-delete">
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
      const searchInput = document.getElementById('searchInput');
      const productsGrid = document.getElementById('productsGrid');

      searchInput.addEventListener('input', function() {
         const searchTerm = this.value.toLowerCase();
         const productCards = productsGrid.querySelectorAll('.product-card');

         productCards.forEach(card => {
            const name = card.dataset.name;
            const supplier = card.dataset.supplier;

            if (name.includes(searchTerm) || supplier.includes(searchTerm)) {
               card.style.display = 'block';
               card.style.animation = 'fadeIn 0.3s ease';
            } else {
               card.style.display = 'none';
            }
         });
      });

      // Image preview functions
      function previewImage(input) {
         const preview = document.getElementById('imagePreview');
         const uploadArea = input.parentElement;

         if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
               preview.src = e.target.result;
               preview.style.display = 'block';
               uploadArea.style.border = '3px solid #43e97b';
               uploadArea.style.background = 'rgba(67, 233, 123, 0.1)';
            }

            reader.readAsDataURL(input.files[0]);
         }
      }

      function previewEditImage(input) {
         const preview = document.getElementById('editImagePreview');
         const uploadArea = input.parentElement;

         if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
               preview.src = e.target.result;
               preview.style.display = 'block';
               uploadArea.style.border = '3px solid #43e97b';
               uploadArea.style.background = 'rgba(67, 233, 123, 0.1)';
            }

            reader.readAsDataURL(input.files[0]);
         }
      }

      // Edit product function
      function editProduct(id, nombre, descripcion, precio, proveedor, imagen) {
         document.getElementById('edit_id').value = id;
         document.getElementById('edit_nombre').value = nombre;
         document.getElementById('edit_descripcion').value = descripcion;
         document.getElementById('edit_precio').value = precio;
         document.getElementById('edit_proveedor').value = proveedor;
         document.getElementById('edit_imagen_actual').value = imagen;

         // Show current image if exists
         const preview = document.getElementById('editImagePreview');
         if (imagen) {
            preview.src = 'img/' + imagen;
            preview.style.display = 'block';
         } else {
            preview.style.display = 'none';
         }

         const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
         modal.show();
      }

      // Delete product function
      function showDeleteProductModal(id, nombre) {
         document.getElementById('delete_product_id').value = id;
         document.getElementById('delete_product_nombre').textContent = nombre;
         new bootstrap.Modal(document.getElementById('deleteProductModal')).show();
      }

      // Drag and drop functionality
      const uploadAreas = document.querySelectorAll('.image-upload-area');

      uploadAreas.forEach(area => {
         area.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('dragover');
         });

         area.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');
         });

         area.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('dragover');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
               const input = this.querySelector('input[type="file"]');
               input.files = files;

               // Trigger preview
               if (input.id === 'imagen') {
                  previewImage(input);
               } else {
                  previewEditImage(input);
               }
            }
         });
      });

      // Responsive behavior
      window.addEventListener('resize', function() {
         if (window.innerWidth > 768) {
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
         }
      });

      // Add fade in animation
      const style = document.createElement('style');
      style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(20px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
      document.head.appendChild(style);

      // Auto-hide alerts
      setTimeout(function() {
         const alerts = document.querySelectorAll('.alert-custom');
         alerts.forEach(alert => {
            alert.style.transition = 'all 0.5s ease';
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 500);
         });
      }, 5000);
   </script>
</body>

</html>