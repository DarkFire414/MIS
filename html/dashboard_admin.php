<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    //PHP DE CONTROL DE SESION
    include("conexion.php");
    session_start();
    if(!isset($_SESSION['admin'])){
        header("location:login_admin.php");
    }
    if(isset($_REQUEST['cerrar'])){
        session_destroy();
        header('location:login_admin.php');
    }
    //PROCEDIMIENTO PARA REGISTRAR ALUMNOS:
    if((isset($_REQUEST['bole']) && !empty($_REQUEST['bole']))){ 
        //echo $_REQUEST['bole'];
        $nombre = $_REQUEST['nombre'];
        $contrasena = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);
        $sem_act = $_REQUEST['sa'];
        $boleta = $_REQUEST['bole'];
        $plan = $_REQUEST['planes'];
        $unidad = $_REQUEST['unidad'];
        $laboratorio = ""; //Al inicio no se encuentra en ningun laboratorio
        $RFID = $_REQUEST['rfid'];
        //REGISTRAMOS EN LA BASE DE DATOS AL NUEVO ESTUDIANTE
        $valida = mysqli_query($conexion, "SELECT * FROM estudiante WHERE boleta='".$boleta."'"); //consulta si hay alumnos con la misma boleta
        $resultadosvalida = mysqli_num_rows($valida);
        if($resultadosvalida == 1){
            echo "<script> alert('Estudiante ya registrado'); </script>";
        }else{
            $creausuario = mysqli_query($conexion, "INSERT INTO estudiante (`boleta`, `contrasena`, `Nombre`, `unidad`, `Planestudios`, `semestre`, `laboratorio`,`RFID`) VALUES('$boleta','$contrasena','$nombre','$unidad','$plan','$sem_act','$laboratorio','$RFID')"); //Ya que todo esta validado se introduce como un nuevo alumno en la base de datos
            if($creausuario){
                echo "<script> alert('Te has registrado con exito'); </script>";   
            }
            else{
                $error = mysqli_error($conexion);
                echo "<script> alert(" . $error . "); </script>";
            }
        }
        unset($_REQUEST['bole']);
        //echo $_REQUEST['bole'];
    }
    if(isset($_REQUEST['conceder'])){ //Registramos que el alumno que ya tiene permiso
        $boleta = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE id_solicitud = '".$_REQUEST['conceder']."'")->fetch_assoc();
        $nboleta = $boleta['boleta'];
        $laboratorio = $boleta['id_labo'];
        $estudianteaprobada = mysqli_query($conexion, "UPDATE estudiante SET acceso=2 WHERE boleta='".$nboleta."'");
        $solicitudaprobada = mysqli_query($conexion, "UPDATE solicitudes SET estatus=2 WHERE id_solicitud='".$_REQUEST['conceder']."'");
        $actualizadisponibilidad = mysqli_query($conexion, "UPDATE laboratorio SET disponibilidad=disponibilidad-1 WHERE id='".$laboratorio."'");
        if($estudianteaprobada && $solicitudaprobada && $actualizadisponibilidad){
            echo "<script> alert('Hecho!, se le notificará al alumno que su solicitud ha sido aprobada'); </script> ";
        }else{
            echo "<script> alert('Ha ocurrido un error, por favor intente mas tarde'); </script> ";
        }
        unset($_REQUEST['conceder']);
    }
    if(isset($_REQUEST['denegar'])){ //Registramos que el alumno que no tiene permiso
        $boleta = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE id_solicitud = '".$_REQUEST['denegar']."'")->fetch_assoc();
        $nboleta = $boleta['boleta'];
        $estudiantedenegada = mysqli_query($conexion, "UPDATE estudiante SET acceso=3 WHERE boleta='".$nboleta."'");
        $solicituddenegada = mysqli_query($conexion, "UPDATE solicitudes SET estatus=3 WHERE id_solicitud='".$_REQUEST['denegar']."'");
        if($estudiantedenegada && $solicituddenegada){
            echo "<script> alert('Hecho!, se le notificará al alumno que su solicitud ha sido denegada'); </script> ";
        }else{
            echo "<script> alert('Ha ocurrido un error, por favor intente mas tarde'); </script> ";
        }
        unset($_REQUEST['denegar']);
    }
    if(isset($_REQUEST['lab'])){ //registramos el laboratorio
        $id_lab = $_REQUEST['lab'];
        $disponibilidad = $_REQUEST['disp'];
        $edificio = $_REQUEST['edif'];
        $unidad = $_REQUEST['unidad'];
        $verifica = mysqli_query($conexion, "SELECT * FROM laboratorio WHERE id = '".$id_lab."'");
        $resultados = mysqli_num_rows($verifica);
        if($resultados == 1){
            echo "<script> alert('Este laboratorio ya ha sido registrado'); </script>";
        }else{
            $registra_laboratorio = mysqli_query($conexion,"INSERT INTO laboratorio (`id`,`disponibilidad`,`horario`,`edificio`,`unidad`) VALUES ('$id_lab','$disponibilidad','','$edificio','$unidad') ");
            $lunes = ''; //variables para almacenar los horarios
            $l1='';
            $l2='';
            $l3='';
            $l4='';
            $l5='';
            $l6='';
            $l7='';

            $martes = '';
            $ma1='';
            $ma2='';
            $ma3='';
            $ma4='';
            $ma5='';
            $ma6='';
            $ma7='';
            
            $miercoles = '';
            $mi1='';
            $mi2='';
            $mi3='';
            $mi4='';
            $mi5='';
            $mi6='';
            $mi7='';

            $jueves = '';
            $j1='';
            $j2='';
            $j3='';
            $j4='';
            $j5='';
            $j6='';
            $j7='';

            $viernes = '';
            $v1='';
            $v2='';
            $v3='';
            $v4='';
            $v5='';
            $v6='';
            $v7='';

            if(!isset($_REQUEST['l'])){ //Si existen horarios que guardar LUNES
                if(isset($_REQUEST['l1'])){ //verificamos que checkbox existen
                    $l1=$_REQUEST['l1'].",";
                }
                if(isset($_REQUEST['l2'])){ //verificamos que checkbox existen
                    $l2=$_REQUEST['l2'].",";
                }
                if(isset($_REQUEST['l3'])){ //verificamos que checkbox existen
                    $l3=$_REQUEST['l3'].",";
                }
                if(isset($_REQUEST['l4'])){ //verificamos que checkbox existen
                    $l4=$_REQUEST['l4'].",";
                }
                if(isset($_REQUEST['l5'])){ //verificamos que checkbox existen
                    $l5=$_REQUEST['l5'].",";
                }
                if(isset($_REQUEST['l6'])){ //verificamos que checkbox existen
                    $l6=$_REQUEST['l6'].",";
                }
                if(isset($_REQUEST['l7'])){ //verificamos que checkbox existen
                    $l7=$_REQUEST['l7'];
                }
            }
            if(!isset($_REQUEST['ma'])){ //MARTES
                if(isset($_REQUEST['ma1'])){ //verificamos que checkbox existen
                    $ma1=$_REQUEST['ma1'].",";
                }
                if(isset($_REQUEST['ma2'])){ //verificamos que checkbox existen
                    $ma2=$_REQUEST['ma2'].",";
                }
                if(isset($_REQUEST['ma3'])){ //verificamos que checkbox existen
                    $ma3=$_REQUEST['ma3'].",";
                }
                if(isset($_REQUEST['ma4'])){ //verificamos que checkbox existen
                    $ma4=$_REQUEST['ma4'].",";
                }
                if(isset($_REQUEST['ma5'])){ //verificamos que checkbox existen
                    $ma5=$_REQUEST['ma5'].",";
                }
                if(isset($_REQUEST['ma6'])){ //verificamos que checkbox existen
                    $ma6=$_REQUEST['ma6'].",";
                }
                if(isset($_REQUEST['ma7'])){ //verificamos que checkbox existen
                    $ma7=$_REQUEST['ma7'];
                }
            }
            if(!isset($_REQUEST['mi'])){ //MIERCOLES
                if(isset($_REQUEST['mi1'])){ //verificamos que checkbox existen
                    $mi1=$_REQUEST['mi1'].",";
                }
                if(isset($_REQUEST['mi2'])){ //verificamos que checkbox existen
                    $mi2=$_REQUEST['mi2'].",";
                }
                if(isset($_REQUEST['mi3'])){ //verificamos que checkbox existen
                    $mi3=$_REQUEST['mi3'].",";
                }
                if(isset($_REQUEST['mi4'])){ //verificamos que checkbox existen
                    $mi4=$_REQUEST['mi4'].",";
                }
                if(isset($_REQUEST['mi5'])){ //verificamos que checkbox existen
                    $mi5=$_REQUEST['mi5'].",";
                }
                if(isset($_REQUEST['mi6'])){ //verificamos que checkbox existen
                    $mi6=$_REQUEST['mi6'].",";
                }
                if(isset($_REQUEST['mi7'])){ //verificamos que checkbox existen
                    $mi7=$_REQUEST['mi7'];
                }
            }
            if(!isset($_REQUEST['j'])){ //JUEVES
                if(isset($_REQUEST['j1'])){ //verificamos que checkbox existen
                    $j1=$_REQUEST['j1'].",";
                }
                if(isset($_REQUEST['j2'])){ //verificamos que checkbox existen
                    $j2=$_REQUEST['j2'].",";
                }
                if(isset($_REQUEST['j3'])){ //verificamos que checkbox existen
                    $j3=$_REQUEST['j3'].",";
                }
                if(isset($_REQUEST['j4'])){ //verificamos que checkbox existen
                    $j4=$_REQUEST['j4'].",";
                }
                if(isset($_REQUEST['j5'])){ //verificamos que checkbox existen
                    $j5=$_REQUEST['j5'].",";
                }
                if(isset($_REQUEST['j6'])){ //verificamos que checkbox existen
                    $j6=$_REQUEST['j6'].",";
                }
                if(isset($_REQUEST['j7'])){ //verificamos que checkbox existen
                    $j7=$_REQUEST['j7'];
                }
            }        
            if(!isset($_REQUEST['v'])){ //VIERNES
                if(isset($_REQUEST['v1'])){ //verificamos que checkbox existen
                    $v1=$_REQUEST['v1'].",";
                }
                if(isset($_REQUEST['v2'])){ //verificamos que checkbox existen
                    $v2=$_REQUEST['v2'].",";
                }
                if(isset($_REQUEST['v3'])){ //verificamos que checkbox existen
                    $v3=$_REQUEST['v3'].",";
                }
                if(isset($_REQUEST['v4'])){ //verificamos que checkbox existen
                    $v4=$_REQUEST['v4'].",";
                }
                if(isset($_REQUEST['v5'])){ //verificamos que checkbox existen
                    $v5=$_REQUEST['v5'].",";
                }
                if(isset($_REQUEST['v6'])){ //verificamos que checkbox existen
                    $v6=$_REQUEST['v6'].",";
                }
                if(isset($_REQUEST['v7'])){ //verificamos que checkbox existen
                    $v7=$_REQUEST['v7'];
                }
            }              
            $lunes=$l1.$l2.$l3.$l4.$l5.$l6.$l7; //unimos todos los resultados
            $martes=$ma1.$ma2.$ma3.$ma4.$ma5.$ma6.$ma7;
            $miercoles=$mi1.$mi2.$mi3.$mi4.$mi5.$mi6.$mi7;
            $jueves=$j1.$j2.$j3.$j4.$j5.$j6.$j7;
            $viernes=$v1.$v2.$v3.$v4.$v5.$v6.$v7;
            if($lunes[strlen($lunes)-1] == ','){ //limpiamos los datos
                $lunes = substr($lunes,0,strlen($lunes)-1);
            }
            if($martes[strlen($martes)-1] == ','){
                $martes = substr($martes,0,strlen($martes)-1);
            }
            if($miercoles[strlen($miercoles)-1] == ','){
                $miercoles = substr($miercoles,0,strlen($miercoles)-1);
            }
            if($jueves[strlen($jueves)-1] == ','){
                $jueves = substr($jueves,0,strlen($jueves)-1);
            }
            if($viernes[strlen($viernes)-1] == ','){
                $viernes = substr($viernes,0,strlen($viernes)-1);
            }
            //identificadores unicos para el horario
            $id1 = "l".$id_lab;
            $id2 = "m".$id_lab;
            $id3 = "i".$id_lab;
            $id4 = "j".$id_lab;
            $id5 = "v".$id_lab;
            //INSERTAMOS LOS HORARIOS
            $r_hor1 = mysqli_query($conexion,"INSERT INTO hlab (`idl`,`id_labo`,`diasemana`,`horario`) VALUES ('$id1','$id_lab','lunes','$lunes') ");
            
            $r_hor2 = mysqli_query($conexion,"INSERT INTO hlab (`idl`,`id_labo`,`diasemana`,`horario`) VALUES ('$id2','$id_lab','martes','$martes') ");
            
            $r_hor3 = mysqli_query($conexion,"INSERT INTO hlab (`idl`,`id_labo`,`diasemana`,`horario`) VALUES ('$id3','$id_lab','miercoles','$miercoles') ");
            
            $r_hor4 = mysqli_query($conexion,"INSERT INTO hlab (`idl`,`id_labo`,`diasemana`,`horario`) VALUES ('$id4','$id_lab','jueves','$jueves') ");
            
            $r_hor5 = mysqli_query($conexion,"INSERT INTO hlab (`idl`,`id_labo`,`diasemana`,`horario`) VALUES ('$id5','$id_lab','viernes','$viernes') ");
            
            if($registra_laboratorio && $r_hor1 && $r_hor2&& $r_hor3 && $r_hor4 && $r_hor5){
                echo "<script> alert('Laboratorio registrado con exito'); </script>";
            }else{
                echo "<script> alert('Algo salio mal :('); </script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - Admin</title>

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../CSS/dashboard.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
                <div class="sidebar-heading border-bottom bg-light"><a href="../" style="color: black; text-decoration: none"><img src="../img/logo.png" style="height: 5vh">MIS <i>Make It Safe</i></a></div>
                <div class="list-group list-group-flush">
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 active"   sdelement="true" id="b1" onclick="buttonId(this)" href="#!">Registrar estudiantes</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b2" onclick="buttonId(this)"href="#!">Registrar o alterar el horario y uso de los laboratorios</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b3" onclick="buttonId(this)"href="#!">Consultar los horarios de los laboratorios</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b4" onclick="buttonId(this)"href="#!">Atiende las solicitudes actuales de los alumnos</a>
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b5" onclick="buttonId(this)"href="#!">Consulta que alumnos estan utilizando los laboratorios</a>
                    <button class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b7" onclick="confirmarcerrar()">Cerrar sesión</button>
                </div>
            </div>
            <!-- Page content wrapper-->
            <div id="page-content-wrapper">
                <!-- Top navigation-->
                <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                    <div class="container-fluid">
                        <button class="btn btn-primary" id="sidebarToggle">Menú</button>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                                <li class="nav-item active"><a class="nav-link" href="#!">Acerca de</a></li>
                                <li class="nav-item"><a class="nav-link" href="#!">Ayuda</a></li>
                                <li class="nav-item"><a class="nav-link">Administrador</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div class="container p-3 my-3 bg-danger text-white" style='display:block;'>
                    <h3>Alerta!</h3>
                    <p>Se ha detectado posible forzamiento de la cerradura en el laboratorio: <strong>317</strong></p>
                    <button type="button" class="btn btn-dark">Descartar alerta</button>
                </div>
                <!-- Page content-->
                <div class="main p-2 container-fluid">
                    
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="../js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/dashboard.js"></script>
        <!-- JQuery library -->
        <script src="../js/jquery.min.js"></script>
        <!-- Main Functionality-->
        <script src="../js/sidebar_handler.js"></script>
        <script>
            redirect("b1");
        </script>
        <script>
        function confirmarcerrar(){
            if (confirm("¿Deseas cerrar tu sesión?")) {
                window.location = "dashboard_admin.php?cerrar=1"
            } else {
            }
        }
        </script>
    </body>
</html>
