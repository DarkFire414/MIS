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

//Message to client
//echo "  Lab: \n"; echo $lab;
//echo "  Mov: \n"; echo $mov;

$query = "INSERT INTO `movimientos` (`id`, `rfid`, `laboratorio`, `mov`, `conteo`, `fecha`) VALUES (NULL, '$rfid', '$lab', '$mov', '$count', current_timestamp(2));";
mysqli_query($conection, $query);
mysqli_close($conection);
echo " Data received \n";
//echo $query;
//UPDATE estudiante SET laboratorio='317' WHERE rfid='87654321';
?>

