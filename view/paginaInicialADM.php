<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <?php include_once "resource/headDataTables.php";?>
    <?php include_once "resource/headLeaflet.php";?>

    <!-- Leaflet Draw -->    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/0.4.2/leaflet.draw.js"></script>

    <title>SIGNA - ADMIN</title>
    <style>

    #map { height: 600px; z-index: 100; cursor:pointer;}
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
                        <button class="btn btn-danger w-100" id="btnAltCoord" style="display: none;">Alterar posição</button>
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
                                <a href='#' type='button' data-bs-toggle='modal' data-bs-target='#CadAssuntos' data-title='Alterar Assunto' data-content='$assunto->DESCRICAO'data-selector='$assunto->IDASSUNTO'><img src='".URL."resource/imagens/icons/caneta-de-pena.png' style='width:25px;' alt='Alterar assunto'></a><div class='vr mx-2'></div>
                                <a href='".URL."assuntos/excluir/$assunto->IDASSUNTO' ><img src='".URL."resource/imagens/icons/trash.png' style='width:25px;' alt='Excluir assunto'></a>
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
                                    for($i = 1; $i <= $feedback->AVALIACAO; $i++){echo"<img src=\"".URL."resource/imagens/icons/star.png\" width=\"20px\" alt=\"Estrela\">"; }
                                    echo"</td><td>$feedback->DESCRICAO</td>
                                    <td>$feedback->TEXTO</td>
                                    <td>";echo $feedback->EMAIL != "" ? $feedback->EMAIL : "-"; echo"</td>";
                                
                                if($feedback->IDADMIN == NULL){
                                    echo "
                                        <td>
                                            <span href='#' type='button' data-bs-toggle='modal' data-bs-target='#RespFeedback'data-content='$feedback->AVALIACAO'data-selector='$feedback->IDFEEDBACK'>
                                                <img src='".URL."resource/imagens/icons/eye-open.png' style='width:25px;' alt='Visualizado' title='Visualizado'>
                                                <div class='vr mx-2'></div>
                                                <img src='".URL."resource/imagens/icons/email-send.png' style='width:25px;' alt='Responder' title='Responder'>
                                            </span>
                                        </td>
                                    </tr>
                                    ";
                                }
                                else{
                                    echo "
                                        <td>
                                            <span href='#' type='button' data-bs-toggle='modal' data-bs-target='#RespFeedback'data-content='$feedback->AVALIACAO'data-selector='$feedback->IDFEEDBACK'>
                                                <img src='".URL."resource/imagens/icons/eye-closed.png' style='width:25px;' alt='Respondido' title='Respondido'>
                                                <div class='vr mx-2'></div>
                                                <img src='".URL."resource/imagens/icons/email.png' style='width:25px;' alt='Visualizar Resposta' title='Visualizar Resposta'>
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
                                    <img src="<?php echo URL.'resource/imagens/icons/sair-do-canto-superior-direito.png'?>" style="width:20px;" alt="Ir ao Espécime">
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

        <!-- Modal Manejos-->
        <div class="modal fade text-white " id="ModalManejo" tabindex="-1" aria-labelledby="Modal Manejo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content bg-verde">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Manejo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <span>
                                <button id="btnCadManejo" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#ModalCadManejo" data-especime="">Cadastrar</button>
                            </span>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table id="listaManejos" class="table table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>DATA</th>
                                            <th>TIPO</th>
                                            <th>AÇÃO</th>
                                        </tr>
                                    </thead>
                                    <tbody id="corpoTabelaManejos">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cadastro de Manejos-->
        <div class="modal fade text-white" id="ModalCadManejo" tabindex="-1" aria-labelledby="Modal Cadastro de Manejo" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-verde">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Cadastro de manejo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formCadManejo" action="<?php echo URL.'manejo/cadastrar';?>" method="POST" class="mb-3 mt-3">
                            <input type="hidden" value="" class="form-control" id="inputEspecime" name="inputEspecime" aria-hidden="true">
                            <div class="mb-3">
                                <label for="inputTipoManejo" class="form-label">Tipo</label>
                                <select class="form-select" id="inputTipoManejo" name="inputTipoManejo" aria-label="Caixa de seleção do tipo do manejo" required>
                                    <option selected disabled value="">Tipo de Manejo</option>
                                    <option value="RG">Rega</option>
                                    <option value="PD">Poda</option>
                                    <option value="AD">Adubação</option>
                                    <option value="CP">Controle de praga</option>
                                    <option value="OT">Outro</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="inputDataManejo" class="form-label">Data do manejo</label>
                                <input type="date" value="" class="form-control" id="inputDataManejo" name="inputDataManejo" aria-label="Data do Manejo" placeholder="dd/mm/aaaa" required>
                            </div>
                            <button id="btnSubmitManejo" type="submit" class="modal-title btn btn-success float-end ms-3">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
    <?php include_once "resource/pluginsDataTables.php";?>
    <script> const URI = "<?php echo URL?>";</script>

    <script>
        //Script de inicialização personalizado da tabela
        tableAssunto = $('#listaAssunto').DataTable({
            responsive: true,
            language: {
                url: `${URI}resource/json/pt_br.json`
            },
            pageLength: 4,
            lengthChange: false,
            deferRender: false,
            order: [[0, 'asc']]
        });

        tableFeedback = $('#listaFeedback').DataTable({
            responsive: true,
            language: {
                url: `${URI}resource/json/pt_br.json`
            },
            pageLength: 4,
            lengthChange: false,
            deferRender: false,
            order: [[0, 'desc']]
        });
    </script>

    <!-- Script de Assuntos -->
    <script src="<?php echo URL.'view/resource/js/assuntos.js'?>"></script>

    <!-- Script de Feedbacks -->
    <script src="<?php echo URL.'view/resource/js/feedback.js'?>"></script>

    <!-- Script de Manejos -->
    <script src="<?php echo URL.'view/resource/js/manejo.js'?>"></script>

    <!-- Script do Mapa -->
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

        // Adiciona o controle de localização
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
        /*var imageUrl = 'resource/ui/map/mapv1.png' //{Mapa antigo com coordenadas antigas}
           imageBounds = [[-23.3356483, -46.7212599], [-23.3366457, -46.722830]];
           L.imageOverlay(imageUrl, imageBounds).addTo(map);*/
        var imageUrl = 'resource/ui/map/mapv2.png'
        imageBounds = [[-23.335573, -46.721265], [-23.336502, -46.722828]];
           L.imageOverlay(imageUrl, imageBounds, { opacity: 1.0 }).addTo(map);

           /* DEBUG DO mapa
           L.marker(imageBounds[0]).addTo(map);
           L.marker(imageBounds[1]).addTo(map);*/


        //Alterar ícone do Marker
        var PlantIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
        });

        var DeadPlantIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/dead_plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
        });

        var SelectedPlantIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/Selected_plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
        });
    </script>

    <!-- Adicionar marcador ao clicar no mapa -->
    <script>
        //Declara variáveis marcador e índice
        var marker = [];

        //Exibir um marcador ao clicar
        function onMapClick(e) {

            //Remove marcador anterior
            map.removeLayer(marker);

            //Adiciona novo marcador
            marker = L.marker(e.latlng, {icon: PlantIcon}).addTo(map);

            //Elemento input
            const coordInput = document.getElementById("inputCoord");
            
            //Define valor ao input
            
            //var coord = e.latlng.lat+", "+e.latlng.lng;
            var coord = Math.round(e.latlng.lat * 10000000) / 10000000 + ", " + Math.round(e.latlng.lng * 10000000) / 10000000;
            coordInput.value = coord;
        }

        //Cria um marcador para visualização baseado na coordenada informada
        function criaMarkerView(coordTxt){
            const coordArray = coordTxt.split(", ");
            latlngObj = { latlng: {lat:coordArray[0], lng:coordArray[1]}};

            onMapClick(latlngObj);
        }

        map.on('click', onMapClick);
    </script>

    <!-- Exibir espécimes no mapa -->
    <script>
        //Exibir espécimes no mapa
        var AllMarkers = L.layerGroup().addTo(map);
        var layerControl = L.control.layers().addTo(map);
        var LayerAtivo = L.layerGroup().addTo(map);
        var LayerInativo = L.layerGroup().addTo(map);

        layerControl.addOverlay(LayerAtivo, "<span class='user-select-none' id='layerAtivo'>Ativo</span><span class='float-end'><img src='<?php echo URL.'resource/imagens/icons/plant.png'?>' height='20px' alt='Planta'></span>");
        layerControl.addOverlay(LayerInativo, "<span class='user-select-none' id='layerAtivo'>Inativo</span><span class='float-end'><img src='<?php echo URL.'resource/imagens/icons/dead_plant.png'?>' height='20px' alt='Planta morta'></span>");

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
                            echo "\nMarkersAtivos$especie->IDESPECIE.push(L.marker([$especime->COORD],{alt: \"$especime->NOMEPOP\", icon: PlantIcon, idespecime:$especime->IDESPECIME}).bindPopup('<p><a href=\"http://api.qrserver.com/v1/create-qr-code/?data=".URL."especime/$especime->IDESPECIME\" title=\"Gerar QR Code\" target=\"_blank\"><img src=\"".URL."resource/imagens/icons/qr-digitalizar.png\" style=\"width:20px;\" alt=\"Gerar QR Code\"></a> Espécie: $especime->NOMEPOP</p><p>Status: "; echo $especime->ESTADO == 1? "<span class=\"badge text-bg-success\">Ativo</span>": "<span class=\"badge text-bg-danger\">Inativo</span></p>"; echo "<p>Data de cadastro: $especime->DATACAD</p><p>Cadastro por: $especime->NOME</p><a href=\"".URL."especimes/altera/$especime->IDESPECIME\" title=\"Alterar Espécime\"><img src=\"".URL."resource/imagens/icons/caneta-de-pena.png\" style=\"width:20px;\"></a><a href=\"#\" class=\"ms-2\" title=\"Manejo\" data-bs-toggle=\"modal\" data-bs-target=\"#ModalManejo\" data-especime=\"$especime->IDESPECIME\" data-status=\"ativo\"><img src=\"".URL."resource/imagens/icons/manejo.png\" style=\"width:20px;\"\></a><a href=\"".URL."especime/$especime->IDESPECIME\" class=\"float-end\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'));";
                        }
                        else // Inativo
                        {
                            echo "\nMarkersInativos$especie->IDESPECIE.push(L.marker([$especime->COORD],{alt: \"$especime->NOMEPOP\", icon: DeadPlantIcon, idespecime:$especime->IDESPECIME}).bindPopup('<p><a href=\"http://api.qrserver.com/v1/create-qr-code/?data=".URL."especime/$especime->IDESPECIME\" title=\"Gerar QR Code\" target=\"_blank\"><img src=\"".URL."resource/imagens/icons/qr-digitalizar.png\" style=\"width:20px;\" alt=\"Gerar QR Code\"></a> Espécie: $especime->NOMEPOP</p><p>Status: "; echo $especime->ESTADO == 1? "<span class=\"badge text-bg-success\">Ativo</span>": "<span class=\"badge text-bg-danger\">Inativo</span></p>"; echo "<p>Data de cadastro: $especime->DATACAD</p><p>Cadastro por: $especime->NOME</p><a href=\"".URL."especimes/altera/$especime->IDESPECIME\" title=\"Alterar Espécime\"><img src=\"".URL."resource/imagens/icons/caneta-de-pena.png\" style=\"width:20px;\"></a><a href=\"#\" class=\"ms-2\" title=\"Manejo\" data-bs-toggle=\"modal\" data-bs-target=\"#ModalManejo\" data-especime=\"$especime->IDESPECIME\" data-status=\"inativo\"><img src=\"".URL."resource/imagens/icons/manejo.png\" style=\"width:20px;\"\></a><a href=\"".URL."especime/$especime->IDESPECIME\" class=\"float-end\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'));";
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
        // Armazena todos os marcadores em um único layerGroup
        LayerAtivo.eachLayer(function(layer) {
            layer.eachLayer(function(marker) {
                marker.addTo(AllMarkers);
            });
        });
        LayerInativo.eachLayer(function(layer) {
            layer.eachLayer(function(marker) {
                marker.addTo(AllMarkers);
            });
        });
    </script>

    <!-- Script de seleção de múltiplos marcadores -->
    <script>
        // Desenhar formas no mapa
        var selectedMarkers = [];

        var editableLayers = new L.FeatureGroup();
        map.addLayer(editableLayers);
        
        // Localização em português
        L.drawLocal.draw.toolbar.actions = {title: 'Cancelar seleção', text: 'Cancelar'};
        L.drawLocal.draw.toolbar.buttons.rectangle = 'Selecionar área.';
        L.drawLocal.draw.handlers.rectangle.tooltip.start = 'Clique e arraste para selecionar área.';
        L.drawLocal.draw.handlers.simpleshape.tooltip.end = 'Solte para finalizar a seleção.';

        // Controlador de desenho
        var drawControl = new L.Control.Draw({
            draw: {
                rectangle: {
                    shapeOptions: {
                        color: '#2caed6ff',
                        weight: 3
                    }
                },
                circle: false,
                polygon: false,
                polyline: false,
                marker: false,
                circlemarker: false
            }
        });
        map.addControl(drawControl);

        // Evento ao criar uma nova forma
        map.on(L.Draw.Event.CREATED, function (e) {

            // Limpa array para armazenar os marcadores selecionados
            selectedMarkers = [];
            
            var countSelected = 0;
            var type = e.layerType,
                layer = e.layer;
            

            // Iterar entre as os marcadores do layer ativo
            LayerAtivo.eachLayer(function(MarkersAtivos) {
                // Iterar entre os marcadores
                MarkersAtivos.eachLayer(function(Markers) {

                    // Define o ícone padrão
                    Markers.setIcon(PlantIcon);

                    // Verifica se o marcador está dentro da forma desenhada
                    if (layer.getBounds().contains(Markers.getLatLng())) {
                        countSelected++;
                        Markers.setIcon(SelectedPlantIcon);
                        selectedMarkers.push(Markers.options.idespecime);
                    }
                });
            });

            if(countSelected > 0)
            {
                $("#inputEspecime").val(selectedMarkers.join(","));
                $("#ModalCadManejo").modal('show');
            }
        });
    </script>

    <!--Alterar coordenada-->
    <script src="<?php echo URL.'view/resource/js/altCoord.js'?>"></script>
    
</body>
</html>
