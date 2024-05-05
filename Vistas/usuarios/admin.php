<!-- Modal editar usuarios -->
<div class="modal fade" id="editUser" tabindex="-1" aria-labelledby="editUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form action="/usuarios/guardar" method="POST">
                        <input type="hidden" id="UsId" name="UsId" value="">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" class="form-control" id="nombre" name="UsNombre">
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="UsApellidos">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="UsEmail">
                        </div>
                        <div class="mb-3">
                            <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="fechaNacimiento" name="UsFechaNacimiento">
                        </div>
                        <div class="mb-3">
                            <label for="clave" class="form-label">Clave:</label>
                            <input type="password" class="form-control" id="clave" name="UsPassword" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary" style="floaT:right;">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="col-12 d-flex justify-content-between">
        <h2>Administracion de usuarios</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarLibro">Agregar
            libro</button>
    </div>
    <table class="table" id="tablaLibros">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">UsNombre</th>
                <th scope="col">UsApellidos</th>
                <th scope="col">UsEmail</th>
                <th scope="col">UsFechaNacimiento</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($datos as $key): ?>
            <tr>
                <td><?=$key['UsId']?></td>
                <td><?=$key['UsNombre']?></td>
                <td><?=$key['UsApellidos']?></td>
                <td><?=$key['UsEmail']?></td>
                <td><?=$key['UsFechaNacimiento']?></td>
                <td class="d-flex">
                    <button type="button" class="btn btn-danger m-1"
                        onclick="eliminar(<?=$key['UsId']?>)">Eliminar</button>
                    <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#editUser"
                        onclick="editUser(<?=$key['UsId']?>)">Editar</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
    function editUser(id) {
            // Realizar la solicitud al servidor
            fetch(`${URL}/usuarios/buscar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: id
                    })
                }).then(response => {
                    console.log(response.json);
                    if (response.ok) {

                }).catch(error => {
                    // Manejo de errores de red o del servidor
                    console.error('Error', error);
                });

    }
    </script>