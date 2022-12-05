<h1>Consulte que alumnos se encuentran utilizando cada laboratorio</h1><hr>

<?php //Consultamos a la base de datos los alumnos por laboratorio
    include("../conexion.php"); //incluimos la informacion para acceder a la base
    session_start(); //mantenemos la sesion iniciada
    $lab = mysqli_query($conexion, "SELECT * FROM laboratorio");
    $laboratorios = $lab->fetch_assoc();
    if($laboratorios != NULL){ //si existen registros, entonces:
        do{ //Imprime una tabla para cada laboratorio registrado
            echo "<div class='table-responsive'><center><table border class = 'tb2 table table-hover table-responsive' style='text-align: center;'>
                        <tr>
                            <th colspan = '7'> Alumnos usando actualmente el laboratorio: ".$laboratorios['id']." </th>
                        </tr>
                        <tr>
                            <td> Boleta </td>
                            <td> Nombre del alumno </td>
                            <td> Unidad </td>
                            <td> Plan de estudios </td>
                            <td> Semestre </td>
                            <td> Acceso </td>
                            <td> En uso/No en uso </td>
                        </tr>"; //acceso mencionará "En uso" ó "Con permiso pero sin uso"
            $permitidos =  mysqli_query($conexion, "SELECT * FROM solicitudes WHERE id_labo = '".$laboratorios['id']."' AND estatus = 2");
            $boletas = $permitidos-> fetch_assoc(); //Solo solicitudes aprobadas correspondientes al laboratorio
            do{
                $al = mysqli_query($conexion, "SELECT * FROM estudiante WHERE boleta = '".$boletas['boleta']."'"); //estudiantes que estan usando el laboratorio
                $alumnos = $al->fetch_assoc();
                if($alumnos != NULL){ //si hay alumnos, los ponemos en la tabla
                    echo"<tr>
                            <td>". $alumnos['boleta'] ."</td>
                            <td>". $alumnos['Nombre'] ."</td>
                            <td>". $alumnos['unidad'] ."</td>
                            <td>". $alumnos['Planestudios'] ."</td>
                            <td>". $alumnos['semestre'] ."</td>
                            <td> Acceso válido </td>";

                    if($alumnos['laboratorio'] != NULL){
                        echo"<td> En uso </td>";
                    }else{
                        echo"<td> No en uso </td>";
                    }
                    echo"</tr>";
                }else{
                    echo"<tr>
                            <td> No hay alumnos utilizando actualmente este laboratorio </td>
                        </tr>";
                }
            }while($boletas = $permitidos-> fetch_assoc());
            echo "</table></center></div>";
        }while($laboratorios = $lab->fetch_assoc());
    }else{ ?>
        <p>No hay laboratorios existentes en el sistema</p>
<?php }
?>