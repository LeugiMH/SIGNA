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
                <section class="col-sm-12 col-lg-11 col-xl-10 p-0 my-5" style="z-index: 2;">
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-5"><?php echo $url[1] == 'cadastro'? 'CADASTRO':'ALTERAÇÃO';?> DA ESPÉCIE</header>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white">
                        <form action="<?php echo $url[1] == 'cadastro'? URL.'especies/cadastrar':URL.'especies/alterar';?>" method="POST" enctype="multipart/form-data">
                            <!--Informações-->
                            <?php
                                //Exibindo mensagem de erro
                                if(isset($_COOKIE["msg"]))
                                {echo $_COOKIE["msg"];}
                            ?>
                            <div class="row mb-3">
                                <div class="col-12 col-sm-5 mb-3 mb-sm-0">
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
                                        <!--<input type="text" value="<?php echo isset($especie)?$especie->HABITAT:'';?>" placeholder="Habitat Natural" class="form-control" id="inputHabitat" name="inputHabitat" aria-label="Digite o habitat natural" maxlength="256" required>-->
                                        <textarea class="form-control" placeholder="Habitat Natural" id="inputHabitat" name="inputHabitat" rows="7" style="height:100%; resize:none;"><?php echo isset($especie)?$especie->HABITAT:'';?></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col sm-6">
                                            <input type="number" value="<?php echo isset($especie)?$especie->ALTURA:'';?>" placeholder="Altura adulta(m)" step="0.01" class="form-control" id="inputAltura" name="inputAltura" aria-label="Digite a altura da árvore adulta" min="00.00" max="999.99" required>
                                        </div>
                                        <div class="col sm-6">
                                            <input type="text" value="" placeholder="Estado de conservação" class="form-control" aria-label="Estado de conservação">
                                        </div>
                                    </div>
                                </div>
                                <!--Imagem-->
                                <div class="col-12 col-sm-3 mb-3 mb-sm-0 d-flex flex-column">
                                    <div class="mb-3">
                                        <input type="file" name="inputImagem" id="inputImagem" accept="image/*" hidden>
                                        <label for="inputImagem" class="w-100">
                                            <img src="<?php echo isset($especie->IMAGEM)? URL."resource/imagens/especies/$especie->IMAGEM":URL."resource/sem_imagem_clique.png";?>" id="imagem" class="w-100 h-100 rounded" for="inputImagem" style="height:100%;">
                                        </label>
                                    </div>
                                    <div class="m-0" style="height:100%;">
                                        <textarea class="form-control" placeholder="Descrição da imagem" id="inputImgDesc" name="inputImgDesc" style="height:100%; resize:none;"><?php echo isset($especie)?$especie->DESCRICAOIMG:'';?></textarea>
                                    </div>
                                </div>
                                <!--Lista de Atributos-->
                                <div class="col-12 col-sm-4 mb-3 mb-sm-0">
                                    <?php
                                        //Exibindo mensagem de erro
                                        if(isset($_COOKIE["msgLista"]))
                                        {echo $_COOKIE["msgLista"];}
                                    ?>
                                    <a href="#" class="btn btn-warning mb-3" data-bs-toggle="modal" data-bs-target="#CadAtributo">Cadastrar Atributo</a>
                                    <table id="lista" class="table table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>ATRIBUTO</th>
                                                <th>AÇÕES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($atributos as $atributo)
                                            {
                                            echo "
                                            <tr>    
                                                <td>$atributo->IDATRIBUTO</td>
                                                <td>$atributo->NOMEATRIBUTO</td>
                                                <td>
                                                <a href='#'><img src='".URL."resource/imagens/icons/caneta-de-pena.png' style='width:25px;'></a><div class='vr mx-2'></div>
                                                <a href='#' onClick='excluirAtr($atributo->IDATRIBUTO)'><img src='".URL."resource/imagens/icons/trash.png' style='width:25px;'></a>
                                                </td>
                                            </tr>
                                            ";
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>ID</th>
                                                <th>ATRIBUTO</th>
                                                <th>AÇÕES</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="mt-3">
                                    <textarea class="form-control" placeholder="Conteúdo do Atributo " id="inputDescAtr" name="inputDescAtr" rows="3" style="height:100%; resize:none;"></textarea>
                                </div>
                                </div>  
                                <?php 
                                foreach($atributos as $atributo)
                                {
                                    //echo "<input type='text'> ";
                                }
                                ?>
                            </div>
                            <a href="<?php echo URL."especies/lista" ?>" class="btn btn-success" >Voltar</a>
                            <button type="submit" class="btn btn-success float-end"><?php echo $url[1] == 'cadastro'? 'Cadastrar':'Alterar';?></button>
                        </form>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="CadAtributo" tabindex="-1" aria-labelledby="Modal cadastro de atributo" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Cadastro de atributo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex">
                        <input type="text" name="inputNomeAtr" id="inputNomeAtr" placeholder="Tipo de Atributo" class="form-control" aria-label="Digite o tipo de atributo" maxlength="50" required>
                        <button onClick="cadastrarAtr()" class="btn btn-success float-end ms-3">Cadastrar</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <?php include_once "resource/plugins.php";?>
    <?php include_once "resource/pluginsDataTables.php";?>
    
    <script>
        //SCRIPT PARA MOSTRAR A FOTO ENVIADA EM TEMPO REAL
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
    <script>
        //Script de inicialização personalizado da tabela
        table = $('#lista').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            },
            pageLength: 3,
            lengthChange: false
        });        
    </script>
    <script>

        function atualizaListaAtr()
        {
            table = $('#lista').DataTable();

            table.clear().draw();

            //Consulta a tabela novamente
            $.ajax({
                url: '<?php echo URL;?>atributos/listar/',
                dataType: "JSON",
                success: function(result){
                    $(result).each(function (index, data)
                    {
                        table.row.add([
                            data.IDATRIBUTO,
                            data.NOMEATRIBUTO,
                            `<a href='#'><img src='<?php echo URL.'resource/imagens/icons/caneta-de-pena.png'?>' style='width:25px;'></a><div class='vr mx-2'></div><a href='#' onClick='excluirAtr(${data.IDATRIBUTO})'><img src='<?php echo URL.'resource/imagens/icons/trash.png'?>' style='width:25px;'></a>`
                        ]).draw();
                    });
                },
            });
        }

        //Cadastrar atributo 
        function cadastrarAtr()
        {
            $.ajax({
                // Cadastra o novo atributo
                url: '<?php echo URL;?>atributos/cadastrar/',
                type: 'POST',
                data: {inputNomeAtr: $("input#inputNomeAtr").val()},
                success: function(){
                    atualizaListaAtr(); // atualiza a lista
                    $('input#inputNomeAtr').val(""); //Limpa o valor do campo 
                    },
                error: function(){
                    alert("Erro ao cadastrar atributo");
                }
            });
        }
    </script>
    <script>
        //Excluir atributo
        function excluirAtr(id)
        {
            $.ajax({
                //exclui atributo
                url: '<?php echo URL;?>atributos/excluir/'+id,
                success: function(msg){
                    atualizaListaAtr();
                    },
                error: function(msg){
                    alert("Erro ao excluir atributo");
                }
            });
        }
    </script>
</body>
</html>