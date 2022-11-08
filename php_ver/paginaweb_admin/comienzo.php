<?php //PHP DE CONTROL DE SESION
    include("conexion.php");
    session_start();
    if(!isset($_SESSION['admin'])){
        header("location:index.php");
    }
    if(isset($_REQUEST['cerrar'])){
        session_destroy();
        header('location:index.php');
    }
    //PROCEDIMIENTO PARA REGISTRAR ALUMNOS:
    if((isset($_REQUEST['bole']) && !empty($_REQUEST['bole']))){ 
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
            $creausuario = mysqli_query($conexion, "INSERT INTO estudiante VALUES('$boleta','$contrasena','$nombre','$unidad','$plan','$sem_act','$laboratorio')"); //Ya que todo esta validado se introduce como un nuevo alumno en la base de datos
            if($creausuario){
                echo "<script> alert('Te has registrado con exito'); </script>";    
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Inicio</title>
</head>
<body>
    <center><h1> Sistema de administración de los laboratorios de la UPIIH </h1></center>
    <h2>Las opiones de administrador son las siguientes:</h2>

    <ol>
        <li> <a href="comienzo.php?regis_estudiante=1"> Registrar estudiantes </a>
        <li> <a href="comienzo.php?ra_horario=1"> Registrar o alterar el horario y uso de los laboratorios </a>
        <li> <a href="comienzo.php?consu_horario=1"> Consultar los horarios de los laboratorios </a>
    </ol>

    <?php
        if(isset($_REQUEST['regis_estudiante'])){ ?>
            <!-- ------------------------------------------Formulario de registro------------------------------------------------->
            <form class='registrar' id="form-registra" action="comienzo.php" method='POST'>
                <h3 style='font-size: 30px; font-family: '>CREAR CUENTA PARA EL ALUMNO</h3><br><br>
                <strong>Información personal:</strong> <br><br>
                    Nombre*             <input class='bordecito' type="text" name="nombre" pattern="[a-zA-Z\s]+" placeholder='Nombre completo del alumno' maxlength="50" required><br><br>
                    Unidad*:            <SELECT name='unidad'>
                                            <OPTION> upiih </OPTION>
                                            <option> cecyt </option>
                                        </SELECT><br><br>
                    
                    Plan de estudios*:  <SELECT name='planes'>
                                            <OPTION> Mecatrónica </OPTION>
                                            <OPTION> ISISA </OPTION>
                                        </SELECT><br><br>

		            Semestre actual*:   <input class='bordecito' type="number" name='sa' placeholder='Número actual del semestre que cursas' max="20" required><br><br>
                    <br><strong> Informacion de inicio de sesión </strong><br><br>

                    Número de boleta* <br><input class='bordecito' type="number" name="bole" placeholder="[Example]: 2020214563" max="9999999999" autocomplete="off" required><br><br>
                    Contraseña* <input class='bordecito' type="password" name="pass" size="25" maxlength="20" required title="Requisitos mínimos: 6 caracteres, una mayúscula y una minúscula. Puede usar caracteres especiales (*/.}{¿'=, etc..). No use espacios en blanco." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w\S{6,}" placeholder="Introduzca contraseña"><br><br>
                    <br><input class='boton' style='width: 12%;' type="submit" value="Enviar" id="enviar"><br><br>
            </form>
            <a href="comienzo.php"> VOLVER A LAS OPCIONES DE ADMINISTRADOR</a>
            
        <?php }

        if(isset($_REQUEST['ra_horario'])){ ?>
            <!-- -------------------------Formulario para modificar los horarios de los laboratorios -->
            <h3>REGISTRA O MODIFICA LOS HORARIOS Y OCUPABILIDAD</h3>
            <a href="comienzo.php?r_horario=1">Registrar horario</a> <!--Para registrar horarios-->
            <a href="comienzo.php?a_horario=1">Alterar horario</a> <!--Alterar los horarios-->

            <!--Tabla con los datos ya registrados-->           
        <?php } ?>
        <?php
            if(isset($_REQUEST['r_horario'])){ ?>
                <h3>Registrar horario y ocupabilidad de laboratorios</h3>
                <form action="">
                    <label for="lab">Ingresa el identificador del laboratorio</label>
                    <input type="text" id="lab" placeholder="Ingresa el laboratorio">

                    </form>
        <?php } ?>  

    <a href='comienzo.php?cerrar=1'> Cerrar sesión </a>
</body>
</html>