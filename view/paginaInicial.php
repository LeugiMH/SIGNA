<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
  
    <title>SIGNA</title>
    <style>

    #map { height: 500px; z-index: 100; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <section class="container-fluid folhas1 pt-3 m-0 row justify-content-center align-content-center" style="min-height: 30vh;">
                <!--Container de conteúdo-->
                <div class="col-lg-6" style="z-index: 2;">
                    <header class="display-1 text-center my-4">MAPA INTERATIVO abb</header>
                    <p class="text-center"><strong>Mapa interativo da flora nativa da faculdade de Tecnologia</strong></p>
                    <div id="map"></div>
                    <p class="position-relative" style="z-index: 100;">Legenda: Mapa do entorno da instituição</p>
                </div>
            </section>
            <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_corrected.svg'?>" class="nuvem nuvem-top px-0">
            <section class="container-fluid folhas2 p-3 m-0  row justify-content-center align-content-center position-relative">
                <div class="col-lg-6 mt-5" style="z-index: 2;">
                </div>
            </section>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <script>
        //Exibir Mapa
        // initialize the map on the "map" div with a given center and zoom
        var map = L.map('map', {
            center: [-23.33605, -46.72202],
            zoom: 19
        });
        // Tile do
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar',
            //Não mudar cinza
            maxNativeZoom: 19,
            maxZoom: 20,
            minZoom: 19,
            aattribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        map.scrollWheelZoom.disable();

        //Overlay Imagem Fundo Mapa
        var imageUrl_bg = 'resource/ui/map/bg_map.png'
            imageBounds_bg = [[-23.3335426, -46.7266859], [-23.3378499, -46.7199262]];
            L.imageOverlay(imageUrl_bg, imageBounds_bg).addTo(map);
        //Overlay Imagem Mapa
        var imageUrl = 'resource/ui/map/mapv1.png'
            imageBounds = [[-23.3356483, -46.7212599], [-23.3366457, -46.722830]];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);

        //Alterar ìcone do Marker
        var myIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
            /*popupAnchor: [-3, -76],
            shadowUrl: 'ui/bg/arvore.png',
            shadowSize: [68, 95],
            shadowAnchor: [22, 94]*/
        });

        //Exibir um marcador ao clicar
        /*function onMapClick(e) {
            popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
            L.marker(e.latlng, {icon: myIcon}).addTo(map);
            var teste = document.getElementById("teste_coord");
            teste.innerHTML = e.latlng;
        }
        map.on('click', onMapClick);*/

    </script>
    <?php include_once "resource/plugins.php";?>

    <script>
        //Exibir espécimes no mapa
        <?php
            //var_dump(date("d-m-Y"));
            //var_dump(date_diff(date_create("25-09-2024"), date_create(date("d-m-Y"))));
            echo "var markerBD = [";
            foreach ($especimes as $especime)
            {   
                $dataPlant = date("d/m/Y",strtotime($especime->DATPLANT));
                $idade = date_diff(date_create($especime->DATPLANT), date_create(date("d-m-Y")));
                echo "L.marker([$especime->COORD],{icon: myIcon}).addTo(map).bindPopup('<p>Espécie: $especime->NOMEPOP</p><p>Data de platio: $dataPlant </p><p>Idade: "; echo $idade->format("%y ano(s), %m mês(es) e %d dia(s)."); echo"</p><a href=\"".URL."especime/$especime->IDESPECIME\" title=\"Abrir Espécime\"><img src=\"".URL."resource/imagens/icons/sair-do-canto-superior-direito.png\" style=\"width:20px;\"></a>'),";
            }
            echo "''];";
        ?>
    </script>
</body>
</html>
