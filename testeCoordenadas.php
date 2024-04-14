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

    <form action="" method="post">
        <input type="button" id="btn teste" value="Botão Teste">
    </form>
    <div id="map"></div>

        

        <!-- prettier-ignore -->
    <script>
        (g=>{var h,a,k,p="The Google Maps JavaScript API",c="google",l="importLibrary",q="__ib__",m=document,b=window;b=b[c]||(b[c]={});var d=b.maps||(b.maps={}),r=new Set,e=new URLSearchParams,u=()=>h||(h=new Promise(async(f,n)=>{await (a=m.createElement("script"));e.set("libraries",[...r]+"");for(k in g)e.set(k.replace(/[A-Z]/g,t=>"_"+t[0].toLowerCase()),g[k]);e.set("callback",c+".maps."+q);a.src=`https://maps.${c}apis.com/maps/api/js?`+e;d[q]=f;a.onerror=()=>h=n(Error(p+" could not load."));a.nonce=m.querySelector("script[nonce]")?.nonce||"";m.head.append(a)}));d[l]?console.warn(p+" only loads once. Ignoring:",g):d[l]=(f,...n)=>r.add(f)&&u().then(()=>d[l](f,...n))})
        ({key: "<?php echo $MapsAPIKey;?>", v: "weekly"});
    </script>
    <script>
        let map;
        const margem = {norte: -23.332912, leste: -46.719139, sul: -23.338775, oeste: -46.725957};
        console.log(margem.norte);
        async function initMap() {
        const { Map } = await google.maps.importLibrary("maps");

        console.log(Map);
        map = new Map(document.getElementById("map"), {
            zoom:10,
            //-23.335872, -46.722554
            center: { lat: -23.335872, lng: -46.722554},
            mapTypeId: 'satellite',
            disableDefaultUI: false,
            zoomControl: true,
            mapTypeControl: true,
            scaleControl: true,
            streetViewControl: true,
            rotateControl: true,
            fullscreenControl: true,
            //Restrições
            restriction: { 
                strictBounds: true,
                //-23.332912, -46.725957
                //-23.338775, -46.719139
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
    </script>
    
    
</body>
</html>