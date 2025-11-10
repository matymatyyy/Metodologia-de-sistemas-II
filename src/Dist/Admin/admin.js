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
        $(".sidebar-nav .nav-link").removeClass("active");
        $(this).addClass("active");

        $("#dashboard-content").html(`
            <div class="text-center p-5">
                <div class="spinner-border text-primary"></div>
                <p class="mt-3">Cargando vista...</p>
            </div>
        `);

        $.ajax({
            url: viewUrl,
            type: "GET",
            success: function (response) {
                $("#dashboard-content").html(response);
            },
            error: function (xhr) {
                $("#dashboard-content").html(`
                    <div class='alert alert-danger'>
                        Error al cargar la vista solicitada.
                    </div>
                `);
                console.error(xhr.responseText);
            }
        });
    });

});