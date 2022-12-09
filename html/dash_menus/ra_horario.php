<h1>Registra o modifica los horarios y ocupabilidad</h1><hr>  

<select name="RoM" id="RoM" class="form-select mt-2" onchange='cambia();'>
    <option value="Registrar">Registrar nuevo horario</option>
    <option value="Modificar">Modificar un horario ya registrado</option>
</select> 
<div id="modificarhorario" class="container border p-2 mt-2" style="border-radius: 1.0rem; display:none;">
    <p>versiones futuras</p>
</div>
<div id="registrarlaboratorio" class="container border p-2 mt-2" style="border-radius: 1.0rem; display:block;">
<!-- -------------------------Formulario para modificar los horarios de los laboratorios -->
<!--Tabla con los datos ya registrados-->
    <form id="horario_labo"  action="dashboard_admin.php" method = "POST" class="h-100">
        <h5 class="form_element">Registrar horario y ocupabilidad de laboratorios</h5><br>
        <div class="mt-2">
            <strong>Información para la identificación del laboratorio</strong>
            <div class="mt-2">
                <label for="lab" class="form-label">Ingresa el identificador del laboratorio</label>
                <input type="number" name="lab" id="lab" class="form-control" placeholder="Ingresa el laboratorio [Ejemplo: 310]" required>
            </div>
            <div class="mt-2">
                <label for="disp" class="form-label">Ingresa la disponiblidad del laboratorio</label>
                <input type="number" name="disp" id="dips" class="form-control" placeholder="Ingrese disponibilidad [Ejemplo: 40]" required>
            </div>
            <div class="mt-2">
                <label for="">Ingrese en que edificio se encuentra el laboratorio</label>
                <input type="number" name="edif" id="edif" class="form-control" placeholder="Edificio []Ejemplo: 3]" required>
            </div>
            <div class="mt-2">
                <label for="">Seleccione la unidad a la que pertenece</label>
                <select name="unidad" id="unidad">
                    <option value="upiih">UPIIH</option>
                    <option value="cecyt">CECyT</option>
                </select>
            </div>
            <div class='table-responsive'>
            <table class = 'tb2 table table-hover table-responsive' style='text-align: center;'>
                <tr>
                    <th colspan="9" style='text-align: center;'>INFORMACIÓN DEL HORARIO DE USO</th>
                </tr>    
                <tr>
                    <td>Dia semana</td>
                    <td>7:30-9:00</td>
                    <td>9:00-10:30</td>
                    <td>10:30-12:00</td>
                    <td>12:00-13:30</td>
                    <td>13:30-15:00</td>
                    <td>15:00-16:40</td>
                    <td>16:40-18:00</td>
                    <td>Desocupado todo el dia</td>
                </tr>
                <tr>
                    <td>Lunes</td>
                    <td><input type="checkbox" name="l1" id="l1" value='7:30-9:00'></td>
                    <td><input type="checkbox" name="l2" id="l2" value='9:00-10:30'></td>
                    <td><input type="checkbox" name="l3" id="l3" value='10:30-12:00'></td>
                    <td><input type="checkbox" name="l4" id="l4" value='12:00-13:30'></td>
                    <td><input type="checkbox" name="l5" id="l5" value='13:30-15:00'></td>
                    <td><input type="checkbox" name="l6" id="l6" value='15:00-16:40'></td>
                    <td><input type="checkbox" name="l7" id="l7" value='16:40-18:00'></td>
                    <td><input type="checkbox" name="l"  id="l" value='d'></td>
                </tr>    
                <tr>
                    <td>Martes</td>
                    <td><input type="checkbox" name="ma1" id="ma1" value='7:30-9:00'></td>
                    <td><input type="checkbox" name="ma2" id="ma2" value='9:00-10:30'></td>
                    <td><input type="checkbox" name="ma3" id="ma3" value='10:30-12:00'></td>
                    <td><input type="checkbox" name="ma4" id="ma4" value='12:00-13:30'></td>
                    <td><input type="checkbox" name="ma5" id="ma5" value='13:30-15:00'></td>
                    <td><input type="checkbox" name="ma6" id="ma6" value='15:00-16:40'></td>
                    <td><input type="checkbox" name="ma7" id="ma7" value='16:40-18:00'></td>
                    <td><input type="checkbox" name="ma"  id="ma" value='d'></td>
                </tr>        
                <tr>
                    <td>Miercoles</td>
                    <td><input type="checkbox" name="mi1" id="mi1" value='7:30-9:00'></td>
                    <td><input type="checkbox" name="mi2" id="mi2" value='9:00-10:30'></td>
                    <td><input type="checkbox" name="mi3" id="mi3" value='10:30-12:00'></td>
                    <td><input type="checkbox" name="mi4" id="mi4" value='12:00-13:30'></td>
                    <td><input type="checkbox" name="mi5" id="mi5" value='13:30-15:00'></td>
                    <td><input type="checkbox" name="mi6" id="mi6" value='15:00-16:40'></td>
                    <td><input type="checkbox" name="mi7" id="mi7" value='16:40-18:00'></td>
                    <td><input type="checkbox" name="mi"  id="mi" value='d'></td>
                </tr>
                <tr>
                    <td>Jueves</td>
                    <td><input type="checkbox" name="j1" id="j1" value='7:30-9:00'></td>
                    <td><input type="checkbox" name="j2" id="j2" value='9:00-10:30'></td>
                    <td><input type="checkbox" name="j3" id="j3" value='10:30-12:00'></td>
                    <td><input type="checkbox" name="j4" id="j4" value='12:00-13:30'></td>
                    <td><input type="checkbox" name="j5" id="j5" value='13:30-15:00'></td>
                    <td><input type="checkbox" name="j6" id="j6" value='15:00-16:40'></td>
                    <td><input type="checkbox" name="j7" id="j7" value='16:40-18:00'></td>
                    <td><input type="checkbox" name="j"  id="j" value='d'></td>
                </tr>
                <tr>
                    <td>Viernes</td>
                    <td><input type="checkbox" name="v1" id="v1" value='7:30-9:00'></td>
                    <td><input type="checkbox" name="v2" id="v2" value='9:00-10:30'></td>
                    <td><input type="checkbox" name="v3" id="v3" value='10:30-12:00'></td>
                    <td><input type="checkbox" name="v4" id="v4" value='12:00-13:30'></td>
                    <td><input type="checkbox" name="v5" id="v5" value='13:30-15:00'></td>
                    <td><input type="checkbox" name="v6" id="v6" value='15:00-16:40'></td>
                    <td><input type="checkbox" name="v7" id="v7" value='16:40-18:00'></td>
                    <td><input type="checkbox" name="v"  id="v" value='d'></td>
                </tr>
            </table>
            </div>
        </div>
        <button type="submit" value="Registrar" id="registrar_ra" class="boton btn btn-primary">Registrar</button>
    </form>
</div>
<script>
    let ra = document.getElementById("horario_labo");
    ra.addEventListener('submit', (event) => { //RUTINA PARA VALIDAR QUE LOS CHECK BOX ESTAN BIEN SELECCIONADOS
        let l1 = document.getElementById("l1").checked;
        let l2 = document.getElementById("l2").checked;
        let l3 = document.getElementById("l3").checked;
        let l4 = document.getElementById("l4").checked;
        let l5 = document.getElementById("l5").checked;
        let l6 = document.getElementById("l6").checked;
        let l7 = document.getElementById("l7").checked;
        let l =  document.getElementById("l").checked;
        let ma1 = document.getElementById("ma1").checked;
        let ma2 = document.getElementById("ma2").checked;
        let ma3 = document.getElementById("ma3").checked;
        let ma4 = document.getElementById("ma4").checked;
        let ma5 = document.getElementById("ma5").checked;
        let ma6 = document.getElementById("ma6").checked;
        let ma7 = document.getElementById("ma7").checked;
        let ma  = document.getElementById("ma").checked;
        let mi1 = document.getElementById("mi1").checked;
        let mi2 = document.getElementById("mi2").checked;
        let mi3 = document.getElementById("mi3").checked;
        let mi4 = document.getElementById("mi4").checked;
        let mi5 = document.getElementById("mi5").checked;
        let mi6 = document.getElementById("mi6").checked;
        let mi7 = document.getElementById("mi7").checked;
        let mi  = document.getElementById("mi").checked;
        let j1 = document.getElementById("j1").checked;
        let j2 = document.getElementById("j2").checked;
        let j3 = document.getElementById("j3").checked;
        let j4 = document.getElementById("j4").checked;
        let j5 = document.getElementById("j5").checked;
        let j6 = document.getElementById("j6").checked;
        let j7 = document.getElementById("j7").checked;
        let j  = document.getElementById("j").checked;
        let v1 = document.getElementById("v1").checked;
        let v2 = document.getElementById("v2").checked;
        let v3 = document.getElementById("v3").checked;
        let v4 = document.getElementById("v4").checked;
        let v5 = document.getElementById("v5").checked;
        let v6 = document.getElementById("v6").checked;
        let v7 = document.getElementById("v7").checked;
        let v  = document.getElementById("v").checked;
    
        if(((l1 || l2 || l3 || l4 || l5 || l6 || l7) && (l))   ||  ((ma1 || ma2 || ma3 || ma4 || ma5 || ma6 || ma7) && (ma))   ||  ((mi1 || mi2 || mi3 || mi4 || mi5 || mi6 || mi7) && (mi))   ||  ((j1 || j2 || j3 || j4 || j5 || j6 || j7) && (j))   ||  ((v1 || v2 || v3 || v4 || v5 || v6 || v7) && (v))){
            alert("Por favor, selecciona los checkbox con cuidado");
            event.preventDefault();
        }else if((!l1 && !l2 && !l3 && !l4 && !l5 && !l6 && !l7 && !l) || (!ma1 && !ma2 && !ma3 && !ma4 && !ma5 && !ma6 && !ma7 && !ma) || (!mi1 && !mi2 && !mi3 && !mi4 && !mi5 && !mi6 && !mi7 && !mi) || (!j1 && !j2 && !j3 && !j4 && !j5 && !j6 && !j7 && !j) || (!v1 && !v2 && !v3 && !v4 && !v5 && !v6 && !v7 && !v)){
            alert("Por favor, selecciona al menos una opcion de cada fila");
            event.preventDefault();
        }else{
            if (confirm("¿Registrar horario?")) {
                //se sube el formulario
            } else {
                event.preventDefault();
            }
        }
        
    });
    function cambia(){
        let regis = document.getElementById('registrarlaboratorio');
        let modif = document.getElementById('modificarhorario');
        if(regis.style.display == 'block'){
            regis.style.display = 'none';
            modif.style.display = 'block';
        }else{
            regis.style.display = 'block';
            modif.style.display = 'none';
        }
    }
</script>