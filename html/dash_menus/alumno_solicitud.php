<h1>Solicitar acceso a un laboratorio</h1><hr> 
<script>
            let formulario = document.getElementById("form_solicitud");
            formulario.addEventListener('submit', (event) => { //RUTINA PARA VALIDAR QUE LAS HORAS INGRESADAS SON VALIDAS
                var currentTime = new Date(); //Generamos un objeto de tiempo para el tiempo actual                
                let horai = document.getElementById("horaentrada").value;
                let horas = document.getElementById("horasalida").value;
                let horaiarreglo = horai.split(':'); //Vectores de las horas
                let horasarreglo = horas.split(':');
                let hora_inicio = new Date(); //Inicializamos los objetos de hora
                let hora_salida = new Date();
                hora_inicio.setHours(horaiarreglo[0],horaiarreglo[1],0); //Seteamos las horas junto con la fecha, esto no es importante por que la fecha es la actual
                hora_salida.setHours(horasarreglo[0],horasarreglo[1],0);
                hora_minima = new Date();
                hora_maxima = new Date();
                hora_minima.setHours('07','30',0);
                hora_maxima.setHours('18','00',0);                
                //alert(horaiarreglo[0])
                //alert(horaiarreglo[1])
                //alert(hora_inicio)
                //alert(hora_salida)
                //alert(currentTime)
                //alert(hora_minima)
                //alert(hora_maxima)
                //event.preventDefault();
                if((hora_inicio >= hora_salida)){
                    alert("Revisa las horas");
                    event.preventDefault();
                }
                if(hora_inicio < currentTime){
                    alert("Tu hora de inicio ya paso");
                    event.preventDefault();
                }
                if(hora_inicio < hora_minima || hora_salida > hora_maxima){
                    alert("La hora minima de entrada es 7:30 y la maxima a las 18:00")
                    event.preventDefault();
                }
            });
        </script>
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
        <h3> Se enviara una solicitud a gestion escolar </h3>
        <form id="form_solicitud" action="dashboard.php" method = "POST" class="h-100">
            <div class="mt-2">
                <label for="labo" class="form-label">Laboratorio a solicitar:</label>
                <?php if(!isset($_REQUEST['solicitar'])){ //Si se entra directamente?> 
                    <input class='bordecito form-control' type="number" id="labo" name="labo" placeholder="[Example]: 423" max="999" autocomplete="off" required>
                <?php }else{
                        echo "<input class='bordecito form-control' type='number' disabled value='".$_REQUEST['solicitar']."' required>";                    
                        echo "<input class='bordecito form-control' type='number' id='labo' name='labo' value='".$_REQUEST['solicitar']."' style='display:none;' required>";
                    }
                ?>
            </div>
            
            <!--<div class="mt-2"> Para despues
                <label for="fecha" class="form-label"> Fecha en la que deseas utilizar el laboratorio </label>
                <input type="date" class="" id="fecha" name="fecha">
            </div> -->
            <strong>Las horas de inicio y termino deben comprenderse entre las 7:30 y las 18:00 hrs</strong>
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
            <p> Actualmente cuentas con permiso para utilizar el laboratorio que solicitaste, si deseas cancelar su uso <a id="b3" onclick="buttonId(this)"href="#!">da click aqui.</a> </p><br><br>
    <?php }else if($estado == 3){ ?>
            <p> Lamentamos los posibles inconvenientes que podamos causarle, pero actualmente no es posible asignarle el uso del laboratorio que solicito por razones academicas. </p>
    <?php } ?>
</div>