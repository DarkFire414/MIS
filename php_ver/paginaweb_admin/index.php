<?php
    include("conexion.php");
    session_start(); //Permmite manejar el boleta y la sesion
    if(isset($_SESSION['admin'])){
        header('location: comienzo.php');
    }

    //VERIFICAMOS QUE SE HAYAN INGRESADO DATOS
    if((isset($_REQUEST['correo']) && !empty($_REQUEST['correo']))){
        //Validamos que la boleta este correctamnete ingresada
        $usuario = $_POST['correo'];
        $contrasena = $_POST['clave'];
        $correo_arroba = explode("@", $usuario); //división por arrobas
        if(count($correo_arroba) > 1){
            $correo_punto = explode(".", $correo_arroba[1]); //Decomponemos despues del array
            
            if(count($correo_punto)<=3 && !empty($correo_punto[0]) && !empty($correo_punto[1]) && !empty($correo_arroba[0])){   //VERIFICAMOS LA ESTRUCTURA DEL CORREO ELECTRONICO

                //CONSULTA DE LA INFORMACION DE INGRESO
                $infouser=mysqli_query($conexion,"SELECT * FROM administrador WHERE correo='$usuario'");
                $verifica=mysqli_num_rows($infouser);
                $encriptada=mysqli_fetch_assoc($infouser)['contrasena'];
                
                //Saber si esta registrado
                //if($verifica==1 && password_verify($contrasena,$encriptada)){
                if($verifica==1 && ($encriptada == $contrasena)){
                    $_SESSION['admin']=$usuario;
                    header('location: comienzo.php');
                }else{
                    if($verifica==1){
                        echo"<script> alert('Tu contraseña es incorrecta'); </script>";
                    }else{
                        echo"<script> alert('No estas registrado aun'); </script>";
                    }
                }
            }else{
                echo "<script> alert('Correo inválido'); </script>";
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
        Ingresa con tu correo electrónico y contraseña <br><br>

        Correo electronico: <br><br>
        <input class='bordecito' type="email" name="correo" id="usuario" placeholder="nickname@gmail.com" required><br><br>
        Contraseña: <br><br>
        <input class="bordecito" type="password" name="clave" id="contrasena" placeholder="Password [A-a-1]" required><br><br>

        <input class="boton" style='width: 12%;' type="submit" value="Enviar" id="enviar"><br><br>

    </form>
</body>
</html>