<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <?php include_once "resource/headLeaflet.php";?>
  
    <title>SIGNA - Sistema de Gerenciamente do Núcleo arbóreo</title>
    <style>

    #map { height: 500px; z-index: 100; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <section class="container-fluid folhas1 pt-3 m-0 row justify-content-center align-content-center position-relative" style="min-height: 30vh;">
                <!--Container de conteúdo-->
                <div class="col-lg-6" style="z-index: 2;">
                    <header class="display-1 text-center my-4">MAPA INTERATIVO</header>
                    <p class="text-center" id="Mapa-Interativo"><strong>Mapa interativo da flora nativa da faculdade de Tecnologia</strong></p>
                    <div id="map"></div>
                    <p class="position-relative" style="z-index: 2;">Legenda: Mapa do entorno da instituição</p>
                </div>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_corrected.svg'?>" class="nuvem nuvem-bottom px-0" alt="Imagem plano de fundo de núvem" aria-hidden="true">
            </section>
            <section class="container-fluid folhas2 p-3 m-0 row justify-content-center align-content-center position-relative">
                <div class="col-10">
                    <div class="col-lg-6 mt-5 list-group list-group-flush" style="z-index: 2;">
                        <h4>Filtro de espécies</h4>
                        <?php
                            if (isset($especies))
                            {
                                foreach ($especies as $especie)
                                {
                                    echo 
                                    "<a href=\"#Mapa-Interativo\" class=\"list-group-item list-group-item-action border-0 border-bottom blur\" onClick=\"mostraEspecie(this)\" aria-id=\"$especie->IDESPECIE\" style=\"background-color: transparent;\"aria-label=\"Filtrar mapa pela espécie $especie->NOMEPOP.\">$especie->NOMEPOP".
                                    "<span class=\"badge text-bg-success rounded-pill float-end\">$especie->QUANTATIVA</span>".
                                    "</a>";
                                }
                            }
                            else
                            {
                                echo "<li class=\"list-group-item list-group-item-action\">Nenhuma Espécie encontrada</li>";
                            }
                        ?>
                    </div>
                    <div class="col-lg-6 mt-5"></div>
                </div>
            </section>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <script>
        //Exibir Mapa
        // initialize the map on the "map" div with a given center and zoom
        var map = L.map('map', {
            center: [-23.3361335, -46.722095],
            zoom: 19,
            //maxBounds: [[-23.3378499, -46.7266859], [-23.3335426, -46.7199262]]
        });
        // Tile do
        var tile = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar',
            //Não mudar cinza
            maxNativeZoom: 19,
            maxZoom: 20,
            minZoom: 19
        }).addTo(map);

        // Adiciona o controle de localização
        var mapLocate = new L.Control.SimpleLocate({
            position: "bottomleft",
            className: "button-locate",
            afterClick: (result) => {
                console.log("afterClick", result);
                if (!result.geolocation) console.log("Geolocation Error");
                if (!result.orientation) console.log("Orientation Error");
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
            /*afterDeviceMove: (event) => {
                // Do something after the device moves.
            }*/
        }).addTo(map);

        map.scrollWheelZoom.disable();

        //Overlay Imagem Fundo Mapa
        var imageUrl_bg = 'resource/ui/map/bg_map.png';
        var imageBounds_bg = [[-23.3335426, -46.7266859], [-23.3378499, -46.7199262]];
        var bgOverlay = L.imageOverlay(imageUrl_bg, imageBounds_bg).addTo(map);

        //Overlay Imagem Mapa
        var imageUrl = 'resource/ui/map/mapv1.png';
        var imageBounds = [[-23.3356483, -46.7212599], [-23.3366457, -46.722830]];
        var overlay = L.imageOverlay(imageUrl, imageBounds).addTo(map);

        //Alterar ìcone do Marker
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

    </script>
    <?php include_once "resource/plugins.php";?>
    <script>
        //Exibir grupo de marcadores no mapa
        //var layerControl = L.control.layers().addTo(map);
        var layerControl = L.control.layers();
        var allLayers = []; // Array para armazenar todos os marcadores
        <?php
            foreach ($especies as $especie)
            {
                // Cria grupo de marcadores
                echo "\nvar Makers$especie->IDESPECIE = [];";
                foreach ($especimes as $especime)
                {   
                    // Verifica se o ID da espécie do espécime é igual ao ID da espécie
                    if($especie->IDESPECIE == $especime->IDESPECIE)
                    {
                        $dataPlant = date("d/m/Y",strtotime($especime->DATPLANT));
                        $idade = date_diff(date_create($especime->DATPLANT), date_create(date("d-m-Y")));
                        
                        // Cria o marcador e adiciona ao grupo de marcadores
                        echo "\nMakers$especie->IDESPECIE.push(L.marker([$especime->COORD],{alt: \"$especime->NOMEPOP\", icon: PlantIcon,title: \"$especime->NOMEPOP\"}).bindPopup('<p>Espécie: $especime->NOMEPOP</p><p>Data de platio: $dataPlant </p><p>Idade: "; echo $idade->format("%y ano(s), %m mês(es) e %d dia(s)."); echo"</p><a href=\"".URL."especime/$especime->IDESPECIME\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'));";
                    }
                }
                // Cria o layerGroup e adiciona ao mapa
                echo "\nvar layer$especie->IDESPECIE = L.layerGroup(Makers$especie->IDESPECIE).addTo(map);";
                echo "\nallLayers.push(layer$especie->IDESPECIE);";
                // Adiciona o layerGroup ao controle de camadas
                echo "\nlayerControl.addOverlay(layer$especie->IDESPECIE, \"<span id='layer$especie->IDESPECIE'>$especie->NOMEPOP<span>\");";
            }
        ?>        
    </script>
    <script>
        function mostraEspecie(listItem)
        {
            var IdEspecie = $(listItem).attr("aria-id");
            var layerIndex = this["layer"+IdEspecie];
            // Verifica se o layer já está no mapa
            
            if(!$(listItem).hasClass("ativo"))
            {
                $(listItem).parent().children().removeClass("ativo");
                $(listItem).parent().children().prop("style", "background-color: transparent;");
                $(listItem).prop("style", "");
                $(listItem).addClass("ativo");
                map.eachLayer(function(layer) {
                    // Remove todos os layers do mapa
                    if (layer != tile && layer != bgOverlay && layer != overlay) {
                        map.removeLayer(layer);
                    }
                });
                map.addLayer(layerIndex);
            }
            else
            {
                // Exibe todas os marcadores
                $(listItem).removeClass("ativo");
                $(listItem).parent().children().prop("style", "background-color: transparent;");
                $(listItem).prop("style", "background-color: transparent;");
                allLayers.forEach(function(layer) {
                    map.addLayer(layer);
                });
            }
        }
    </script>
</body>
</html>
