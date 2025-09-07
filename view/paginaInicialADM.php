<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA - ADMIN</title>
    <style>

    #map { height: 500px; z-index: 100; cursor:pointer;}
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <section class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center position-relative">
                <!--Container de conteúdo-->
                <div class="col-lg-8 row" style="z-index: 2;">
                    <header class="display-1 text-center my-4 text-break p-0">ADMINISTRADOR BIOSFERA</header>
                    <p class="text-center"><strong>Mapa interativo da flora nativa da faculdade de Tecnologia</strong></p>
                    <div class="col-xl-3">
                        <form action="<?php echo URL."especimes/cadastro"?>" method="post" class="mb-3">
                            <button class="btn btn-warning w-100">ADICIONAR PLANTA</button>
                            <input type="text" class="form-control" id="inputCoord" name="inputCoord" value="" placeholder="00.0000000, 00.0000000" onChange="criaMarkerView(this.value)" maxlength="50" required>
                            <div class="form-text">Coordenadas da planta</div>
                        </form>
                    </div>
                    <div class="col-xl-9">
                        <div id="map"></div>
                        <p class="position-relative" style="z-index: 2;">Legenda: Mapa do entorno da instituição</p>
                    </div>
                </div>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_corrected.svg'?>" class="nuvem nuvem-bottom px-0" alt="Imagem plano de fundo de núvem" aria-hidden="true">
            </section>
            <!-- Feedbacks -->
            <section class="container-fluid folhas2 p-5 m-0 row justify-content-center align-content-center position-relative" id="sectionFeedbacks">
                <h1 class="text-center mb-5">Feedbacks</h2>
                <!--Assuntos Lista-->
                <div class="col-lg-4" style="z-index: 2;">
                    <h3>Assuntos de Feedback</h3>
                    <?php
                        //Exibindo mensagem de erro
                        if(isset($_COOKIE["msgAssunto"]))
                        {echo $_COOKIE["msgAssunto"];}
                    ?>
                    
                    <table id="listaAssunto" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
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
                                <a href='#' type='button' data-bs-toggle='modal' data-bs-target='#CadAssuntos' data-title='Alterar Assunto' data-content='$assunto->DESCRICAO'data-selector='$assunto->IDASSUNTO'><img src='".URL."resource/imagens/icons/caneta-de-pena.png' style='width:25px;'></a><div class='vr mx-2'></div>
                                <a href='".URL."assuntos/excluir/$assunto->IDASSUNTO'><img src='".URL."resource/imagens/icons/trash.png' style='width:25px;'></a>
                                </td>
                            </tr>
                            ";
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href='#' type='button' data-bs-toggle='modal' data-bs-target='#CadAssuntos' data-title='Cadastrar Assunto' class='btn btn-warning'>Cadastrar</a>
                </div>

                <!--Feedbacks Lista-->
                <div class="col-lg-8 mt-5 mt-lg-0" style="z-index: 2;">
                    <h3>Feedbacks enviados</h3>
                    <?php
                        if(isset($_COOKIE["msgFeedback"]))
                        {echo $_COOKIE["msgFeedback"];}
                    ?>
                    <table id="listaFeedback" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AVALIAÇÃO</th>
                                <th>ASSUNTO</th>
                                <th>FEEDBACK</th>
                                <th>EMAIL</th>
                                <th>RESPOSTA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($feedbacks as $feedback)
                            { 
                                echo "
                                <tr id='feedback_$feedback->IDFEEDBACK'>
                                    <td>$feedback->IDFEEDBACK</td>
                                    <td>";
                                    for($i = 1; $i <= $feedback->AVALIACAO; $i++){echo"<img src=\"".URL."resource/imagens/icons/star.png\" width=\"20px\">"; }
                                    echo"</td><td>$feedback->DESCRICAO</td>
                                    <td>$feedback->TEXTO</td>
                                    <td>";echo $feedback->EMAIL != "" ? $feedback->EMAIL : "-"; echo"</td>";
                                
                                if($feedback->IDADMIN == NULL){
                                    echo "
                                        <td>
                                            <span href='#' type='button' data-bs-toggle='modal' data-bs-target='#RespFeedback'data-content='$feedback->AVALIACAO'data-selector='$feedback->IDFEEDBACK'>
                                                <img src='".URL."resource/imagens/icons/eye-open.png' style='width:25px;'>
                                                <div class='vr mx-2'></div>
                                                <img src='".URL."resource/imagens/icons/email-send.png' style='width:25px;'>
                                            </span>
                                        </td>
                                    </tr>
                                    ";
                                }
                                else{
                                    echo "
                                        <td>
                                            <span href='#' type='button' data-bs-toggle='modal' data-bs-target='#RespFeedback'data-content='$feedback->AVALIACAO'data-selector='$feedback->IDFEEDBACK'>
                                                <img src='".URL."resource/imagens/icons/eye-closed.png' style='width:25px;'>
                                                <div class='vr mx-2'></div>
                                                <img src='".URL."resource/imagens/icons/email.png' style='width:25px;'>
                                            </span>
                                        </td>
                                    </tr>
                                    ";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <!-- Modal Assuntos-->
        <div class="modal fade text-white " id="CadAssuntos" tabindex="-1" aria-labelledby="Modal cadastro de atributo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-verde">
                    <div class="modal-header d-flex">
                        <h1 class="modal-title fs-5">Atributo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAssunto" action="<?php echo URL.'assuntos/cadastrar';?>" method="POST">
                            <div class="mb-3">
                                <label for="inputIdAssunto" class="form-label">Id do Assunto</label>
                                <input type="text" value="" class="form-control" id="inputIdAssunto" name="inputIdAssunto" aria-label="Id do Assunto" readonly="readonly">
                            </div>
                            <div class="mb-3">
                                <label for="inputDescricao" class="form-label">Assunto</label>
                                <input type="text" value="" class="form-control" id="inputDescricao" name="inputDescricao" aria-label="Id do Assunto">
                            </div>
                            
                            <button id="btnCadAssunto" type="submit" class="modal-title btn btn-success float-end ms-3">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Feedbacks-->
        <div class="modal fade text-white" id="RespFeedback" tabindex="-1" aria-labelledby="Modal cadastro de atributo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-verde">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Resposta ao Feedback</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formFeedback" action="<?php echo URL.'respFeedback';?>" method="POST" class="mb-3 mt-3">
                            <div class="mb-3">
                                <input type="text" value="" class="form-control" id="inputIdFeedback" name="inputIdFeedback" hidden>
                            </div>
                            <div class="mb-3" style="display: none;">
                                <label class="form-label">Espécime: </label>
                                <a href="" class="link-opacity-50-hover link-underline-opacity-0 link-light btn btn-success">
                                    <span id="EspecimeFeedback"></span>
                                    <img src="<?php echo URL.'resource/imagens/icons/sair-do-canto-superior-direito.png'?>" style="width:20px;">
                                </a>
                            </div>
                            <div class="mb-3">
                                <label for="inputEmail" class="form-label">Endereço de Email</label>
                                <input type="email" value="" class="form-control" id="inputEmail" name="inputEmail" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="rating" class="form-label">Avaliação</label>
                                <div class="rating" aria-label="Avaliação" >
                                    <img class="rating__star star-i star me-2" aria-label="1 estrela" ></img>
                                    <img class="rating__star star-i star me-2" aria-label="2 estrelas"></img>
                                    <img class="rating__star star-i star me-2" aria-label="3 estrelas"></img>
                                    <img class="rating__star star-i star me-2" aria-label="4 estrelas"></img>
                                    <img class="rating__star star-i star me-2" aria-label="5 estrelas"></img>
                                </div>
                                <input type="hidden" value="" class="form-control" id="rating" name="rating">
                            </div>
                            <div class="mb-3">
                                <label for="inputAssunto" class="form-label">Assunto</label>
                                <input name="inputAssunto" id="inputAssunto" class="form-select" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="inputMessage" class="form-label">Mensagem</label>
                                <textarea class="form-control" name="inputMessage" id="inputMessage" rows="5"  readonly></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="inputResposta" class="form-label">Resposta</label>
                                <textarea class="form-control" name="inputResposta" id="inputResposta" rows="5"></textarea>
                            </div>

                            <button id="btnEnvFeedback" type="submit" class="btn btn-success float-end ms-3">Responder</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
    <?php include_once "resource/pluginsDataTables.php";?>

    <script>
        //Script de inicialização personalizado da tabela
        tableAssunto = $('#listaAssunto').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            },
            pageLength: 4,
            lengthChange: false,
            deferRender: false,
            order: [[0, 'asc']]
        });

        tableFeedback = $('#listaFeedback').DataTable({
            responsive: true,
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            },
            pageLength: 4,
            lengthChange: false,
            deferRender: false,
            order: [[0, 'desc']]
        });
    </script>

    <script>
        //Mostra estrelas
        function executeRating(avaliacao) {
            const starClassActive = "rating__star star-a star me-2";
            const starClassInactive = "rating__star star-i star me-2";
            const stars = [...document.getElementsByClassName("rating__star")];
            const starsLength = stars.length;
            let i=0;

            stars.map((star) => {
                document.getElementById("rating").value = stars.indexOf(star)+1;
                for (i; i <= avaliacao-1; ++i) stars[i].className = starClassActive;
            });
        }
    </script>

    <script>
        //Coloca valores dos data attributes nos inputs
        $('#CadAssuntos').on('show.bs.modal', function (event) {
            
            var title = $(event.relatedTarget).data('title');
            var assunto = $(event.relatedTarget).data('content');
            var id = $(event.relatedTarget).data('selector');
            $(this).find('.modal-title').html(title);
            $(this).find('#inputIdAssunto').val(id);
            $(this).find('#inputDescricao').val(assunto);

            if (title.match(/^Cadastrar.*$/)) {
                $(this).find('#inputIdAssunto').attr('disabled', 'disabled');
                $(this).find('#inputIdAssunto').attr('hidden', 'hidden');
                $(this).find('label[for="inputIdAssunto"]').attr('hidden', 'hidden');
            }else{
                $(this).find('#inputIdAssunto').removeAttr('disabled', 'disabled');
                $(this).find('#inputIdAssunto').removeAttr('hidden', 'hidden');
                $(this).find('label[for="inputIdAssunto"]').removeAttr('hidden', 'hidden');
            }
        });

        //Modal de Feedbacks
        $('#RespFeedback').on('show.bs.modal', function (event) {
            var id = $(event.relatedTarget).data('selector');
            var avaliacao = $(event.relatedTarget).data('content');
            $(this).find('#inputIdFeedback').val(id);
            console.log(id);
            var url = '<?php echo URL."buscaFeedback/";?>';
            var urlId = url + id;
            console.log(urlId);          

            executeRating(avaliacao);
            $.ajax({
                // Busca atributo
                url: urlId,
                type: 'POST',
                dataType: "JSON",
                success: function(result){
                    $(result).each(function (index, data)
                    {
                        escreveFeedback(data);
                    });
                }
            });

            
        });

        function escreveFeedback(data){
            console.log(data)
            var email = data.EMAIL;
            var assunto = data.DESCRICAO;
            var texto = data.TEXTO;
            var coment = data.COMENT_ADMIN;

            console.log(email);

            if(data.IDESPECIME != null)
            {
                $('#EspecimeFeedback').parent().parent().show();
                $('#EspecimeFeedback').html(data.IDESPECIME);
                $('#EspecimeFeedback').parent().prop("href","<?php echo URL.'especimes/altera/'?>"+data.IDESPECIME);
            }
            else
            {
                $('#EspecimeFeedback').parent().parent().hide();
            }
            $('#inputEmail').val(email);
            $('#inputAssunto').val(assunto);
            $('#inputMessage').val(texto);
            $('#inputResposta').val(coment);
        }
    </script>


    <script>
        //Exibir Mapa
        // initialize the map on the "map" div with a given center and zoom
        var map = L.map('map', {
            center: [-23.3361335, -46.722095],
            zoom: 19
        });
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar',
            //Não mudar cinza
            maxNativeZoom: 19,
            maxZoom: 20,
            //minZoom: 19,
            aattribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var mapLocate = new L.Control.SimpleLocate({
            position: "bottomleft",
            className: "button-locate",
            afterClick: (result) => {
                // Do something after the button is clicked.
            },
            afterMarkerAdd: () => {
               const elem = document.getElementById("leaflet-simple-locate-icon-spot");
                if (elem) {
                    elem.addEventListener("click", (event) => {
                        const latlng = control.getLatLng();
                        const latlng_str = `geolocation: [${Math.round(latlng.lat * 100000) / 100000}, ${Math.round(latlng.lng * 100000) / 100000}]`;

                        const accuracy = control.getAccuracy();
                        const accuracy_str = `accuracy: ${Math.round(accuracy)} meter`;

                        const angle = control.getAngle();
                        const angle_str = `orientation: ${Math.round(angle)} degree`;

                        L.popup()
                            .setLatLng(latlng)
                            .setContent(`<p style="margin: 0.25rem 0 0.25rem 0">${latlng_str}</p><p style="margin: 0.25rem 0 0.25rem 0">${accuracy_str}</p><p style="margin: 0.25rem 0 0.25rem 0">${angle_str}</p>`)
                            .openOn(map);

                        event.stopPropagation();
                        event.preventDefault();
                    });
                }
            },
            afterDeviceMove: (event) => {
                // Do something after the device moves.
            }
        }).addTo(map);

        //Overlay Imagem Fundo Mapa
        /*var imageUrl_bg = 'resource/ui/map/bg_map.png'
            imageBounds_bg = [[-23.3335426, -46.7266859], [-23.3378499, -46.7199262]];
            L.imageOverlay(imageUrl_bg, imageBounds_bg).addTo(map);*/
        //Overlay Imagem Mapa
        var imageUrl = 'resource/ui/map/mapv1.png'
           imageBounds = [[-23.3356483, -46.7212599], [-23.3366457, -46.722830]];
           L.imageOverlay(imageUrl, imageBounds).addTo(map);


        //Alterar ícone do Marker
        var PlantIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
            /*popupAnchor: [-3, -76],
            shadowUrl: 'ui/bg/arvore.png',
            shadowSize: [68, 95],
            shadowAnchor: [22, 94]*/
        });

        var DeadPlantIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/dead_plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
            /*popupAnchor: [-3, -76],
            shadowUrl: 'ui/bg/arvore.png',
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
        var layerControl = L.control.layers().addTo(map);
        var LayerAtivo = L.layerGroup().addTo(map);
        var LayerInativo = L.layerGroup().addTo(map);

        layerControl.addOverlay(LayerAtivo, "<span class='user-select-none' id='layerAtivo'>Ativo</span><span class='float-end'><img src='<?php echo URL.'resource/imagens/icons/plant.png'?>' height='20px'></span>");
        layerControl.addOverlay(LayerInativo, "<span class='user-select-none' id='layerAtivo'>Inativo</span><span class='float-end'><img src='<?php echo URL.'resource/imagens/icons/dead_plant.png'?>' height='20px'></span>");

        <?php
            foreach ($especies as $especie)
            {
                // Cria grupo de marcadores
                echo "\nvar MarkersAtivos$especie->IDESPECIE = [];";
                echo "\nvar MarkersInativos$especie->IDESPECIE = [];";

                foreach ($especimes as $especime)
                {   
                    // Verifica se o ID da espécie do espécime é igual ao ID da espécie
                    if($especie->IDESPECIE == $especime->IDESPECIE)
                    {
                        $especime->DATACAD = date("d/m/Y",strtotime($especime->DATACAD));
                        
                        // Cria o marcador e adiciona ao grupo de marcadores
                        if($especime->ESTADO == 1) // Ativo
                        {
                            echo "\nMarkersAtivos$especie->IDESPECIE.push(L.marker([$especime->COORD],{alt: \"$especime->NOMEPOP\", icon: PlantIcon}).bindPopup('<p><a href=\"http://api.qrserver.com/v1/create-qr-code/?data=".URL."especime/$especime->IDESPECIME\" title=\"Gerar QR Code\" target=\"_blank\"><img src=\"".URL."resource/imagens/icons/qr-digitalizar.png\" style=\"width:20px;\"></a> Espécie: $especime->NOMEPOP</p><p>Status: "; echo $especime->ESTADO == 1? "<span class=\"badge text-bg-success\">Ativo</span>": "<span class=\"badge text-bg-danger\">Inativo</span></p>"; echo "<p>Data de cadastro: $especime->DATACAD</p><p>Cadastro por: $especime->NOME</p><a href=\"".URL."especimes/altera/$especime->IDESPECIME\" title=\"Alterar Espécime\"><img src=\"".URL."resource/imagens/icons/caneta-de-pena.png\" style=\"width:20px;\"></a><a href=\"".URL."especime/$especime->IDESPECIME\" class=\"float-end\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'));";
                        }
                        else // Inativo
                        {
                            echo "\nMarkersInativos$especie->IDESPECIE.push(L.marker([$especime->COORD],{alt: \"$especime->NOMEPOP\", icon: DeadPlantIcon}).bindPopup('<p><a href=\"http://api.qrserver.com/v1/create-qr-code/?data=".URL."especime/$especime->IDESPECIME\" title=\"Gerar QR Code\" target=\"_blank\"><img src=\"".URL."resource/imagens/icons/qr-digitalizar.png\" style=\"width:20px;\"></a> Espécie: $especime->NOMEPOP</p><p>Status: "; echo $especime->ESTADO == 1? "<span class=\"badge text-bg-success\">Ativo</span>": "<span class=\"badge text-bg-danger\">Inativo</span></p>"; echo "<p>Data de cadastro: $especime->DATACAD</p><p>Cadastro por: $especime->NOME</p><a href=\"".URL."especimes/altera/$especime->IDESPECIME\" title=\"Alterar Espécime\"><img src=\"".URL."resource/imagens/icons/caneta-de-pena.png\" style=\"width:20px;\"></a><a href=\"".URL."especime/$especime->IDESPECIME\" class=\"float-end\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'));";
                        }

                    }
                }
                // Cria o layerGroup agrupa os marcadores ativos e inativos e adiciona ao mapa
                echo "\nvar layer$especie->IDESPECIE = L.layerGroup(MarkersAtivos$especie->IDESPECIE).addTo(map);";
                echo "\n layer$especie->IDESPECIE.addLayer(L.layerGroup(MarkersInativos$especie->IDESPECIE));";
            
                // Adiciona os marcadores aos layers de ativos e inativos
                echo "\n LayerAtivo.addLayer(L.layerGroup(MarkersAtivos$especie->IDESPECIE));";
                echo "\n LayerInativo.addLayer(L.layerGroup(MarkersInativos$especie->IDESPECIE));";

                // Adiciona o layerGroup ao controle de camadas
                echo "\nlayerControl.addOverlay(layer$especie->IDESPECIE, \"<span class='user-select-none' id='layer$especie->IDESPECIE'>$especie->NOMEPOP</span><span class='badge text-bg-success rounded-pill float-end'>$especie->QUANT</span>\");";
            }
            ?>
    </script>
</body>
</html>
