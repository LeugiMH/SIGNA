<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>
<body>
    <div class="corpo-list min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div class="container-sm folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <div class="col-sm-2 col-lg-6 col-xl-8 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <h1 class="display-1 text-center mb-5">CONTAINER</h1>
                    <div class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <div class="table-responsive">
                            <table id="tabela" class="table table-striped"> 
                                <thead>
                                    <tr>
                                        <th>IDESPÉCIE</th>
                                        <th>NOMECIE</th>
                                        <th>NOMEPOP</th>
                                        <th>FAMILIA</th>
                                        <th>HABITAT</th>
                                        <th>ALTURA</th>
                                        <th>IMAGEM</th>
                                        <th>DESCRICAOIMG</th>
                                        <th>DATACAD</th>
                                        <th>IDCADADM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($especies as $especie)
                                    {
                                    echo "
                                    <tr>
                                        <td>$especie->IDESPECIE</td>
                                        <td>$especie->NOMECIE</td>
                                        <td>$especie->NOMEPOP</td>
                                        <td>$especie->FAMILIA</td>
                                        <td>$especie->HABITAT</td>
                                        <td>$especie->ALTURA</td>
                                        <td>$especie->IMAGEM</td>
                                        <td>$especie->DESCRICAOIMG</td>
                                        <td>$especie->DATACAD</td>                               
                                        <td>$especie->IDCADADM</td>                               
                                    </tr>
                                    ";
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>IDESPÉCIE</th>
                                        <th>NOMECIE</th>
                                        <th>NOMEPOP</th>
                                        <th>FAMILIA</th>
                                        <th>HABITAT</th>
                                        <th>ALTURA</th>
                                        <th>IMAGEM</th>
                                        <th>DESCRICAOIMG</th>
                                        <th>DATACAD</th>
                                        <th>IDCADADM</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>