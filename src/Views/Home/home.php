<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTN Chacabuco</title>
    <link href="../../Dist/fontawesome/css/all.min.css" rel="stylesheet">
    <link rel="icon" href="../../Dist/Image/image.webp" type="image/png">
    <link href="../../Dist/Header/header.css" rel="stylesheet">
    <link href="../../Dist/Home/home.css" rel="stylesheet">
    <link href="../../Dist/Footer/footer.css" rel="stylesheet">
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
                <h1 class="hero-title">La educación es la mejor clave del éxito en la vida</h1>
                <p class="hero-description">
                    La educación transforma vidas y abre puertas hacia un futuro brillante. 
                    En nuestra institución, ofrecemos programas de alta calidad con profesores 
                    experimentados y metodologías innovadoras.
                </p>
                <div class="hero-buttons">
                    <a href="#about" class="btn-primary">
                        Oferta Académica <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#contact" class="btn-secondary">
                        Contáctanos <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <div class="hero-image">
                <div class="celebration-container">
                    <div class="celebration-img"></div>
                    <div class="floating-elements">
                        <div class="floating-element"></div>
                        <div class="floating-element"></div>
                        <div class="floating-element"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about" id="about">
        <div class="about-container">
            <div class="about-single-image fade-in-once"></div>
            <div class="about-content fade-in-once">
                <div class="section-subtitle">
                    <i class="fas fa-graduation-cap"></i>
                    Acerca de Nuestra Universidad
                </div>
                <h2 class="section-title">Algunas Palabras Sobre la Universidad</h2>
                <p class="about-text">
                    Nuestra universidad en Chacabuco nació del sueño de acercar la educación a la gente de la región. Con el apoyo de docentes, estudiantes, el municipio y toda la comunidad, fuimos creciendo paso a paso: desde los primeros cursos de ingreso en los 80, hasta contar hoy con nuestra propia sede y carreras que se convirtieron en una oportunidad real para muchos que querían estudiar sin alejarse de su ciudad.
                </p>
                <p class="about-text">
                    Hoy seguimos con ese mismo espíritu: formar profesionales que no solo sepan de su carrera, sino que también estén comprometidos con su entorno. Nos enorgullece ofrecer tecnicaturas y licenciaturas en áreas que hacen crecer a la región, y sobre todo, nos motiva seguir siendo un lugar de encuentro, aprendizaje y desarrollo para quienes eligen apostar a su futuro acá, en su propia comunidad.
                </p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="courses">
        <div class="features-container">
            <div class="features-content fade-in-once">
                <h2>Por Qué Elegir UTN Chacabuco</h2>
                <p class="features-subtitle">
                    Con más de 25 años de trayectoria en la ciudad, somos la única sede universitaria 
                    que ofrece carreras tecnológicas y de grado, formando profesionales comprometidos 
                    con el desarrollo regional.
                </p>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-industry"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Carreras Orientadas a la Región</h3>
                        <p>
                            Ofrecemos tecnicaturas y licenciaturas específicamente diseñadas para las 
                            necesidades de nuestra región: Industrias Alimentarias, Mantenimiento Industrial, 
                            Administración Rural y más, con fuerte vinculación al sector productivo local.
                        </p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Sede Propia en el Centro</h3>
                        <p>
                            Desde 2013 contamos con nuestra propia sede en Remedios de San Martín 138, 
                            completamente renovada con el esfuerzo conjunto de profesores, estudiantes 
                            y la comunidad de Chacabuco.
                        </p>
                    </div>
                </div>
                
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="feature-text">
                        <h3>Convenios con Instituciones Locales</h3>
                        <p>
                            Trabajamos en conjunto con el Colegio Industrial, la Escuela Agrotécnica
                            y empresas locales para brindar formación práctica real. Nuestros estudiantes 
                            aprenden en entornos profesionales desde el primer día.
                        </p>
                    </div>
                </div>
            </div>
            <div class="features-image fade-in-once"></div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats">
        <div class="stats-container">
            <div class="stats-grid">
                
                <div class="stat-item fade-in-once">
                    <div class="icon-container">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h3>38+</h3>
                    <p>Años de Trayectoria</p>
                </div>

                <div class="stat-item fade-in-once">
                    <div class="icon-container">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3>7</h3>
                    <p>Carreras Activas</p>
                </div>

                <div class="stat-item fade-in-once">
                    <div class="icon-container">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>2013</h3>
                    <p>Sede Propia</p>
                </div>

                <div class="stat-item fade-in-once">
                    <div class="icon-container">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <h3>1996</h3>
                    <p>Primera Carrera</p>
                </div>

            </div>
        </div>
    </section>

    <?php include '../Includes/footer.php'; ?>

    <!-- Scroll to Top Button -->
    <div class="scroll-top" id="scrollTop" onclick="scrollToTop()">
        <i class="fas fa-chevron-up"></i>
    </div>

    <script src="../../Dist/Header/header.js"></script>
    <script src="../../Dist/Home/home.js"></script>
    <script src="../../Dist/Footer/footer.js"></script>
</body>
</html>