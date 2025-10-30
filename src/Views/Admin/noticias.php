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
                           <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNoticia">Nueva Noticia</button>
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
                                        <th>Imagen</th>
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
                        <label for="titulo" class="form-label">Título de la Noticia <span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="titulo" name="title" placeholder="Ej: Avance tecnológico en IA" required>
                    </div>

                    <div class="mb-3">
                        <label for="contenido" class="form-label">Descripción de la Noticia <span class="text-danger"></span></label>
                        <textarea class="form-control" id="contenido" name="description" rows="3" placeholder="Descripción breve de la noticia" required></textarea>
                        <small class="text-muted">Descripción breve</small>
                    </div>

                    <div class="mb-3">
                        <label for="texto" class="form-label">Texto Completo de la Noticia <span class="text-danger"></span></label>
                        <textarea class="form-control" id="texto" name="text" rows="8" placeholder="Contenido completo de la noticia" required></textarea>
           
                    </div>

                    <div class="mb-3">
                        <label for="fecha_publicacion" class="form-label">Fecha de Publicación <span class="text-danger"></span></label>
                        <input type="date" class="form-control" id="fecha_publicacion" name="publicationDate" required>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen</label>
                        <input class="form-control" type="file" id="imagen" name="image" accept=".png, .jpg, .jpeg">
                        <small class="text-muted">Sube una imagen para la noticia</small>
                        
                        <div id="vista_previa_imagen" class="mt-2" style="max-width: 150px; display: none;">
                            
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
