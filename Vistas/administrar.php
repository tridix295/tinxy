<!-- Modal Agregar Libro -->
<div class="modal fade" id="agregarLibro" tabindex="-1" aria-labelledby="agregarLibro" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar un nuevo libro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method='POST' action='/libros/registrar' id="formLibros" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="titulo" class="form-label">Titulo</label>
                                <input type="text" class="form-control" id="titulo" name='titulo'
                                    aria-describedby="Escriba el nombre del libro" placeholder='Titulo del libro' required>
                            </div>
                            <div class="col-md-5">
                                <label for="fecha" class="form-label">Fecha de publicacion</label>
                                <input type="date" class="form-control" id="fecha" name='fecha' required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="genero" class="form-label">Genero</label>
                                <select class="form-select" aria-label="Seleciona el genero del libro" id='genero'
                                    name='genero' required>

                                </select>

                            </div>

                            <div class="col-md-8">
                                <label for="autor" class="form-label">Autor</label>
                                <input type="text" class="form-control" id="autor" name='autor'
                                    placeholder='Autor del libro' required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name='isbn'
                                    placeholder='Escribe el ISBN del libro' required>
                            </div>
                            <div class="col-md-5">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="imagen" name='imagen'>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripcion</label>
                            <textarea id="descripcion" cols="10" rows="5" class='form-control'
                                name='descripcion' required> Agregar una descripcion del libro</textarea>
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
<!-- Modal Editar Libro -->
<div class="modal fade" id="editarLibro" tabindex="-1" aria-labelledby="editarLibro" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Editar libro</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method='POST' action='/libros/editar' id="eformLibros" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="eid" hidden value="">
                        <div class="row">
                            <div class="col-md-7">
                                <label for="etitulo" class="form-label">Titulo</label>
                                <input type="text" class="form-control" id="etitulo" name='titulo'
                                    aria-describedby="Escriba el nombre del libro" placeholder='Titulo del libro' required>
                            </div>
                            <div class="col-md-5">
                                <label for="efecha" class="form-label">Fecha de publicacion</label>
                                <input type="date" class="form-control" id="efecha" name='fecha' required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="egenero" class="form-label">Genero</label>
                                <select class="form-select" aria-label="Seleciona el genero del libro" id='egenero'
                                    name='genero' required>
                                   
                                </select>

                            </div>

                            <div class="col-md-8">
                                <label for="eautor" class="form-label">Autor</label>
                                <input type="text" class="form-control" id="eautor" name='autor'
                                    placeholder='Autor del libro' required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <label for="eisbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="eisbn" name='isbn'
                                    placeholder='Escribe el ISBN del libro' required>
                            </div>
                            <div class="col-md-5">
                                <label for="eimagen" class="form-label">Imagen</label>
                                <input type="file" class="form-control" id="eimagen" name='imagen'>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edescripcion" class="form-label">Descripcion</label>
                            <textarea id="edescripcion" cols="10" rows="5" class='form-control'
                                name='descripcion' required> Agregar una descripcion del libro</textarea>
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
        <h2>Administrar libros</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarLibro">Agregar
            libro</button>
    </div>
    <table class="table" id="tablaLibros">

    </table>
    <div class="row">
    <div class="col-12 d-flex justify-content-end">
            <nav aria-label="paginacion">
                <ul class="pagination" id="paginacion">
                </ul>
            </nav>
        </div>
    </div>
</div>