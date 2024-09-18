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
                    <?php $url = $_GET["url"]; $url = explode("/",$url);?>
                    <form action="<?php echo $url[1] == 'cadastro'? URL.'especies/cadastrar':URL.'especies/alterar';?>" method="POST" enctype="multipart/form-data">
                        <?php
                            //Exibindo mensagem de erro
                            if(isset($_COOKIE["msg"]))
                            {echo $_COOKIE["msg"];}
                            
                            //Excluindo cookie de erro
                            setcookie("msg","",time() - 3600);
                        ?>
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <input type="hidden" name="inputId" value="<?php echo isset($especie)?$especie->IDESPECIE:'';?>">
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($especie)?$especie->NOMECIE:'';?>" placeholder="Nome Científico" class="form-control" id="inputNomeCie" name="inputNomeCie" aria-label="Digite o nome científico" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($especie)?$especie->NOMEPOP:'';?>" placeholder="Nome Popular" class="form-control" id="inputNomePop" name="inputNomePop" aria-label="Digite o nome popular" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($especie)?$especie->FAMILIA:'';?>" placeholder="Família" class="form-control" id="inputFamilia" name="inputFamilia" aria-label="Digite o nome da família da espécie" maxlength="256" required>
                                </div>
                                <div class="mb-3">
                                    <input type="text" value="<?php echo isset($especie)?$especie->HABITAT:'';?>" placeholder="Habitat Natural" class="form-control" id="inputHabitat" name="inputHabitat" aria-label="Digite o habitat natural" maxlength="256" required>
                                </div>
                                <div class="">
                                    <input type="number" value="<?php echo isset($especie)?$especie->ALTURA:'';?>" placeholder="Altura adulta(m)" step="0.01" class="form-control" id="inputAltura" name="inputAltura" aria-label="Digite a altura da árvore adulta" min="00.00" max="999.99" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="row mb-3">
                                    <div class="col">
                                        <input type="file" name="inputImagem" id="inputImagem" accept="image/*" hidden>
                                        <label for="inputImagem">
                                            <img src="<?php echo isset($especie->IMAGEM)? URL."resource/imagens/especies/$especie->IMAGEM":URL."resource/sem_imagem_clique.png";?>" id="imagem" class="w-100 h-100 rounded" for="inputImagem" style="height:100%;">
                                        </label>
                                    </div>
                                    <div class="col">
                                        <textarea class="form-control" placeholder="Descrição da imagem" id="inputImgDesc" name="inputImgDesc" style="height:100%; resize:none;"><?php echo isset($especie)?$especie->DESCRICAOIMG:'';?></textarea>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="button" class="btn btn-success" onclick="history.back()">Voltar</button>
                                    <button type="submit" class="btn btn-success float-end"><?php echo $url[1] == 'cadastro'? 'Cadastrar':'Alterar';?></button>
                                </div>
                            </div>
                        </div>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
    
    <!-- SCRIPT PARA MOSTRAR A FOTO ENVIADA EM TEMPO REAL-->
    <script>
        inputImagem.onchange = evt => {
            var [file] = inputImagem.files
            if (file && $("#inputImagem").val() != "") {
                var url = URL.createObjectURL(file);
                imagem.src = url;
            }
            else
            {
                imagem.src = "recursos/img/imagem_exemplo.jpg";
            }
        }
    </script>
</body>
</html>