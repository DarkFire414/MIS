<?php
    include("conexion.php");
    session_start();
    if(!isset($_SESSION['alumno'])){ //si no esta iniciada la sesion vamos a la pagina de inicio
        header("location:index.php");
    }
    if(isset($_REQUEST['cerrar'])){ //Cerramos sesion si se aprieta el boton
        session_destroy();
        header('location:index.php');
    }
    if(isset($_REQUEST['motivo'])){ //Si se envia el formulario de solitud de ingreso a un laboratorio hacemos el registro
        $boleta = $_SESSION['alumno'];
        $laboratorio = $_POST['labo'];
        $horaingreso = $_POST['horaentrada'];
        $horasalida = $_POST['horasalida'];
        $motivouso = $_POST['motivo'];
        date_default_timezone_set('America/Mexico_City');
        $fecha = date('Y-m-d');
        //Hacemos el registro y notificamos
        $solicitud = mysqli_query($conexion, "INSERT INTO solicitudes (id_solicitud,boleta,id_labo,estatus,horainicio,horatermino,motivo,fecha) VALUES ('',$boleta,$laboratorio,1,'$horaingreso','$horasalida','$motivouso','$fecha')");
        mysqli_query($conexion, "UPDATE estudiante SET acceso = '1' WHERE boleta = '".$_SESSION['alumno']."'"); //Actualizamos el estado de las solicitudes del estudiante.
        echo "<script> alert('Solicitud registrada con exito, será revisada y atendida a la brevedad'); </script>";
    }
    if(isset($_REQUEST['cancelar'])){ //Cancelamos la solicitud
        if(mysqli_query($conexion, "DELETE FROM solicitudes WHERE boleta='".$_SESSION['alumno']."'")){
            echo "<script> alert('Solicitud eliminada'); </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p> Usuario en sesion: </p>
    <?php 
        if(isset($_SESSION['alumno'])){ //Consultamos los datos del usuario para mostrarlos:
            $usuario = mysqli_query($conexion, "SELECT * FROM estudiante WHERE boleta='".$_SESSION['alumno']."'")->fetch_assoc();
            $nombre = $usuario['Nombre']; //nombre del usuario actual
            $laboratorio = $usuario['laboratorio']; //laboratorio donde se encuentra el alumno
            $acceso = $usuario['acceso'];
            $unidad = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT unidad FROM laboratorio WHERE id='".$laboratorio."'"))['unidad']; //Consultamos la unidad a la que pertenece el laboratorio
            //IMPRIMIMOS EL NOMBRE Y DATOS ACTUALES DEL LABORATORIO
            echo "<div> Alumno: ".$nombre."<br></br>";
            if($laboratorio != ''){
                echo ("Laboratorio donde te encuentras actualmente: ".$laboratorio."<br>");
                if($unidad=='cecyt' && $acceso=='0'){
                    echo "Para usar los laboratorios de CECyT necesitas solicitar permiso directamente con el ingeniero Abraham o en la aplicación <br></br>";
                }else{
                    echo "Acceso vigente actualemnte";
                }
            }else{
                echo "No estas usando ningun laboratorio actualmente";
            }
            echo "</div>";
        }
    ?>
    <ol>
        <li><a href="comienzo.php?consultar"> Consultar disponibilidad de laboratorios </a></li>
        <li><a href="comienzo.php?solicitar"> Solicitar acceso a un laboratorio </a></li>
        <li><a href="comienzo.php?solicitudes"> Consultar estado de la solicitud actual </a></li>
    </ol>

    <?php
        if(isset($_REQUEST['consultar'])){ ?> <!-- Se muestran todos los salones disponibles -->
            <h3>PUEDES ENTRAR A CUALQUIERA DE LOS SIGUIENTES LABORATORIOS</h3>
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
                echo ("<center><table border class = 'tb2' >
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
                        echo "<td> <button onclick='mostrarhorario(".$datos['id'].");'> Visualiza el horario </button> </td>";//El dato del horario es una imagen
                        echo "<td>".$datos['edificio']."</td>";
                        $horas = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM hlab WHERE id_labo='".$datos['id']."' AND diasemana='".$diaactual."'"))['horario'];
                        if ($horas != NULL){ //sIEMPRE QUE HAYA UNA CONSULTA COMO RESPUESTA
                            //Extraemos los datos de cada horario por separado, el formato es: 7:30-9:00,13:00-15:00 [horario inicial],[horario siguiente]
                            $horarios = explode(',',$horas); //Extraemos cada horario por separado
                            if(count($horarios) < 2){ //Para laboratorios que solo tienen una hora de uso durante el dia
                                $horainicio = strtotime(explode("-",$horas)[0]);
                                $horafin = strtotime(explode("-",$horas)[1]);
                                if($horaactual<$horainicio || $horaactual>$horafin){ //Si el laboratorio esta libre
                                    echo "<td> Horario disponible </td>";
                                    if($datos['disponibilidad']>0){ //Revisamos si hay disponibilidad
                                        echo "<td> <a href='comienzo.php?solicitar=".$datos['id']."'> Solicitar su uso </a></td>";
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
                                        echo "<td> <a href='comienzo.php?solicitar=".$datos['id']."'> Solicitar su uso </a></td>";
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
                    echo ("</table></center>");
                }else{
                    echo "No hay laboratorios registrados";
                } ?>
            <div id="horario" style='display:none;'>fdf</div> <!-- Muestra los horarios -->
            <a href="comienzo.php"> Volver </a> <br></bR>
        <?php }
        if(isset($_REQUEST['solicitar'])){  //Formulario para solicitar el acceso a un laboratorio
            $estado = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT estatus FROM solicitudes WHERE boleta = '".$_SESSION['alumno']."'"))['estatus']; 
            if($estado == 0){ ?>
            <p> Se enviara una solicitud a gestion escolar para acceder a un laboratorio de cecyt </p>
            <form action="comienzo.php" method = "POST">
                <label for="labo"> Ingresa el laboratorio que quieres solicitar: </label>
                <?php if($_REQUEST['solicitar']==NULL){ //Si se entra directamente?> 
                        <input class='bordecito' type="number" id="labo" name="labo" placeholder="[Example]: 423" max="999" autocomplete="off" required><br><br>
                <?php }else{
                        echo "<input class='bordecito' type='number' id='labo' name='labo' value='".$_REQUEST['solicitar']."' required><br><br>";
                      } ?>
                <label for="horaentrada"> Hora de inicio de uso </label>
                <input type="time" id="horaentrada" name="horaentrada" required >
                <label for="horasalida"> Hora de termino de uso </label>
                <input type="time" id="horasalida" name="horasalida" required> <br><br>
                <label for="motivo"> Describa brevemente el motivo de uso: </label>
                <input type="text" id="motivo" name="motivo" style="min-width:90%; font-size:12px;" required> <br><br>
                <input type="submit" value="Enviar"><br><br>
            </form> 
      <?php }else if($estado == 1){ ?>
                <p> Estimado estudiante, en este momento cuentas con una solicutud pendiente de respuesta, en breve te atenderemos. </p><br>
                <p> Si deseas, puedes cancelar tu solicitud haciendo clic en el <a href="comienzo.php?solicitudes"> siguiente enlace. </a></p>

      <?php }else if($estado == 2){ ?>
                <p> Actualmente cuentas con permiso para utilizar el laboratorio que solicitaste, si deseas cancelar su uso <a href="comienzo.php?solicitudes">da click aqui.</a> </p><br><br>
      <?php }else if($estado == 3){ ?>
                <p> Lamentamos los posibles inconvenientes que podamos causarle, pero actualmente no es posible asignarle el uso del laboratorio que solicito por razones academicas. </p>
      <?php }
        }
            if(isset($_REQUEST['solicitudes'])){ //Consultar estado de las solicitudes ?>
            <!-- Interpretaciones en la tabla de estudiante:
            0 -> Sin solicitud pendiente
            1 -> Solicitud pendiente
            2 -> Laboratorio asignado
            3 -> Laboratorio no asignado 

            Interpretaciones en la tabla de solicitudes:ente
            1 -> Solicitud pendiente
            2 -> Laboratorio asignado
            3 -> Laboratorio no asignado-->
      <?php $csol = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE boleta = '".$_SESSION['alumno']."'");
            $solicitudes = $csol->fetch_assoc();
                if($solicitudes != NULL){
                    echo "<center><table border class = 'tb2'>
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
                                    <td> <button onclick='confirmar();'> Cancelar solicitud </button> </td>
                                </tr>";
                    }while($solicitudes=$csol->fetch_assoc());
                        echo "</table></center>";
                }else{ ?>
                    <p> No tienes solcitudes pendientes por ahora, vuelve pronto </p>   
        <?php   }  ?>
      <?php } ?>
      <!--<button onclick='mostrarhorario("upiih");'>Ocultar horario</button>-->
        <script>
            function mostrarhorario(lab){ //Funcion que muestra la imagen de los horarios de los laboratorios
                const horario = document.getElementById('horario');
                console.log(typeof horario.style.display);
                if(horario.style.display == "none"){
                    console.log("hola");
                    horario.style.display = 'block';
                    horario.innerHTML = "<img src = 'images/"+lab+".jpg' alt='imagen del horario'>";
                }else{
                    horario.style.display = 'none';
                    horario.innerHTML = "";
                }
            }
            function confirmar(){
                if (confirm("Estas seguro de cancelar tu solicitud")) {
                    window.location = "comienzo.php?cancelar";
                } else {
                    window.location = "comienzo.php?solicitudes";
                }
            }
        </script>
    <a href='comienzo.php?cerrar=1'> Cerrar sesión </a>
</body>
</html>