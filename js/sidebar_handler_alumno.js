/*
    Generates the elements of verticar bar, depending of each user
*/
function buttonId(obj)
{
    // Identifies wich element in the sidebar was pressed
    const currentid = obj.id;
    //alert("You have pressed the button: " + currentid);
    
    var sideElements = document.querySelectorAll('[sdelement]');
    sideElements.forEach(function(sideItem){
        //console.log(sideItem.className);
        if (sideItem.id != currentid){
            sideItem.className = "list-group-item list-group-item-action list-group-item-light p-3 inactive";
        }
        else{
            sideItem.className = "list-group-item list-group-item-action list-group-item-light p-3 active";
        }
    });
    //console.log("Elements found: " + sideElements.length);
    
    redirect(currentid);
}

function redirect(sensorType)
{
    // Load the appropiate content in the div main
    switch (sensorType){
        case "b1":
            // Consultar disponibilidad
            $(".main").load("../html/dash_menus/alumno_disponibilidad.php");
            break;
        case "b2":
            // Solicitar acceso
            $(".main").load("../html/dash_menus/alumno_solicitud.php");
            break;
        case "b3":
            // Consultar solicitud
            $(".main").load("../html/dash_menus/alumno_consultar.php");
            break;
        case "b4":
            // Cerrar sesión
            
            break;
        default:
            $(".main").load("../html/dash_menus/alumno_solicitud.php?solicitar=" + sensorType);
            break;
    }
}