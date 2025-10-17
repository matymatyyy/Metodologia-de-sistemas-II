<?php
/** @var User[] $users */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
</head>
<body>

<h2 style="text-align:center;">Listado de Usuarios</h2>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php for ($i = 0; $i < count($users); $i++): ?>
                <tr>
                    <td><?= $users[$i]->getId() ?> <a href="#editar">✏️ Editar</a><a href="#eliminar">🗑️ Eliminar</a> </td>
                    <td><?= $users[$i]->getNombre() ?> <a href="#editar">✏️ Editar</a><a href="#eliminar">🗑️ Eliminar</a> </td>
                    <td><?= $users[$i]->getEmail() ?> <a href="#editar">✏️ Editar</a><a href="#eliminar">🗑️ Eliminar</a> </td>
                </tr>
            <?php endfor; ?>
        <?php else: ?>
            <tr><td colspan="3">No hay datos disponibles</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>