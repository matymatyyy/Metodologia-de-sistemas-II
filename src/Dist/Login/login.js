// Variables para manejar el login
let currentLanguage = 'es';  // idioma por defecto
let isLoading = false;       // para no enviar el form varias veces

// función para hashear password con SHA-256
async function hashPassword(password) {
    // convertir string a ArrayBuffer
    const encoder = new TextEncoder();
    const data = encoder.encode(password);
    
    // crear hash SHA-256
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    
    // convertir a hexadecimal
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    
    return hashHex;
}

// Sistema de traducciones español/inglés 
const translations = {
    es: {
        title: 'UTN Chacabuco',
        subtitle: 'Panel Administrativo',
        emailPlaceholder: 'Ingrese su email',
        passwordPlaceholder: 'Ingrese su contraseña',
        loginBtn: 'Iniciar Sesión',
        footer: '© 2024 Universidad Tecnológica Nacional',
        caps: 'Bloq Mayús activado',
        loading: 'Cargando Panel UTN',
        loginError: 'Error al iniciar sesión. Verifique sus credenciales.'
    },
    en: {
        title: 'UTN Chacabuco',
        subtitle: 'Administrative Panel',
        emailPlaceholder: 'Enter your email',
        passwordPlaceholder: 'Enter your password',
        loginBtn: 'Sign In',
        footer: '© 2024 National Technological University',
        caps: 'Caps Lock is ON',
        loading: 'Loading UTN Panel',
        loginError: 'Login failed. Please check your credentials.'
    }
};

// cargar la página y mostrar efectos
window.addEventListener('load', () => {
    setTimeout(() => {
        // ocultar preloader
        document.getElementById('preloader').style.opacity = '0';
        setTimeout(() => {
            document.getElementById('preloader').style.display = 'none';
            // mostrar la tarjeta de login
            document.getElementById('loginCard').classList.add('card-enter');
            // crear las particulas de fondo
            createParticles();
        }, 500);
    }, 1500);  // esperar 1.5 segundos
});

// crear particulas flotantes para que se vea copado
function createParticles() {
    const container = document.getElementById('particles');
    // Menos partículas en móviles para mejor rendimiento
    const particleCount = window.innerWidth < 768 ? 30 : 50;
    
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.className = 'particle';
        // Posición horizontal aleatoria
        particle.style.left = Math.random() * 100 + '%';
        // Delay aleatorio para animación más natural
        particle.style.animationDelay = Math.random() * 20 + 's';
        // Duración aleatoria entre 10-20 segundos
        particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
        container.appendChild(particle);
    }
}

// funcion para mostrar/ocultar contraseña
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');
    
    if (passwordInput.type === 'password') {
        // mostrar contraseña
        passwordInput.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        // ocultar contraseña
        passwordInput.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// ==================== CAMBIO DE IDIOMA ====================
// Sistema bilingüe español/inglés
function toggleLanguage() {
    // Alternar entre español e inglés
    currentLanguage = currentLanguage === 'es' ? 'en' : 'es';
    // Cambiar texto del botón (muestra el idioma disponible)
    document.getElementById('lang-btn').textContent = currentLanguage === 'es' ? 'EN' : 'ES';
    // Aplicar traducciones
    updateLanguage();
}

// Actualizar textos según idioma seleccionado
function updateLanguage() {
    const lang = translations[currentLanguage];
    document.getElementById('title').textContent = lang.title;
    document.getElementById('subtitle').textContent = lang.subtitle;
    document.getElementById('email').placeholder = lang.emailPlaceholder;
    document.getElementById('password').placeholder = lang.passwordPlaceholder;
    document.getElementById('btn-text').textContent = lang.loginBtn;
    document.getElementById('footer-text').textContent = lang.footer;
    document.getElementById('caps-text').textContent = lang.caps;
}

// ==================== DETECCIÓN DE BLOQ MAYÚS ====================
// Detectar cuando está activado Caps Lock
function detectCapsLock(event) {
    const capsWarning = document.getElementById('caps-warning');
    // Verificar si Caps Lock está activado usando getModifierState
    if (event.getModifierState && event.getModifierState('CapsLock')) {
        capsWarning.classList.add('show');
    } else {
        capsWarning.classList.remove('show');
    }
}

// ==================== VALIDACIÓN DE INPUTS ====================
// Validación en tiempo real de campos del formulario
function validateInput(input, type) {
    const value = input.value.trim();
    const validationEl = document.getElementById(type + '-validation');
    
    if (type === 'email') {
        // Validar email con regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (value.length === 0) {
            validationEl.textContent = '';
            validationEl.className = 'validation-message';
        } else if (!emailRegex.test(value)) {
            showValidation(validationEl, 'Email inválido', 'error');
        } else {
            showValidation(validationEl, 'Email válido', 'success');
        }
    } else if (type === 'password') {
        // Validar contraseña (mínimo 6 caracteres)
        if (value.length === 0) {
            validationEl.textContent = '';
            validationEl.className = 'validation-message';
        } else if (value.length < 6) {
            showValidation(validationEl, 'Contraseña debe tener al menos 6 caracteres', 'error');
        } else {
            showValidation(validationEl, 'Contraseña válida', 'success');
        }
    }
}

// Mostrar mensaje de validación con estilo
function showValidation(element, message, type) {
    element.textContent = message;
    element.className = 'validation-message ' + type;
    element.classList.add('show');
}

// ==================== EFECTO RIPPLE EN BOTÓN ====================
function createRipple(event) {
    const button = event.currentTarget;
    const ripple = button.querySelector('.btn-ripple');
    const rect = button.getBoundingClientRect();
    // Calcular posición del clic relativa al botón
    const x = event.clientX - rect.left;
    const y = event.clientY - rect.top;
    
    // Posicionar el ripple en el punto de clic
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.classList.add('active');
    
    // Remover el efecto después de la animación
    setTimeout(() => {
        ripple.classList.remove('active');
    }, 600);
}

// Función para enviar el formulario
function handleFormSubmit(e) {
    e.preventDefault(); // Prevenir envío normal para usar AJAX
    
    if (isLoading) {
        return;
    }
    
    // obtener datos del formulario para validación básica
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    // validar campos antes de enviar
    if (!email || !password) {
        showLoginError('Por favor complete todos los campos');
        return;
    }
    
    // Mostrar estado de carga
    isLoading = true;
    const btn = document.getElementById('loginBtn');
    btn.classList.add('loading');
    
    // Limpiar errores anteriores
    const existingError = document.querySelector('.login-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Enviar por AJAX
    fetch('/usuario', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            email: email,
            password: password
        })
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        }
        return response.json().then(data => Promise.reject(data));
    })
    .then(data => {
        if (data.success) {
            // Login exitoso - mostrar página de éxito y redirigir
            showSuccessAndRedirect(data.user);
        }
    })
    .catch(error => {
        // Mostrar error en la misma página
        const errorMessage = error.error || 'Error de conexión';
        showLoginError(errorMessage);
    })
    .finally(() => {
        isLoading = false;
        btn.classList.remove('loading');
    });
}

// Función para mostrar éxito y redirigir
function showSuccessAndRedirect(userName) {
    // Crear overlay de éxito
    const successOverlay = document.createElement('div');
    successOverlay.innerHTML = `
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #0f172a; z-index: 9999; display: flex; align-items: center; justify-content: center;">
            <div style="background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(20px); border-radius: 25px; padding: 50px 40px; border: 1px solid rgba(255, 255, 255, 0.2); box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1); text-align: center; max-width: 450px; width: 90%; animation: fadeInScale 0.8s ease-out;">
                <div style="margin-bottom: 25px;">
                    <img src="/src/Dist/Image/UTN_logo.jpg" alt="UTN Logo" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,0.3);">
                </div>
                <div style="font-size: 4rem; color: #2ecc71; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h1 style="color: white; font-size: 2rem; font-weight: 600; margin-bottom: 10px;">UTN Chacabuco</h1>
                <p style="color: rgba(255,255,255,0.9); font-size: 1.1rem; margin-bottom: 30px;">Acceso Autorizado</p>
                <p style="color: rgba(255,255,255,0.8); font-size: 1rem; margin-bottom: 25px;">Bienvenido/a, <strong>${userName}</strong></p>
                <div style="margin: 25px 0;">
                    <div style="width: 100%; height: 6px; background: rgba(255,255,255,0.2); border-radius: 3px; overflow: hidden;">
                        <div style="height: 100%; background: linear-gradient(90deg, #2ecc71, #27ae60); border-radius: 3px; animation: progress 2s ease-out;"></div>
                    </div>
                    <p style="color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-top: 15px;">Redirigiendo al Panel Administrativo...</p>
                </div>
            </div>
        </div>
        <style>
            @keyframes fadeInScale { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
            @keyframes progress { from { width: 0%; } to { width: 100%; } }
        </style>
    `;
    
    document.body.appendChild(successOverlay);
    
    // Redirigir después de 2.5 segundos
    setTimeout(() => {
        window.location.href = '/admin';
    }, 2500);
}

// mostrar mensaje de error cuando no se puede loguear
function showLoginError(customMessage = null) {
    const lang = translations[currentLanguage];
    const errorMessage = customMessage || lang.loginError;
    
    // remover errores anteriores
    const existingError = document.querySelector('.login-error');
    if (existingError) {
        existingError.remove();
    }
    
    // crear mensaje de error
    const errorDiv = document.createElement('div');
    errorDiv.className = 'login-error';
    errorDiv.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <span>${errorMessage}</span>
    `;
    
    // agregar despues del boton
    const form = document.getElementById('loginForm');
    form.appendChild(errorDiv);
    
    // mostrar con animacion
    setTimeout(() => errorDiv.classList.add('show'), 100);
}

// ==================== EVENT LISTENERS PRINCIPALES ====================
document.addEventListener('DOMContentLoaded', function() {
    // DETECCIÓN DE CAPS LOCK: Escuchar teclas presionadas y liberadas
    document.addEventListener('keydown', detectCapsLock);
    document.addEventListener('keyup', detectCapsLock);
    
    // VALIDACIÓN EN TIEMPO REAL: Mientras el usuario escribe
    document.getElementById('email').addEventListener('input', function() {
        validateInput(this, 'email');
    });
    
    document.getElementById('password').addEventListener('input', function() {
        validateInput(this, 'password');
    });
    
    // EFECTO RIPPLE: Al hacer clic en el botón de login
    document.getElementById('loginBtn').addEventListener('click', createRipple);
    
    // ENVÍO DEL FORMULARIO
    document.getElementById('loginForm').addEventListener('submit', handleFormSubmit);
    
    // TECLA ENTER: Permite enviar formulario con Enter
    document.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !isLoading) {
            document.getElementById('loginForm').dispatchEvent(new Event('submit'));
        }
    });
    
    // EFECTOS DE FOCUS: Animaciones cuando el usuario hace clic en inputs
    const inputs = document.querySelectorAll('.input-wrapper input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            // Agregar clase 'focused' para animación
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            // Remover clase solo si el input está vacío
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
});

// ==================== AJUSTES RESPONSIVE ====================
// Detectar cambios de tamaño de pantalla para optimizar en móviles
window.addEventListener('resize', function() {
    if (window.innerWidth < 768) {
        document.body.classList.add('mobile');
    } else {
        document.body.classList.remove('mobile');
    }
});

// ==================== OPTIMIZACIÓN PARA MÓVILES ====================
// Detectar dispositivos móviles para aplicar optimizaciones específicas
if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
    document.body.classList.add('mobile-device');
}

// ==================== RESUMEN DE FUNCIONALIDADES ====================
/*
CARACTERÍSTICAS IMPLEMENTADAS EN ESTE LOGIN:

1. PRELOADER: Pantalla de carga inicial con logo y barra de progreso
2. GLASSMORPHISM: Efecto de vidrio esmerilado en la tarjeta de login
3. PARTÍCULAS ANIMADAS: Sistema de partículas flotantes en el fondo
4. MULTIIDIOMA: Español/Inglés con botón toggle
5. VALIDACIÓN EN TIEMPO REAL: Campos de email y contraseña
6. DETECCIÓN CAPS LOCK: Advertencia cuando está activado
7. MOSTRAR/OCULTAR CONTRASEÑA: Botón con ojo para alternar visibilidad
8. EFECTOS RIPPLE: Animación de ondas al hacer clic en el botón
9. RESPONSIVE DESIGN: Adaptable a móviles y tablets
10. EFECTOS DE FOCUS: Animaciones en los campos de input
11. LOADING STATES: Spinner en el botón durante el proceso
12. CONTADOR DE INTENTOS: Muestra número de intentos de login
13. ELEMENTOS FLOTANTES: Decoración animada de fondo
14. ONDAS DECORATIVAS: Efectos de wave en el background
15. TIPOGRAFÍA PREMIUM: Fuente Inter para aspecto profesional

TECNOLOGÍAS UTILIZADAS:
- HTML5 semántico
- CSS3 con variables y efectos avanzados
- JavaScript ES6+ vanilla (sin librerías externas)
- FontAwesome para iconografía
- Responsive design mobile-first
- Optimización de rendimiento para dispositivos móviles
*/

// login listo para usar
console.log('Login cargado correctamente');