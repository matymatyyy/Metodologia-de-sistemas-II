<!DOCTYPE html>
<html lang="es">
<head>
    <!-- 
    =====================================================
    VISTA DE LOGIN - UTN CHACABUCO PANEL ADMINISTRATIVO
    =====================================================
    
    Esta página maneja el inicio de sesión para el sistema administrativo
    de la Universidad Tecnológica Nacional - Regional Chacabuco.
    
    CARACTERÍSTICAS IMPLEMENTADAS:
    - Diseño glassmorphism con efectos de vidrio esmerilado
    - Sistema responsive que se adapta a móviles, tablets y desktop
    - Preloader con animación de carga
    - Validación de formularios en tiempo real
    - Sistema bilingüe (Español/Inglés)
    - Efectos de partículas animadas en el fondo
    - Detección de Caps Lock activado
    - Manejo de errores del backend vía sesión PHP
    - AJAX para envío sin recarga de página
    
    ARCHIVOS RELACIONADOS:
    - Estilos: /src/Dist/Login/login.css
    - JavaScript: /src/Dist/Login/login.js
    - Controller: src/Controller/User/UserLoginController.php
    - Ruta: /login (configurada en UsuarioRoutes.php)
    
    USUARIOS DE PRUEBA:
    - admin@utn.edu.ar / admin123 (Administrador)
    - secretaria@utn.edu.ar / secretaria123 (Secretaría)
    -->
    
    <meta charset="UTF-8">
    <!-- viewport optimizado para móviles - user-scalable=no previene zoom accidental -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <title>UTN Chacabuco - Panel Administrativo</title>
    
    <!-- Favicon - Logo UTN en la pestaña del navegador -->
    <link rel="icon" type="image/x-icon" href="/src/Dist/Image/UTN_logo.jpg">
    <link rel="shortcut icon" type="image/x-icon" href="/src/Dist/Image/UTN_logo.jpg">
    
    <!-- CSS con timestamp para evitar caché del navegador -->
    <link rel="stylesheet" href="/src/Dist/Login/login.css?v=<?php echo time(); ?>">
    
    <!-- FontAwesome para iconos (usuario, contraseña, ojo, etc.) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Fuente Inter más moderna que Arial/Poppins para texto profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Preload de imagen de fondo para carga más rápida -->
    <link rel="preload" href="/src/Dist/Image/blurred-background-vibrant-campus-scene-600nw-2527446029.webp" as="image">
</head>
<body>
    <!-- PRELOADER: Pantalla de carga inicial con logo y barra de progreso -->
    <div class="preloader" id="preloader">
        <div class="preloader-logo">
            <img src="/src/Dist/Image/UTN_logo.jpg" alt="UTN Logo">
            <div class="loading-text">Cargando Panel UTN</div>
            <div class="loading-bar">
                <div class="loading-progress"></div>
            </div>
        </div>
    </div>

    <!-- PARTÍCULAS DE FONDO: Sistema de partículas animadas para ambiente premium -->
    <div class="particles-container" id="particles"></div>

    <div class="login-container">
        <!-- SELECTOR DE IDIOMA: Botón para alternar entre Español e Inglés -->
        <div class="lang-toggle">
            <button onclick="toggleLanguage()" id="lang-btn">EN</button>
        </div>

        <!-- OVERLAY: Capa de transparencia sobre la imagen de fondo -->
        <div class="background-overlay"></div>
        
        <!-- TARJETA PRINCIPAL DE LOGIN: Contenedor glassmorphism con efectos premium -->
        <div class="login-card" id="loginCard">
            <div class="login-header">
                <!-- LOGO DE UTN: Contenedor con logo y efecto de brillo -->
                <div class="logo-container">
                    <img src="/src/Dist/Image/UTN_logo.jpg" alt="UTN Logo" class="utn-logo">
                    <div class="logo-glow"></div>
                </div>
                <h1 id="title">UTN Chacabuco</h1>
                <p id="subtitle">Panel Administrativo</p>
            </div>
            
            <!-- FORMULARIO DE LOGIN: Envío POST a tu ruta de usuario login -->
            <form class="login-form" id="loginForm">
                
                <!-- MENSAJE DE ERROR: Se muestra si hay error en el login -->
                <?php 
                /*
                 * MANEJO DE ERRORES DE LOGIN
                 * =========================
                 * 
                 * Los errores pueden venir de dos fuentes:
                 * 1. $_SESSION['login_error'] - Errores del UserLoginController
                 * 2. $_GET['error'] - Errores por URL (menos común)
                 * 
                 * FLUJO DE ERROR:
                 * - Usuario intenta hacer login con datos incorrectos
                 * - UserLoginController detecta el error
                 * - Se guarda mensaje en $_SESSION['login_error'] 
                 * - Se redirige a /login
                 * - Esta vista muestra el error y lo limpia de la sesión
                 * - El error NO persiste entre recargas
                 */
                $loginError = null;
                if (isset($_SESSION['login_error'])) {
                    $loginError = $_SESSION['login_error'];
                    unset($_SESSION['login_error']); // Limpiar el error después de mostrarlo
                }
                if ((isset($_GET['error']) && $_GET['error'] == '1') || $loginError): 
                ?>
                <div class="error-message" style="background: #ff4757; color: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; box-shadow: 0 2px 10px rgba(255, 71, 87, 0.3); animation: shake 0.5s;">
                    <i class="fas fa-exclamation-triangle" style="margin-right: 8px;"></i>
                    <strong>Error de autenticación</strong><br>
                    <small><?php echo $loginError ? htmlspecialchars($loginError) : 'Email o contraseña incorrectos. Verifique sus credenciales e inténtelo nuevamente.'; ?></small>
                </div>
                <style>
                @keyframes shake {
                    0%, 20%, 40%, 60%, 80% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                }
                </style>
                <?php endif; ?>
                
                <!-- CAMPO EMAIL: Input con icono y animación de línea inferior -->
                <div class="input-group">
                    <div class="input-wrapper" data-label="Email">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" id="email" placeholder="Ingrese su email" required autocomplete="email">
                        <div class="input-line"></div>
                    </div>
                    <!-- MENSAJE DE VALIDACIÓN para campo email -->
                    <div class="validation-message" id="email-validation"></div>
                </div>
                
                <!-- CAMPO CONTRASEÑA: Input con icono, botón mostrar/ocultar y validación -->
                <div class="input-group">
                    <div class="input-wrapper password-wrapper" data-label="Contraseña">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" id="password" placeholder="Ingrese su contraseña" required autocomplete="current-password">
                        <!-- BOTÓN TOGGLE: Mostrar/ocultar contraseña con ojo -->
                        <button type="button" class="toggle-password" onclick="togglePassword()" tabindex="-1">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                        <div class="input-line"></div>
                    </div>
                    <!-- MENSAJE DE VALIDACIÓN para campo contraseña -->
                    <div class="validation-message" id="password-validation"></div>
                </div>

                <!-- ADVERTENCIA CAPS LOCK: Se muestra cuando está activado el bloqueo de mayúsculas -->
                <div class="caps-warning" id="caps-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span id="caps-text">Bloq Mayús activado</span>
                </div>
                
                <!-- BOTÓN DE LOGIN: Con loader animado, ripple effect y flecha -->
                <button type="submit" class="login-btn" id="loginBtn">
                    <div class="btn-content">
                        <span class="btn-text" id="btn-text">Iniciar Sesión</span>
                        <!-- SPINNER: Animación durante el proceso de login -->
                        <div class="btn-loader">
                            <div class="spinner"></div>
                        </div>
                        <i class="fas fa-arrow-right btn-arrow"></i>
                    </div>
                    <!-- EFECTO RIPPLE: Animación al hacer clic -->
                    <div class="btn-ripple"></div>
                </button>
            </form>
            
            <!-- PIE DE PÁGINA: Copyright de la universidad -->
            <div class="login-footer">
                <p id="footer-text">&copy; 2025 Universidad Tecnológica Nacional</p>
            </div>
        </div>
    </div>

    <!-- JavaScript del Login desde archivo externo -->
    <script src="/src/Dist/Login/login.js?v=<?php echo time(); ?>"></script>
</body>
</html>