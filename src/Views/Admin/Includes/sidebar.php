<style>
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
    height: calc(100vh - var(--header-height));
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

/* ======= Sidebar colapsado ======= */
@media (min-width: 1200px) {
    body.toggle-sidebar #sidebar {
        width: var(--sidebar-width-collapsed);
        padding: 20px 8px;
    }

    body.toggle-sidebar .sidebar-nav .nav-link {
        justify-content: center;
        padding: 10px;
    }

    body.toggle-sidebar .sidebar-nav .nav-link i {
        margin-right: 0;
        font-size: 22px;
    }

    body.toggle-sidebar .sidebar-nav .nav-link span,
    body.toggle-sidebar .sidebar-nav .nav-heading {
        display: none;
    }
}

/* ======= Sidebar oculto en pantallas chicas ======= */
@media (max-width: 1199px) {
    #sidebar {
        left: -100%;
        transition: left 0.3s ease;
    }

    body.toggle-sidebar #sidebar {
        left: 0;
        width: var(--sidebar-width);
    }
}

</style>
<aside id="sidebar" class="sidebar">
  <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
          <a class="nav-link collapsed" href="/admin/home">
              <i class="bi bi-grid"></i>
              <span>Dashboard</span>
          </a>
      </li>

      <li class="nav-item">
          <a class="nav-link collapsed" href="/admin/carreras">
              <i class="bi bi-mortarboard"></i>
              <span>Carreras</span>
          </a>
      </li>

      <li class="nav-item">
          <a class="nav-link collapsed" id="link-inscripciones" href="/admin/inscripciones">
              <i class="bi bi-file-earmark-text"></i>
              <span>Inscripciones</span>
          </a>
      </li>

      <!-- <li class="nav-item">
          <a class="nav-link collapsed" href="/admin/carreras-plan">
              <i class="bi bi-journal-bookmark"></i>
              <span>Carreras Plan</span>
          </a>
      </li> -->

      <!-- <li class="nav-item">
          <a class="nav-link collapsed" href="/admin/noticias">
              <i class="bi bi-newspaper"></i>
              <span>Noticias</span>
          </a>
      </li> -->

      <li class="nav-item">
          <a class="nav-link collapsed" href="/admin/contacto">
              <i class="bi bi-newspaper"></i>
              <span>Consultas</span>
          </a>
      </li>

      <li class="nav-item">
          <a class="nav-link collapsed" href="/admin/usuarios">
              <i class="bi bi-people"></i>
              <span>Usuarios</span>
          </a>
      </li>
  </ul>
</aside>
 <script>
//  document.addEventListener('DOMContentLoaded', function () {
    // ======= TOGGLE SIDEBAR =======
    const toggleBtn = document.querySelector('.toggle-sidebar-btn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
        document.body.classList.toggle('toggle-sidebar');
        });
    }

    // ======= MARCAR ÍTEM ACTIVO SEGÚN URL =======
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('#sidebar-nav .nav-link');

    navLinks.forEach(link => {
        const linkPath = new URL(link.href).pathname;
        if (currentPath === linkPath || currentPath.startsWith(linkPath + "/")) {
        link.classList.add('active');
        link.classList.remove('collapsed');
        } else {
        link.classList.remove('active');
        }
    });

    // navLinks.forEach(link => {
    //     link.addEventListener('click', () => {
    //         // Cierra el sidebar automáticamente en pantallas chicas
    //         if (window.innerWidth < 1200) {
    //         document.body.classList.remove('toggle-sidebar');
    //         }
    //     });
    // });
    
// })
</script>