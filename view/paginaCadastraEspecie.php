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
                <section class="col-sm-12 col-lg-10 col-xl-8 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-5">CADASTRO DA ESPÉCIE</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                    <form action="logar" method="POST">
                        <?php
                            //Exibindo mensagem de erro
                            if(isset($_COOKIE["msg"]))
                            {
                                echo "<div class='alert alert-danger' role='alert'>
                                    ".$_COOKIE['msg'] ."
                                </div>";
                            }
                            //Excluindo cookie de erro
                            setcookie("msg","",time() - 3600);
                        ?>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="mb-3">
                                    <input type="text" value="" placeholder="Nome Científico" class="form-control" id="inputNomeCie" name="inputNomeCie" aria-label="Digite o nome científico" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="" placeholder="Nome Popular" class="form-control" id="inputNomePop" name="inputNomePop" aria-label="Digite o nome popular" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="" placeholder="Família" class="form-control" id="inputFamilia" name="inputFamilia" aria-label="Digite o nome da família da espécie" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="" placeholder="Habitat Natural" class="form-control" id="inputHabitat" name="inputHabitat" aria-label="Digite o habitat natural" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="number" value="" placeholder="Altura adulta(m)" step="0.1" class="form-control" id="inputAltura" name="inputAltura" aria-label="Digite a altura da árvore adulta" maxlength="4" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="row mb-3" style="height:calc(100% - 70px);">
                                    <div class="col">
                                        <img src="<?php echo URL."resource/exemplo.webp";?>" class="w-100 h-100 rounded">
                                    </div>
                                    <div class="col">
                                        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height:100%; resize:none;"></textarea>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-success" onclick="history.back()">Voltar</button>
                                    <button type="submit" class="btn btn-success float-end">Logar</button>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                        </div>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>