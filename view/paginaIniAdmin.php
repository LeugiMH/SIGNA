<!DOCTYPE html>
<html lang="pt-br">

<head>
    <?php include_once "resource/head.php";?>
    <title>SIGNA</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css"
        integrity="sha384-NvKbDTEnL+A8F/AA5Tc5kmMLSJHUO868P+lDtTpJIeQdGYaUIuLr4lVGOEA1OcMy" crossorigin="anonymous">
    <style>
    #map {
        height: 500px;
        z-index: 100;
    }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">


    <div class="corpo h-100">
        <?php include_once "resource/navbarControle.php";?>
        <div class="conteudo bg-secondary h-100 clouds">
            <!--Container de conteúdo-->
            <div class="container-fluid folhas1 pt-5 m-0 row justify-content-center align-content-center"
                >
                <h1 class="display-1 text-center my-2 mb-5">Administrador Biosfera</h1>

                <!-- Espécies -->
                <div class="col-lg-4" style="z-index: 2;">
                    <h3 class="text-center mb-3">Plantas Registradas</h3>
                    <div class="bg-verde p-3 rounded-4 text-white" style="height:90%">
                        <!-- Tabela -->
                        <button type="button" class="btn btn-success btn-floating" data-mdb-ripple-init
                            data-mdb-ripple-color="dark">
                            <i class="fas fa-plus"></i>
                        </button>
                        <div class="table-responsive" style="height:100%">
                            <table id="tabela-especimes" class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th style='width:10%'>ID</th>
                                        <th style='width:70%'>Espécie</th>
                                        <th style='width:20%'></th>
                                        <!--<th>Estado</th>
                                        <th>Coord</th>
                                        <th>DAP</th>
                                        <th>Imagem</th>
                                        <th>DescImg</th>
                                        <th>Cadastro</th>
                                        <th>Admin</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach($plantas as $planta)
                                    {
                                    /*echo "
                                    <tr>
                                        <td>$planta->IDESPECIME</td>
                                        <td>$planta->NOMEPOP</td>
                                        <td>$planta->ESTADO</td>
                                        <td>$planta->COORD</td>
                                        <td>$planta->DAP</td>
                                        <td>$planta->IMAGEM</td>
                                        <td>$planta->DESCRICAOIMG</td>
                                        <td>$planta->DATACAD</td>                               
                                        <td>$planta->NOMEADMIN</td>                               
                                    </tr>
                                    ";*/
                                    echo "
                                    <tr>
                                        <td>$planta->IDESPECIME</td>
                                        <td>$planta->NOMEPOP</td>
                                        <td>
                                            <a type='button' class='btn m-0 p-0'>
                                                <i class='fas fa-plus'></i>
                                            </a>
                                            <a type='button' class='btn m-0 p-0'>
                                                <i class='fas fa-plus'></i>
                                            </a> 
                                            <a type='button' class='btn m-0 p-0'>
                                                <i class='fas fa-plus'></i>
                                            </a> 
                                        </td>   
                                                                  
                                    </tr>
                                    ";

                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Espécie</th>
                                        <th></th>
                                        <!--<th>Estado</th>
                                        <th>Coord</th>
                                        <th>DAP</th>
                                        <th>Imagem</th>
                                        <th>DescImg</th>
                                        <th>Cadastro</th>
                                        <th>Admin</th>-->

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- Botões -->

                    </div>
                </div>

                <!-- Mapa -->
                <div class="col-lg-8" style="z-index: 2;">
                    <h3 class="text-center mb-3">Mapa interativo da flora nativa da faculdade de Tecnologia</h3>

                    <div id="map"></div>
                    <p class="position-relative" style="z-index: 100;">Legenda: Mapa do entorno da instituição</p>
                </div>
            </div>

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
        zoom: 20
    });
    // Tile do
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png?{foo}', {
        foo: 'bar',
        maxZoom: 19,
        aattribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    map.scrollWheelZoom.disable();

    //Overlay Imagem
    var imageUrl = 'resource/ui/mapa.webp',
        imageBounds = [
            [40.712216, -74.22655],
            [40.773941, -74.12544]
        ];
    L.imageOverlay(imageUrl, imageBounds).addTo(map);

    //Alterar ìcone do Marker
    var myIcon = L.icon({
        iconUrl: '<?php echo URL.'resource/ui/favicon.png'?>',
        iconSize: [30, 30],
        iconAnchor: [15, 30],
        /*popupAnchor: [-3, -76],
        shadowUrl: 'ui\bg\arvore.png',
        shadowSize: [68, 95],
        shadowAnchor: [22, 94]*/
    });

    //Exibir um marcador ao clicar
    /*function onMapClick(e) {
        /*popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
        L.marker(e.latlng, {
            icon: myIcon
        }).addTo(map);
        var teste = document.getElementById("teste_coord");
        teste.innerHTML = e.latlng;
    }
    map.on('click', onMapClick);*/
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.bootstrap5.js"></script>
    <script>
    $(document).ready(function() {
        $('#tabela-especimes').DataTable({
            language: {
                url: "<?php echo URL.'resource/json/pt_br.json';?>"
            }
        });
    });
    </script>
</body>

</html>
