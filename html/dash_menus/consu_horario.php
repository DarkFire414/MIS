<?php
    include("../conexion.php");
    session_start();

?>
<h1>Consultar los horarios de los laboratorios</h1><hr>     

<div class="row d-flex justify-content-center align-items-center">
    <!--col-12 for less than md-->
    <div class="col-12 col-md-6">
        <div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
            <?php
            //Variables del tiempo
            $dias = array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");  
            date_default_timezone_set('America/Mexico_City');
            $diaactual = $dias[date("w")];                
            $horaactual = strtotime(date("H:i"));
            //echo date("H:i").",";
            $disp = 0;
            $labs = mysqli_query($conexion, "SELECT * FROM laboratorio");
            $filas = $labs->num_rows; //numero de filas ed la consulta
            $datos = $labs->fetch_assoc();
            echo "<input type='text' id='actualiza' value='1' style='display: none;'>";
            if($filas>0){ //mientras haya filas que consultar
            echo ("<div class='table-responsive'><center><table class = 'tb2 table table-hover table-responsive' >
            <tr>
                <td>Laboratorio</td>
                <td>Lugares disponibles</td>
                <td>Horario</td>
                <td>Edificio</td>
                <td>Alterar datos</td>
                </tr>");
                do{
                    echo "<tr><td>".$datos['id']."</td>";
                    echo "<td>".$datos['disponibilidad']."</td>";
                    echo "<td> <button class='btn btn-primary btn-block' onclick='mostrarhorario(".$datos['id'].");'> Ver Horario </button> </td>";//El dato del horario es una imagen
                    echo "<td>".$datos['edificio']."</td>";
                    echo "<td> <a class='btn btn-primary btn-block' onclick='redirectmodificar(".$datos['id'].")' href='#!'> Modificar información </button> </td>";
                }while($datos=$labs->fetch_assoc());
                echo ("</table></center></div>");
            }else{
                echo "No hay laboratorios registrados";
            } ?>
            
        </div>
    </div>

    <div id="horario_wd" style='display:none;' class="col-12 col-md-6">
        <div class="container border p-2 mt-2" style="border-radius: 1.0rem;">
            <h2>Horario asignado</h2><hr>
            <div id="horario" style='display:none;'>fdf</div> <!-- Muestra los horarios -->
        </div>
    </div>
</div>

<script>
    function mostrarhorario(lab){ //Funcion que muestra la imagen de los horarios de los laboratorios
        const horario = document.getElementById('horario'); //contenedores
        const container_horario = document.getElementById('horario_wd');
        const actualiza = document.getElementById('actualiza');
        if(lab == actualiza.value || actualiza.value == "1"){
            actualiza.value = lab;
            if(horario.style.display == "none"){
                horario.style.display = 'block';
                container_horario.style.display = 'block';
                horario.innerHTML = "<img src = '../img_horarios/"+lab+".jpg' alt='imagen del horario' class='img-fluid'>";
            }else{
                horario.style.display = 'none';
                container_horario.style.display = 'none';
                horario.innerHTML = "";
                actualiza.value = "1";
            }
        }else{
            if(horario.style.display == "block"){
                actualiza.value = lab;
                horario.innerHTML = "";
                horario.innerHTML = "<img src = '../img_horarios/"+lab+".jpg' alt='imagen del horario' class='img-fluid'>";
            }else{

            }
        }
    }
</script>