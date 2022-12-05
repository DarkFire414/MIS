<?php
    include("../conexion.php");
    session_start();
?>
<h1> Atender las solicitudes actuales de los alumnos </h1><hr>
<div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
<?php
    //Variables del tiempo
    //$dias = array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");  
    //date_default_timezone_set('America/Mexico_City');
    //$diaactual = $dias[date("w")];                
    //$horaactual = strtotime(date("H:i"));
    //echo date("H:i").",";
    //$disp = 0;
    //$labs = mysqli_query($conexion, "SELECT * FROM laboratorio");
    //$filas = $labs->num_rows; //numero de filas ed la consulta
    //$datos = $labs->fetch_assoc();
    $solicitudes = mysqli_query($conexion, "SELECT * FROM solicitudes");
    $filas = $solicitudes->num_rows;
    $datos = $solicitudes->fetch_assoc();

    if($filas>0){ //mientras haya filas que consultar
    echo ("<div class='table-responsive'><center><table class = 'tb2 table table-hover table-responsive' >
    <tr>
        <td>ID solicitud </td>
        <td>Boleta </td>
        <td>Laboratorio </td>
        <td>Estado </td>
        <td>Hora de inicio </td>
        <td>Hora de termino </td>
        <td>Motivo </td>
        <td>Fecha </td>
        <td>Conceder permiso </td>
        <td>Denegar permiso </td>
        </tr>");
        do{
            echo "<tr><td>".$datos['id_solicitud']."</td>";
            echo "<td>".$datos['boleta']."</td>";
            echo "<td>".$datos['id_labo']."</td>";
            echo "<td>".$datos['estatus']."</td>";
            echo "<td>".$datos['horainicio']."</td>";
            echo "<td>".$datos['horatermino']."</td>";
            echo "<td>".$datos['motivo']."</td>";
            echo "<td>".$datos['fecha']."</td>";
            if($datos['estatus'] == 1){
                echo "<td> <button class='btn btn btn-primary btn-block' id='".$datos['id_solicitud']."' onclick='conceder(".$datos['id_solicitud'].");'> Otorgar acceso </button></td>";
                echo "<td> <button class='btn btn btn-primary btn-block' id='".$datos['id_solicitud']."' onclick='denegar(".$datos['id_solicitud'].");'> Denegar acceso </button></td>";
            }elseif($datos['estatus'] == 2){
                echo "<td> El permiso ya fue otorgado </td>";
            }else{
                echo "<td> El permiso ya fue denegado </td>";
            }
        }while($datos=$solicitudes->fetch_assoc());
        echo ("</tr></table></center></div>");
    }else{
        echo "No hay solicitudes pendientes";
    } ?>
</div>
<script>
    function conceder(id){
        if (confirm("¿Confirmar acción de conceder acceso?")) {
                window.location = "dashboard_admin.php?conceder=" + id;
                redirect("b3");
            } else {
            }
    }
    function denegar(id){
        if (confirm("¿Confirmar acción de denegar acceso?")) {
                window.location = "dashboard_admin.php?denegar=" + id;
                redirect("b3");
            } else {
            }
    }    
</script>