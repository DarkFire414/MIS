<h1>Solicitar acceso a un laboratorio</h1><hr> 
<div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
    <?php
        include("../conexion.php");
        session_start();
        //Formulario para solicitar el acceso a un laboratorio
        $estado = 0;
        $estado_temp = mysqli_query($conexion, "SELECT estatus FROM solicitudes WHERE boleta = '".$_SESSION['alumno']."'")->fetch_assoc(); 
        if(isset($estado_temp['estatus'])){
            $estado = $estado_temp['estatus'];
        }
        if($estado == 0){ ?>
        <p> Se enviara una solicitud a gestion escolar </p>
        <form action="dashboard.php" method = "POST" class="h-100">
            <div class="mt-2">
                <label for="labo" class="form-label">Ingresa el laboratorio que quieres solicitar:</label>
                <?php if(!isset($_REQUEST['solicitar'])){ //Si se entra directamente?> 
                    <input class='bordecito form-control' type="number" id="labo" name="labo" placeholder="[Example]: 423" max="999" autocomplete="off" required>
                <?php }else{
                    echo "<input class='bordecito form-control' type='number' id='labo' name='labo' value='".$_REQUEST['solicitar']."' required>";
                    } ?>
            </div>
            <div class="mt-2">
                <label for="horaentrada" class="form-label"> Hora de inicio de uso </label>
                <input type="time" class="" id="horaentrada" name="horaentrada" required >
            </div>
            <div class="mt-2">
                <label for="horasalida" class="form-label"> Hora de termino de uso </label>
                <input type="time" id="horasalida" name="horasalida" required>
            </div>
            <div class="mt-2">
                <label for="motivo" class="form-label"> Describa brevemente el motivo de uso: </label>
                <textarea type="text" class="form-control" id="motivo" name="motivo" style="min-width:90%; font-size:12px;" required></textarea>
            </div>
            <div class="mt-2 mx-auto">
                <button type="submit" class="btn btn-primary" value="Enviar">Enviar</button>
            </div>
        </form> 
    <?php }else if($estado == 1){ ?>
            <p> Estimado estudiante, en este momento cuentas con una solicutud pendiente de respuesta, en breve te atenderemos. </p><br>
            <p> Si deseas, puedes cancelar tu solicitud llendo a la pestaña <i>Consultar estado de la solicitud actual</i></p>

    <?php }else if($estado == 2){ ?>
            <p> Actualmente cuentas con permiso para utilizar el laboratorio que solicitaste, si deseas cancelar su uso <a href="comienzo.php?solicitudes">da click aqui.</a> </p><br><br>
    <?php }else if($estado == 3){ ?>
            <p> Lamentamos los posibles inconvenientes que podamos causarle, pero actualmente no es posible asignarle el uso del laboratorio que solicito por razones academicas. </p>
    <?php } ?>
</div>