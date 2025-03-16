<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-8 col-lg-6 col-xl-4 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mt- mb-4">Redefinir senha</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <form action="<?php echo URL."alterar-senha"?>" method="POST">
                            <?php
                                //Exibindo mensagem de erro
                                if(isset($_COOKIE["msg"]))
                                {echo $_COOKIE['msg'];}
                            ?>
                            <div class="text-danger alert alert-danger" id="avisoIgualdade" style="display:none;">As senhas devem ser iguais</div>
                            <input type="hidden" value="<?php echo $idadmin;?>" class="d-none" id="inputIdAdmin" name="inputIdAdmin" required>
                            <div class="mb-3">
                                <label for="inputSenha" class="form-label">Nova senha</label>
                                <input type="password" value="" class="form-control" id="inputSenha" name="inputSenha" aria-label="Digite a nova senha" maxlength="255" required>
                            </div>
                            <div class="mb-3">
                                <label for="inputConfirmaSenha" class="form-label">Confirmar nova senha</label>
                                <input type="password" value="" class="form-control" id="inputConfirmaSenha" name="inputConfirmaSenha" aria-label="Digite a nova senha novamente" maxlength="255" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="btn btn-success" onclick="history.back()">Voltar</button>
                                <button type="submit" class="btn btn-success">Logar</button>
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
    <script type="text/javascript">
        //confirme a senha
        $("form").submit(function(){
            if($("#inputSenha").val() != $("#inputConfirmaSenha").val())
            {
                event.preventDefault();
                $("#avisoIgualdade").show();
            }
            else{$("#avisoIgualdade").hide();}
        });
    </script>
</body>
</html>
