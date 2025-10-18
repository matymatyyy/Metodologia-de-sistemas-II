<!-- ======= Main Content - Carreras ======= -->
<main id="noticias" class="noticias">
    <div class="pagetitle">
        <h1>Gestión de Noticias</h1>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title">Listado de Noticias</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNoticia" onclick="nuevaNoticia()">
                                <i class="bi bi-plus-circle"></i> Nueva Noticia
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="tablaNoticias" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Descripcion</th>
                                        <th>Fecha</th>
                                        <th>Imagen</th>
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

<!-- Modal Noticias-->
<div class="modal fade" id="modalNoticia" tabindex="-1" aria-labelledby="modalNoticiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNoticiaLabel">Nueva Noticia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <form id="formNoticia">
                <div class="modal-body">
                    <input type="hidden" id="noticia_id" name="id">
                    //titulo de la noticia 
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la noticia <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Lanzamiento de nuevas carreras" required>
                    </div>
                    //descipcion de la noticia 
                     <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción de la noticia <span class="text-danger"></span></label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Detalle de la noticia" required></textarea>
                    </div>

                       //fecha de la noticia
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha" class="form-label">Fecha de la noticia<span class="text-danger"></span></label>
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
                            <small class="text-muted">Ingrese la fecha estimada de finalización de la carrera</small>
                        </div>

                        //imagen de la noticia 
                        <div class="col-md-6 mb-3">
                            <label for="imagen" class="form-label">Imagen de la noticia</label>
                            <input type="text" class="form-control" id="imagen" name="imagen" placeholder="noticia1.jpg" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="activo" name="activo" checked>
                            <label class="form-check-label" for="activo">
                                Estado Activo
                                <small class="text-muted d-block">Las noticias inactivas no se mostraran publicamenten</small>
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

<!-- Script para Noticias con DataTables -->
<script>
    let tablaNoticias;

    $(document).ready(function() {
        inicializarDataTable();
    });

    // Inicializar DataTable con AJAX
    function inicializarDataTable() {
        tablaNoticias = $('#tablaNoticias').DataTable({
            ajax: {
                url: 'api/noticias.php',
                type: 'GET',
                dataSrc: function(json) {
                    if(json.success) {
                        return json.data;
                    }
                    return [];
                },
                error: function(xhr, error, thrown) {
                    console.error('Error al cargar las noticias:', error);
                    Swal.fire('Error', 'No se pudieron cargar las noticias', 'error');
                }
        },
            columns: [
                { data: 'id' },
                { data: 'titulo'},
                { data: 'descripcion'},

                { data: 'fecha',
                    render: function(data, type, row) {
                        return '<strong>' + data + '</strong>';
                    }
                },
                { 
                    data: 'imagen',
                    render: function(data) {
                        return `<img src="{data}" alt="imagen" width="60" height="60" style="object-fit: conver; border-radius: 8px;">`;
                    }
                }
                },

                { 
                    data: 'activo',
                    render: function(data) {
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
                                <button class="btn btn-sm btn-info" onclick="verDetalleNoticia(${row.id})" title="Ver">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-warning" onclick="editarNoticia(${row.id})" title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarNoticia(${row.id})" title="Eliminar">
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
        });

    // Nueva noticia 
    function nuevaNoticia
        $('#formNoticia')[0].reset();
        $('#noticia_id').val('');
        $('#modalNoticiaLabel').text('Nueva Noticia');
        $('#activo').prop('checked', true);
    }

    // Editar carrera
    function editarNoticia(id) {
        $.ajax({
            url: `api/noticias.php?id=${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const data = response.data;
                    $('#noticia_id').val(data.id);
                    $('#titulo').val(data.titulo);
                    $('#fecha').val(data.fecha);
                    $('#imagen').val(data.imagen);
                    $('#activo').prop('checked', data.activo == 1);
                    $('#modalNoticiaLabel').text('Editar Noticia');
                    
                    $('#modalNoticia').modal('show');
                } else {
                    Swal.fire('Error', 'No se pudo cargar la noticia', 'error');
                }
            }
        });
    }

    // Ver detalle de noticia
    function verDetalleNoticia(id) {
        $.ajax({
            url: `api/noticias.php?id=${id}`,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const data = response.data;
                    const estado = data.activo == 1 ? 'Activo' : 'Inactivo';
                    
                    
                    Swal.fire({
                        title: 'Detalle de Noticia',
                        html: `
                            <div class="text-start">
                                <p><strong>ID:</strong> ${data.id}</p>
                                <p><strong>Título:</strong> ${data.titulo}</p>
                                <p><strong>Descripción:</strong> ${data.descripcion}</p>
                                <p><strong>Fecha de creacion:</strong> ${data.fecha_de_creacion}</p>
                                <p><strong>Imagen:</strong> ${data.imagen}</p>
                                <p><strong>Estado:</strong> <span class="badge bg-${data.activo == 1 ? 'success' : 'danger'}">${estado}</span></p>
                            </div>
                        `,
                        icon: 'info',
                        confirmButtonText: 'Cerrar',
                        width: '500px'
                    });
                }
            }
        });
    }

    // Eliminar noticia
    function eliminarNoticia(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará la noticia permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'api/noticias.php',
                    type: 'DELETE',
                    data: JSON.stringify({ id: id }),
                    contentType: 'application/json',
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Eliminado', response.message, 'success');
                            tablaNoticias.ajax.reload(null, false); // Recargar sin reset de paginación
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Error al eliminar la noticia', 'error');
                    }
                });
            }
        });
    }

    // Guardar carrera (crear o actualizar)
    $('#formNoticia').on('submit', function(e) {
        e.preventDefault();
        
        const id = $('#noticia_id').val();
        const formData = {
            id: id,
            titulo: $('#titulo').val(),
            descripcion: $('#descripcion').val(),
            fecha: $('#fecha').val(),
            activo: $('#activo').is(':checked') ? 1 : 0
        };

        const method = id ? 'PUT' : 'POST';
        
        $.ajax({
            url: 'api/noticias.php',
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
                    $('#modalNoticia').modal('hide');
                    tablaNoticias.ajax.reload(null, false); // Recargar DataTable sin reset
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error', 'Ocurrió un error al guardar la noticia', 'error');
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
</style>