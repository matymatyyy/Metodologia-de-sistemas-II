document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('.toggle-sidebar-btn');
    const sidebar = document.querySelector('#sidebar');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            document.body.classList.toggle('toggle-sidebar');
        });
    }

    // Expandir sidebar al pasar el mouse cuando está cerrado
    if (sidebar) {
        sidebar.addEventListener('mouseenter', function () {
            if (document.body.classList.contains('toggle-sidebar')) {
                document.body.classList.add('sidebar-hover');
            }
        });

        sidebar.addEventListener('mouseleave', function () {
            document.body.classList.remove('sidebar-hover');
        });
    }
});