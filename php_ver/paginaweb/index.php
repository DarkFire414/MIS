<?php
    include("conexion.php");
    session_start(); //Permmite manejar el boleta y la sesion
    if(isset($_SESSION['alumno'])){
        header('location: comienzo.php');
    }

    //VERIFICAMOS QUE SE HAYAN INGRESADO DATOS
    if((isset($_REQUEST['boleta']) && !empty($_REQUEST['boleta']))){
        $bol = $_POST['boleta'];
        $contrasena = $_POST['clave'];

        //VERIFICACION DE LA INFORMACION DE INGRESO
        $infouser=mysqli_query($conexion,"SELECT * FROM estudiante WHERE boleta='$bol'");
        $verifica=mysqli_num_rows($infouser);
        $encriptada=mysqli_fetch_assoc($infouser)['Contrasena'];

        //Saber si esta registrado
        if($verifica==1 && password_verify($contrasena,$encriptada)){
            $_SESSION['alumno']=$bol;
            header('location: comienzo.php');
        }else{
            if($verifica==1){
                echo"<script> alert('Tu contraseña es incorrecta'); </script>";
            }else{
                echo"<script> alert('No estas registrado aun'); </script>";
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
    <title>Sistema de entradas y salidas</title>
</head>
<body>
    <img class="imagenlogo" src="images/upiih.jpg" width=200px height=100px alt="logo upiih">
    <form class='ingresar' style="width:43%;" id="ingresa" action="index.php" method='POST'>
        <h3> INGRESA AL SISTEMA DE ADMINISTRACION DE LABORATORIOS DE COMPUTO DE LA UPIIH </h3><br>
        Por favor ingresa con tu numero y boleta que te han sido brindados por subdirección académica <br><br>

        Número de boleta: <br><br>
        <input class='bordecito' type="number" name="boleta" id="boleta" placeholder="nickname@gmail.com" required><br><br>
        Contraseña: <br><br>
        <input class="bordecito" type="password" name="clave" id="password" placeholder="Password [A-a-1]" required><br><br>

        <input class="boton" style='width: 12%;' type="submit" value="Enviar" id="enviar"><br><br>

    </form>
</body>
</html>