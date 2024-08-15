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

    <?php include_once "resource/navbarControle.php";?>

    <div class="corpo h-100">
        <div class="conteudo bg-secondary h-100">
            <div class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center" style="min-height: 50vh;">
                <!--Container de conteúdo-->
                <div class="col-lg-6">
                    <div id="map"></div>
                </div>
            </div>
            <div class="container-fluid folhas2 p-3 m-0 row justify-content-center align-content-center position-relative" style="min-height: 50vh;">
                <img src="<?php echo URL.'resource/ui/bg/bg_nuvem_icon.svg'?>" class="nuvem px-0 mt-0">
                <div class="col-lg-6">
                <h1>aa</h1>
                </div>
            </div>
        </div>
        <div class="rodape bg-dark text-white h-100">
            <div class="py-4 text-center row m-0 p-0">
                <h3 class="m-0 p-0 col" id="teste_coord">RODAPÉ</h3>
            </div>
        </div>
    </div>
    <script>
        //Exibir Mapa
        var map = L.map('map').setView([40.712216, -74.22655], 21);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        //Overlay Imagem
        var imageUrl = 'https://blog.yurimotatech.com/wp-content/uploads/2022/02/Hello-World-Python.png',
            imageBounds = [[40.712216, -74.22655], [40.773941, -74.12544]];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);

        //Alterar ìcone do Marker
        var myIcon = L.icon({
            iconUrl: '<?php echo URL.'resource/ui/bg/arvore.png'?>',
            iconSize: [30, 30],
            iconAnchor: [15, 30],
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