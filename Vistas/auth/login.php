<section class="">
    <br><br><br><br>
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                    class="img-fluid" alt="Sample image">
            </div>
            <div class="col-md-8 col-lg-6 col-xl-6 offset-xl-1">
                <form action="/login/event" method="POST" id="login">

                    <!-- Email input -->
                    <div data-mdb-input-init class="form-outline mb-12 m-1">
                        <input type="email" id="email" class="form-control form-control-lg"
                            placeholder="Ingresa tu correo" name="email" />
                        <label class="form-label" for="email">Correo Electronico</label>
                    </div>
                    <div data-mdb-input-init class="form-outline mb-2 m-1">
                        <input type="password" id="clave" class="form-control form-control-lg"
                            placeholder="Ingresa tu contraseña" name="clave" />
                        <label class="form-label" for="clave">Contraseña</label>
                    </div>
                    <div class="text-center text-lg-start mt-4 pt-2" style="float:right;">
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;">Ingresar</button>
                        <p class="small fw-bold mt-2 pt-1 mb-0">No tienes una cuenta? <a href="/registro"
                                class="link-danger"><i>Registrate</i></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
document.getElementById('login').addEventListener('submit', function(event) {
    event.preventDefault();
    register();
});

function register() {
    let email = document.getElementById('email').value;
    let password = document.getElementById('clave').value;

    if (email === '' ||password === '') {
        alert('Todos los campos son obligatorios');
        return;
    }


    document.getElementById('login').submit();
}
</script>