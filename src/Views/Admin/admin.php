<?php
    // Asegúrate de que session_start() se ejecute al inicio si lo necesitas
    // session_start(); 
    $_SESSION['usuario'] = "Admin";
    $_SESSION['rol'] = "Secretario";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de control</title>
    
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    
    <link href="src/Dist/Admin/admin.css" rel="stylesheet">
</head>
<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
            <a href="admin.php">
                <img src="src/Dist/Image/logoUTN.png" alt="Logo" style="height:90px; width:auto;">
            </a>
        </div>
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <img src="src/Dist/Image/usuario.png" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['usuario']; ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar-large">
                                    <?php echo strtoupper(substr($_SESSION['usuario'], 0, 1)); ?>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-1"><?php echo $_SESSION['usuario']; ?></h6>
                                    <span class="badge bg-primary"><?php echo $_SESSION['rol']; ?></span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center text-danger" href="#">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Cerrar Sesión</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="cargarContenido('/src/Views/Admin/dashboard.php')">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" onclick="cargarContenido('/src/Views/Admin/carreras.php')"> 
                    <i class="bi bi-mortarboard"></i>
                    <span>Carreras</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Inscripciones</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" onclick="cargarContenido('/src/Views/Admin/carreras_plan.php')">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Carreras Plan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" onclick="cargarContenido('/src/Views/Admin/noticias.php')"> 
                    <i class="bi bi-newspaper"></i>
                    <span>Noticias</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-people"></i>
                    <span>Usuarios</span>
                </a>
            </li>
        </ul>
    </aside>

    <main id="main" class="main">
        <div class="pagetitle">
            
        </div>
        
        <div id="contenidoDinamico" class="mt-4">
            </div>
    </main>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script src="src/Dist/Admin/admin.js"></script>

    <script>
        
        // Función CRUCIAL para cargar contenido en el div dinámico
        function cargarContenido(url) {
            // Oculta el título de bienvenida predeterminado
            $('#tituloDefault').hide();
            
            // 1. Muestra un loader (Feedback al usuario)
            $('#contenidoDinamico').html(`
                <div class="text-center p-5">
                    <span class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></span>
                    <p class="mt-2 text-primary">Cargando módulo...</p>
                </div>
            `);
            
            // 2. Petición AJAX
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // Carga el contenido HTML recibido
                    $('#contenidoDinamico').html(data);
                    
                    // Vuelve a mostrar el título (ahora el título del módulo)
                    $('#tituloDefault').show();

                    // 3. Ejecuta los scripts que vienen incluidos en el archivo (¡CRUCIAL para DataTables!)
                    ejecutarScriptsCargados();
                },
                error: function(xhr) {
                    $('#contenidoDinamico').html(`
                        <div class="alert alert-danger mt-4">
                            <strong>Error ${xhr.status}</strong>: No se pudo cargar el módulo de ${url}.
                        </div>
                    `);
                    $('#tituloDefault').show();
                }
            });
        }
        
        // Función para re-ejecutar los scripts dentro del contenido cargado
        function ejecutarScriptsCargados() {
            // Busca todos los bloques <script> dentro del contenido dinámico
            const scripts = $('#contenidoDinamico').find('script');
            scripts.each(function() {
                const newScript = document.createElement('script');
                if ($(this).attr('src')) {
                    newScript.src = $(this).attr('src'); // Script externo
                } else {
                    newScript.textContent = $(this).text(); // Código interno
                }
                // Añade al DOM para su ejecución
                document.body.appendChild(newScript);
                // Elimina el script original para evitar duplicidad
                $(this).remove(); 
            });
        }
        
        // CORRECCIÓN CLAVE: Al iniciar, solo mostramos el mensaje de bienvenida.
        $(document).ready(function() {
             $('#contenidoDinamico').html('<div class="alert alert-info mt-4"><h4 class="mb-3">Bienvenido, <?php echo $_SESSION['usuario']; ?>.</h4><p>Seleccione una opción del menú lateral para comenzar a administrar el sistema.</p></div>');
        });
    </script>
</body>
</html>