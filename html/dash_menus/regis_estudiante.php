<h1>Registrar estudiante</h1><hr> 

<div id="requestList_wd" class="container border p-2 mt-2" style="border-radius: 1.0rem;">
    <!-- ------------------------------------------Formulario de registro------------------------------------------------->
    <form id="form-registra" action="dashboard_admin.php" class="h-100" method='POST'>
        <h5 class="form_element">Crear cuenta para el alumno</h5><br>
        <strong>Información personal:</strong>
        <div class="mt-2">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" pattern="[a-zA-Z\s]+" class="bordecito form-control" placeholder='Nombre completo del alumno' maxlength="50" required>
        </div>
        <select name='unidad' class="form-select mt-2" aria-label="Default select example">
            <option selected>Seleccione su unidad</option>
            <option>upiih</option>
            <option>cecyt</option>
        </select>    
        <select name='planes' class="form-select mt-2" aria-label="Default select example">
            <option selected>Seleccione su plan de estudios</option>
            <option>Mecatrónica</option>
            <option>ISISA</option>
        </select>    
        <div class="mt-2">
            <label for="sa" class="form-label">Semestre actual</label>
            <input type="number" name='sa' class="bordecito form-control" placeholder='Número actual del semestre que cursas' max="20" required>
        </div>
        <br><strong>Informacion de inicio de sesión</strong>
        <div class="mt-2">
            <label for="bole" class="form-label">Número de boleta</label>
            <input type="number" name='bole' class="bordecito form-control" placeholder="[Ejemplo]: 2020214563" max="9999999999" autocomplete="off" required>
        </div>
        <div class="mt-2">
            <label for="pass" class="form-label">Contraseña</label>
            <input type="password" name='pass' size="25" class="bordecito form-control" maxlength="20" required title="Requisitos mínimos: 6 caracteres, una mayúscula y una minúscula. Puede usar caracteres especiales (*/.}{¿'=, etc..). No use espacios en blanco." pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w\S{6,}" placeholder="Introduzca contraseña">
        </div>    
        <br><strong>Informacion de uso del sistema</strong>
        <div class="mt-2">
            <label for="rfid" class="form-label">RFID</label>
            <input type="number" name='rfid' class="bordecito form-control" placeholder="[Ejemplo]: 2020214563" max="9999999999" autocomplete="off" required>
        </div>
        <div class="mt-2 mx-auto">
            <input type="submit" value="Enviar" id="enviar" class="boton btn btn-primary">
        </div>   
    </form>
</div>