<?php

$hostDb = "localhost";
$user = "root";
$nameDb = "clcupiih";
$key = "root";

$conection = mysqli_connect($hostDb, $user, $key, $nameDb);  // $clave, $nombreDb);
mysqli_select_db($conection, $nameDb);

$lab = $_GET['lab'];
$query = "INSERT INTO `forzamientos` (`id`,`laboratorio`,`fecha`) VALUES (NULL, '$lab', current_timestamp(2))";

mysqli_query($conection, $query);

mysqli_close($conection);

?>