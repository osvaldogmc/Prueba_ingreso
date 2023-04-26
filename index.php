<?php
include('./DB/Connection.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Prueba de ingreso</title>
        <meta charset="UTF-8"/>
    </head>
    <body>
        <h1>FORMULARIO DE VOTACIÓN:</h1>
        <form id="form-data" action="helpers/enviar_formulario.php" method="post" style="border-top: ridge; width: 620px; border-left: ridge;">           
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="name">Nombre y Apellido</label>
                <input type="text" id="name" name="user_name">
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="alias">Alias</label>
                <input type="text" id="alias" name="user_alias">
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="rut">RUT</label>
                <input type="text" id="rut" name="user_rut">
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="mail">Email</label>
                <input type="email" id="mail" name="user_mail">
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="region">Región</label>
                <select name="region" id="region" style="width: 177px;">
                    <option value="0" selected>Seleccionar</option>
                    <?php
                        $conexion = conexion();
                        $query = $conexion->query('select * from region;');
                        while ($valores = mysqli_fetch_array($query)) {
                            echo '<option value="'.$valores['id'].'">'.$valores['nombre'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="comuna">Comuna</label>
                <select name="comuna" id="comuna" style="width: 177px;">
                    <option value="0" selected>Seleccionar</option>
                </select>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="candidato">Candidato</label>
                <select name="candidato" style="width: 177px;" id="candidato">
                    <option value="0" selected>Seleccionar</option>
                    <?php
                        $conexion = conexion();
                        $query = $conexion->query('select * from candidato;');
                        while ($valores = mysqli_fetch_array($query)) {
                            echo '<option value="'.$valores['id'].'">'.$valores['nombre'].'</option>';
                        }
                    ?>
                </select>
            </div>
            <div style="display: flex; justify-content: space-between; margin: 1em;">
                <label for="como">Como se entero de nosotros</label>
                <div>
                    <label><input type="checkbox" id="chk-web">Web</label>
                    <label><input type="checkbox" id="chk-tv">Tv</label>
                    <label><input type="checkbox" id="chk-rrss">Redes Sociales</label>
                    <label><input type="checkbox" id="chk-amigo">Amigo</label>
                </div>
            </div>
            <br>
                <button id="btn-submit">Votar</button>
            </br>
        </form>
    </body>
</html>
<script src="./index.js"></script>
