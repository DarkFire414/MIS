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
function redirectmodificar(lab){
    $(".main").load("../html/dash_menus/ra_horario.php?id=" + lab);
}
function redirect(sensorType)
{
    // Load the appropiate content in the div main
    switch (sensorType){
        case "b1":
            // Registrar estudiante
            $(".main").load("../html/dash_menus/regis_estudiante.php");
            break;
        case "b2":
            // Registrar o alterar horario
            $(".main").load("../html/dash_menus/ra_horario.php");
            break;
        case "b3":
            // Consultar horarios
            $(".main").load("../html/dash_menus/consu_horario.php");
            break;
        case "b4":
            $(".main").load("../html/dash_menus/atiendesolicitudes.php");
            break;
        case "b5":
            $(".main").load("../html/dash_menus/uso_alumnos.php");
                break;
        case "b6":
            $(".main").load("../html/dash_menus/uso_alumnos.php");
                break;
        case "b7":
            // Cerrar sesión
            
            break;
        default:
            $(".main").load("../html/dash_menus/regis_estudiante.php");
            break;
    }
}