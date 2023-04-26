<?php

function conexion(){
    $server = "localhost";
    $user = "root";
    $pass = "Osvi7860";
    $db = "prueba_ingreso";
    
    $conexion = new mysqli($server, $user, $pass, $db);
    if ($conexion->connect_errno) {
        die("Conexion Fallida" . $conexion->connect_errno);
    } else {
        return $conexion;
    }
}
?>