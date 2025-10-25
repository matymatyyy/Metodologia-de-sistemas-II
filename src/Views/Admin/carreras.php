<!-- ======= Main Content - Carreras ======= -->
<main id="carreras" class="carreras">
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
                                        <th>Cupos</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- DataTables cargará los datos automáticamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Modal Carrera -->
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
                            <label for="duracion" class="form-label">Duración (Fecha de Finalización) <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="duracion" name="duracion" required>
                            <small class="text-muted">Ingrese la fecha estimada de finalización de la carrera</small>
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

<!-- falta hacer que sean locales las dependencias, los recursos estand descargados en el proyecto. -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let tablaCarreras;

    $(document).ready(function() {
        inicializarDataTable();
    });

    // Inicializar DataTable con AJAX
    function inicializarDataTable() {
        tablaCarreras = $('#tablaCarreras').DataTable({
            ajax: {
                url: 'http://localhost:8080/carreras', //falta hacer dinamico y carreras(crud) no anda al momento 25/10
                type: 'GET',
                dataSrc: function(json) {
                    if(json.success) {
                        return json.data;
                    }
                    console.error('Error en respuesta:', json);
                    return [];
                },
                error: function(xhr, error, thrown) {
                    console.error('Error al cargar datos:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudieron cargar las carreras'
                    });
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
                        const fechaDuracion = new Date(data);
                        const hoy = new Date();
                        const difAnios = Math.ceil((fechaDuracion - hoy) / (1000 * 60 * 60 * 24 * 365));
                        return difAnios > 0 ? difAnios + ' años' : 'Finalizada';
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
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
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
            url: 'http://localhost:8080/carreras?id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const data = response.data;
                    $('#carrera_id').val(data.id);
                    $('#titulo').val(data.titulo);
                    $('#duracion').val(data.duracion);
                    $('#cupos').val(data.cupos);
                    $('#activo').prop('checked', data.activo == 1);
                    $('#modalCarreraLabel').text('Editar Carrera');
                    
                    $('#modalCarrera').modal('show');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo cargar la carrera'
                    });
                }
            },
            error: function(xhr, error, thrown) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar los datos de la carrera'
                });
            }
        });
    }

    // Ver detalle de carrera
    function verDetalleCarrera(id) {
        $.ajax({
            url: 'http://localhost:8080/carreras?id=' + id,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const data = response.data;
                    const estado = data.activo == 1 ? 'Activo' : 'Inactivo';
                    
                    // Calcular duración
                    const fechaDuracion = new Date(data.duracion);
                    const hoy = new Date();
                    const difAnios = Math.ceil((fechaDuracion - hoy) / (1000 * 60 * 60 * 24 * 365));
                    const duracionTexto = difAnios > 0 ? difAnios + ' años' : 'Finalizada';
                    
                    Swal.fire({
                        title: 'Detalle de Carrera',
                        html: `
                            <div class="text-start">
                                <p><strong>ID:</strong> ${data.id}</p>
                                <p><strong>Título:</strong> ${data.titulo}</p>
                                <p><strong>Duración:</strong> ${duracionTexto}</p>
                                <p><strong>Fecha de Finalización:</strong> ${data.duracion}</p>
                                <p><strong>Cupos Disponibles:</strong> ${data.cupos}</p>
                                <p><strong>Estado:</strong> <span class="badge bg-${data.activo == 1 ? 'success' : 'danger'}">${estado}</span></p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        width: '500px'
                    });
                }
            },
            error: function(xhr, error, thrown) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cargar el detalle de la carrera'
                });
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
                    url: 'http://localhost:8080/carreras',
                    type: 'DELETE',
                    data: JSON.stringify({ id: id }),
                    contentType: 'application/json',
                    success: function(response) {
                        if(response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            tablaCarreras.ajax.reload(null, false); // Recargar sin reset de paginación
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr, error, thrown) {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error al eliminar la carrera'
                        });
                    }
                });
            }
        });
    }

    // Guardar carrera (crear o actualizar)
    $('#formCarrera').on('submit', function(e) {
        e.preventDefault();
        
        const id = $('#carrera_id').val();
        const formData = {
            id: id,
            titulo: $('#titulo').val(),
            duracion: $('#duracion').val(),
            cupos: $('#cupos').val(),
            activo: $('#activo').is(':checked') ? 1 : 0
        };

        const method = id ? 'PUT' : 'POST';
        
        $.ajax({
            url: 'http://localhost:8080/carreras',
            type: method,
            data: JSON.stringify(formData),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Éxito',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#modalCarrera').modal('hide');
                    tablaCarreras.ajax.reload(null, false); // Recargar DataTable sin reset
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message
                    });
                }
            },
            error: function(xhr, error, thrown) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al guardar la carrera'
                });
            }
        });
    });
</script>

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
    
    .card-title {
        margin-bottom: 0;
    }
    
    /* Estilos adicionales para DataTables */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        padding: 0.375rem 2.25rem 0.375rem 0.75rem;
    }
</style>
