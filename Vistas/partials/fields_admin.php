<ul class="nav nav-pills">
    <li class="nav-item"><a href="/" class="nav-link active" aria-current="page">Inicio</a></li>
    <li class="nav-item"><a href="/inicio/admin" class="nav-link">Administrar</a></li>
    <li class="nav-item"><a href="/generos" class="nav-link">Generos</a></li>
    <!--Perfil-->
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <?=$usuario['UsNombre']?>
        </a>
        <ul class="dropdown-menu">
                <li class="nav-item"><a href="/usuarios/edit/<?=$usuario['UsId']?>" class="nav-link">Mi perfil</a></li>
                <?php if($usuario['UsTipoUsuario'] == 0):?>
                    <li class="nav-item"><a href="/usuarios/admin" class="nav-link">Administracion de usuarios</a></li>
                <?php endif;?>
                <li class="nav-item"><a href="/usuarios/logout" class="nav-link">Cerrar sesion</a></li>
        </ul>
    </li>
</ul>