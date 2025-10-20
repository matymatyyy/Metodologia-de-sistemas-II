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
                                        <th>Descripción</th>
                                        <th>Texto</th>
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
                        <textarea class="form-control" id="contenido" name="contenido" rows="3" placeholder="Descripción breve de la noticia" required></textarea>
                        <small class="text-muted">Descripción corta que aparece en listados</small>
                    </div>

                    <div class="mb-3">
                        <label for="texto" class="form-label">Texto Completo de la Noticia <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="texto" name="texto" rows="8" placeholder="Contenido completo de la noticia" required></textarea>
                        <small class="text-muted">Texto completo del artículo</small>
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
    // Evitar conflictos usando namespace global para noticias
    window.NoticiasModule = (function() {
        'use strict';
        
        // Variables locales al módulo
        let tablaNoticias;
        let $btnGuardar, $spinner, $saveIcon, $imgActual;
        let isInitialized = false; // Flag para evitar doble inicialización
        
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
            try {
                // Configuración local para el lenguaje (evita problemas de CORS)
                const languageConfig = {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                };
                
                // Verificar que el elemento de la tabla existe
                if (!$('#tablaNoticias').length) {
                    console.error('Elemento #tablaNoticias no encontrado');
                    return;
                }
                
                tablaNoticias = $('#tablaNoticias').DataTable({
                    destroy: true, // Permite destruir y recrear automáticamente
                    ajax: {
                        url: '/news',
                        type: 'GET',
                        dataSrc: function(json) {
                            return json.success ? json.data : [];
                        },
                        error: function(xhr, error, thrown) {
                            console.error('Error al cargar datos:', error);
                            if (window.Swal) {
                                Swal.fire('Error', 'No se pudieron cargar las noticias', 'error');
                            } else {
                                alert('Error al cargar las noticias');
                            }
                        }
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'titulo', render: (data) => `<strong>${data}</strong>` },
                        { 
                            data: 'contenido', 
                            render: (data) => data.length > 50 ? data.substring(0, 50) + '...' : data
                        },
                        { 
                            data: 'texto', 
                            render: (data) => data.length > 60 ? data.substring(0, 60) + '...' : data
                        },
                        { data: 'fecha_publicacion' },
                        {
                            data: null,
                            render: () => '<span class="badge bg-success">Publicado</span>'
                        },
                        {
                            data: null,
                            orderable: false,
                            render: (data, type, row) => `
                                <div class="action-buttons">
                                    <button class="btn btn-sm btn-warning" onclick="window.NoticiasModule.editarNoticia(${row.id})" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="window.NoticiasModule.eliminarNoticia(${row.id})" title="Eliminar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>`
                        }
                    ],
                    language: languageConfig,
                    order: [[4, 'desc']], // Ordena por fecha_publicacion (ahora índice 4)
                    pageLength: 10,
                    responsive: true,
                    processing: true,
                    autoWidth: false,
                    serverSide: false,
                    deferRender: true
                });
                
                console.log('DataTable inicializado correctamente');
                
            } catch (error) {
                console.error('Error al inicializar DataTable:', error);
                if (window.Swal) {
                    Swal.fire('Error', 'Error al inicializar la tabla de noticias', 'error');
                }
            }
        }

        // Nueva Noticia
        function nuevaNoticia() {
            $('#formNoticia')[0].reset();
            $('#noticia_id').val('');
            $('#modalNoticiaLabel').text('Nueva Noticia');
            
            const today = new Date().toISOString().split('T')[0];
            $('#fecha_publicacion').val(today);
            
            $('#vista_previa_imagen').hide(); 
            $imgActual.attr('src', '');
            
            $('#modalNoticia').modal('show'); 
        }

        // Editar noticia
        function editarNoticia(id) {
            nuevaNoticia(); 
            $('#modalNoticiaLabel').text('Cargando Noticia...'); 
            
            $.ajax({
                url: `/news?id=${id}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if(response.success) {
                        const data = response.data;
                        $('#noticia_id').val(data.id);
                        $('#titulo').val(data.titulo);
                        $('#contenido').val(data.contenido);
                        $('#texto').val(data.texto);
                        $('#fecha_publicacion').val(data.fecha_publicacion);
                        $('#modalNoticiaLabel').text('Editar Noticia');

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

        // Guardar noticia
        function guardarNoticia() {
            setButtonLoading(true);

            const formData = new FormData($('#formNoticia')[0]);
            const id = $('#noticia_id').val();
            
            if (id) {
                formData.append('_method', 'PUT'); 
            }

            $.ajax({
                url: '/news',
                type: 'POST',
                data: formData,
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
                    console.error("AJAX Error:", status, error, xhr.responseText);
                    Swal.fire('Error', 'Ocurrió un error al guardar la noticia.', 'error');
                },
                complete: function() {
                    setButtonLoading(false);
                }
            });
        }

        // Eliminar noticia
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
                        url: `/news/${id}`,
                        type: 'DELETE',
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

        // Configurar event handlers
        function setupEventHandlers() {
            // Vista Previa de Imagen
            $('#imagen_destacada').off('change').on('change', function() {
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

            // Formulario de guardado
            $('#formNoticia').off('submit').on('submit', function(e) {
                e.preventDefault();
                guardarNoticia();
            });
        }
        
        // Función de inicialización principal
        function init() {
            if (isInitialized) {
                console.log('Módulo de noticias ya está inicializado, omitiendo...');
                return;
            }
            
            console.log('Inicializando módulo de noticias con librerías locales...');
            
            // Verificar que DataTables esté disponible
            if (!$ || !$.fn || !$.fn.DataTable) {
                console.error('DataTables no está disponible');
                setTimeout(init, 500);
                return;
            }
            
            // Inicializar elementos jQuery
            $btnGuardar = $('#btnGuardarNoticia');
            $spinner = $('#loadingSpinner');
            $saveIcon = $('#saveIcon');
            $imgActual = $('#img_actual');
            
            console.log('Elementos jQuery inicializados');
            
            // Destruir DataTable existente de forma muy segura
            try {
                const $table = $('#tablaNoticias');
                if ($table.length) {
                    // Verificar si ya es un DataTable usando la API
                    if ($.fn.DataTable.isDataTable('#tablaNoticias')) {
                        $table.DataTable().destroy();
                        console.log('DataTable anterior destruido');
                    }
                    // Limpiar clases CSS residuales
                    $table.removeClass('dataTable')
                           .removeClass('table-striped')
                           .removeClass('table-bordered')
                           .find('thead, tbody').off();
                    
                    // Limpiar el tbody por completo
                    $table.find('tbody').empty();
                }
            } catch (e) {
                console.warn('Error al destruir DataTable anterior:', e.message);
                // Si hay error, limpiar manualmente
                $('#tablaNoticias').empty().html(`
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Fecha Publicación</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                `);
            }
            
            inicializarDataTableNoticias();
            setButtonLoading(false);
            setupEventHandlers();
            
            isInitialized = true;
            console.log('Módulo de noticias inicializado correctamente');
        }
        
        // API pública del módulo
        return {
            init: init,
            nuevaNoticia: nuevaNoticia,
            editarNoticia: editarNoticia,
            eliminarNoticia: eliminarNoticia
        };
    })();

    // Inicializar cuando el DOM esté listo - ahora con librerías locales
    $(document).ready(function() {
        console.log('DOM listo, inicializando módulo de noticias...');
        // Con librerías locales, DataTables debería estar disponible inmediatamente
        setTimeout(function() {
            window.NoticiasModule.init();
        }, 300); // Pequeño delay para asegurar que todo esté cargado
    });
    
    // Exponer funciones globalmente para compatibilidad
    function nuevaNoticia() { window.NoticiasModule.nuevaNoticia(); }
    function editarNoticia(id) { window.NoticiasModule.editarNoticia(id); }
    function eliminarNoticia(id) { window.NoticiasModule.eliminarNoticia(id); }
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