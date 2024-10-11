<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>
<body>
    <?php $url = $_GET["url"]; $url = explode("/",$url);?>
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-10 col-lg-8 col-xl-4 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-5"><?php echo $url[1] == 'cadastro'? 'CADASTRO':'ALTERAÇÃO';?> DO ADMIN</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <form action="<?php echo $url[1] == 'cadastro'? URL.'admins/cadastrar':URL.'admins/alterar';?>" method="POST" enctype="multipart/form-data">
                            <?php
                                //Exibindo mensagem de erro
                                if(isset($_COOKIE["msg"]))
                                {echo $_COOKIE["msg"];}
                            ?>
                            <div class="row">
                                <input type="hidden" name="inputId" value="<?php echo isset($admin)?$admin->IDADMIN:'';?>">
                                <input type="hidden" name="inputSenhaBkp" value="<?php echo isset($admin)?$admin->SENHA:'';?>">
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($admin)?$admin->NOME:'';?>" placeholder="Nome do administrador" class="form-control" id="inputNome" name="inputNome" aria-label="Digite o nome do admin" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($admin)?$admin->MATRICULA:'';?>" placeholder="Matrícula do administrador" class="form-control" id="inputMatricula" name="inputMatricula" aria-label="Digite a matrícula do admin" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" value="<?php echo isset($admin)?$admin->EMAIL:'';?>" placeholder="Email do administrador" class="form-control" id="inputEmail" name="inputEmail" aria-label="Digite o email do admin" required>
                                </div>
                                <div class="mb-3">
                                    <input type="password" placeholder="Senha do administrador" class="form-control" id="inputSenha" name="inputSenha" aria-label="Digite a senha do admin" <?php echo isset($admin) ? '' : 'required'; ?> >
                                </div>
                                <div>
                                    <a href="<?php echo URL."admins/lista" ?>" class="btn btn-success" >Voltar</a>
                                    <button type="submit" class="btn btn-success float-end"><?php echo $url[1] == 'cadastro'? 'Cadastrar':'Alterar';?></button>
                                </div>
                            </div>
                        </form> 
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>

</body>
</html>