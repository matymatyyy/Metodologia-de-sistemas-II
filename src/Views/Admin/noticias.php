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
                            <h5 class="card-title">Listado de Noticias / Artículos</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" onclick="nuevaNoticia()">
                                <i class="bi bi-plus-circle"></i> Nueva Noticia
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table id="tablaNoticias" class="table table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th>Fecha Publicación</th>
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

<div class="modal fade" id="modalNoticia" tabindex="-1" aria-labelledby="modalNoticiaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNoticiaLabel">Nueva Noticia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formNoticia" enctype="multipart/form-data"> 
                <div class="modal-body">
                    <input type="hidden" id="noticia_id" name="id">
                    
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título de la Noticia <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Ej: Avance tecnológico en IA" required>
                    </div>

                    <div class="mb-3">
                        <label for="contenido" class="form-label">Descripción de la Noticia <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="contenido" name="contenido" rows="5" placeholder="Descripción de la noticia" required></textarea>
                        <small class="text-muted"></small>
                    </div>

                    <div class="mb-3">
                        <label for="fecha_publicacion" class="form-label">Fecha de Publicación <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="fecha_publicacion" name="fecha_publicacion" required>
                    </div>

                    <div class="mb-3">
                        <label for="imagen_destacada" class="form-label">Imagen Destacada (PNG, JPG)</label>
                        <input class="form-control" type="file" id="imagen_destacada" name="imagen_destacada" accept=".png, .jpg, .jpeg">
                        <small class="text-muted">Sube una imagen para la noticia. Deja vacío para mantener la actual.</small>
                        
                        <div id="vista_previa_imagen" class="mt-2" style="max-width: 150px; display: none;">
                            <strong>Actual/Nueva:</strong>
                            <img id="img_actual" src="" class="img-fluid border" alt="Imagen actual" style="max-height: 100px;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="publicado" class="form-label">Estado de la Noticia <span class="text-danger">*</span></label>
                        <select class="form-select" id="publicado" name="publicado" required>
                            <option value="0">Inactivo (Borrador)</option>
                            <option value="1">Activo (Publicado)</option>
                        </select>
                        <small class="text-muted">Selecciona "Activo" para publicar o "Inactivo" para guardar como borrador.</small>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCancelar">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarNoticia">
                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true" id="loadingSpinner" style="display: none;"></span>
                        <i class="bi bi-save" id="saveIcon"></i> 
                        Guardar Noticia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let tablaNoticias;
    const $btnGuardar = $('#btnGuardarNoticia');
    const $spinner = $('#loadingSpinner');
    const $saveIcon = $('#saveIcon');
    const $imgActual = $('#img_actual'); 

    $(document).ready(function() {
        inicializarDataTableNoticias();
        setButtonLoading(false); 
    });

    // Control de estado del botón de carga
    function setButtonLoading(isLoading) {
        if (isLoading) {
            $btnGuardar.attr('disabled', true);
            $saveIcon.hide();
            $spinner.show();
            $btnGuardar.contents().last().replaceWith(' Cargando...'); 
        } else {
            $btnGuardar.attr('disabled', false);
            $spinner.hide();
            $saveIcon.show();
            $btnGuardar.contents().last().replaceWith(' Guardar Noticia'); 
        }
    }

    // Inicializar DataTable 
    function inicializarDataTableNoticias() {
        tablaNoticias = $('#tablaNoticias').DataTable({
            ajax: {
                url: 'api/noticias.php', // <--- TU ENDPOINT DE LECTURA
                type: 'GET',
                dataSrc: function(json) {
                    return json.success ? json.data : [];
                },
                error: function(xhr, error, thrown) {
                    console.error('Error al cargar datos:', error);
                    Swal.fire('Error', 'No se pudieron cargar las noticias', 'error');
                }
            },
            columns: [
                { data: 'id' },
                { data: 'titulo', render: (data) => `<strong>${data}</strong>` },
                { data: 'fecha_publicacion' },
                { 
                    data: 'publicado', 
                    render: (data) => data == 1 ? 
                        '<span class="badge bg-success">Activo (Publicado)</span>' : 
                        '<span class="badge bg-warning text-dark">Inactivo (Borrador)</span>'
                },
                {
                    data: null,
                    orderable: false,
                    render: (data, type, row) => `
                        <div class="action-buttons">
                            <button class="btn btn-sm btn-warning" onclick="editarNoticia(${row.id})" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="eliminarNoticia(${row.id})" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>`
                }
            ],
            language: { url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' },
            order: [[2, 'desc']], // Ordena por la columna de fecha (índice 2)
            pageLength: 10,
            responsive: true,
            processing: true
        });
    }

    // Nueva Noticia (Función de inicialización)
    function nuevaNoticia() {
        $('#formNoticia')[0].reset();
        $('#noticia_id').val('');
        $('#modalNoticiaLabel').text('Nueva Noticia');
        $('#publicado').val('0'); // Inactivo por defecto
        
        // Establecer la fecha actual por defecto
        const today = new Date().toISOString().split('T')[0];
        $('#fecha_publicacion').val(today);
        
        // Ocultar y limpiar la vista previa de imagen
        $('#vista_previa_imagen').hide(); 
        $imgActual.attr('src', '');
        
        $('#modalNoticia').modal('show'); 
    }

    // Editar noticia
    function editarNoticia(id) {
        nuevaNoticia(); 
        $('#modalNoticiaLabel').text('Cargando Noticia...'); 
        
        $.ajax({
            url: `api/noticias.php?id=${id}`, // <--- TU ENDPOINT DE LECTURA POR ID
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if(response.success) {
                    const data = response.data;
                    $('#noticia_id').val(data.id);
                    $('#titulo').val(data.titulo);
                    $('#contenido').val(data.contenido); 
                    $('#fecha_publicacion').val(data.fecha_publicacion);
                    
                    // Cargar el valor del SELECT (0 o 1)
                    $('#publicado').val(data.publicado.toString()); 
                    
                    $('#modalNoticiaLabel').text('Editar Noticia');

                    // Mostrar imagen actual si existe 
                    if (data.imagen_url) {
                         $imgActual.attr('src', data.imagen_url); 
                         $('#vista_previa_imagen').show();
                    }
                    $('#modalNoticia').modal('show');
                } else {
                    Swal.fire('Error', 'No se pudo cargar la noticia', 'error');
                }
            }
        });
    }

    // Vista Previa de Imagen
    $('#imagen_destacada').on('change', function() {
        const [file] = this.files;
        if (file) {
            $imgActual.attr('src', URL.createObjectURL(file));
            $('#vista_previa_imagen').show();
        } else {
            if (!$('#noticia_id').val() || !$imgActual.attr('src')) {
                $('#vista_previa_imagen').hide();
            }
        }
    });

    // Guardar noticia (Crear o actualizar) - LÓGICA DE ENVÍO DE ARCHIVOS
    $('#formNoticia').on('submit', function(e) {
        e.preventDefault();
        
        // 1. Mostrar estado de carga (spinner)
        setButtonLoading(true);

        const formData = new FormData(this);
        const id = $('#noticia_id').val();
        
        // Simular el método PUT si estamos editando
        if (id) {
            formData.append('_method', 'PUT'); 
        }

        $.ajax({
            url: 'api/noticias.php', // <--- TU ENDPOINT DE PROCESAMIENTO
            type: 'POST', // DEBE ser POST
            data: formData, 
            
            // ¡VITALES para la subida de archivos!
            processData: false, 
            contentType: false, 
            
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
                    tablaNoticias.ajax.reload(null, false);
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            },
            error: function(xhr, status, error) {
                // Mensaje detallado si la API no devuelve JSON válido o hay un error 500
                console.error("AJAX Error:", status, error, xhr.responseText);
                Swal.fire('Error', 'Ocurrió un error al guardar la noticia. Por favor, verifica tu script PHP.', 'error');
            },
            // 2. Ocultar estado de carga (spinner) al finalizar
            complete: function() {
                setButtonLoading(false);
            }
        });
    });

    // Eliminar noticia (mantenido)
    function eliminarNoticia(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción eliminará la noticia de forma permanente.",
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
                            tablaNoticias.ajax.reload(null, false);
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
    
    #btnGuardarNoticia {
        min-width: 150px; 
    }
</style>