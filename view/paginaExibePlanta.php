<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <?php include_once "resource/headLeaflet.php";?>

    <title>SIGNA - <?php echo $planta->NOMEPOP;?></title>
    <style>
    #map { height: 400px; z-index: 100; cursor:default;}
    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="corpo min-vh-100 h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <div class="container-fluid folhas p-0 m-0 row justify-content-center align-content-center position-relative h-100">
                <section class="col-sm-10 col-lg-8 col-xl-6 p-0 my-5" style="z-index: 2;">
                    <div id="map" class="m-3 mb-5"></div>
                    <!-- Conteúdo -->
                    <header class="display-1 text-center mb-3 text-break"><?php echo $planta->NOMEPOP;?></header>
                    <h2 class="text-center mb-5"><?php echo $planta->NOMECIE;?></h2>
                    <article class="bg-verde p-3 p-lg-5 rounded-4 text-white ">
                        <div class="row m-0 mb-md-3">
                            <div class="col-md-6 p-0 mb-3 mb-md-0">
                                <figure class="figure imgview1">
                                    <img src="<?php echo isset($planta->IMGESPECIE) && file_exists("resource/imagens/especies/$planta->IMGESPECIE")? URL."resource/imagens/especies/$planta->IMGESPECIE" : URL."resource/sem_imagem.jpg";?>" aria-label="<?php echo "$planta->DESCESPECIE";?>" alt="<?php echo "$planta->DESCESPECIE";?>" class="w-100 rounded">
                                    <figcaption class="figure-caption text-white">Imagem de exemplo da espécie.</figcaption>
                                </figure>
                            </div>
                            <div class="col-md-6 p-0">
                                <p><strong><?php echo "Diâmetro na altura do peito (m):</strong> "; echo $planta->DAP == null  ? "Não mensurado" : number_format($planta->DAP, 2, ',', '.'); ?></p>
                                <hr>
                                <p><strong><?php echo "Data de plantio:</strong> ".date("d/m/Y",strtotime($planta->DATPLANT));?></p>
                                <hr>
                                <h4>Último manejo</h4>
                                <?php 
                                if(empty($manejos))
                                    echo "Sem registro";
                                foreach ($manejos as $manejo)
                                    {
                                        echo "<hr></hr><p><strong>$manejo->TIPOMANEJO: </strong>$manejo->DATAMANEJO</p>";
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="row m-0">
                            <div class="col-md-6 p-0">
                                <p><strong><?php echo "Família:</strong> $planta->FAMILIA";?></p>
                                <hr>
                                <p><strong><?php echo "Habitat natural:</strong> $planta->HABITAT";?></p>
                                <hr>
                                <?php $estadosConservação = [0 => 'Extinto', 1 => 'Extinto na natureza', 2 => 'Criticamente em perigo', 3 => 'Em perigo', 4 => 'Vulnerável', 5 => 'Quase ameaçado', 6 => 'Pouco preocupante', 7 => 'Dados Deficientes', 8 => 'Não avaliada'];?>
                                <p><strong><?php echo "Estado de conservação:</strong> ".$estadosConservação[$planta->CONSERV];?></p>
                                <hr>
                                <p><strong><?php echo "Altura máxima:</strong> ".number_format($planta->ALTURA, 2, ',', '.')." metro(s)";?></p>
                                <?php
                                    foreach ($atributos as $atributo)
                                    {
                                        echo "<hr><p><strong>$atributo->NOMEATRIBUTO:</strong> $atributo->DESCRICAO</p>";
                                    }
                                ?>
                            </div>
                            <div class="col-md-6 p-0">
                                <figure class="figure imgview2">
                                    <img src="<?php echo isset($planta->IMGESPECIME) && file_exists("resource/imagens/especimes/$planta->IMGESPECIME") ? URL."resource/imagens/especimes/$planta->IMGESPECIME" : URL."resource/sem_imagem.jpg" ;?>" aria-label="<?php echo "$planta->DESCESPECIME";?>" class=" w-100 figure-img img-fluid rounded" alt="<?php echo "$planta->DESCESPECIME";?>">
                                    <figcaption class="figure-caption text-end text-white">Imagem da planta na instituição.</figcaption>
                                </figure>
                                <!--<img src="<?php echo URL."resource/imagens/especimes/$planta->IMGESPECIME";?>" aria-label="<?php echo "$planta->DESCESPECIME";?>" alt="Imagem da espécie" class="w-100 rounded imgview2">-->
                            </div>
                        </div>
                    </article>
                </section>
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_completo.svg'?>" class="nuvem nuvem-mid p-0" alt="Imagem plano de fundo de núvem" style="z-index: 0!important;">
            </div>
        </div>
        <?php include_once "resource/footerControle.php";?>
    </div>
    <script>
        //Exibir Mapa
        // initialize the map on the "map" div with a given center and zoom
        var map = L.map('map', {
            center: [<?php echo $planta->COORD;?>],
            zoom: 19,
            maxBounds: [[-23.3374978, -46.724504], [-23.3345129, -46.7191953]],
            zoomControl: false
        });
        // Tile do
        var tile = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar',
            //Não mudar cinza
            maxNativeZoom: 19,
            maxZoom: 20,
            minZoom: 19
        }).addTo(map);

        map.scrollWheelZoom.disable();
        map.dragging.disable();
        map.doubleClickZoom.disable();
        map.boxZoom.disable();
        map.keyboard.disable();
        map.touchZoom.disable();

        //Overlay Imagem Fundo Mapa
        var imageUrl_bg = '<?php echo URL.'resource/ui/map/bg_map.png'?>';
        var imageBounds_bg = [[-23.3335426, -46.7266859], [-23.3378499, -46.7199262]];
        var bgOverlay = L.imageOverlay(imageUrl_bg, imageBounds_bg)/*.addTo(map)*/;

        //Overlay Imagem Mapa
        var imageUrl = '<?php echo URL.'resource/ui/map/mapv2_usu.png'?>';
        var imageBounds = [[-23.335573, -46.721265], [-23.336502, -46.722828]];
        var overlay = L.imageOverlay(imageUrl, imageBounds).addTo(map);

        //Alterar ìcone do Marker
        var PlantIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/plant.png'?>',
            iconSize: [40, 40],
            iconAnchor: [20, 40],
            alt: 'Marcador'
            /*popupAnchor: [-3, -76],
            shadowUrl: 'ui/bg/arvore.png',
            shadowSize: [68, 95],
            shadowAnchor: [22, 94]*/
        });

        <?php echo "L.marker([$planta->COORD],{alt: \"$planta->NOMEPOP\", icon: PlantIcon, title: \"$planta->NOMEPOP\"}).addTo(map);"; ?>
    </script>
    <?php include_once "resource/plugins.php";?>
</body>
</html>