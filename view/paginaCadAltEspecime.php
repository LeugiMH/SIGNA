<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA - Cadastro de espécime</title>
</head>
<body class="d-flex flex-column min-vh-100">
    <?php $url = $_GET["url"]; $url = explode("/",$url);?>
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-12 col-lg-8 col-xl-6 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-4"><?php echo $url[1] == 'cadastro'? 'CADASTRO':'ALTERAÇÃO';?> DA ESPÉCIME</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <form action="<?php echo $url[1] == 'cadastro'? URL.'especimes/cadastrar':URL.'especimes/alterar';?>" method="POST" enctype="multipart/form-data">
                            <?php
                                //Exibindo mensagem de erro
                                if(isset($_COOKIE["msg"]))
                                {echo $_COOKIE["msg"];}
                                if(isset($_COOKIE["erro"]))
                                {echo $_COOKIE["erro"];}
                            ?>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <input type="hidden" name="inputEspecime" value="<?php echo isset($especime)?$especime->IDESPECIME:'';?>">
                                    <input type="hidden" name="inputCoord" value="<?php echo isset($especime)?$especime->COORD: (isset($_COOKIE['coord']) ? $_COOKIE['coord']: $_POST['inputCoord']);?>">
                                    <div class="mb-3">
                                        <select name="inputEspecie" id="inputEspecie" class="form-select" aria-label="Selecione a espécie da planta" required>
                                            <option disabled selected>Selecione uma Espécie</option> 
                                            <?php
                                            foreach ($especies as $especie)
                                            {
                                                //Verifica se existe espécie e espécime
                                                if(isset($especime))
                                                {
                                                    //Define status selecionado para a opção correta
                                                    if($especime->IDESPECIE == $especie->IDESPECIE)
                                                    {
                                                        echo"<option selected value='$especie->IDESPECIE'>$especie->NOMEPOP</option>";
                                                    }
                                                    else{
                                                        echo"<option value='$especie->IDESPECIE'>$especie->NOMEPOP</option>";
                                                    }
                                                }
                                                else
                                                {
                                                    echo"<option value='$especie->IDESPECIE'>$especie->NOMEPOP</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <textarea class="form-control" placeholder="Descrição da imagem" id="inputImgDesc" name="inputImgDesc" style="height:100%; resize:none;" rows="4"><?php echo isset($especime)?$especime->DESCRICAOIMG:'';?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <select  name="inputStatus" id="inputStatus" class="form-select" aria-label="Selecione o Status da planta" required>
                                            <?php
                                            if(isset($especime))
                                            {
                                                if($especime->ESTADO == 1)
                                                {
                                                    echo "<option selected value=\"1\">Ativo</option>";
                                                    echo "<option value=\"0\">Inativo</option>";
                                                }
                                                else{
                                                    echo "<option value=\"1\">Ativo</option>";
                                                    echo "<option selected value=\"0\">Inativo</option>";
                                                }
                                            }
                                            else
                                            {
                                                echo "<option value=\"1\">Ativo</option>";
                                                echo "<option value=\"0\">Inativo</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="date" value="<?php echo isset($especime)?str_replace(" 00:00:00","",$especime->DATPLANT):'\"\"';?>" class="form-control" id="inputDatPlant" name="inputDatPlant" aria-label="Digite a data de plantiu" required>
                                        </div>
                                        <div class="col-sm-6 ">
                                            <input type="number" value="<?php echo isset($especime)?$especime->DAP:'';?>" placeholder="Diam. Alt. Peito(m)" step="0.01" class="form-control" id="inputDAP" name="inputDAP" aria-label="Digite o Diâmetro na Altura do Peito" min="00.00" max="99.99" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="h-100 text-center">
                                        <input type="file" name="inputImagem" id="inputImagem" accept="image/*" capture="environment" hidden>
                                        <label for="inputImagem" class="h-100 pb-3">
                                            <img src="<?php echo isset($especime->IMAGEM) && file_exists("resource/imagens/especimes/$especime->IMAGEM")? URL."resource/imagens/especimes/$especime->IMAGEM":URL."resource/sem_imagem_clique.png";?>" id="imagem" class="w-100 h-100 rounded" for="inputImagem">
                                        </label>
                                    </div>  
                                </div>
                            </div>
                            <a href="<?php echo URL."inicio" ?>" class="btn btn-success">Voltar</a>
                            <button type="submit" class="btn btn-success float-end"><?php echo $url[1] == 'cadastro'? 'Cadastrar':'Alterar';?></button>
                        </form>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
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