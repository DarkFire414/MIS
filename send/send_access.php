<?php
    $conexion = mysqli_connect("localhost","root","root","clcupiih");
    mysqli_select_db($conexion, "clcupiih");

    $laboratorio = number_format($_GET['lab']);

    if(!$conexion){
        echo"Conexion fallida";
    }else{
    }

    $bol = mysqli_query($conexion, "SELECT * FROM solicitudes WHERE estatus = 2 AND id_labo='".$laboratorio."'"); //solo alumnos con acceso activo
    $boletas = $bol->fetch_assoc();
    $permitidos = array();
    do{
        $estudiante = mysqli_query($conexion, "SELECT * FROM estudiante WHERE boleta = '".$boletas['boleta']."'");
        $estudiantes = $estudiante->fetch_assoc();
        $permitidos = $permitidos +     array($estudiantes['rfid']=>"acceso");
    }while($boletas=$bol->fetch_assoc());
    echo json_encode($permitidos);
    //echo $permitidos["3SAD2323"];
    mysqli_free_result($bol);
    mysqli_free_result($estudiante);
    //mysqli_close($conexion);
?>