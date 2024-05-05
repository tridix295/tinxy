<div class="col-12">
    <div class="col-12 d-flex justify-content-between">
        <h2>Buscando</h2>
    </div>
    <br>
    <table class="table" id="tablaLibros">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Titulo</th>
                <th scope="col">Autor</th>
                <th scope="col">ISBN</th>
                <th scope="col">Genero</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Fecha</th>
                <th scope="col">Imagen</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($datos[200])): foreach ($datos[200] as $libro):?>
            <tr>
                <td><?=$libro['tiid']?></td>
                <td><?=$libro['titulo']?></td>
                <td><?=$libro['Anombre']?></td>
                <td><?=$libro['ISBN']?></td>
                <td><?=$libro['Gnombre']?></td>
                <td><?=$libro['Comentarios']?></td>
                <td><?=$libro['fecha']?></td>
                <td><img src='<?=$libro['imagen']?>' class="img-thumbnail img-fluid" alt="..."></td>
                <td class="d-flex">
                    <button type="button" class="btn btn-danger m-1" onclick="eliminar(<?=$libro['tiid']?>)">Eliminar</button>
                    <a href="/libros/editar/<?=$libro['tiid']?>"><button type="button" class="btn btn-primary m-1">Editar</button></a>
                </td>
            </tr>
            <?php endforeach; else:?>
                <tr><h3>No se han encontrado registros</h3></tr>
            <?php endif;?>
            
        </tbody>
    </table>

    
</div>