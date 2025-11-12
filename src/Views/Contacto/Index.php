<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTN Chacabuco</title>
    <link href="/src/Dist/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="/src/Dist/Image/image.webp" type="image/png">
    <link href="/src/Dist/Header/header.css" rel="stylesheet">
    <link href="/src/Dist/Inscripcion/Inscripcion.css" rel="stylesheet">
    <link href="/src/Dist/Contacto/contacto.css" rel="stylesheet">
    <link href="/src/Dist/Footer/footer.css" rel="stylesheet">
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/Views/Includes/header.php'; ?>

    <!-- Hero Section -->
  <section class="hero" id="home">
  <div class="hero-container">
    <div class="hero-content">
      <h1 class="hero-title">Contáctanos</h1>
      <p class="hero-description">¿Tenés alguna consulta sobre nuestras carreras? ¡Escribinos y te respondemos a la brevedad!</p>

  <!-- Formulario de contacto principal -->
      <form id="contactForm" class="form-container">
        <!-- Campo: Nombre completo (con icono y validación) -->
        <div class="form-group">
          <label for="name"><i class="fas fa-user"></i> Nombre completo:</label>
          <input type="text" id="name" name="name" placeholder="Tu nombre completo" required>
          <span class="validation-message" id="nameValidation"></span>
          <span class="error" id="nameError">Por favor ingresa tu nombre completo</span>
        </div>

        <!-- Campo: Correo electrónico (con icono y validación) -->
        <div class="form-group">
          <label for="email"><i class="fas fa-envelope"></i> Correo electrónico:</label>
          <input type="email" id="email" name="email" placeholder="tu@email.com" required>
          <span class="validation-message" id="emailValidation"></span>
          <span class="error" id="emailError">Por favor ingresa un email válido</span>
        </div>

        <!-- Campo: Asunto (select con icono) -->
        <div class="form-group">
          <label for="subject"><i class="fas fa-tag"></i> Asunto:</label>
          <select id="subject" name="subject" required>
            <option value="">Selecciona un tema</option>
            <option value="informacion-carreras">Información sobre carreras</option>
            <option value="inscripciones">Proceso de inscripción</option>
            <option value="horarios">Horarios y cursadas</option>
            <option value="requisitos">Requisitos de ingreso</option>
            <option value="titulaciones">Títulos y certificaciones</option>
            <option value="extension">Extensión Universitaria</option>
            <option value="observatorio">Observatorio de Datos Locales</option>
            <option value="otro">Otra consulta</option>
          </select>
          <span class="error" id="subjectError">Por favor selecciona un asunto</span>
        </div>

        <!-- Campo: Mensaje (textarea con icono, contador y validación) -->
        <div class="form-group">
          <label for="message"><i class="fas fa-comment-dots"></i> Mensaje:</label>
          <textarea id="message" name="message" rows="5" placeholder="Escribí tu consulta aquí..." maxlength="500" required></textarea>
          <span class="character-counter" id="messageCounter">0/500</span>
          <span class="validation-message" id="messageValidation"></span>
          <span class="error" id="messageError">Por favor escribe tu mensaje (mínimo 10 caracteres)</span>
        </div>

        <!-- Botón de envío con animación de carga -->
        <div class="cont-button-submit">
          <button type="submit" class="btn-primary" id="submitBtn">
            <span class="btn-text">ENVIAR MENSAJE</span>
            <span class="btn-loading">
              <i class="fas fa-spinner fa-spin"></i> Enviando...
            </span>
          </button>
        </div>
      </form>

  <!-- Mensajes de éxito y error tras enviar el formulario -->
      <div class="message-container">
        <div class="success-message" id="successMessage">
          <i class="fas fa-check-circle"></i>
          <h3>¡Mensaje enviado correctamente!</h3>
          <p>Te responderemos a la brevedad en tu email.</p>
        </div>
        <div class="error-message" id="errorMessage">
          <i class="fas fa-exclamation-circle"></i>
          <h3>Error al enviar el mensaje</h3>
          <p>Por favor intenta nuevamente o contáctanos por teléfono.</p>
        </div>
      </div>

    </div>
  </div>
</section>


 
    <?php include $_SERVER["DOCUMENT_ROOT"] . '/src/Views/Includes/footer.php'; ?>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </div>


    <!-- Modal de éxito profesional -->
    <div id="successModal" class="success-modal-bg">
      <div class="success-modal-card">
        <div class="success-modal-icon">
          <svg viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="26" cy="26" r="25" stroke="#22c55e" stroke-width="3" fill="rgba(34,197,94,0.08)"/>
            <path d="M16 27.5L23.5 35L36 20" stroke="#22c55e" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <h2 class="success-modal-title">¡Mensaje enviado!</h2>
        <p class="success-modal-text">Tu consulta fue recibida correctamente.</p>
        <div class="success-modal-comment">Te responderemos a la brevedad al correo proporcionado.</div>
      </div>
    </div>

    <script src="/src/Dist/Header/header.js"></script>
    <script src="/src/Dist/Contacto/contacto.js"></script>
    <script src="/src/Dist/Footer/footer.js"></script>
</body>
</html>