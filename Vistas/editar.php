<div class="container mt-5 p-4 rounded shadow bg-white">
        <h2 class="mb-4 text-center">Editar <?= $datos['titulo']?></h2>
        <form method="POST" action="/libros/editar">
            <input type="hidden" name="id" value="<?= $datos['tiid']?>">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título:</label>
                <input type="text" class="form-control" id="titulo" value="<?= $datos['titulo']?>" name="titulo" required>
            </div>
            <div class="mb-3">
                <label for="autor" class="form-label">Autor:</label>
                <input type="text" class="form-control" id="autor" value="<?= $datos['Anombre']?>" name="autor" required>
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Género:</label>
                <select class="form-select" id="egenero" name="genero" required>
                </select>
            </div>
            <div class="mb-3">
                <label for="ISBN" class="form-label">ISBN:</label>
                <input type="text" class="form-control" id="ISBN" value="<?= $datos['ISBN']?>" name='isbn'>
            </div>
            <div class="mb-3">
                <label for="comentarios" class="form-label">Comentarios:</label>
                <textarea class="form-control" id="comentarios" rows="3" name='descripcion' required><?= $datos['Comentarios']?></textarea>
            </div>
            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha de publicacion</label>
                <input type="date" class="form-control" id="fecha" name='fecha' required>            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen:</label>
                <input type="file" class="form-control" id="imagen">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
    </div>
