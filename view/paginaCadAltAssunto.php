<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA - Cadastro de Assunto</title>
</head>
<body>
    <?php $url = $_GET["url"]; $url = explode("/",$url);?>
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-10 col-lg-8 col-xl-4 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-5"><?php echo $url[1] == 'cadastro'? 'CADASTRO':'ALTERAÇÃO';?> DO ASSUNTO</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <form action="<?php echo $url[1] == 'cadastro'? URL.'assuntos/cadastrar':URL.'assuntos/alterar';?>" method="POST" enctype="multipart/form-data">
                            <?php
                                //Exibindo mensagem de erro
                                if(isset($_COOKIE["msg"]))
                                {echo $_COOKIE["msg"];}
                            ?>
                            <div class="row">
                                <input type="hidden" name="inputId" value="<?php echo isset($assunto)?$assunto->IDASSUNTO:'';?>">
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($assunto)?$assunto->DESCRICAO:'';?>" placeholder="Descrição do assunto" class="form-control" id="inputDescricao" name="inputDescricao" aria-label="Digite a descrição do assunto a ser utilizado em feedbacks" required>
                                </div>
                                <div>
                                    <a href="<?php echo URL."assuntos/lista" ?>" class="btn btn-success" >Voltar</a>
                                    <button type="submit" class="btn btn-success float-end"><?php echo $url[1] == 'cadastro'? 'Cadastrar':'Alterar';?></button>
                                </div>
                            </div>
                        </form> 
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>

</body>
</html>