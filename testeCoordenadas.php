<?php
    include_once "./config/config.php"; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa</title>
    <style>
        *
        {
            box-sizing: border-box;
        }
        body
        {
            margin: 0;
            width: 100vw;
            height:100vh;
        }
        /* 
        * Always set the map height explicitly to define the size of the div element
        * that contains the map. 
        */
        #map {
        height: 50%;
        width: 50%;
        }

        /* 
        * Optional: Makes the sample page fill the window. 
        */
        html,
        body {
        height: 100%;
        margin: 0;
        padding: 0;
        }
    </style>

</head>
<body>

    <div id="map"></div>
    <form>
        <input type="button" id="btn teste" value="Habilitar marcador" onclick="habilitarMarcador()">
    </form>
    
        

        <!-- prettier-ignore -->
    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "<?php echo $MapsAPIKey;?>", v: "weekly"});
    </script>
    <script>
    
        let map;
        const margem = {norte: -23.332912, leste: -46.719139, sul: -23.338775, oeste: -46.725957};
        
        async function initMap() {
            const { Map } = await google.maps.importLibrary("maps");
            map = new Map(document.getElementById("map"), {
                //Configurações de Setup
                zoom:10,
                center: { lat: -23.335872, lng: -46.722554},

                //Algumas configurações
                mapTypeId: 'satellite',
                disableDefaultUI: false,
                zoomControl: true,
                mapTypeControl: false,
                scaleControl: true,
                streetViewControl: false,
                rotateControl: false,
                fullscreenControl: true,

                //Restrições
                restriction: { 
                    strictBounds: true,
                    latLngBounds: { //Limitar as Bordas 
                        north: margem.norte,
                        south: margem.sul,
                        east: margem.leste,
                        west: margem.oeste,
                    },
                },
            });
        }
        initMap();

        var habMarcador = null;
        function habilitarMarcador()
        {
            console.log("habilitarMarcador-Início");
            
            habMarcador = map.addListener("click", (e) => adicionarMarcador(e.latLng,map));

            console.log("habilitarMarcador-Fim");
        }
        let n = 1;
        function adicionarMarcador(coordenadas, map)
        {
            console.log("adicionarMarcador-Início");

            new google.maps.Marker({
                position: coordenadas,
                label: n.toString(),
                map: map,
            });
            google.maps.event.removeListener(habMarcador);
            n++;
            
            console.log("adicionarMarcador-Fim");
        }

    </script>  
</body>
</html>