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
                <h2 class="text-center mb-3">Feedbacks</h2>
                <div class="col-lg-3 me-3" style="z-index: 2;">
                    <h3>ASSUNTOS</h3>
                    <?php
                        //Exibindo mensagem de erro
                        if(isset($_COOKIE["msgLista"]))
                        {echo $_COOKIE["msgLista"];}
                    ?>
                    <a href="<?php echo URL.'assuntos/cadastro';?>" class="btn btn-warning">Cadastrar</a>
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
                                <th>ID</th>
                                <th>DESCRIÇÃO</th>
                                <th>AÇÕES</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-lg-6" style="z-index: 2; background-color: red;">
                <h3>ASSUNTOS</h3>
                    <?php
                        //Exibindo mensagem de erro
                        if(isset($_COOKIE["msgF"]))
                        {echo $_COOKIE["msgF"];}
                    ?>
                    <table id="listaFeedback" class="table table-striped text-center">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>AVALIACAO</th>
                                <th>ASSUNTO</th>
                                <th>TEXTO</th>
                                <th>EMAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($feedbacks as $feedback)
                            {
                            echo "
                            <tr>
                                <td>$feedback->IDFEEDBACK</td>
                                <td>$feedback->AVALIACAO</td>
                                <td>$feedback->IDASSUNTO</td>
                                <td>$feedback->TEXTO</td>
                                <td>$feedback->EMAIL</td>
                            
                            </tr>
                            ";
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                            <th>ID</th>
                                <th>AVALIACAO</th>
                                <th>ASSUNTO</th>
                                <th>TEXTO</th>
                                <th>EMAIL</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <?php include_once "resource/plugins.php";?>
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
        var imageUrl = 'resource/ui/map/map.png'
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