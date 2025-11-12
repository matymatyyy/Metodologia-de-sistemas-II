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

    <!-- ======= Main Content - Carreras ======= -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Gestión de Carreras</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title">Listado de Carreras</h5>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCarrera" onclick="nuevaCarrera()">
                                    <i class="bi bi-plus-circle"></i> Nueva Carrera
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="tablaCarreras" class="table table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Título</th>
                                            <th>Duración</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Cupos</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="modalCarrera" tabindex="-1" aria-labelledby="modalCarreraLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCarreraLabel">Nueva Carrera</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formCarrera">
                    <div class="modal-body">
                        <input type="hidden" id="carrera_id" name="id">
                        
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título de la Carrera <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Ingeniería en Sistemas" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">Fecha de Inicio <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">Fecha de Finalización <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="duracion" class="form-label">Duración <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="duracion" name="duracion" placeholder="Ej: 8 meses" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cupos" class="form-label">Cupos Disponibles <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="cupos" name="cupos" min="1" placeholder="Ej: 50" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                                <label class="form-check-label" for="activo">
                                    Estado Activo
                                    <small class="text-muted d-block">Las carreras inactivas no estarán disponibles para inscripción</small>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include_once 'src/Views/Admin/Includes/footer.php'; ?>

    <script>
        let dataTable;

        $(document).ready(function() {
            inicializarDataTable();
        });

        function inicializarDataTable() {
            dataTable = $('#tablaCarreras').DataTable({
                ajax: {
                    url: 'http://localhost:8080/carreras',
                    type: 'GET',
                    cache: true,
                    dataSrc: function(json) {
                        console.log('Datos recibidos:', json);
                        if(json.data) {
                            return json.data;
                        }
                        return [];
                    },
                    error: function(xhr, error, thrown) {
                        console.error('Error al cargar datos:', error);
                        console.error('XHR:', xhr);
                        Swal.fire('Error', 'No se pudieron cargar las carreras: ' + error, 'error');
                    }
                },
                columns: [
                    { data: 'id' },
                    { 
                        data: 'titulo',
                        render: function(data, type, row) {
                            return '<strong>' + data + '</strong>';
                        }
                    },
                    { 
                        data: 'duracion',
                        render: function(data, type, row) {
                            return data || 'N/A';
                        }
                    },
                    { 
                        data: 'fecha_inicio',
                        render: function(data, type, row) {
                            if(!data) return 'N/A';
                            const partes = data.split('-');
                            if (partes.length === 3) {
                                return `${partes[2]}/${partes[1]}/${partes[0]}`;
                            }
                            return data;
                        }
                    },
                    { 
                        data: 'fecha_fin',
                        render: function(data, type, row) {
                            if (!data) return 'N/A';
                            const partes = data.split('-');
                            if (partes.length === 3) {
                                return `${partes[2]}/${partes[1]}/${partes[0]}`;
                            }
                            return data;
                        }
                    },
                    { 
                        data: 'cupos',
                        render: function(data, type, row) {
                            return '<span class="badge bg-info text-dark"><i class="bi bi-people-fill"></i> ' + data + ' cupos</span>';
                        }
                    },
                    { 
                        data: 'activo',
                        render: function(data, type, row) {
                            return data == 1 ? 
                                '<span class="badge bg-success">Activo</span>' : 
                                '<span class="badge bg-danger">Inactivo</span>';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-info" onclick="verDetalleCarrera(${row.id})" title="Ver">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" onclick="editarCarrera(${row.id})" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="eliminarCarrera(${row.id})" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                // language: {
                //     url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                // },
                order: [[0, 'desc']],
                pageLength: 10,
                responsive: true,
                processing: true,
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rtip'
            });
        }

        // Nueva carrera
        function nuevaCarrera() {
            $('#formCarrera')[0].reset();
            $('#carrera_id').val('');
            $('#modalCarreraLabel').text('Nueva Carrera');
            $('#activo').prop('checked', true);
        }

        // Editar carrera
        function editarCarrera(id) {
            $.ajax({
                url: `http://localhost:8080/carreras/${id}`,
                type: 'GET',
                dataType: 'json',
                cache: true,
                success: function(response) {
                    console.log('Respuesta editar:', response);
                    
                    // Adaptado para diferentes formatos de respuesta
                    const data = response.data || response;
                    
                    $('#carrera_id').val(data.id);
                    $('#titulo').val(data.titulo);
                    $('#duracion').val(data.duracion);
                    $('#fecha_inicio').val(data.fecha_inicio);
                    $('#fecha_fin').val(data.fecha_fin);
                    $('#cupos').val(data.cupos);
                    $('#activo').prop('checked', data.activo == 1);
                    $('#modalCarreraLabel').text('Editar Carrera');
                    
                    $('#modalCarrera').modal('show');
                },
                error: function(xhr, error, thrown) {
                    console.error('Error al cargar carrera:', error);
                    Swal.fire('Error', 'No se pudo cargar la carrera', 'error');
                }
            });
        }

        // Ver detalle de carrera
        function verDetalleCarrera(id) {
            $.ajax({
                url: `http://localhost:8080/carreras/${id}`,
                type: 'GET',
                dataType: 'json',
                cache: true,
                success: function(response) {
                    const data = response.data || response;
                    const estado = data.activo == 1 ? 'Activo' : 'Inactivo';
                    
                    // Formatear fechas
                    const fechaInicio = data.fecha_inicio ? new Date(data.fecha_inicio).toLocaleDateString('es-AR') : 'N/A';
                    const fechaFin = data.fecha_fin ? new Date(data.fecha_fin).toLocaleDateString('es-AR') : 'N/A';
                    
                    Swal.fire({
                        title: 'Detalle de Carrera',
                        html: `
                            <div class="text-start">
                                <p><strong>ID:</strong> ${data.id}</p>
                                <p><strong>Título:</strong> ${data.titulo}</p>
                                <p><strong>Duración:</strong> ${data.duracion}</p>
                                <p><strong>Fecha de Inicio:</strong> ${fechaInicio}</p>
                                <p><strong>Fecha de Finalización:</strong> ${fechaFin}</p>
                                <p><strong>Cupos Disponibles:</strong> ${data.cupos}</p>
                                <p><strong>Estado:</strong> <span class="badge bg-${data.activo == 1 ? 'success' : 'danger'}">${estado}</span></p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        width: '500px'
                    });
                },
                error: function(xhr, error, thrown) {
                    console.error('Error al cargar detalle:', error);
                    Swal.fire('Error', 'No se pudo cargar el detalle de la carrera', 'error');
                }
            });
        }

        // Eliminar carrera
        function eliminarCarrera(id) {
            Swal.fire({
                title: '¿Está seguro?',
                text: "Esta acción eliminará la carrera y todas sus relaciones",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `http://localhost:8080/carreras/${id}`,
                        type: 'DELETE',
                        contentType: 'application/json',
                        success: function(response) {
                            console.log('Respuesta eliminar:', response);
                            
                            if(response.success !== false) {
                                Swal.fire('Eliminado', response.message || 'Carrera eliminada correctamente', 'success');
                                dataTable.ajax.reload(null, false);
                            } else {
                                Swal.fire('Error', response.message || 'Error al eliminar', 'error');
                            }
                        },
                        error: function(xhr, error, thrown) {
                            console.error('Error al eliminar:', error);
                            Swal.fire('Error', 'Error al eliminar la carrera', 'error');
                        }
                    });
                }
            });
        }

        // === Guardar Inscripción (Crear o Actualizar) ===
        $('#formCarrera').on('submit', function (e) {
            e.preventDefault();
            const id = $('#carrera_id').val();
            const data = {
                titulo: $('#titulo').val(),
                duracion: $('#duracion').val(),
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_fin: $('#fecha_fin').val(),
                cupos: $('#cupos').val(),
                activo: $('#activo').is(':checked') ? 1 : 0
            };
            // // Validaciones
            // let isValid = true;
            // Object.keys(validators).forEach((field) => {
            // const input = document.getElementById(field);
            // const error = document.getElementById(field + "Error");

            // const value = field === "terms" ? input.checked : input.value;
            // if (!validators[field](value)) {
            //     alert("Por favor, ingrese un valor válido para " + field);
            //     isValid = false;
            // }
            // });


            // if (!isValid) {
            //     return; // Detener el envío si hay errores de validación
            // }

            // Determinar si es crear o editar
            if (id) {
                // EDITAR - PUT
                $.ajax({
                    url: `http://localhost:8080/carreras/${id}`,
                    type: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: res => {
                        Swal.fire('Éxito', 'carrera actualizada correctamente', 'success');
                        $('#modalCarrera').modal('hide');
                        dataTable.ajax.reload();
                    },
                    error: (xhr) => {
                        Swal.fire('Error', 'No se pudo actualizar la carrera', 'error');
                    }
                });
            } else {
                // CREAR - POST
                $.ajax({
                    url: 'http://localhost:8080/carreras',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: res => {
                        Swal.fire('Éxito', 'carrera creada correctamente', 'success');
                        $('#modalCarrera').modal('hide');
                        dataTable.ajax.reload();
                    },
                    error: (xhr) => {
                        Swal.fire('Error', 'No se pudo crear la carrera', 'error');
                    }
                });
            }
        });
    </script>

</body>
</html>
