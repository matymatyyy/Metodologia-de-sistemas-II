<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTN Chacabuco</title>
    <link href="src/Dist/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="src/Dist/Image/image.webp" type="image/png">
    <link href="src/Dist/Header/header.css" rel="stylesheet">
    <link href="src/Dist/Inscripcion/Inscripcion.css" rel="stylesheet">
    <link href="src/Dist/Footer/footer.css" rel="stylesheet">
</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <?php include '../Includes/header.php'; ?>

    <!-- Hero Section -->
  <section class="hero" id="home">
  <div class="hero-container">
    <div class="hero-content">
      <h1 class="hero-title">Contáctanos</h1>
      <p class="hero-description"> Aca va la informacion para contactarnos</p>

    </div>
  </div>
</section>


 
    <?php include '../Includes/footer.php'; ?>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="src/Dist/Header/header.js"></script>
    <script src="src/Dist/Home/home.js"></script>
    <script src="src/Dist/Inscripcion/Inscripcion.js"></script>
    <script src="src/Dist/Footer/footer.js"></script>
</body>
</html>