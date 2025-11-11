document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.querySelector('.toggle-sidebar-btn');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            document.body.classList.toggle('toggle-sidebar');
        });
    }

    // === Manejo dinámico de vistas ===
    $(document).on("click", ".sidebar-nav .nav-link", function (e) {
        e.preventDefault();

        const viewUrl = $(this).attr("href"); // Ej: /admin/inscripciones

        if (viewUrl === "/admin" || viewUrl === "/admin/") {
            window.location.href = viewUrl;
            return;
        }
        
        // Limpiar estados anteriores
        $(".sidebar-nav .nav-link").removeClass("active").addClass("collapsed");
        
        // Activar el elemento clickeado
        $(this).addClass("active").removeClass("collapsed");

        $("#main").html(`
            <div class="text-center p-5">
                <div class="spinner-border text-primary"></div>
                <p class="mt-3">Cargando vista...</p>
            </div>
        `);

        $.ajax({
            url: viewUrl,
            type: "GET",
            success: function (response) {
                $("#main").html(response);
            },
            error: function (xhr) {
                $("#main").html(`
                    <div class='alert alert-danger'>
                        Error al cargar la vista solicitada.
                    </div>
                `);
                console.error(xhr.responseText);
            }
        });
    });

});