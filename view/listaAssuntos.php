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
                <section class="col-sm-12 col-lg-11 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-5">ASSUNTOS</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <?php
                            //Exibindo mensagem de erro
                            if(isset($_COOKIE["msgLista"]))
                            {echo $_COOKIE["msgLista"];}
                        ?>
                        <a href="<?php echo URL.'assuntos/cadastro';?>" class="btn btn-warning">Cadastrar</a>
                        <table id="lista" class="table table-striped text-center">
                            <thead>
                                <tr>
                                    <th>IDASSUNTO</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($assuntos as $assunto)
                                {
                                echo "
                                <tr>
                                    <td>$assunto->IDASSUNTO</td>
                                    <td>$assunto->DESCRICAO</td>
                                    <td>
                                    <a href='".URL."assuntos/altera/$assunto->IDASSUNTO'><img src='".URL."resource/imagens/icons/caneta-de-pena.png' style='width:25px;'></a><div class='vr mx-2'></div>
                                    <a href='".URL."assuntos/excluir/$assunto->IDASSUNTO'><img src='".URL."resource/imagens/icons/trash.png' style='width:25px;'></a>
                                    </td>
                                </tr>
                                ";
                                }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>IDASSUNTO</th>
                                    <th>DESCRIÇÃO</th>
                                    <th>AÇÕES</th>
                                </tr>
                            </tfoot>
                        </table>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0"
                    style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
	<!--Imports-->  
    <?php include_once "resource/plugins.php";?>
    <?php include_once "resource/pluginsDataTables.php";?>
</body>

</html>