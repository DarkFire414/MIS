<?php

$hostDb = "localhost";
$user = "root";
$nameDb = "test";
$key = "root";

$conection = mysqli_connect($hostDb, $user, $key, $nameDb);  // $clave, $nombreDb);
mysqli_select_db($conection, $nameDb);

//Receive data, method post
$lab = $_GET ['lab'];
$mov = $_GET ['mov'];

//Message to client
echo "  Lab: \n"; echo $lab;
echo "  Mov: \n"; echo $mov;

$query = "INSERT INTO `movimientos` (`id`, `laboratorio`, `movimiento`, `fecha`) VALUES (NULL, '$lab', '$mov', current_timestamp(2));";
mysqli_query($conection, $query);
mysqli_close($conection);
echo " Data received \n";
echo $query;
?>