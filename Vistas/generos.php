<!-- Modal Agregar genero -->
<div class="modal fade" id="agregarGenero" tabindex="-1" aria-labelledby="agregarGenero" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar un nuevo genero</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method='POST' action='/generos/registrar' id="formGeneros">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="Gnombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="Gnombre" name='Gnombre'
                                    aria-describedby="Escriba el nombre del genero" placeholder='Nombre del genero'
                                    required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Editar generos -->
<div class="modal fade" id="editarGenero" tabindex="-1" aria-labelledby="editarGenero" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar genero</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method='POST' action='/generos/editar' id="eformGenero">
                        <input type="hidden" name="id" id="id_genero" hidden value="">
                        <div class="row d-flex justify-content-evenly">
                            <div class="col-md-12">
                                <label for="Gnombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="Gnombre" name='Gnombre'
                                    aria-describedby="Escriba el nombre del genero" placeholder='Nombre del genero'
                                    required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="col-12 d-flex justify-content-between">
        <h2>Buscando</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarGenero">Agregar genero</button>
    </div>
    <br>
    <table class="table text-center" id="tablaLibros">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($datos[200])): foreach ($datos[200] as $genero):?>
            <tr>
                <td><?=$genero['id_genero']?></td>
                <td><?=$genero['Gnombre']?></td>
                <td class="d-flex justify-content-center">
                    <button type="button" class="btn btn-danger m-1"
                        onclick="eliminarGeneros(<?=$genero['id_genero']?>)">Eliminar</button>
                </td>
            </tr>
            <?php endforeach; else:?>
            <tr>
                <h3>Sin registros para mostrar</h3>
            </tr>
            <?php endif;?>

        </tbody>
    </table>


</div>