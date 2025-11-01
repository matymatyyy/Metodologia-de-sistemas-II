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
    <link href="/src/Dist/Footer/footer.css" rel="stylesheet">
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <?php include_once '../Includes/header.php'; ?>

    <!-- Hero Section -->
  <section class="hero" id="home">
  <div class="hero-container">
    <div class="hero-content">
      <h1 class="hero-title">Inscripción Carreras Universitarias 2026</h1>
      <p class="hero-description">
        A continuación te presentamos el formulario para la inscripción a las carreras universitarias 2025. El presente formulario implica confirmación de inscripción en el ciclo introductorio, una vez que presione el botón Enviar al finalizar la carga.

Todas las carreras se dictan de forma presencial y de manera completa en la sede de la UTN-FRSN Aula Chacabuco.

A partir del envio de la inscripción la comunicación será a través de correo electrónico y WhatsApp. Esté atento a ambos medios de comunicación, incluso correo Spam.
      </p>

      <form id="inscriptionForm" class="form-container">
        <div class="form-group">
          <label for="email">Correo electrónico:</label>
          <input type="email" id="email" placeholder="Tu dirección de correo electrónico" required>
        </div>

        <div class="form-group">
          <label for="career">Selecciona la carrera:</label>
          <select id="career" required>
            <option value="">Selecciona una carrera</option>
            <option value="loi">Licenciatura en Organización Industrial</option>
            <option value="lar">Licenciatura en Administración Rural</option>
            <option value="tumi">Tecnicatura Universitaria en Mantenimiento Industrial</option>
            <option value="tum">Tecnicatura Universitaria en Mecatrónica</option>
            <option value="tuhst">Tecnicatura Universitaria en Higiene y Seguridad</option>
            <option value="tup">Tecnicatura Universitaria en Programación</option>
          </select>
        </div>

        <div class="form-group">
          <label for="fullName">Apellido y Nombre:</label>
          <input type="text" id="fullName" placeholder="Tu apellido y nombre completo" required>
        </div>

        <div class="form-group">
          <label for="dni">DNI:</label>
          <input type="text" id="dni" placeholder="Número de documento" required>
        </div>

        <div class="form-group">
          <label for="address">Domicilio:</label>
          <input type="text" id="address" placeholder="Ingresa tu domicilio" required>
        </div>

        <div class="form-group">
          <label for="city">Localidad:</label>
          <input type="text" id="city" placeholder="Ingresa tu localidad" required>
        </div>

        <div class="form-group">
          <label for="phone">Teléfono celular:</label>
          <input type="tel" id="phone" placeholder="Ej: 1122334455" required>
        </div>

        <div class="form-group">
          <label for="birthdate">Fecha de nacimiento:</label>
          <input type="text" id="birthdate" placeholder="dd/mm/aaaa" required>
        </div>
                
        <div class="form-group">
            <label>Foto DNI (ambos lados)</label>
            <small>suba hasta dos archivos. Formatos aceptados: JPG, PNG, PDF. Máx. 5MB por archivo.</small>
            <div class="file-upload" id="fileUploadArea">
                <p><i class="fas fa-cloud-upload-alt"></i> Haz clic aquí para subir archivos o arrastra y suelta</p>
                <input type="file" id="fileInput" class="file-input" multiple accept=".jpg,.jpeg,.png,.pdf" max-size="10485760">
            </div>
            <div class="file-list" id="fileList"></div>
            <div class="error" id="fileError">Por favor, sube al menos un archivo (máximo 2)</div>
        </div>

        <div class="checkbox-group">
          <input type="checkbox" id="terms" required>
          <label for="terms">Acepto los términos y condiciones</label>
        </div>

        <div class="cont-button-submit">
          <button type="submit" class="btn-primary">ENVIAR FORMULARIO</button>
        </div>
      </form>
    </div>
  </div>
</section>


 
    <?php include '../Includes/footer.php'; ?>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="/src/Dist/Header/header.js"></script>
    <script src="/src/Dist/Home/home.js"></script>
    <script src="/src/Dist/Inscripcion/Inscripcion.js"></script>
    <script src="/src/Dist/Footer/footer.js"></script>
</body>
</html>