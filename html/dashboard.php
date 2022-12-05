<?php
    include("conexion.php");
    session_start();
    if(!isset($_SESSION['alumno'])){ //si no esta iniciada la sesion vamos a la pagina de inicio
        header("location:login.php");
    }
    if(isset($_REQUEST['cerrar'])){ //Cerramos sesion si se aprieta el boton
        session_destroy();
        header('location:login.php');
    }
    $solicitud = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE boleta='".$_SESSION['alumno']."'")->fetch_assoc();
    if ($solicitud == NULL){ //Siempre que el alumno no tenga registrada ninguna solicitud actualizamos su estado de uso actiual
        $actualiza = mysqli_query($conexion, "UPDATE estudiante SET acceso = 0 WHERE boleta='".$_SESSION['alumno']."'");
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
        $verifica = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE boleta = $boleta")->fetch_assoc();
        if($verifica == NULL){
            $solicitud = mysqli_query($conexion, "INSERT INTO solicitudes (id_solicitud,boleta,id_labo,estatus,horainicio,horatermino,motivo,fecha) VALUES (NULL,$boleta,$laboratorio,1,'$horaingreso','$horasalida','$motivouso','$fecha')");
            mysqli_query($conexion, "UPDATE estudiante SET acceso = '1' WHERE boleta = '".$_SESSION['alumno']."'"); //Actualizamos el estado de las solicitudes del estudiante.
            if($solicitud){
                echo "<script> alert('Solicitud registrada con exito, será revisada y atendida a la brevedad'); </script>";
            }
        }else{
            echo "<script> alert('Ya tienes solicitudes registradas, por favor dales continuidad o, si lo deseas, puedes darla de baja'); </script>";
        }
    }
    if(isset($_REQUEST['cancelar'])){ //Cancelamos la solicitud
        $sregistrada = mysqli_query($conexion, "SELECT id_labo FROM solicitudes WHERE estatus=2 AND boleta ='".$_SESSION['alumno']."'"); //solicitud registrada y con permiso
        if(mysqli_query($conexion, "DELETE FROM solicitudes WHERE boleta='".$_SESSION['alumno']."'")){
            mysqli_query($conexion, "UPDATE estudiante SET acceso=0 WHERE boleta='".$_SESSION['alumno']."'"); //de nuevo no tiene solicitudes           
            if($sregistrada){ //sumamos un lugar solo a aquellas solicitudes concedidas
                $lab_actualizar = $sregistrada->fetch_assoc();
                $dispactual = mysqli_query($conexion, "SELECT disponibilidad FROM laboratorio WHERE id='".$lab_actualizar['id_labo']."'")->fetch_assoc();
                $dispnueva = $dispactual['disponibilidad']+1;
                mysqli_query($conexion, "UPDATE laboratorio SET disponibilidad=$dispnueva WHERE id='".$lab_actualizar['id_labo']."'"); //sumamos un nuevo lugar disponible para este laboratorio
            }
            echo "<script> alert('Solicitud eliminada'); </script>";
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
        <title>MIS - Login</title>

        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../CSS/dashboard.css" rel="stylesheet" />
    </head>
    <body>
        <div class="d-flex" id="wrapper">
            <!-- Sidebar-->
            <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light"><a href="../" style="color: black; text-decoration: none"><img src="../img/logo.png" style="height: 5vh">MIS <i>Make It Safe</i></a></div>
                <div class="list-group list-group-flush">
                    <!--<a class="list-group-item list-group-item-action list-group-item-light p-3 active"   sdelement="true" id="b1" onclick="buttonId(this)" href="#!">Consultar disponibilidad y solicitar acceso</a>-->
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 active"   sdelement="true" id="b1" href="dashboard.php">Consultar disponibilidad y solicitar acceso</a>
                    <!--<a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b2" onclick="buttonId(this)"href="#!">Solicitar acceso a un laboratorio</a>-->
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b3" onclick="buttonId(this)"href="#!">Consultar estado de la solicitud actual</a>
                    
                    <button class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b5" onclick="confirmarcerrar()">Cerrar sesión</button>
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
                                <li class="nav-item"><a class="nav-link">Alumno</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
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
        <script src="../js/sidebar_handler_alumno.js"></script>
        <script>
            redirect("b1");
        </script>
        <script>
        function confirmarcerrar(){
            if (confirm("¿Deseas cerrar tu sesión?")) {
                window.location = "dashboard.php?cerrar=1"
            } else {
            }
        }
</script>
    </body>
</html>
