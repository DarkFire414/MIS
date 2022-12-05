<?php
    include("conexion.php");
    session_start(); //Permmite manejar el boleta y la sesion
    if(isset($_SESSION['admin'])){
        header('location: dashboard_admin.php');
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
                    header('location: dashboard_admin.php');
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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="../CSS/dashboard.css" rel="stylesheet">
    <script src="../js/bootstrap.bundle.min.js"></script>
    
    <!-- Navigation Bar style sheet -->
    <link rel="stylesheet" href="../CSS/login_admin.css">

    <title>Admin - Login</title>
</head>
    <body>
        <div class="main container-lg border px-4 py-1 my-5" style="border-radius: 1.0rem;">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-5 p-5 d-none d-lg-block mx-auto">
                    <img src="../img/main_logo.png" class="img">
                </div>
                <div class="col-lg-7">
                    <div class="row form_element">
                        <div class="col d-lg-none d-flex justify-content-center">
                            <img src="../img/main_logo.png" class="img">
                        </div>
                        <div class="col d-flex justify-content-center">
                            <a href="../"><img src="../img/logo.png" class="logo"></a>    
                        </div>
                        <div class="col d-flex flex-column justify-content-center">
                            <a href="../" style="color: black; text-decoration: none">
                                <h1>MIS</h1>
                                <i class="text">Make It Safe</i>
                            </a>
                        </div>
                    </div>
                    <div class="row d-flex justify-content-center">
                        <hr>
                    </div>
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="flex-grow-1">
                            <form class="ingresar h-100" id="ingresa" action="login_admin.php" method="POST">
                                <h5 class="form_element">Inicie Sesión como administrador</h5>
                                <div class="form_element">
                                    <label for="email" class="form-label text" id="text">Correo electrónico</label>
                                    <input type="email" class="form-control" name="correo" id="usuario" placeholder="Ingrese su correo: ejemplo@gmail.com" required>
                                </div>
                                <div class="form_element">
                                    <label for="pwd" class="form-label text">Contraseña</label>
                                    <input type="password" class="form-control" name="clave" id="contrasena" placeholder="Ingrese su contraseña" required>
                                </div>
                                <div class="d-grid form_element">
                                    <button type="submit" class="boton btn btn-primary btn-block" value="Enviar" id="enviar">Ingresar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>