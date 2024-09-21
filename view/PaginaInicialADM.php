<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
    <style>

    #map { height: 500px; z-index: 100; cursor:pointer;}
    </style>
</head>
<body>

    
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <section class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" style="min-height: 50vh;">
                <!--Container de conteúdo-->
                <div class="col-lg-8 row" style="z-index: 2;">
                    <header class="display-1 text-center my-5">ADMINISTRADOR BIOSFERA</header>
                    <p class="text-center"><strong>Mapa interativo da flora nativa da faculdade de Tecnologia</strong></p>
                    <div class="col-xl-3">
                        <form action="<?php echo URL."especimes/cadastro"?>" method="post">
                            <button class="btn btn-warning">ADICIONAR PLANTA</button>
                            <input type="text" class="form-control" id="inputCoord" name="inputCoord" value="" placeholder="Coordenadas do marcador" onChange="criaMarkerView(this.value)";>
                        </form>
                    </div>
                    <div class="col-xl-9">
                        <div id="map"></div>
                        <p class="position-relative" style="z-index: 100;">Legenda: Mapa do entorno da instituição</p>
                    </div>
                </div>
            </section>
            <section class="container-fluid folhas2 p-3 m-0  row justify-content-center align-content-center position-relative" style="min-height: 50vh;">
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_icon.svg'?>" class="nuvem nuvem-top px-0">
                <div class="col-lg-6 mt-5" style="z-index: 2;">
                    <?php 
                        echo phpversion();
                    ?>
                </div>
            </section>
        </div>
        <?php include_once "resource/rodape.php";?>
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
        var imageUrl = 'https://blog.yurimotatech.com/wp-content/uploads/2022/02/Hello-World-Python.png',
            imageBounds = [[40.712216, -74.22655], [40.773941, -74.12544]];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);

        //Alterar ìcone do Marker
        var myIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/imagens/icons/arvore.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 15],
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
            coord = e.latlng.lat+", "+e.latlng.lng;
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
        <?php
            echo "var markerBD = [";
            foreach ($especimes as $especime)
            {
                echo "L.marker([$especime->COORD],{icon: myIcon}).addTo(map),";
            }
            echo "''];";
        ?>
    </script>
</body>
</html>