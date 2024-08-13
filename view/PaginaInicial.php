<!DOCTYPE html>
<html lang="pt-br">
<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
    <style>

    #map { height: 1000px; }
    </style>
</head>
<body>

    <?php include_once "resource/navbarControle.php";?>

    <div class="corpo h-100">
        <div class="conteudo bg-secondary">
            <div class="container-fluid p-0 folhas min-vh-100">
                <!--Container de conteúdo-->

                <div class="bg-light">
                    <h1>aa</h1>
                </div>
                <div id="map"></div>
                
            </div>
        </div>
        <div class="rodape bg-dark text-white row m-0">
            <div class="col py-4 text-center">
                <h3 class="m-0" id="teste">RODAPÉ</h3>
            </div>
        </div>
    </div>
    <script>
        var map = L.map('map').setView([40.712216, -74.22655], 21);
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

//Overlay GNOMO
        var imageUrl = 'https://blog.yurimotatech.com/wp-content/uploads/2022/02/Hello-World-Python.png',
            imageBounds = [[40.712216, -74.22655], [40.773941, -74.12544]];
            L.imageOverlay(imageUrl, imageBounds).addTo(map);

            var myIcon = L.icon({
                iconUrl: 'ui/bg/arvore.png',
                iconSize: [38, 95],
                iconAnchor: [22, 94],
                popupAnchor: [-3, -76],
                shadowUrl: 'ui\bg\arvore.png',
                shadowSize: [68, 95],
                shadowAnchor: [22, 94]
            });

        function onMapClick(e) {
            /*popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);*/
            L.marker(e.latlng, {icon: myIcon}).addTo(map);
            var teste = document.getElementById("teste");
            teste.innerHTML = e.latlng;
        }

map.on('click', onMapClick);

    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>