<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
    <style>

    #map { height: 500px; z-index: 100; cursor:pointer;}
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <section class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" >
                <!--Container de conteúdo-->
                <div class="col-lg-8 row" style="z-index: 2;">
                    <header class="display-1 text-center my-4 text-break p-0">ADMINISTRADOR BIOSFERA</header>
                    <p class="text-center"><strong>Mapa interativo da flora nativa da faculdade de Tecnologia</strong></p>
                    <div class="col-xl-3">
                        <form action="<?php echo URL."especimes/cadastro"?>" method="post" class="mb-3">
                            <button class="btn btn-warning w-100">ADICIONAR PLANTA</button>
                            <input type="text" class="form-control" id="inputCoord" name="inputCoord" value="" placeholder="Coordenadas do marcador" onChange="criaMarkerView(this.value)" maxlength="50" required>
                        </form>
                    </div>
                    <div class="col-xl-9">
                        <div id="map"></div>
                        <p class="position-relative" style="z-index: 100;">Legenda: Mapa do entorno da instituição</p>
                    </div>
                </div>
            </section>

            <!-- Feedbacks -->
            <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_corrected.svg'?>" class="nuvem nuvem-top px-0">
            <section class="container-fluid folhas2 p-5 m-0  row justify-content-center align-content-center position-relative">
                <h1 class="text-center mb-5">Feedbacks</h2>
                <div class="col-lg-4 me-3" style="z-index: 2;">
                    <h3>Assuntos de Feedback</h3>
                    <?php
                        //Exibindo mensagem de erro
                        if(isset($_COOKIE["msgLista"]))
                        {echo $_COOKIE["msgLista"];}
                    ?>
                    
                    <table id="listaAssunto" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Ações</th>
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
                                <a href='#' data-bs-toggle='modal' data-bs-target='#CadAssuntos' onClick='altAssunto($assunto->IDASSUNTO)'><img src='".URL."resource/imagens/icons/caneta-de-pena.png' style='width:25px;'></a><div class='vr mx-2'></div>
                                <a href='".URL."assuntos/excluir/$assunto->IDASSUNTO'><img src='".URL."resource/imagens/icons/trash.png' style='width:25px;'></a>
                                </td>
                            </tr>
                            ";
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href='#' onClick='cadAssunto("assunto_<?php $assunto->IDASSUNTO ?>")' class='btn btn-warning'>Cadastrar</a>
                </div>
                <div class="col-lg-7" style="z-index: 2;">
                <h3>Feedbacks enviados</h3>
                    <?php
                        //Exibindo mensagem de erro
                        if(isset($_COOKIE["msgFeedback"]))
                        {echo $_COOKIE["msgFeedback"];}
                    ?>
                    <table id="listaFeedback" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Avaliação</th>
                                <th>Assunto</th>
                                <th>Feedback</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($feedbacks as $feedback)
                            {
                                echo "
                                <tr id='feedback_$feedback->IDFEEDBACK'>
                                    <td>$feedback->IDFEEDBACK</td>
                                    <td>$feedback->AVALIACAO</td>
                                    <td>$feedback->IDASSUNTO</td>
                                    <td>$feedback->TEXTO</td>
                                    <td>$feedback->EMAIL</td>
                                ";
                                if($feedback->IDADMIN == NULL){
                                    echo "
                                        <td>
                                            <a href='#' onClick='respondeFeedback('feedback_$feedback->IDFEEDBACK')'>
                                                <img src='".URL."resource/imagens/icons/eye-open.png' style='width:25px;'>
                                                <div class='vr mx-2'></div>
                                                <img src='".URL."resource/imagens/icons/email-send.png' style='width:25px;'>
                                            </a>
                                        </td>
                                    </tr>
                                    ";
                                }
                                else{
                                    echo "
                                        <td>
                                            <a href='#' onClick='veFeedback('feedback_$feedback->IDFEEDBACK')'>
                                                <img src='".URL."resource/imagens/icons/eye-closed.png' style='width:25px;'>
                                                <div class='vr mx-2'></div>
                                                <img src='".URL."resource/imagens/icons/email.png' style='width:25px;'>
                                            </a>
                                        </td>
                                    </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th>Avaliação</th>
                                <th>Assunto</th>
                                <th>Feedback</th>
                                <th>Email</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>

        <!-- Modal Assuntos-->
        <div class="modal fade" id="CadAssuntos" tabindex="-1" aria-labelledby="Modal cadastro de atributo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content px-3">
                    <div class="modal-header d-flex">
                        <h1 class="modal-title fs-5">Atributo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAssunto">
                            <?php
                                //Exibindo mensagem de erro
                                if(isset($_COOKIE["msgF"]))
                                {
                                echo $_COOKIE['msgF'];
                                }
                            ?>
                            <div class="mb-3">
                                <label for="inputIdAssunto" class="form-label">Id do Assunto</label>
                                <input type="text" value="" class="form-control" id="inputIdAssunto" name="inputIdAssunto" aria-label="Id do Assunto" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="inputDescricao" class="form-label">Id do Assunto</label>
                                <input type="text" value="" class="form-control" id="inputDescricao" name="inputDescricao" aria-label="Id do Assunto" disabled>
                            </div>
                            
                            <button id="btnCadAssunto" onClick="alterarAssunto()" type="submit" class="btn btn-success float-end ms-3">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Feedbacks-->
        <div class="modal fade" id="RespFeedback" tabindex="-1" aria-labelledby="Modal cadastro de atributo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Resposta ao Feedback</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex">
                            <form id="formFeedback" class="d-flex w-100">
                                <input type="text" name="inputNomeAtr" id="inputNomeAtr" placeholder="Tipo de Atributo" class="form-control" aria-label="Digite o tipo de atributo" maxlength="50" required>
                                <button onClick="cadastrarAtr()" type="submit" class="btn btn-success float-end ms-3">Cadastrar</button>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>

    <script>
        //Script de inicialização personalizado da tabela
        tableAssunto = $('#listaAssunto').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            },
            pageLength: 4,
            lengthChange: false,
            deferRender: false
        });

        tableFeedback = $('#listaFeedback').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            },
            pageLength: 4,
            lengthChange: false,
            deferRender: false
        });
    </script>

    <script>
        //Coloca o valor do atributo textarea
        function altAssunto(idAssunto)
        {
            $('inputIdAssunto').val(idAssunto);
            //$('inputDescricao') //usa a funçao de buscar do php
        }
        function alterarAssunto(idAssunto)
        {
            IdAssunto = $('inputIdAssunto');
            IdAssunto = $('inputDescricao');
            btnAssunto = $('btnCadAssunto')
            btnAssunto.on('submit', () => {return false});
            

            //Se valor do input for diferente de vazio
            if(descAssunto.val() != "")
            {
                //Div lista de atributos
                listaAtr = $('#listaAtributos');
                $.ajax({
                    // Cadastra o novo atributo
                    url: '<?php echo URL;?>assuntos/cadastrar',
                    type: 'POST',
                    data: {IdAssunto: IdAssunto.val(),IdAssunto: IdAssunto.val()}, 
                    success: function(id){
                        alert("foi");
                        },
                    error: function(){
                        alert("Erro ao cadastrar atributo");
                    }
                });
            }
        }

        //Atualiza input do atributo
        function updInputAtr()
        {
            textArea = $('#inputDescAtr');
            atrId = textArea.attr("data-idAtr");   
            listItem = $(`tr#${atrId}`);
            
            //Define classe para melhor visualização

            input = $(`input#atributo\\[${atrId}\\]`);
            
            //Define valor do input com id do textarea = valor do text area
            input.val(textArea.val());

            //Caso valor do input seja diferente de vazio, define class 'table-success', caso contrário remove 'table-success'
            if(input.val() != "")
            {
                listItem.addClass('table-success');
            }
            else
            {
                listItem.removeClass('table-success');
            }
        }


        //Cadastrar atributo 
        function cadastrarAtr()
        {
            //Cancel form submit
            cadAtrForm = $('form#cadAtr');
            cadAtrForm.on('submit', () => {return false});
            
            //Input de cadastro de atributo
            inputNomeAtr = $("input#inputNomeAtr");

            //Se valor do input for diferente de vazio
            if(inputNomeAtr.val() != "")
            {
                //Div lista de atributos
                listaAtr = $('#listaAtributos');
                $.ajax({
                    // Cadastra o novo atributo
                    url: '<?php echo URL;?>atributos/cadastrar/',
                    type: 'POST',
                    data: {inputNomeAtr: inputNomeAtr.val()}, //Envia valor do input para cadastro
                    success: function(id){
                        atualizaListaAtr(); //Atualiza a lista
                        listaAtr.append(`<input type='hidden' name='atributo[${id}]' id='atributo[${id}]' value=''>`); //Adiciona o input atributo 
                        inputNomeAtr.val(''); //Limpa o valor do input 
                        },
                    error: function(){
                        alert("Erro ao cadastrar atributo");
                    }
                });
            }
        }

        //Excluir atributo
        function excluirAtr(id)
        {
            $.ajax({
                //Exclui atributo
                url: '<?php echo URL;?>atributos/excluir/'+id,
                type: 'GET',
                success: function(msg){
                    if(msg == "true")
                    {
                        //Exclusão executada com sucesso
                        atualizaListaAtr(); // Atualiza a lista
                        $(`input#atributo\\[${id}\\]`).remove();//Remove o input do atributo
                    }
                    else
                    {
                        //Exclusão executada com erro   
                        alert("Erro ao excluir atributo! É possível que o atributo esteja relacionado com alguma espécie");
                    }
                    
                },
                error: function(){
                    alert("Erro ao excluir atributo");
                }
            });
        }
    </script>

    <script>
        //Exibir Mapa
        // initialize the map on the "map" div with a given center and zoom
        var map = L.map('map', {
            center: [-23.33605, -46.72202],
            zoom: 20
        });
        // Tile do
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar',
            maxZoom: 19,
            aattribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        //Overlay Imagem
        var imageUrl = 'resource/ui/map/mapv1.png'
            imageBounds = [[-23.3357271, -46.7216205], [-23.3365669, -46.722789]];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);

        //Alterar ìcone do Marker
        var myIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            /*popupAnchor: [-3, -76],
            shadowUrl: 'ui\bg\arvore.png',
            shadowSize: [68, 95],
            shadowAnchor: [22, 94]*/
        });

        //Declara variáveis marcador e índice
        var markerIndex = 0;
        var marker = [];

        //Exibir um marcador ao clicar
        function onMapClick(e) {

            //Adiciona marcador baseado no índice e incrementa índice
            marker [markerIndex] = L.marker(e.latlng, {icon: myIcon}).addTo(map);
            map.addLayer(marker[markerIndex]);
            
            //Remove marcador do índice anterior
            if(markerIndex){
                map.removeLayer(marker[markerIndex-1]);
            }
            //Elemento input
            const coordInput = document.getElementById("inputCoord");
            
            //Define valor ao input
            
            //var coord = e.latlng.lat+", "+e.latlng.lng;
            var coord = Math.round(e.latlng.lat * 10000000) / 10000000 + ", " + Math.round(e.latlng.lng * 10000000) / 10000000;
            coordInput.value = coord;
            markerIndex ++;
        }

        //Cria um marcador para visualização baseado na coordenada informada
        function criaMarkerView(coordTxt){
            const coordArray = coordTxt.split(", ");
            latlngObj = { latlng: {lat:coordArray[0], lng:coordArray[1]}};

            onMapClick(latlngObj);
        }

        map.on('click', onMapClick);
    </script>
    <script>
        //Exibir espécimes no mapa
        <?php
            echo "var markerBD = [";
            foreach ($especimes as $especime)
            {
                $especime->DATACAD = date("d-m-Y",strtotime($especime->DATACAD));
                echo "L.marker([$especime->COORD],{icon: myIcon}).addTo(map).bindPopup('<p><a href=\"http://api.qrserver.com/v1/create-qr-code/?data=".URL."especime/$especime->IDESPECIME\" title=\"Gerar QR Code\" target=\"_blank\"><img src=\"".URL."resource/imagens/icons/qr-digitalizar.png\" style=\"width:20px;\"></a> Espécie: $especime->NOMEPOP</p><p>Status: "; echo $especime->ESTADO == 1? "<span class=\"badge text-bg-success\">Ativo</span>": "<span class=\"badge text-bg-danger\">Inativo</span></p>"; echo "<p>Data de cadastro: $especime->DATACAD</p><p>Cadastro por: $especime->NOME</p><a href=\"".URL."especimes/altera/$especime->IDESPECIME\" title=\"Alterar Espécime\"><img src=\"".URL."resource/imagens/icons/caneta-de-pena.png\" style=\"width:20px;\"></a><a href=\"".URL."especime/$especime->IDESPECIME\" class=\"float-end\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'),";
            }
            echo "''];";
        ?>
    </script>
</body>
</html>