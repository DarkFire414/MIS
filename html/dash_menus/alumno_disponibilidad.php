<h1>Consultar disponibilidad y solicitar acceso</h1><hr> 

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
            $acceso = $usuario['acceso']; //La actualizacion que el administrador le da segun el permiso consedido
            //-------CONSULTA LOS DATOS DEL ESTADO DE LA SOLICIUTUD----------------
            $solicitud = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE boleta='".$_SESSION['alumno']."'")->fetch_assoc();
            $labo_soli = $solicitud['id_labo'];
            //IMPRIMIMOS EL NOMBRE Y DATOS ACTUALES DEL LABORATORIO
            echo "<div> Alumno: ".$nombre."<br>";
                //Verificamos si el alumno esta dentro de algun laboratorio
                if($laboratorio != ''){ 
                    echo ("Actualmente estas usando el laboratorio: ".$laboratorio."<br>");
                }else{
                    echo "No estas usando ningun laboratorio actualmente <br>";
                }
                if($acceso == 2 || $acceso == 3){
                    echo "Tu solicitud ya ha sido contestada, revisa el apartado <a id='b3' onclick='buttonId(this)' href='#!'>Consultar estado de la solicitud actual</a><br>";
                }
                if($laboratorio != '' && $acceso != '2'){
                    //echo "Te rogamos usar bien el sistema de seguridad, es para nuestro bien :D <br>";
                    echo "Tu acceso no es válido, por favor abandona el laboratorio y solicitalo <br>";
                }
                //Si existe una solicitud y el alumno no esta en el laboratorio verificamos para el laboratorio de la solicitud
                if($laboratorio == NULL && $solicitud != NULL){ //no esta dentro pero lo solicitó
                    $unidad_temp = mysqli_query($conexion, "SELECT unidad FROM laboratorio WHERE id='".$labo_soli."'")->fetch_assoc(); 
                }elseif($laboratorio != NULL && $solicitud == NULL){ //esta adentro pero no lo solicitó
                    $unidad_temp = mysqli_query($conexion, "SELECT unidad FROM laboratorio WHERE id='".$laboratorio."'")->fetch_assoc(); 
                }elseif($laboratorio != NULL && $solicitud != NULL){ //esta adentro y lo solicitó
                    $unidad_temp = mysqli_query($conexion, "SELECT unidad FROM laboratorio WHERE id='".$laboratorio."'")->fetch_assoc(); 
                }
                
                if(isset($unidad_temp['unidad'])){
                    $unidad = $unidad_temp['unidad'];                                
                    if($laboratorio != NULL && $unidad=='cecyt' && ($acceso=='0' || $acceso=='1')){ //Esta adentro, es de cecyt y no solicitó o esta pendiente
                        echo "Te recordamos que para usar los laboratorios de CECyT necesitas solicitar permiso directamente con el ingeniero Abraham o en la aplicación <br>";
                    }
                    if($acceso == '2'){
                        echo "Acceso vigente";
                    }
                }
            echo "</div>";
        }
    ?>
</div>
<input type="text" id='actualiza' value="1" style="display: none;">
<div class="row d-flex justify-content-center align-items-center">
    <!--col-12 for less than md-->
    <div class="col-12 col-md-6">
        <div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
            <h2>Laboratorios disponibles</h2><hr>
                <?php //CONSULTAMOS QUE LABORATORIOS ESTAN DISPONIBLES A LA HORA ACTUAL:
                    //Variables del tiempo
                    $dias = array("domingo","lunes","martes","miercoles","jueves","viernes","sabado");  
                    date_default_timezone_set('America/Mexico_City');
                    $diaactual = $dias[date("w")];                
                    $horaactual = strtotime(date("H:i"));
                    //echo date("H:i").",";
                    $disp = 0;
                    //Datos del laboratorio
                    //$labs = mysqli_query($conexion, "SELECT * FROM laboratorio WHERE unidad = 'upiih'");
                    $labs = mysqli_query($conexion, "SELECT * FROM laboratorio");
                    $filas = $labs->num_rows; //numero de filas ed la consulta
                    $datos = $labs->fetch_assoc();
                    $solicitudactual = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE boleta='".$_SESSION['alumno']."'")->fetch_assoc();

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
                            //$diaactual = 'lunes';
                            echo "<tr><td>".$datos['id']."</td>";
                            echo "<td>".$datos['disponibilidad']."</td>";
                            echo "<td> <button class='btn btn-primary btn-block' onclick='mostrarhorario(".$datos['id'].");'> Ver Horario </button> </td>";//El dato del horario es una imagen
                            echo "<td>".$datos['edificio']."</td>";
                            $horas_temp = mysqli_query($conexion, "SELECT * FROM hlab WHERE id_labo='".$datos['id']."' AND diasemana='".$diaactual."'")->fetch_assoc();
                            if(isset($horas_temp['horario'])){
                                $horas = $horas_temp['horario'];
                            }
                            //$horas = $horas_temp['horario']; //Comenta esta linea Joahan XD 
                            if ($horas != NULL){ //sIEMPRE QUE HAYA UNA CONSULTA COMO RESPUESTA
                                //Extraemos los datos de cada horario por separado, el formato es: 7:30-9:00,13:00-15:00 [horario inicial],[horario siguiente]
                                $horarios = explode(',',$horas); //Extraemos cada horario por separado
                                if(count($horarios) < 2){ //Para laboratorios que solo tienen una hora de uso durante el dia
                                    $horainicio = strtotime(explode("-",$horas)[0]); //hora de inicio de una clase en el laboratorio
                                    $horafin = strtotime(explode("-",$horas)[1]); //hora de fin de una clase en el laboratorio
                                    if($horaactual<$horainicio || $horaactual>$horafin){ //Si el laboratorio esta libre
                                        echo "<td> Horario disponible </td>";
                                        if($datos['disponibilidad']>0 && $solicitudactual == NULL){ //Revisamos si hay disponibilidad
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
                                        if($horaactual>$horainicio && $horaactual<$horafin){ //Si el laboratorio esta ocupado
                                            $disp++;
                                        }
                                    }
                                    if($disp==0){ //esta desocupado
                                        echo "<td> Horario disponible </td>";
                                        if($datos['disponibilidad']>0 && $solicitudactual == NULL){ //Revisamos si hay disponibilidad
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
                                if($diaactual == "sabado" || $diaactual == "domingo"){ //FINES DE SEMANA NO ESTAN CONSIDERADOS
                                    echo "<td> No aplica fines de semana </td>";
                                    echo "<td> N/A solicitud </td>";
                                }else{
                                    if(gettype($horas) == "NULL"){
                                        echo "<td> Sin información disponible </td>"; //LABORATORIOS QUE NO TIENEN HORA DE USO (ESTAN LIBRES TODO EL DIA) PERO SE PUEDEN SOLICITAR
                                        echo "<td> N/A solicitud </td>";  
                                    }else{
                                        echo "<td> Horario disponible </td>"; //LABORATORIOS QUE NO TIENEN HORA DE USO (ESTAN LIBRES TODO EL DIA) PERO SE PUEDEN SOLICITAR
                                        if($datos['disponibilidad']>0 && $solicitudactual == NULL){ //Revisamos si hay disponibilidad
                                            echo "<td> <button class='btn btn btn-primary btn-block' id='".$datos['id']."' onclick='buttonId(this)'> Solicitar su uso </button></td>";
                                        }else{
                                            echo "<td> N/A solicitud </td>";    
                                        }
                                    }
                                }                                
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
<script>
    function mostrarhorario(lab){
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