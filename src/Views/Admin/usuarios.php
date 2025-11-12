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
            <h1>Gestión de Usuarios</h1>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="card-title">Listado de Usuarios</h5>
                                <button class="btn btn-primary" onclick="nuevoUsuario()">
                                <i class="bi bi-plus-circle"></i> Nuevo Usuario
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="tablaUsuarios" class="table table-striped table-hover" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Email</th>
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

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-labelledby="modalUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formUsuario">
                    <div class="modal-body">
                        <input type="hidden" id="usuario_id" name="id">

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                             <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="repeat-password" class="form-label">Repetir contraseña</label>
                                <input type="password" class="form-control" id="repeat-password" name="repeat-password">
                            </div>
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
        let dataTable;

        $(document).ready(function () {
            inicializarDataTable();
        });

        // === Inicializar DataTable ===
        function inicializarDataTable() {
            dataTable = $('#tablaUsuarios').DataTable({
                ajax: {
                    url: 'http://localhost:8080/usuarios',
                    type: 'GET',
                    dataType: 'json',
                    dataSrc: json => {
                        return json.data || [];
                    }
                },
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    {
                        data: null,
                        render: r => `
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-warning" onclick="editarUsuario(${r.id})">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!--<button class="btn btn-sm btn-danger" onclick="eliminarUsuario(${r.id})">
                                    <i class="bi bi-trash"></i>-->
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
        nombre: (val) => val.trim().length >= 3,
        password: (val) => /^(?=.*[A-Z]).{8,}$/.test(val), // 8 caracteres y 1 mayúscula
        };

        // === Nueva Inscripción ===
        function nuevoUsuario() {
        $('#formUsuario')[0].reset();
        $('#usuario_id').val('');
        $('#password').val('');
        $('#repeat-password').val('');
        $('#activo').prop('checked', true);
        $('#modalUsuarioLabel').text('Nuevo usuario');
        $('#modalUsuario').modal('show');
        }

        // === Editar Usuario ===
        function editarUsuario(id) {
        $.getJSON(`http://localhost:8080/usuarios/${id}`, (res) => {
            const data = res.data || res;
            $('#usuario_id').val(data.id);
            $('#nombre').val(data.name);
            $('#password').val('');
            $('#repeat-password').val('');
            $('#email').val(data.email).prop('disabled', true); //Deshabilitar email
            $('#modalUsuarioLabel').text('Editar Usuario');
            $('#modalUsuario').modal('show');
        });
        }

        // === Cambiar texto del botón según acción ===
        $('#modalUsuario').on('show.bs.modal', function () {
        const id = $('#usuario_id').val();
        $('#btnGuardarTexto').text(id ? 'Actualizar' : 'Crear');
        });

        // === Función para hashear contraseña (SHA-256) ===
        async function hashPassword(password) {
        const encoder = new TextEncoder();
        const data = encoder.encode(password);
        const hashBuffer = await crypto.subtle.digest('SHA-256', data);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map((b) => b.toString(16).padStart(2, '0')).join('');
        }

        // === Guardar Usuario ===
        $('#formUsuario').on('submit', async function (e) {
        e.preventDefault();

        const id = $('#usuario_id').val();
        const name = $('#nombre').val().trim();
        const email = $('#email').val().trim();
        const password = $('#password').val();
        const repeatPassword = $('#repeat-password').val();

        // === Validaciones básicas ===
        if (!validators.nombre(name)) {
            Swal.fire('Error', 'El nombre debe tener al menos 3 caracteres.', 'warning');
            return;
        }

        if (!validators.email(email)) {
            Swal.fire('Error', 'El email no tiene un formato válido.', 'warning');
            return;
        }

        // === Validaciones de contraseña ===
        if (!id) {
            // Si es creación
            if (!validators.password(password)) {
            Swal.fire(
                'Error',
                'La contraseña debe tener al menos 8 caracteres y una letra mayúscula.',
                'warning'
            );
            return;
            }
            if (password !== repeatPassword) {
            Swal.fire('Error', 'Las contraseñas no coinciden.', 'warning');
            return;
            }
        } else {
            // Si está editando
            if (password || repeatPassword) {
            // Solo validar si escribió algo
            if (!validators.password(password)) {
                Swal.fire(
                'Error',
                'La contraseña debe tener al menos 8 caracteres y una letra mayúscula.',
                'warning'
                );
                return;
            }
            if (password !== repeatPassword) {
                Swal.fire('Error', 'Las contraseñas no coinciden.', 'warning');
                return;
            }
            }
        }

        // === Construcción del objeto a enviar ===
        const data = { name, email };
        if (password) {
            data.password = await hashPassword(password); // solo si se escribió
        }

        const btn = $('#formUsuario button[type="submit"]');
        btn.prop('disabled', true);

        const url = id
            ? `http://localhost:8080/usuarios/${id}`
            : 'http://localhost:8080/usuarios';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url,
            type: method,
            contentType: 'application/json',
            data: JSON.stringify(data),
            success: (res) => {
            Swal.fire(
                'Éxito',
                id ? 'Usuario actualizado correctamente' : 'Usuario creado correctamente',
                'success'
            );
            $('#modalUsuario').modal('hide');
            dataTable.ajax.reload();
            },
            error: () => {
            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
            },
            complete: () => {
            btn.prop('disabled', false);
            },
        });
        });

        // Eliminar inscripcion
        function eliminarUsuario(id) {
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

    </script>
</body>
</html>
