<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>
<body>
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <div class="col-sm-8 col-lg-6 col-xl-4 p-0" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <h1 class="display-1 text-center mb-5">Login</h1>
                    <form action="logar" method="POST" class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <div class="mb-3">
                            <label for="inputEmail" class="form-label">Endereço de Email</label>
                            <input type="email" class="form-control" id="inputEmail" name="inputEmail" aria-describedby="Ajuda Email" maxlength="256">
                        </div>
                        <div class="mb-3">
                            <label for="inputSenha" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="inputSenha" name="inputSenha" maxlength="256">
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-success" onclick="history.back()">Voltar</button>
                            <button type="submit" class="btn btn-success">Logar</button>
                        </div>
                    </form>
                </div>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>