
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <i class="bi bi-list toggle-sidebar-btn"></i>
        <a href="/admin">
            <img src="/src/Dist/Image/logoUTN.png" alt="Logo" style="height:90px; width:auto;">
        </a>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="/src/Dist/Image/usuario.png" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['user']['name']; ?></span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    <li class="dropdown-header">
                        <div class="d-flex align-items-center">
                            <div class="user-avatar-large">
                                <?php echo strtoupper(substr($_SESSION['user']['name'], 0, 1)); ?>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-1"><?php echo $_SESSION['user']['name']; ?></h6>
                            </div>
                        </div>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center text-danger" href="/logout">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </nav>
</header>