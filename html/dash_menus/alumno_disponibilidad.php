<h1>Consultar disponibilidad</h1><hr> 

<?php
    include("../conexion.php");
    session_start();
?>

<div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
    <?php 
        if(isset($_SESSION['alumno'])){ //Consultamos los datos del usuario para mostrarlos:
            $usuario = mysqli_query($conexion, "SELECT * FROM estudiante WHERE boleta='".$_SESSION['alumno']."'")->fetch_assoc();
            $nombre = $usuario['Nombre']; //nombre del usuario actual
            $laboratorio = $usuario['laboratorio']; //laboratorio donde se encuentra el alumno
            $acceso = $usuario['acceso'];
            $unidad_temp = mysqli_query($conexion, "SELECT unidad FROM laboratorio WHERE id='".$laboratorio."'")->fetch_assoc(); //Consultamos la unidad a la que pertenece el laboratorio
            if(isset($unidad_temp['unidad'])){
                $unidad = $unidad_temp['unidad'];
            }
            //IMPRIMIMOS EL NOMBRE Y DATOS ACTUALES DEL LABORATORIO
            echo "<div> Alumno: ".$nombre."<br></br>";
            if($laboratorio != ''){
                echo ("Laboratorio donde te encuentras actualmente: ".$laboratorio."<br>");
                if($unidad=='cecyt' && $acceso=='0'){
                    echo "Para usar los laboratorios de CECyT necesitas solicitar permiso directamente con el ingeniero Abraham o en la aplicación <br></br>";
                }else{
                    echo "Acceso vigente";
                }
            }else{
                echo "No estas usando ningun laboratorio actualmente";
            }
            echo "</div>";
        }
    ?>
</div>

<div class="row d-flex justify-content-center align-items-center">
    <!--col-12 for less than md-->
    <div class="col-12 col-md-6">
        <div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
            <h2>Laboratorios disponibles</h2><hr>
                <?php //CONSULTAMOS QUE LABORATORIOS ESTAN DISPONIBLES A LA HORA ACTUAL:
                    //Variables del tiempo
                    $dias = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado");  
                    date_default_timezone_set('America/Mexico_City');
                    $diaactual = $dias[date("w")];                
                    $horaactual = strtotime(date("H:i"));
                    $disp = 0;
                    //Datos del laboratorio
                    //$labs = mysqli_query($conexion, "SELECT * FROM laboratorio WHERE unidad = 'upiih'");
                    $labs = mysqli_query($conexion, "SELECT * FROM laboratorio");
                    $filas = $labs->num_rows; //numero de filas ed la consulta
                    $datos = $labs->fetch_assoc();

                    if($filas>0){ //mientras haya filas que consultar
                    echo ("<div class='table-responsive'><center><table border class = 'tb2 table table-hover table-responsive' >
                    <tr>
                        <td>Laboratorio</td>
                        <td>Lugares disponibles</td>
                        <td>Horario</td>
                        <td>Edificio</td>
                        <td>Disponibilidad de horario</td>
                        <td>Solicitar su uso</td>
                        </tr>");
                        do{
                            echo "<tr><td>".$datos['id']."</td>";
                            echo "<td>".$datos['disponibilidad']."</td>";
                            echo "<td> <button class='btn btn-primary btn-block' onclick='mostrarhorario(".$datos['id'].");'> Ver Horario </button> </td>";//El dato del horario es una imagen
                            echo "<td>".$datos['edificio']."</td>";
                            $horas = "";
                            $horas_temp = mysqli_query($conexion, "SELECT * FROM hlab WHERE id_labo='".$datos['id']."' AND diasemana='".$diaactual."'")->fetch_assoc();
                            if(isset($horas_temp['horario'])){
                                $horas = $horas_temp['horario'];
                            }
                            if ($horas != NULL){ //sIEMPRE QUE HAYA UNA CONSULTA COMO RESPUESTA
                                //Extraemos los datos de cada horario por separado, el formato es: 7:30-9:00,13:00-15:00 [horario inicial],[horario siguiente]
                                $horarios = explode(',',$horas); //Extraemos cada horario por separado
                                if(count($horarios) < 2){ //Para laboratorios que solo tienen una hora de uso durante el dia
                                    $horainicio = strtotime(explode("-",$horas)[0]);
                                    $horafin = strtotime(explode("-",$horas)[1]);
                                    if($horaactual<$horainicio || $horaactual>$horafin){ //Si el laboratorio esta libre
                                        echo "<td> Horario disponible </td>";
                                        if($datos['disponibilidad']>0){ //Revisamos si hay disponibilidad
                                            echo "<td> <button class='btn btn btn-primary btn-block' id='".$datos['id']."' onclick='buttonId(this)'> Solicitar su uso </button></td>";
                                        }else{
                                            echo "<td> N/A solicitud </td>";    
                                        }
                                    }else{
                                        echo "<td> Horario no disponible </td>";
                                        echo "<td> N/A solicitud </td>";
                                    }
                                }else{ //Para laboratorios que tienen varias horas de uso durante el dia
                                    for ($i=0;$i<count($horarios);$i++){
                                        $horainicio = strtotime(explode("-",$horarios[$i])[0]);
                                        $horafin = strtotime(explode("-",$horarios[$i])[1]);
                                        if($horaactual>$horainicio && $horaactual<$horafin){ //Si el laboratorio esta libre
                                            $disp++;
                                        }
                                    }
                                    if($disp==0){ //esta desocupado
                                        echo "<td> Horario disponible </td>";
                                        if($datos['disponibilidad']>0){ //Revisamos si hay disponibilidad
                                            echo "<td> <button class='btn btn btn-primary btn-block' id='".$datos['id']."' onclick='buttonId(this)'> Solicitar su uso </button></td>";
                                        }else{
                                            echo "<td> N/A solicitud </td>";    
                                        }
                                    }else{ //Esta ocupado
                                        echo "<td> Horario no disponible </td>";
                                        echo "<td> N/A solicitud </td>";
                                    }
                                }
                            }else{
                                echo "<td> Sin informacion disponible por el momento </td>";
                                echo "<td> N/A solicitud </td>";
                            }
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

<!--<button onclick='mostrarhorario("upiih");'>Ocultar horario</button>-->
<script>
    function mostrarhorario(lab){ //Funcion que muestra la imagen de los horarios de los laboratorios
        const horario = document.getElementById('horario');
        const container_horario = document.getElementById('horario_wd');
        console.log(typeof horario.style.display);
        if(horario.style.display == "none"){
            console.log("hola");
            horario.style.display = 'block';
            container_horario.style.display = 'block';
            horario.innerHTML = "<img src = '../img_horarios/"+lab+".jpg' alt='imagen del horario' class='img-fluid'>";
        }else{
            horario.style.display = 'none';
            container_horario.style.display = 'none';
            horario.innerHTML = "";
        }
    }
</script>