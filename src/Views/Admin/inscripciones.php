<?php
$_SESSION['rol'] = "Secretario";
?>

<!-- ======= Head ======= -->
<?php include_once 'src/Views/Admin/Includes/head.php'; ?>

<body>
    <!-- ======= Header ======= -->
    <?php include_once 'src/Views/Admin/Includes/header.php'; ?>

    <!-- ======= Sidebar ======= -->
    <?php include_once 'src/Views/Admin/Includes/sidebar.php'; ?>

    <style>
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            margin: 0 2px;
        }

        .badge {
            font-size: 0.85rem;
            padding: 0.35em 0.65em;
        }

        .card {
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }
    </style>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestión de Inscripciones</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title">Listado de Inscripciones</h5>
                                <button class="btn btn-primary" onclick="nuevaInscripcion()">
                                <i class="bi bi-plus-circle"></i> Nueva Inscripción
                                </button>
                            </div>
                            <div class="row mb-3">
    <div class="col-md-4">
        <label for="filtro_carrera" class="form-label">Filtrar inscriptos por carrera</label>
        <select id="filtro_carrera" class="form-select">
            <option value="">Todas</option>
        </select>
    </div>
</div>

                            

                            <div class="table-responsive">
                                <table id="tablaInscripciones" class="table table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Email</th>
                                            <th>Teléfono</th>
                                            <th>DNI</th>
                                            <th>Fecha</th>
                                            <th>Carrera</th>
                                            <th>Activo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Modal Editar Inscripción -->
    <div class="modal fade" id="modalInscripcion" tabindex="-1" aria-labelledby="modalInscripcionLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalInscripcionLabel">Editar Inscripción</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formInscripcion">
                    <div class="modal-body">
                        <input type="hidden" id="inscripcion_id" name="id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">DNI</label>
                                <input type="number" class="form-control" id="dni" name="dni" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha de inscripción</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="id_carrera" class="form-label">Carrera</label>
                            <select class="form-select" id="id_carrera" name="id_carrera" required>
                                <option value="">Seleccione una carrera</option>
                            </select>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo">
                            <label class="form-check-label" for="activo">Activo</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> <span id="btnGuardarTexto">Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'src/Views/Admin/Includes/footer.php'; ?>

    <script>
        // Variable global para almacenar las carreras
        let carrerasMap = {};
        let dataTable;

        $(document).ready(function () {
            // Primero cargar las carreras, luego inicializar TODO
            cargarTodasLasCarreras().then(() => {
                inicializarDataTable();
                cargarFiltroCarreras();
            });
        });

        // === Cargar todas las carreras ===
        function cargarTodasLasCarreras() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: 'http://localhost:8080/carreras',
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        
                        let carreras = [];
                        
                        if (res && res.data && Array.isArray(res.data)) {
                            carreras = res.data;
                        }
                        
                        // Poblar el mapa de carreras
                        carreras.forEach(c => {
                            if (c && c.id && c.titulo) {
                                carrerasMap[c.id] = c.titulo;
                            }
                        });
                                            
                        // Cargar select del modal
                        const selectModal = $('#id_carrera');
                        selectModal.empty().append('<option value="">Seleccione una carrera</option>');
                        carreras.forEach(c => {
                            selectModal.append(`<option value="${c.id}">${c.titulo}</option>`);
                        });
                        
                        resolve();
                    },
                    error: function(error) {
                        console.error('Error cargando carreras:', error);
                        reject(error);
                    }
                });
            });
        }

        // === Cargar carreras en el filtro ===
        function cargarFiltroCarreras() {
            $.ajax({
                url: 'http://localhost:8080/carreras',
                type: 'GET', 
                dataType: 'json',
                success: function(res) {
                    const carreras = res.data || [];
                    const select = $('#filtro_carrera');
                    select.empty().append('<option value="">Todas las carreras</option>');
                    carreras.forEach(c => {
                        select.append(`<option value="${c.id}">${c.titulo}</option>`);
                        carrerasMap[c.id] = c.titulo;
                    });
                }
            });
        }

        // === Inicializar DataTable ===
        function inicializarDataTable() {
            dataTable = $('#tablaInscripciones').DataTable({
                ajax: {
                    url: 'http://localhost:8080/inscripciones',
                    type: 'GET',
                    dataType: 'json',
                    dataSrc: json => {
                        return json.data || [];
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'apellido' },
                    { data: 'email' },
                    { data: 'telefono' },
                    { data: 'dni' },
                    { 
                        data: 'fecha', 
                        render: d => d ? new Date(d).toLocaleDateString('es-AR') : 'N/A' 
                    },
                    { 
                        data: 'id_carrera', 
                        render: id => {
                            const nombreCarrera = carrerasMap[id] || `Carrera ${id}`;
                            return `<span class="badge bg-info">${nombreCarrera}</span>`;
                        }
                    },
                    {
                        data: 'activo',
                        render: d => d == 1
                            ? `<span class="badge bg-success">Activo</span>`
                            : `<span class="badge bg-danger">Inactivo</span>`
                    },
                    {
                        data: null,
                        render: r => `
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-warning" onclick="editarInscripcion(${r.id})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarInscripcion(${r.id})">
                                    <i class="bi bi-trash"></i>
                                </button>     
                            </div>`
                    }
                ],
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true
            });
        }

        const validators = {
            email: (val) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val),
            apellido: (val) => val.trim().length >= 5,
            dni: (val) => /^\d{7,9}$/.test(val),
            //address: (val) => val.trim().length >= 5,
            //city: (val) => val.trim().length >= 3,
            telefono: (val) => /^\d{8,}$/.test(val.replace(/\D/g, "")),
            //fecha: (val) => /^\d{2}\/\d{2}\/\d{4}$/.test(val) && isValidDate(val),
            id_carrera: (val) => val !== "",
            //terms: (checked) => checked === true,
        };

        function isValidDate(dateStr) {
            const [d, m, y] = dateStr.split("/").map(Number);
            const date = new Date(y, m - 1, d);
            return date.getFullYear() === y && date.getMonth() === m - 1 && date.getDate() === d;
        }

        // === Nueva Inscripción ===
        function nuevaInscripcion() {
            // Limpiar el formulario
            $('#formInscripcion')[0].reset();
            $('#inscripcion_id').val(''); // Vaciar el ID para indicar que es nuevo
            $('#activo').prop('checked', true); // Activar por defecto
            $('#fecha').val(new Date().toISOString().split('T')[0]); // Fecha actual
            
            // Cambiar el título del modal
            $('#modalInscripcionLabel').text('Nueva Inscripción');
            
            $('#modalInscripcion').modal('show');
        }

        // === Editar Inscripción ===
        function editarInscripcion(id) {
            $.getJSON(`http://localhost:8080/inscripciones/${id}`, res => {
                const data = res.data || res;
                //data = JSON.parse(data);
                $('#inscripcion_id').val(data.id);
                $('#nombre').val(data.nombre);
                $('#apellido').val(data.apellido);
                $('#email').val(data.email);
                $('#telefono').val(data.telefono);
                $('#dni').val(data.dni);
                $('#fecha').val(data.fecha);
                $('#id_carrera').val(data.id_carrera);
                $('#activo').prop('checked', data.activo == 1);

                // Cambiar título a edición
            $('#modalInscripcionLabel').text('Editar Inscripción');
            
            $('#modalInscripcion').modal('show');
            });
        }

        // === Actualizar texto del botón según crear/editar ===
        $('#modalInscripcion').on('show.bs.modal', function() {
            const id = $('#inscripcion_id').val();
            if (id) {
                $('#btnGuardarTexto').text('Actualizar');
            } else {
                $('#btnGuardarTexto').text('Crear');
            }
        });

        // === Guardar Inscripción (Crear o Actualizar) ===
        $('#formInscripcion').on('submit', function (e) {
            e.preventDefault();
            const id = $('#inscripcion_id').val();
            const data = {
                nombre: $('#nombre').val(),
                apellido: $('#apellido').val(),
                email: $('#email').val(),
                telefono: $('#telefono').val(),
                dni: $('#dni').val(),
                fecha: $('#fecha').val(),
                id_carrera: $('#id_carrera').val(),
                activo: $('#activo').is(':checked') ? 1 : 0
            };
            // Validaciones
            let isValid = true;
            Object.keys(validators).forEach((field) => {
            const input = document.getElementById(field);
            const error = document.getElementById(field + "Error");

            const value = field === "terms" ? input.checked : input.value;
            if (!validators[field](value)) {
                alert("Por favor, ingrese un valor válido para " + field);
                isValid = false;
            }
            });


            if (!isValid) {
                return; // Detener el envío si hay errores de validación
            }

            // Determinar si es crear o editar
            if (id) {
                // EDITAR - PUT
                $.ajax({
                    url: `http://localhost:8080/inscripciones/${id}`,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: res => {
                        Swal.fire('Éxito', 'Inscripción actualizada correctamente', 'success');
                        $('#modalInscripcion').modal('hide');
                        dataTable.ajax.reload();
                    },
                    error: (xhr) => {
                        Swal.fire('Error', 'No se pudo actualizar la inscripción', 'error');
                    }
                });
            } else {
                // CREAR - POST
                $.ajax({
                    url: 'http://localhost:8080/inscripciones',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: res => {
                        Swal.fire('Éxito', 'Inscripción creada correctamente', 'success');
                        $('#modalInscripcion').modal('hide');
                        dataTable.ajax.reload();
                    },
                    error: (xhr) => {
                        Swal.fire('Error', 'No se pudo crear la inscripción', 'error');
                    }
                });
            }
        });

        // Eliminar inscripcion
        function eliminarInscripcion(id) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción eliminará la inscripcion y todas sus relaciones",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `http://localhost:8080/inscripciones/${id}`,
                        type: 'DELETE',
                        contentType: 'application/json',
                        success: function(response) {                        
                            if(response.success !== false) {
                                Swal.fire('Eliminado', response.message || 'inscripcion eliminada correctamente', 'success');
                                dataTable.ajax.reload();
                            } else {
                                Swal.fire('Error', response.message || 'Error al eliminar', 'error');
                            }
                        },
                        error: function(xhr, error, thrown) {
                            console.error('Error al eliminar:', error);
                            Swal.fire('Error', 'Error al eliminar la inscripcion', 'error');
                        }
                    });
                }
            });
        }

        // === Evento de filtrado ===
        $('#filtro_carrera').on('change', function () {
            const idCarrera = $(this).val();
            
            if (idCarrera === "") {
                dataTable.ajax.url('http://localhost:8080/inscripciones').load();
            } else {
                const url = `http://localhost:8080/inscripciones/carrera/${idCarrera}`;
                dataTable.ajax.url(url).load();
            }
        });

    </script>
</body>
</html>
