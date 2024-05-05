<div class="container mt-5">
  <h1>Perfil de Usuario</h1>
  <form action="/usuarios/guardar" method="POST">
  <input type="hidden" id="UsId" name= "UsId" value="<?=$datos['UsId']?>">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre:</label>
      <input type="text" class="form-control" id="nombre" name="UsNombre" value="<?=$datos['UsNombre']?>">
    </div>
    <div class="mb-3">
      <label for="apellidos" class="form-label">Apellidos:</label>
      <input type="text" class="form-control" id="apellidos" name="UsApellidos" value="<?=$datos['UsApellidos']?>">
    </div>
    <div class="mb-3">
      <label for="email" class="form-label">Email:</label>
      <input type="email" class="form-control" id="email" name="UsEmail" value="<?=$datos['UsEmail']?>">
    </div>
    <div class="mb-3">
      <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
      <input type="date" class="form-control" id="fechaNacimiento" name="UsFechaNacimiento" value="<?=$datos['UsFechaNacimiento']?>">
    </div>
    <div class="mb-3">
      <label for="clave" class="form-label">Clave:</label>
      <input type="password" class="form-control" id="clave" name="UsPassword" autocomplete="off">
    </div>
    <button type="submit" class="btn btn-primary" style="floaT:right;">Guardar Cambios</button>
  </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Obtenemos el valor de la contraseña del servidor
    var contraseña = "<?php echo htmlspecialchars($datos['UsPassword']); ?>";
    // Asignamos el valor al campo de contraseña
    document.getElementById("clave").value = contraseña;
});
</script>