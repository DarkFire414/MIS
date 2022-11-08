<?php
    $conexion = mysqli_connect("localhost","root","root","clcupiih");
    mysqli_select_db($conexion, "clcupiih");
    if(!$conexion){
        echo"Conexion fallida";
    }else{

    }
?>