<?php

$hostDb = "localhost";
$user = "root";
$nameDb = "clcupiih";
$key = "root";

$conection = mysqli_connect($hostDb, $user, $key, $nameDb);  // $clave, $nombreDb);
mysqli_select_db($conection, $nameDb);

//Receive data, method get
$rfid = $_GET ['rfid'];
$lab = $_GET ['lab'];
$mov = $_GET ['mov'];
$count = $_GET ['count'];
if(isset($_GET['forz'])){
    $forzamiento = $_GET['forz']; //Forz es un valor booleano que envia la ESP32
    if($forzamiento){             //true=forzamiento sobre la puerta
        $query_f = "INSERT INTO `forzamientos` (`id`,`laboratorio`,`fecha`) VALUES (NULL, '$lab', current_timestamp(2))";
        mysqli_query($conection, $query_f);
    }
}

//Message to client
//echo "  Lab: \n"; echo $lab;
//echo "  Mov: \n"; echo $mov;

$query = "INSERT INTO `movimientos` (`id`, `rfid`, `laboratorio`, `mov`, `conteo`, `fecha`) VALUES (NULL, '$rfid', '$lab', '$mov', '$count', current_timestamp(2));";
mysqli_query($conection, $query);

if ($mov == "entrada"){
    $query = "UPDATE estudiante SET laboratorio='$lab' WHERE rfid='$rfid';";
}
else{
    $query = "UPDATE estudiante SET laboratorio='' WHERE rfid='$rfid';";
}
mysqli_query($conection, $query);

mysqli_close($conection);
echo " Data received \n";
//echo $query;
//UPDATE estudiante SET laboratorio='317' WHERE rfid='87654321';
?>

