<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>🚀 Registro - Sistema CRUD Pro</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   <style>
      :root {
         --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         --success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
         --danger: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
      }

      body {
         font-family: 'Poppins', sans-serif;
         background: var(--primary);
         min-height: 100vh;
         display: flex;
         align-items: center;
         justify-content: center;
         position: relative;
         overflow: hidden;
      }

      .register-container {
         background: rgba(255, 255, 255, 0.95);
         backdrop-filter: blur(20px);
         border-radius: 30px;
         box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(255, 255, 255, 0.2);
         padding: 3.5rem;
         width: 100%;
         max-width: 520px;
         position: relative;
         z-index: 10;
         border: 1px solid rgba(255, 255, 255, 0.3);
      }

      .logo-section {
         text-align: center;
         margin-bottom: 3rem;
      }

      .logo-icon {
         width: 90px;
         height: 90px;
         background: var(--success);
         border-radius: 25px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         box-shadow: 0 15px 35px rgba(79, 172, 254, 0.4), 0 5px 15px rgba(0, 0, 0, 0.1);
         animation: logoFloat 3s ease-in-out infinite;
         position: relative;
         overflow: hidden;
      }

      .logo-icon i {
         font-size: 2.5rem;
         color: white;
         z-index: 1;
         position: relative;
      }

      .welcome-title {
         font-size: 2.8rem;
         font-weight: 800;
         background: var(--success);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         margin-bottom: 0.5rem;
         letter-spacing: -1px;
      }

      .form-floating {
         margin-bottom: 1.5rem;
         position: relative;
      }

      .form-control,
      .form-select {
         border: 2px solid #e9ecef;
         border-radius: 15px;
         padding: 1.2rem 1.5rem;
         font-size: 1.05rem;
         font-weight: 500;
         background: rgba(255, 255, 255, 0.9);
         backdrop-filter: blur(10px);
      }

      .btn-register {
         background: var(--success);
         border: none;
         border-radius: 15px;
         padding: 1.2rem 2.5rem;
         font-size: 1.15rem;
         font-weight: 700;
         color: white;
         width: 100%;
         text-transform: uppercase;
         letter-spacing: 1px;
         box-shadow: 0 10px 30px rgba(79, 172, 254, 0.3);
      }

      .login-section {
         text-align: center;
         margin-top: 2.5rem;
         padding-top: 2rem;
         border-top: 2px solid #f8f9fa;
         position: relative;
      }

      .login-link {
         color: #4facfe;
         text-decoration: none;
         font-weight: 600;
         font-size: 1.05rem;
         transition: all 0.3s ease;
         position: relative;
      }

      .error-alert {
         background: var(--danger);
         color: white;
         border: none;
         border-radius: 15px;
         padding: 1.2rem 1.5rem;
         margin-bottom: 2rem;
         font-weight: 500;
      }
   </style>
</head>

<body>
   <div class="register-container">
      <div class="logo-section">
         <div class="logo-icon">
            <i class="fas fa-user-plus"></i>
         </div>
         <h1 class="welcome-title">¡Regístrate!</h1>
         <p class="welcome-description">Crea tu cuenta para acceder al sistema</p>
      </div>
      <?php if (!empty($errores)): ?>
         <div class="alert error-alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>¡Error!</strong>
            <ul class="mb-0 mt-2">
               <?php echo $errores; ?>
            </ul>
         </div>
      <?php endif; ?>
      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="registerForm">
         <div class="form-floating">
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
            <label for="usuario"><i class="fas fa-user me-2"></i>Usuario</label>
         </div>
         <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
         </div>
         <div class="form-floating">
            <select class="form-select" id="rol" name="rol" required>
               <option value="">Selecciona un rol</option>
               <option value="administrador">Administrador</option>
               <option value="usuario">Usuario</option>
            </select>
            <label for="rol"><i class="fas fa-user-tag me-2"></i>Rol</label>
         </div>
         <button type="submit" class="btn btn-register" id="registerBtn">
            <span class="normal-text">
               <i class="fas fa-user-plus me-2"></i>
               Registrarse
            </span>
         </button>
      </form>
      <div class="login-section">
         <p class="mb-0">¿Ya tienes una cuenta?
            <a href="<?php echo RUTA . 'login.php' ?>" class="login-link">
               Inicia sesión aquí <i class="fas fa-arrow-right ms-1"></i>
            </a>
         </p>
      </div>
   </div>
</body>

</html>