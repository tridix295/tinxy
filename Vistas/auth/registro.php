<section class="vh-100">
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-8 col-lg-5 col-xl-4">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-6 offset-xl-1">
                <form action="/registro/add" method="POST" id="register">

                    <div class="d-flex">
                        <div class="validate-input form-outline mb-1 m-1" data-validate="Por favor ingrese el usuario.">
                            <input type="text" id="usuario" class="form-control form-control-lg"
                                placeholder="Escribe tu nombre" name="usuario" />
                            <label class="form-label" for="usuario">Usuario</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-2 m-1">
                            <input type="text" id="apellidos" class="form-control form-control-lg"
                                placeholder="Apellidos..." name="apellidos" />
                            <label class="form-label" for="usuario">Apellidos</label>
                        </div>

                    </div>

                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-12 m-1">
                        <input type="email" id="email" class="form-control form-control-lg"
                            placeholder="Ingresa tu correo" name="email" />
                        <label class="form-label" for="email">Correo Electronico</label>
                    </div>
                    <div class="d-flex">
                        <div data-mdb-input-init class="form-outline mb-2 m-1">
                            <input type="password" id="clave" class="form-control form-control-lg"
                                placeholder="Ingresa tu contraseña" name="clave"/>
                            <label class="form-label" for="clave">Contraseña</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-1 m-1">
                            <input type="date" id="nacimiento" class="form-control form-control-lg"
                                name="nacimiento" autocomplete="Ingrese su clave"/>
                            <label class="form-label" for="nacimiento">Fecha de nacimiento</label>
                        </div>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2" style="float:right;">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Ingresar</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">Ya tienes una cuenta? <a href="/login"
                                class="link-danger"><i>Iniciar sesion</i></a></p>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<script>

document.getElementById('register').addEventListener('submit', function(event){
			event.preventDefault();
			register();
});
function register() {
    let username = document.getElementById('usuario').value;
    let apellidos = document.getElementById('apellidos').value;
    let nacimiento = document.getElementById('nacimiento').value;
    let email = document.getElementById('email').value;
    let password = document.getElementById('clave').value;



    if (
        username === '' || apellidos === '' || nacimiento === '' || email === '' ||
        password === ''
    ) {
        alert('Todos los campos son obligatorios');
        return;
    }


    document.getElementById('register').submit();
}
</script>