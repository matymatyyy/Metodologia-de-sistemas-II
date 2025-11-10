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
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'src/Views/Admin/Includes/footer.php'; ?>

    <script>
        $(document).ready(function () {
            inicializarDataTable();
            cargarCarreras();
        });

        // === Cargar carreras en el select ===
        function cargarCarreras() {
            $.get('http://localhost:8080/carreras', function (res) {
                const carreras = res.data || [];
                const select = $('#id_carrera');
                select.empty().append('<option value="">Seleccione una carrera</option>');
                carreras.forEach(c => {
                    select.append(`<option value="${c.id}">${c.titulo}</option>`);
                });
            });
        }

        // === Inicializar DataTable ===
        function inicializarDataTable() {
            $('#tablaInscripciones').DataTable({
                ajax: {
                    url: 'http://localhost:8080/inscripciones',
                    type: 'GET',
                    dataSrc: json => json.data || [],
                    error: xhr => {
                        Swal.fire('Error', 'No se pudieron cargar las inscripciones', 'error');
                        console.error(xhr.responseText);
                    }
                },
                columns: [
                    { data: 'id' },
                    { data: 'nombre' },
                    { data: 'apellido' },
                    { data: 'email' },
                    { data: 'telefono' },
                    { data: 'dni' },
                    { data: 'fecha', render: d => d ? new Date(d).toLocaleDateString('es-AR') : 'N/A' },
                    { data: 'id_carrera', render: id => `<span class="badge bg-info">${id}</span>` },
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
                            </div>`
                    }
                ],
                // language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
                pageLength: 10,
                order: [[0, 'desc']],
                responsive: true
            });
        }

        // === Editar inscripción ===
        function editarInscripcion(id) {
            $.get(`http://localhost:8080/inscripciones/${id}`, res => {
                const data = res.data || res;
                $('#inscripcion_id').val(data.id);
                $('#nombre').val(data.nombre);
                $('#apellido').val(data.apellido);
                $('#email').val(data.email);
                $('#telefono').val(data.telefono);
                $('#dni').val(data.dni);
                $('#fecha').val(data.fecha);
                $('#id_carrera').val(data.id_carrera);
                $('#activo').prop('checked', data.activo == 1);
                $('#modalInscripcion').modal('show');
            });
        }

        // === Guardar inscripción (solo editar) ===
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

            $.ajax({
                url: `http://localhost:8080/inscripciones/${id}`,
                type: 'PUT',
                data,
                success: res => {
                    Swal.fire('Éxito', 'Inscripción actualizada correctamente', 'success');
                    $('#modalInscripcion').modal('hide');
                    $('#tablaInscripciones').DataTable().ajax.reload();
                },
                error: () => Swal.fire('Error', 'No se pudo actualizar la inscripción', 'error')
            });
        });
    </script>
</body>
</html>
