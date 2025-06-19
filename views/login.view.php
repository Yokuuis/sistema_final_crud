<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Iniciar Sesión</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   <style>
      :root {
         --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
         --secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
         --success: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
         --danger: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
         --dark: #2c3e50;
         --light: #ecf0f1;
      }

      * {
         margin: 0;
         padding: 0;
         box-sizing: border-box;
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

      body::before {
         content: '';
         position: absolute;
         top: 0;
         left: 0;
         right: 0;
         bottom: 0;
         background:
            radial-gradient(circle at 20% 80%, rgba(120, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(255, 119, 198, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 40% 40%, rgba(120, 219, 255, 0.3) 0%, transparent 50%);
         animation: gradientShift 8s ease-in-out infinite;
      }

      @keyframes gradientShift {

         0%,
         100% {
            opacity: 1;
         }

         50% {
            opacity: 0.8;
         }
      }

      .floating-shapes {
         position: absolute;
         width: 100%;
         height: 100%;
         overflow: hidden;
         pointer-events: none;
      }

      .shape {
         position: absolute;
         background: rgba(255, 255, 255, 0.1);
         border-radius: 50%;
         animation: float 6s ease-in-out infinite;
      }

      .shape:nth-child(1) {
         width: 100px;
         height: 100px;
         top: 10%;
         left: 10%;
         animation-delay: 0s;
      }

      .shape:nth-child(2) {
         width: 150px;
         height: 150px;
         top: 70%;
         right: 10%;
         animation-delay: 2s;
      }

      .shape:nth-child(3) {
         width: 80px;
         height: 80px;
         bottom: 10%;
         left: 30%;
         animation-delay: 4s;
      }

      .shape:nth-child(4) {
         width: 120px;
         height: 120px;
         top: 30%;
         right: 30%;
         animation-delay: 1s;
      }

      @keyframes float {

         0%,
         100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 0.7;
         }

         50% {
            transform: translateY(-30px) rotate(180deg);
            opacity: 1;
         }
      }

      .login-container {
         background: rgba(255, 255, 255, 0.95);
         backdrop-filter: blur(20px);
         border-radius: 30px;
         box-shadow:
            0 25px 50px rgba(0, 0, 0, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.2);
         padding: 3.5rem;
         width: 100%;
         max-width: 480px;
         position: relative;
         z-index: 10;
         animation: slideInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         border: 1px solid rgba(255, 255, 255, 0.3);
      }

      @keyframes slideInUp {
         from {
            opacity: 0;
            transform: translateY(60px) scale(0.95);
         }

         to {
            opacity: 1;
            transform: translateY(0) scale(1);
         }
      }

      .logo-section {
         text-align: center;
         margin-bottom: 3rem;
      }

      .logo-icon {
         width: 90px;
         height: 90px;
         background: var(--primary);
         border-radius: 25px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         box-shadow:
            0 15px 35px rgba(102, 126, 234, 0.4),
            0 5px 15px rgba(0, 0, 0, 0.1);
         animation: logoFloat 3s ease-in-out infinite;
         position: relative;
         overflow: hidden;
      }

      .logo-icon::before {
         content: '';
         position: absolute;
         top: -50%;
         left: -50%;
         width: 200%;
         height: 200%;
         background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
         animation: shine 3s linear infinite;
      }

      @keyframes logoFloat {

         0%,
         100% {
            transform: translateY(0px) rotate(0deg);
         }

         50% {
            transform: translateY(-10px) rotate(5deg);
         }
      }

      @keyframes shine {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
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
         background: var(--primary);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         margin-bottom: 0.5rem;
         letter-spacing: -1px;
      }

      .welcome-subtitle {
         color: #6c757d;
         font-size: 1.1rem;
         font-weight: 400;
         margin-bottom: 0.5rem;
      }

      .welcome-description {
         color: #8e9aaf;
         font-size: 0.95rem;
         margin-bottom: 2rem;
      }

      .form-floating {
         margin-bottom: 2rem;
         position: relative;
      }

      .form-control {
         border: 2px solid #e9ecef;
         border-radius: 15px;
         padding: 1.2rem 1.5rem;
         font-size: 1.05rem;
         font-weight: 500;
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         background: rgba(255, 255, 255, 0.9);
         backdrop-filter: blur(10px);
      }

      .form-control:focus {
         border-color: #667eea;
         box-shadow:
            0 0 0 0.25rem rgba(102, 126, 234, 0.15),
            0 10px 25px rgba(102, 126, 234, 0.1);
         background: white;
         transform: translateY(-2px);
      }

      .form-floating>label {
         color: #6c757d;
         font-weight: 500;
         font-size: 0.95rem;
      }

      .input-icon {
         position: absolute;
         right: 1.5rem;
         top: 50%;
         transform: translateY(-50%);
         color: #6c757d;
         font-size: 1.1rem;
         z-index: 5;
         transition: all 0.3s ease;
      }

      .form-control:focus+.input-icon {
         color: #667eea;
         transform: translateY(-50%) scale(1.1);
      }

      .btn-login {
         background: var(--primary);
         border: none;
         border-radius: 15px;
         padding: 1.2rem 2.5rem;
         font-size: 1.15rem;
         font-weight: 700;
         color: white;
         width: 100%;
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         position: relative;
         overflow: hidden;
         text-transform: uppercase;
         letter-spacing: 1px;
         box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
      }

      .btn-login::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
         transition: left 0.6s;
      }

      .btn-login:hover::before {
         left: 100%;
      }

      .btn-login:hover {
         transform: translateY(-3px);
         box-shadow: 0 20px 40px rgba(102, 126, 234, 0.4);
      }

      .btn-login:active {
         transform: translateY(-1px);
      }

      .register-section {
         text-align: center;
         margin-top: 2.5rem;
         padding-top: 2rem;
         border-top: 2px solid #f8f9fa;
         position: relative;
      }

      .register-section::before {
         content: 'O';
         position: absolute;
         top: -15px;
         left: 50%;
         transform: translateX(-50%);
         background: white;
         color: #6c757d;
         padding: 0 1rem;
         font-weight: 600;
      }

      .register-link {
         color: #667eea;
         text-decoration: none;
         font-weight: 600;
         font-size: 1.05rem;
         transition: all 0.3s ease;
         position: relative;
      }

      .register-link::after {
         content: '';
         position: absolute;
         bottom: -2px;
         left: 0;
         width: 0;
         height: 2px;
         background: var(--primary);
         transition: width 0.3s ease;
      }

      .register-link:hover::after {
         width: 100%;
      }

      .register-link:hover {
         color: #764ba2;
         transform: translateY(-1px);
      }

      .error-alert {
         background: var(--danger);
         color: white;
         border: none;
         border-radius: 15px;
         padding: 1.2rem 1.5rem;
         margin-bottom: 2rem;
         animation: shake 0.6s ease-in-out;
         box-shadow: 0 10px 30px rgba(250, 112, 154, 0.3);
         font-weight: 500;
      }

      @keyframes shake {

         0%,
         100% {
            transform: translateX(0);
         }

         25% {
            transform: translateX(-8px);
         }

         75% {
            transform: translateX(8px);
         }
      }

      .features {
         display: flex;
         justify-content: space-around;
         margin-top: 2rem;
         padding-top: 1.5rem;
         border-top: 1px solid #f0f0f0;
      }

      .feature {
         text-align: center;
         flex: 1;
      }

      .feature-icon {
         width: 40px;
         height: 40px;
         background: var(--success);
         border-radius: 10px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 0.5rem;
         color: white;
         font-size: 0.9rem;
      }

      .feature-text {
         font-size: 0.8rem;
         color: #6c757d;
         font-weight: 500;
      }

      @media (max-width: 576px) {
         .login-container {
            margin: 1rem;
            padding: 2.5rem 2rem;
         }

         .welcome-title {
            font-size: 2.2rem;
         }

         .logo-icon {
            width: 70px;
            height: 70px;
         }

         .logo-icon i {
            font-size: 2rem;
         }

         .features {
            flex-direction: column;
            gap: 1rem;
         }
      }

      .loading {
         display: none;
      }

      .btn-login.loading {
         pointer-events: none;
      }

      .btn-login.loading .loading {
         display: inline-block;
      }

      .btn-login.loading .normal-text {
         display: none;
      }
   </style>
</head>

<body>
   <div class="floating-shapes">
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
      <div class="shape"></div>
   </div>

   <div class="login-container">
      <div class="logo-section">
         <div class="logo-icon">
            <i class="fas fa-rocket"></i>
         </div>
         <h1 class="welcome-title">¡Bienvenido!</h1>
         <p class="welcome-subtitle">Sistema CRUD Profesional</p>
         <p class="welcome-description">Inicia sesión para acceder a tu panel de control</p>
      </div>

      <?php if (!empty($errores)): ?>
         <div class="alert error-alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>¡Oops!</strong> Usuario y/o contraseña incorrectos
         </div>
      <?php endif; ?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="loginForm">
         <div class="form-floating">
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
            <label for="usuario"><i class="fas fa-user me-2"></i>Usuario</label>
            <i class="fas fa-user input-icon"></i>
         </div>

         <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            <label for="password"><i class="fas fa-lock me-2"></i>Contraseña</label>
            <i class="fas fa-lock input-icon"></i>
         </div>

         <button type="submit" class="btn btn-login" id="loginBtn">
            <span class="normal-text">
               <i class="fas fa-sign-in-alt me-2"></i>
               Iniciar Sesión
            </span>
            <span class="loading">
               <i class="fas fa-spinner fa-spin me-2"></i>
               Iniciando...
            </span>
         </button>
      </form>

      <div class="features">
         <div class="feature">
            <div class="feature-icon">
               <i class="fas fa-shield-alt"></i>
            </div>
            <div class="feature-text">Seguro</div>
         </div>
         <div class="feature">
            <div class="feature-icon">
               <i class="fas fa-bolt"></i>
            </div>
            <div class="feature-text">Rápido</div>
         </div>
         <div class="feature">
            <div class="feature-icon">
               <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="feature-text">Responsive</div>
         </div>
      </div>

      <div class="register-section">
         <p class="mb-0">¿No tienes una cuenta?
            <a href="<?php echo RUTA . 'registro.php' ?>" class="register-link">
               Regístrate aquí <i class="fas fa-arrow-right ms-1"></i>
            </a>
         </p>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
      // Form submission with loading state
      document.getElementById('loginForm').addEventListener('submit', function() {
         const btn = document.getElementById('loginBtn');
         btn.classList.add('loading');
      });

      // Add focus effects
      document.querySelectorAll('.form-control').forEach(input => {
         input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
         });

         input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
         });
      });

      // Particle animation
      function createParticle() {
         const particle = document.createElement('div');
         particle.style.cssText = `
                position: absolute;
                width: 4px;
                height: 4px;
                background: rgba(255, 255, 255, 0.6);
                border-radius: 50%;
                pointer-events: none;
                animation: particleFloat 4s linear infinite;
            `;

         particle.style.left = Math.random() * 100 + '%';
         particle.style.animationDelay = Math.random() * 4 + 's';

         document.body.appendChild(particle);

         setTimeout(() => {
            particle.remove();
         }, 4000);
      }

      // Create particles periodically
      setInterval(createParticle, 300);

      // Add particle animation CSS
      const style = document.createElement('style');
      style.textContent = `
            @keyframes particleFloat {
                0% {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100px) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
      document.head.appendChild(style);
   </script>
</body>

</html>