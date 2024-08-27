<nav class="navbar navbar-expand-lg bg-warning" style="z-index: 10;">
    <div class="container-fluid">
        <a class="navbar-brand" href="inicio" aria-label="SIGNA, Sistema de Gerenciamento de Núcleo Arbóreo">SIGNA - ADMIN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="especies/listar">Espécies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Atributos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Admins</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Assuntos</a>
                </li>
            </ul>
            <span class="navbar-text p-0 me-1">
                <a class="navbar-text p-0 me-1" href="<?php echo URL.'sair';?>">
                    <div class="btn btn-danger">Sair</div>
                </a>
            </span>
        </div>
    </div>
</nav>