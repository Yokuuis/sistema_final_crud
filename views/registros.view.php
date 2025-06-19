<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Registro</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
   <style>
      :root {
         --primary: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
         --secondary: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
         --danger: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
         --dark: #2c3e50;
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
            radial-gradient(circle at 30% 70%, rgba(79, 172, 254, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 70% 30%, rgba(0, 242, 254, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 50% 50%, rgba(67, 233, 123, 0.2) 0%, transparent 50%);
         animation: gradientShift 10s ease-in-out infinite;
      }

      @keyframes gradientShift {

         0%,
         100% {
            opacity: 1;
         }

         50% {
            opacity: 0.7;
         }
      }

      .floating-elements {
         position: absolute;
         width: 100%;
         height: 100%;
         overflow: hidden;
         pointer-events: none;
      }

      .floating-element {
         position: absolute;
         background: rgba(255, 255, 255, 0.1);
         border-radius: 50%;
         animation: floatAround 8s ease-in-out infinite;
      }

      .floating-element:nth-child(1) {
         width: 120px;
         height: 120px;
         top: 15%;
         left: 15%;
         animation-delay: 0s;
      }

      .floating-element:nth-child(2) {
         width: 80px;
         height: 80px;
         top: 60%;
         right: 20%;
         animation-delay: 3s;
      }

      .floating-element:nth-child(3) {
         width: 100px;
         height: 100px;
         bottom: 20%;
         left: 25%;
         animation-delay: 6s;
      }

      .floating-element:nth-child(4) {
         width: 60px;
         height: 60px;
         top: 25%;
         right: 35%;
         animation-delay: 2s;
      }

      @keyframes floatAround {

         0%,
         100% {
            transform: translateY(0px) translateX(0px) rotate(0deg);
            opacity: 0.6;
         }

         25% {
            transform: translateY(-20px) translateX(10px) rotate(90deg);
            opacity: 0.8;
         }

         50% {
            transform: translateY(-10px) translateX(-15px) rotate(180deg);
            opacity: 1;
         }

         75% {
            transform: translateY(15px) translateX(5px) rotate(270deg);
            opacity: 0.7;
         }
      }

      .register-container {
         background: rgba(255, 255, 255, 0.95);
         backdrop-filter: blur(25px);
         border-radius: 35px;
         box-shadow:
            0 30px 60px rgba(0, 0, 0, 0.15),
            0 0 0 1px rgba(255, 255, 255, 0.3);
         padding: 4rem;
         width: 100%;
         max-width: 520px;
         position: relative;
         z-index: 10;
         animation: slideInScale 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         border: 1px solid rgba(255, 255, 255, 0.4);
      }

      @keyframes slideInScale {
         from {
            opacity: 0;
            transform: translateY(80px) scale(0.9);
         }

         to {
            opacity: 1;
            transform: translateY(0) scale(1);
         }
      }

      .header-section {
         text-align: center;
         margin-bottom: 3rem;
      }

      .logo-icon {
         width: 100px;
         height: 100px;
         background: var(--secondary);
         border-radius: 30px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1.5rem;
         box-shadow:
            0 20px 40px rgba(67, 233, 123, 0.4),
            0 8px 20px rgba(0, 0, 0, 0.1);
         animation: logoRotate 4s ease-in-out infinite;
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
         background: conic-gradient(transparent, rgba(255, 255, 255, 0.4), transparent);
         animation: rotate 3s linear infinite;
      }

      @keyframes logoRotate {

         0%,
         100% {
            transform: translateY(0px) rotate(0deg);
         }

         50% {
            transform: translateY(-15px) rotate(10deg);
         }
      }

      @keyframes rotate {
         0% {
            transform: rotate(0deg);
         }

         100% {
            transform: rotate(360deg);
         }
      }

      .logo-icon i {
         font-size: 3rem;
         color: white;
         z-index: 1;
         position: relative;
      }

      .main-title {
         font-size: 3rem;
         font-weight: 900;
         background: var(--secondary);
         -webkit-background-clip: text;
         -webkit-text-fill-color: transparent;
         background-clip: text;
         margin-bottom: 0.5rem;
         letter-spacing: -2px;
      }

      .subtitle {
         color: #6c757d;
         font-size: 1.2rem;
         font-weight: 500;
         margin-bottom: 0.5rem;
      }

      .description {
         color: #8e9aaf;
         font-size: 1rem;
         margin-bottom: 2.5rem;
      }

      .form-floating {
         margin-bottom: 2rem;
         position: relative;
      }

      .form-control,
      .form-select {
         border: 2px solid #e9ecef;
         border-radius: 18px;
         padding: 1.3rem 1.8rem;
         font-size: 1.1rem;
         font-weight: 500;
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         background: rgba(255, 255, 255, 0.9);
         backdrop-filter: blur(10px);
      }

      .form-control:focus,
      .form-select:focus {
         border-color: #4facfe;
         box-shadow:
            0 0 0 0.3rem rgba(79, 172, 254, 0.15),
            0 15px 35px rgba(79, 172, 254, 0.1);
         background: white;
         transform: translateY(-3px);
      }

      .form-floating>label {
         color: #6c757d;
         font-weight: 600;
         font-size: 1rem;
      }

      .input-icon {
         position: absolute;
         right: 1.8rem;
         top: 50%;
         transform: translateY(-50%);
         color: #6c757d;
         font-size: 1.2rem;
         z-index: 5;
         transition: all 0.3s ease;
      }

      .form-control:focus+.input-icon,
      .form-select:focus+.input-icon {
         color: #4facfe;
         transform: translateY(-50%) scale(1.2);
      }

      .btn-register {
         background: var(--secondary);
         border: none;
         border-radius: 18px;
         padding: 1.3rem 3rem;
         font-size: 1.2rem;
         font-weight: 800;
         color: white;
         width: 100%;
         transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
         position: relative;
         overflow: hidden;
         text-transform: uppercase;
         letter-spacing: 1.5px;
         box-shadow: 0 15px 35px rgba(67, 233, 123, 0.3);
      }

      .btn-register::before {
         content: '';
         position: absolute;
         top: 0;
         left: -100%;
         width: 100%;
         height: 100%;
         background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.5), transparent);
         transition: left 0.7s;
      }

      .btn-register:hover::before {
         left: 100%;
      }

      .btn-register:hover {
         transform: translateY(-4px);
         box-shadow: 0 25px 50px rgba(67, 233, 123, 0.4);
      }

      .btn-register:active {
         transform: translateY(-2px);
      }

      .login-section {
         text-align: center;
         margin-top: 3rem;
         padding-top: 2.5rem;
         border-top: 2px solid #f8f9fa;
         position: relative;
      }

      .login-section::before {
         content: '✨';
         position: absolute;
         top: -20px;
         left: 50%;
         transform: translateX(-50%);
         background: white;
         padding: 0 1.5rem;
         font-size: 1.5rem;
      }

      .login-link {
         color: #4facfe;
         text-decoration: none;
         font-weight: 700;
         font-size: 1.1rem;
         transition: all 0.3s ease;
         position: relative;
         display: inline-block;
      }

      .login-link::after {
         content: '';
         position: absolute;
         bottom: -3px;
         left: 0;
         width: 0;
         height: 3px;
         background: var(--secondary);
         transition: width 0.4s ease;
         border-radius: 2px;
      }

      .login-link:hover::after {
         width: 100%;
      }

      .login-link:hover {
         color: #00f2fe;
         transform: translateY(-2px);
      }

      .error-alert {
         background: var(--danger);
         color: white;
         border: none;
         border-radius: 18px;
         padding: 1.5rem 2rem;
         margin-bottom: 2.5rem;
         animation: errorShake 0.8s ease-in-out;
         box-shadow: 0 15px 35px rgba(250, 112, 154, 0.3);
         font-weight: 600;
         font-size: 1.05rem;
      }

      @keyframes errorShake {

         0%,
         100% {
            transform: translateX(0);
         }

         20% {
            transform: translateX(-10px);
         }

         40% {
            transform: translateX(10px);
         }

         60% {
            transform: translateX(-8px);
         }

         80% {
            transform: translateX(8px);
         }
      }

      .role-selector {
         position: relative;
      }

      .role-selector::after {
         content: '\f078';
         font-family: 'Font Awesome 6 Free';
         font-weight: 900;
         position: absolute;
         right: 1.8rem;
         top: 50%;
         transform: translateY(-50%);
         color: #6c757d;
         pointer-events: none;
         z-index: 10;
      }

      .benefits {
         display: grid;
         grid-template-columns: repeat(3, 1fr);
         gap: 1.5rem;
         margin-top: 2.5rem;
         padding-top: 2rem;
         border-top: 1px solid #f0f0f0;
      }

      .benefit {
         text-align: center;
      }

      .benefit-icon {
         width: 50px;
         height: 50px;
         background: var(--primary);
         border-radius: 15px;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         margin-bottom: 1rem;
         color: white;
         font-size: 1.1rem;
         box-shadow: 0 8px 20px rgba(79, 172, 254, 0.3);
      }

      .benefit-text {
         font-size: 0.9rem;
         color: #6c757d;
         font-weight: 600;
      }

      @media (max-width: 576px) {
         .register-container {
            margin: 1rem;
            padding: 3rem 2.5rem;
         }

         .main-title {
            font-size: 2.5rem;
         }

         .logo-icon {
            width: 80px;
            height: 80px;
         }

         .logo-icon i {
            font-size: 2.5rem;
         }

         .benefits {
            grid-template-columns: 1fr;
            gap: 1rem;
         }
      }

      .loading {
         display: none;
      }

      .btn-register.loading {
         pointer-events: none;
      }

      .btn-register.loading .loading {
         display: inline-block;
      }

      .btn-register.loading .normal-text {
         display: none;
      }
   </style>
</head>

<body>
   <div class="floating-elements">
      <div class="floating-element"></div>
      <div class="floating-element"></div>
      <div class="floating-element"></div>
      <div class="floating-element"></div>
   </div>

   <div class="register-container">
      <div class="header-section">
         <div class="logo-icon">
            <i class="fas fa-user-astronaut"></i>
         </div>
         <h1 class="main-title">¡Únete!</h1>
         <p class="subtitle">Sistema CRUD Profesional</p>
         <p class="description">Crea tu cuenta y comienza a gestionar tu inventario</p>
      </div>

      <?php if (!empty($errores)): ?>
         <div class="alert error-alert">
            <i class="fas fa-exclamation-triangle me-3"></i>
            <strong>¡Error!</strong>
            <?php echo str_replace(['<li class="error">', '</li>'], ['', ''], $errores); ?>
         </div>
      <?php endif; ?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" id="registerForm">
         <div class="form-floating">
            <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" required>
            <label for="usuario"><i class="fas fa-user me-2"></i>Nombre de Usuario</label>
            <i class="fas fa-user input-icon"></i>
         </div>

         <div class="form-floating">
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
            <label for="password"><i class="fas fa-lock me-2"></i>Contraseña Segura</label>
            <i class="fas fa-lock input-icon"></i>
         </div>

         <div class="form-floating role-selector">
            <select class="form-select" id="rol" name="rol" required>
               <option value="">Selecciona tu rol</option>
               <option value="administrador">Administrador - Control Total</option>
               <option value="usuario">Usuario - Gestión Básica</option>
            </select>
            <label for="rol"><i class="fas fa-crown me-2"></i>Tipo de Cuenta</label>
         </div>

         <button type="submit" class="btn btn-register" id="registerBtn">
            <span class="normal-text">
               <i class="fas fa-rocket me-2"></i>
               Crear Mi Cuenta
            </span>
            <span class="loading">
               <i class="fas fa-spinner fa-spin me-2"></i>
               Creando Cuenta...
            </span>
         </button>
      </form>

      <div class="benefits">
         <div class="benefit">
            <div class="benefit-icon">
               <i class="fas fa-shield-alt"></i>
            </div>
            <div class="benefit-text">100% Seguro</div>
         </div>
         <div class="benefit">
            <div class="benefit-icon">
               <i class="fas fa-zap"></i>
            </div>
            <div class="benefit-text">Super Rápido</div>
         </div>
         <div class="benefit">
            <div class="benefit-icon">
               <i class="fas fa-heart"></i>
            </div>
            <div class="benefit-text">Fácil de Usar</div>
         </div>
      </div>

      <div class="login-section">
         <p class="mb-0">¿Ya tienes una cuenta?
            <a href="<?php echo RUTA . 'login.php' ?>" class="login-link">
               ¡Inicia sesión aquí! <i class="fas fa-sign-in-alt ms-2"></i>
            </a>
         </p>
      </div>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
   <script>
      // Form submission with loading state
      document.getElementById('registerForm').addEventListener('submit', function() {
         const btn = document.getElementById('registerBtn');
         btn.classList.add('loading');
      });

      // Enhanced focus effects
      document.querySelectorAll('.form-control, .form-select').forEach(input => {
         input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-3px)';
            this.parentElement.style.boxShadow = '0 15px 35px rgba(79, 172, 254, 0.15)';
         });

         input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
            this.parentElement.style.boxShadow = 'none';
         });
      });

      // Password strength indicator
      const passwordInput = document.getElementById('password');
      passwordInput.addEventListener('input', function() {
         const password = this.value;
         const strength = getPasswordStrength(password);

         // Remove existing strength indicator
         const existingIndicator = this.parentElement.querySelector('.strength-indicator');
         if (existingIndicator) {
            existingIndicator.remove();
         }

         if (password.length > 0) {
            const indicator = document.createElement('div');
            indicator.className = 'strength-indicator';
            indicator.style.cssText = `
                    position: absolute;
                    bottom: -25px;
                    left: 0;
                    right: 0;
                    height: 3px;
                    border-radius: 2px;
                    background: ${getStrengthColor(strength)};
                    transition: all 0.3s ease;
                `;
            this.parentElement.appendChild(indicator);
         }
      });

      function getPasswordStrength(password) {
         let strength = 0;
         if (password.length >= 6) strength++;
         if (password.match(/[a-z]/)) strength++;
         if (password.match(/[A-Z]/)) strength++;
         if (password.match(/[0-9]/)) strength++;
         if (password.match(/[^a-zA-Z0-9]/)) strength++;
         return strength;
      }

      function getStrengthColor(strength) {
         const colors = [
            '#ff4757', // Very weak
            '#ff6b7a', // Weak
            '#ffa502', // Fair
            '#2ed573', // Good
            '#1dd1a1' // Strong
         ];
         return colors[strength] || colors[0];
      }

      // Role selection enhancement
      document.getElementById('rol').addEventListener('change', function() {
         const selectedOption = this.options[this.selectedIndex];
         if (selectedOption.value) {
            this.style.color = '#2c3e50';
            this.style.fontWeight = '600';
         }
      });

      // Floating particles effect
      function createFloatingParticle() {
         const particle = document.createElement('div');
         particle.style.cssText = `
                position: absolute;
                width: 6px;
                height: 6px;
                background: rgba(67, 233, 123, 0.7);
                border-radius: 50%;
                pointer-events: none;
                animation: floatUp 5s linear infinite;
                z-index: 1;
            `;

         particle.style.left = Math.random() * 100 + '%';
         particle.style.animationDelay = Math.random() * 5 + 's';

         document.body.appendChild(particle);

         setTimeout(() => {
            particle.remove();
         }, 5000);
      }

      // Create floating particles
      setInterval(createFloatingParticle, 400);

      // Add floating animation CSS
      const floatingStyle = document.createElement('style');
      floatingStyle.textContent = `
            @keyframes floatUp {
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
      document.head.appendChild(floatingStyle);
   </script>
</body>

</html>