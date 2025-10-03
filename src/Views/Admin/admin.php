<?php
    $_SESSION['usuario'] = "Admin";
    $_SESSION['rol'] = "Secretario";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel - Template Simple</title>

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* ======= Variables ======= */
    :root {
      --header-height: 60px;
      --sidebar-width: 300px;
      --sidebar-width-collapsed: 80px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Open Sans", sans-serif;
      background: #f6f9ff;
      color: #444444;
    }

    /* ======= Header ======= */
    #header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: var(--header-height);
      background: #fff;
      box-shadow: 0px 2px 20px rgba(1, 41, 112, 0.1);
      z-index: 997;
    }

    .header .logo {
      font-size: 26px;
      font-weight: 700;
      color: #012970;
      text-decoration: none;
      margin-left: 25px;
    }

    .header .logo img {
      max-height: 40px;
      margin-right: 6px;
    }

    .header .logo span {
      color: #012970;
    }

    .toggle-sidebar-btn {
      font-size: 32px;
      padding-left: 10px;
      cursor: pointer;
      color: #012970;
    }

    .header-nav ul {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .header-nav .nav-icon {
      font-size: 22px;
      color: #012970;
      margin-right: 25px;
      position: relative;
    }

    .header-nav .nav-profile {
      color: #012970;
    }

    .header-nav .nav-profile img {
      max-height: 36px;
    }

    .header-nav .profile {
      min-width: 240px;
      padding-bottom: 0;
    }

    .header-nav .profile .dropdown-header h6 {
      font-size: 18px;
      margin-bottom: 0;
      font-weight: 600;
      color: #444444;
    }

    .header-nav .profile .dropdown-header span {
      font-size: 14px;
    }

    .header-nav .profile .dropdown-item {
      font-size: 14px;
      padding: 10px 15px;
      transition: 0.3s;
    }

    .header-nav .profile .dropdown-item i {
      margin-right: 10px;
      font-size: 18px;
      line-height: 0;
    }

    .header-nav .profile .dropdown-item:hover {
      background-color: #f6f9ff;
    }

    /* ======= Sidebar ======= */
    #sidebar {
      position: fixed;
      top: var(--header-height);
      left: 0;
      bottom: 0;
      width: var(--sidebar-width);
      z-index: 996;
      transition: all 0.3s;
      padding: 20px;
      overflow-y: auto;
      scrollbar-width: thin;
      scrollbar-color: #aab7cf transparent;
      box-shadow: 0px 0px 20px rgba(1, 41, 112, 0.1);
      background-color: #fff;
    }

    #sidebar::-webkit-scrollbar {
      width: 5px;
      height: 8px;
      background-color: #fff;
    }

    #sidebar::-webkit-scrollbar-thumb {
      background-color: #aab7cf;
    }

    @media (max-width: 1199px) {
      #sidebar {
        left: -300px;
      }
    }

    .toggle-sidebar #sidebar {
      left: 0;
    }

    @media (min-width: 1200px) {
      .toggle-sidebar #sidebar {
        left: 0;
        width: var(--sidebar-width-collapsed);
      }
    }

    .sidebar-nav {
      padding: 0;
      margin: 0;
      list-style: none;
    }

    .sidebar-nav li {
      padding: 0;
      margin: 0;
      list-style: none;
    }

    .sidebar-nav .nav-item {
      margin-bottom: 5px;
    }

    .sidebar-nav .nav-heading {
      font-size: 11px;
      text-transform: uppercase;
      color: #899bbd;
      font-weight: 600;
      margin: 10px 0 5px 15px;
    }

    .sidebar-nav .nav-link {
      display: flex;
      align-items: center;
      font-size: 15px;
      font-weight: 600;
      color: #4154f1;
      transition: 0.3s;
      background: #f6f9ff;
      padding: 10px 15px;
      border-radius: 4px;
      text-decoration: none;
      white-space: nowrap;
    }

    .sidebar-nav .nav-link i {
      font-size: 20px;
      margin-right: 10px;
      color: #4154f1;
      min-width: 20px;
    }

    .sidebar-nav .nav-link.collapsed {
      color: #012970;
      background: #fff;
    }

    .sidebar-nav .nav-link.collapsed i {
      color: #899bbd;
    }

    .sidebar-nav .nav-link:hover {
      color: #4154f1;
      background: #f6f9ff;
    }

    .sidebar-nav .nav-link:hover i {
      color: #4154f1;
    }

    /* Sidebar collapsed state */
    .toggle-sidebar .sidebar-nav .nav-link span {
      display: none;
    }

    .toggle-sidebar .sidebar-nav .nav-heading {
      display: none;
    }

    .toggle-sidebar #sidebar {
      padding: 20px 10px;
    }

    .toggle-sidebar .sidebar-nav .nav-link {
      justify-content: center;
      padding: 10px;
    }

    .toggle-sidebar .sidebar-nav .nav-link i {
      margin-right: 0;
      font-size: 24px;
    }

    /* ======= Main Content ======= */
    #main {
      margin-top: var(--header-height);
      padding: 20px 30px;
      transition: all 0.3s;
    }

    @media (min-width: 1200px) {
      #main {
        margin-left: var(--sidebar-width);
      }

      .toggle-sidebar #main {
        margin-left: var(--sidebar-width-collapsed);
      }
    }

    .pagetitle {
      margin-bottom: 10px;
    }

    .pagetitle h1 {
      font-size: 24px;
      margin-bottom: 0;
      font-weight: 600;
      color: #012970;
    }
  </style>
</head>
<body>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <span class="d-none d-lg-block">Mi Panel</span>
     </a>

      <i class="bi bi-list toggle-sidebar-btn"></i>
        <img src="logoUTN.png" alt="Logo" style="height:90px; width:auto;">
        
    </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="usuario.png" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">Usuario</span>
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

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link" href="index.html">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
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
                <a class="nav-link collapsed" href="#">
                    <i class="bi bi-journal-bookmark"></i>
                    <span>Carreras Plan</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
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

    <!-- ======= Main Content ======= -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Bienvenido al panel, <?php echo $_SESSION['usuario']; ?></h1>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../Dist/Admin/admin.js"></script>
</body>
</html>