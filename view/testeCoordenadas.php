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

            // Colocando a imagem no mapa
            // Definindo posição do mapa
            //-23.335590, -46.722704
            //-23.336609, -46.721262
            const bounds = new google.maps.LatLngBounds(
                new google.maps.LatLng(-23.335590, -46.722704),
                new google.maps.LatLng(-23.336609, -46.721262)
            );
            // The photograph is courtesy of the U.S. Geological Survey.
            let image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/talkeetna.png";

            console.log(bounds);
            /**
             * The custom USGSOverlay object contains the USGS image,
             * the bounds of the image, and a reference to the map.
             */
            class USGSOverlay extends google.maps.OverlayView {
                bounds;
                image;
                div;
                constructor(bounds, image) {
                super();
                this.bounds = bounds;
                this.image = image;
                }
                /**
                 * onAdd is called when the map's panes are ready and the overlay has been
                 * added to the map.
                 */
                onAdd() {
                this.div = document.createElement("div");
                this.div.style.borderStyle = "none";
                this.div.style.borderWidth = "0px";
                this.div.style.position = "absolute";

                // Create the img element and attach it to the div.
                const img = document.createElement("img");

                img.src = this.image;
                img.style.width = "100%";
                img.style.height = "100%";
                img.style.position = "absolute";
                this.div.appendChild(img);

                // Add the element to the "overlayLayer" pane.
                const panes = this.getPanes();

                panes.overlayLayer.appendChild(this.div);
                }
                draw() {
                // We use the south-west and north-east
                // coordinates of the overlay to peg it to the correct position and size.
                // To do this, we need to retrieve the projection from the overlay.
                const overlayProjection = this.getProjection();
                // Retrieve the south-west and north-east coordinates of this overlay
                // in LatLngs and convert them to pixel coordinates.
                // We'll use these coordinates to resize the div.
                const sw = overlayProjection.fromLatLngToDivPixel(
                    this.bounds.getSouthWest()
                );
                const ne = overlayProjection.fromLatLngToDivPixel(
                    this.bounds.getNorthEast()
                );

                // Resize the image's div to fit the indicated dimensions.
                if (this.div) {
                    this.div.style.left = sw.x + "px";
                    this.div.style.top = ne.y + "px";
                    this.div.style.width = ne.x - sw.x + "px";
                    this.div.style.height = sw.y - ne.y + "px";
                }
                }
                /**
                 * The onRemove() method will be called automatically from the API if
                 * we ever set the overlay's map property to 'null'.
                 */
                onRemove() {
                if (this.div) {
                    this.div.parentNode.removeChild(this.div);
                    delete this.div;
                }
                }
                /**
                 *  Set the visibility to 'hidden' or 'visible'.
                 */
                hide() {
                if (this.div) {
                    this.div.style.visibility = "hidden";
                }
                }
                show() {
                if (this.div) {
                    this.div.style.visibility = "visible";
                }
                }
                toggle() {
                if (this.div) {
                    if (this.div.style.visibility === "hidden") {
                    this.show();
                    } else {
                    this.hide();
                    }
                }
                }
                toggleDOM(map) {
                if (this.getMap()) {
                    this.setMap(null);
                } else {
                    this.setMap(map);
                }
                }
            }
            const overlay = new USGSOverlay(bounds, image);

            overlay.setMap(map);

            const toggleButton = document.createElement("button");

            toggleButton.textContent = "Toggle";
            toggleButton.classList.add("custom-map-control-button");

            const toggleDOMButton = document.createElement("button");

            toggleDOMButton.textContent = "Toggle DOM Attachment";
            toggleDOMButton.classList.add("custom-map-control-button");
            toggleButton.addEventListener("click", () => {
            overlay.toggle();
            });
            toggleDOMButton.addEventListener("click", () => {
            overlay.toggleDOM(map);
            });
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(toggleDOMButton);
            map.controls[google.maps.ControlPosition.TOP_RIGHT].push(toggleButton);
        
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