<h1>Consultar estado de la solicitud actual</h1><hr>         

<div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
    <!-- Interpretaciones en la tabla de estudiante:
    0 -> Sin solicitud pendiente
    1 -> Solicitud pendiente
    2 -> Laboratorio asignado
    3 -> Laboratorio no asignado 

    Interpretaciones en la tabla de solicitudes:ente
    1 -> Solicitud pendiente
    2 -> Laboratorio asignado
    3 -> Laboratorio no asignado-->
    <?php

    include("../conexion.php");
    session_start();
    
    if(isset($_REQUEST['cancelar'])){ //Cancelamos la solicitud
        if(mysqli_query($conexion, "DELETE FROM solicitudes WHERE boleta='".$_SESSION['alumno']."'")){
            echo "<script> alert('Solicitud eliminada'); </script>";
        }
    }

    $csol = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE boleta = '".$_SESSION['alumno']."'");
    $solicitudes = $csol->fetch_assoc();
        if($solicitudes != NULL){
            echo "<div class='table-responsive'><center><table border class = 'tb2 table table-hover table-responsive'>
                    <tr>
                        <td> Identificador de tu solicitud </td>
                        <td> Laboratorio solicitado </td>
                        <td> Estatus </td>
                        <td> Hora de entrada </td>
                        <td> Hora de salida </td>
                        <td> Motivo de uso </td>
                        <td> Fecha </td>
                        <td> Cancelar solicitud </td>
                    </tr>";
            do{
                echo    "<tr>
                            <td>". $solicitudes['id_solicitud'] ."</td>
                            <td>". $solicitudes['id_labo'] ."</td>";
                if($solicitudes['estatus'] == 1){
                    echo   "<td> Revision en proceso </td>";
                }else if($solicitudes['estatus'] == 2){
                    echo   "<td> Asignado </td>";
                }else if($solicitudes['estatus'] == 3){
                    echo   "<td> No asignado </td>";
                }

                echo       "<td>". $solicitudes['horainicio'] ."</td>
                            <td>". $solicitudes['horatermino'] ."</td>
                            <td>". $solicitudes['motivo'] ."</td>
                            <td>". $solicitudes['fecha'] ."</td>
                            <td> <button class='btn btn-primary btn-block' onclick='confirmar();'> Cancelar solicitud </button> </td>
                        </tr>";
            }while($solicitudes=$csol->fetch_assoc());
                echo "</table></center></div>";
        }else{ ?>
            <p> No tienes solcitudes pendientes por ahora, vuelve pronto </p>   
<?php   }  ?>
</div>

<script>
    function confirmar(){
            if (confirm("Estas seguro de cancelar tu solicitud")) {
                window.location = "dashboard.php?cancelar"
                redirect("b3");
            } else {
                window.location = "comienzo.php?solicitudes";
            }
        }
</script>