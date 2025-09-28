$("#btnAltCoord").click( function()
{
    switchDragabble();
});

var isDrag = false;
var ghost = L.layerGroup();
function switchDragabble()
{
    isDrag = !isDrag;
    if(isDrag)
    {
        map.removeLayer(marker);
        map.off("click");
    }
    else
    {
        map.on("click",onMapClick);
    }

    ghost.removeFrom(map);
    ghost.clearLayers();
    
    AllMarkers.eachLayer(Marker => {
        if(!Marker.dragging.enabled())
        {
            L.marker(Marker.getLatLng(), {icon: Marker.getIcon(), draggable:false, zIndexOffset: - 100, opacity: 0.5}).addTo(ghost);
            Marker.dragging.enable();
            Marker.on("dragend",function(e){alterCoord(e);});
        }
        else
        {
            Marker.dragging.disable();
            Marker.off("dragend");
        }
    });

    ghost.addTo(map);
}

function alterCoord(event)
{
    console.log(event);

    var idEspecime = event.target.options.idespecime;
    var coord = Math.round(event.target.getLatLng().lat * 10000000) / 10000000 + ", " + Math.round(event.target.getLatLng().lng * 10000000) / 10000000;

    $.ajax({
        url: `${URI}especimes/altcoord`,
        type: 'POST',
        dataType: "JSON",
        data: {
            inputEspecime: idEspecime,
            inputCoord: coord,
        },
        success: function(result){
            console.log(result)
            console.log("Espécime movida com sucesso: ", idEspecime);
        },
        error: function(xhr, status, error) {
            console.error("Erro ao mover espécime: ", error);
        }
    });
}