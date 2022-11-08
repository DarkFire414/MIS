<?php
    include("conexion.php");
    session_start(); //Permmite manejar el boleta y la sesion
    if(isset($_SESSION['alumno'])){
        header('location: dashboard.php');
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
            header('location: dashboard.php');
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
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- Navigation Bar style sheet -->
        <link rel="stylesheet" href="../CSS/login_admin.css">

        <title>Login</title>
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
                            <form action="login.php" method="POST" class="h-100">
                                <h5 class="form_element">Inicie Sesión</h5>
                                <div class="form_element">
                                    <label for="boleta" class="form-label text" id="text">Número de boleta</label>
                                    <input type="number" class="bordecito form-control" name="boleta" id="boleta" placeholder="202068XXXX" required>
                                </div>
                                <div class="form_element">
                                    <label for="clave" class="form-label text">Contraseña</label>
                                    <input type="password" class="bordecito form-control" name="clave" id="password" placeholder="Ingrese su contraseña" required>
                                </div>
                                <div class="d-grid form_element">
                                    <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>