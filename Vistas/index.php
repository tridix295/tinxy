<div class="container">
  <div class="row">
    <?php foreach($datos as $libro):?>
      <div class="col-md-4 mb-3">
        <div class="card">
          <img src="<?=$libro['imagen']?>" class="card-img-top img-fluid" alt="...">
          <div class="card-body">
            <h5 class="card-title"><?=$libro['titulo']?></h5>
            <p class="card-text"><?=$libro['Comentarios']?></p>
            <a href="/libros/editar/<?=$libro['tiid']?>" class="btn btn-primary float-right"  style="float: right;">Editar</a>
          </div>
        </div>
      </div>
    <?php endforeach;?>
  </div>
</div>

