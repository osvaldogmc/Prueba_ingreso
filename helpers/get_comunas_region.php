<?php
include('../DB/Connection.php');
$conexion = conexion();
$id_region = $_POST['id'];
$query = $conexion->query('select * from comuna where id_region = '.$id_region.';');
$retorno = [];
while ($valores = mysqli_fetch_array($query)) {
    array_push($retorno,
        array(
            "id"=> $valores['id'],
            "nombre"=> $valores['nombre']
        )
    );
}


echo json_encode($retorno);
?>
