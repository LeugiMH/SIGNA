<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
    <style>

    #map { height: 500px; z-index: 100; }
    </style>
</head>
<body>

    
    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100">
            <div class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" style="min-height: 50vh;">
                <!--Container de conteúdo-->
                <div class="col-lg-6" style="z-index: 2;">
                    <h1 class="display-1 text-center my-5">MAPA INTERATIVO</h1>
                    <p class="text-center"><strong>Mapa interativo da flora nativa da faculdade de Tecnologia</strong></p>
                    <div id="map"></div>
                    <p class="position-relative" style="z-index: 100;">Legenda: Mapa do entorno da instituição</p>
                </div>
            </div>
            <div class="container-fluid folhas2 p-3 m-0  row justify-content-center align-content-center position-relative" style="min-height: 50vh;">
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_icon.svg'?>" class="nuvem nuvem-top px-0 mt-0">
                <div class="col-lg-6 mt-5" style="z-index: 2;">
                    <?php 
                        echo phpversion();
                    ?>
                </div>
            </div>
        </div>
        <?php include_once "resource/rodape.php";?>
    </div>
    <script>
        //Exibir Mapa
        // initialize the map on the "map" div with a given center and zoom
        var map = L.map('map', {
            center: [-23.33605, -46.72202],
            zoom: 20
        });
        // Tile do
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {foo: 'bar',
            //Não mudar cinza
            maxNativeZoom: 19,
            maxZoom: 20,
            minZoom: 20,
            aattribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        //Overlay Imagem
        /*var imageUrl = 'https://blog.yurimotatech.com/wp-content/uploads/2022/02/Hello-World-Python.png',
            imageBounds = [[-23.335673, -46.722682], [-23.336424, -46.721539]];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);*/

        //Alterar ìcone do Marker
        var myIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/ui/bg/plant.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
            alt: 'Marcador'
            /*popupAnchor: [-3, -76],
            shadowUrl: 'ui\bg\arvore.png',
            shadowSize: [68, 95],
            shadowAnchor: [22, 94]*/
        });

        //Exibir um marcador ao clicar
        function onMapClick(e) {
            /*popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);*/
            L.marker(e.latlng, {icon: myIcon}).addTo(map);
            var teste = document.getElementById("teste_coord");
            teste.innerHTML = e.latlng;
        }
        map.on('click', onMapClick);

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>