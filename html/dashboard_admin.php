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
        //REGISTRAMOS EN LA BASE DE DATOS AL NUEVO ESTUDIANTE
        $valida = mysqli_query($conexion, "SELECT * FROM estudiante WHERE boleta='".$boleta."'"); //consulta si hay alumnos con la misma boleta
        $resultadosvalida = mysqli_num_rows($valida);
        if($resultadosvalida == 1){
            echo "<script> alert('Estudiante ya registrado'); </script>";
        }else{
            $creausuario = mysqli_query($conexion, "INSERT INTO estudiante (`boleta`, `contrasena`, `Nombre`, `unidad`, `Planestudios`, `semestre`, `laboratorio`) VALUES('$boleta','$contrasena','$nombre','$unidad','$plan','$sem_act','$laboratorio')"); //Ya que todo esta validado se introduce como un nuevo alumno en la base de datos
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
                    <a class="list-group-item list-group-item-action list-group-item-light p-3 inactive" sdelement="true" id="b4" onclick="buttonId(this)"href='dashboard_admin.php?cerrar=1'>Cerrar sesión</a>
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
                <!-- Page content-->
                <div class="main p-2 container-fluid">
                    
                </div>
            </div>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="../js/dashboard.js"></script>
        <!-- JQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <!-- Main Functionality-->
        <script src="../js/sidebar_handler.js"></script>
        <script>
            redirect("b1");
        </script>
    </body>
</html>
