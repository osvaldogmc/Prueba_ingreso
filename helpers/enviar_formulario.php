<?php
include('../DB/Connection.php');

$nombre_recibido = $_POST['user_name'];
$alias_recibido = $_POST['user_alias'];
$rut_recibido = $_POST['user_rut'];
$mail_recibido = $_POST['user_mail'];
$region = $_POST['region'];
$comuna = $_POST['comuna'];
$candidato = $_POST['candidato'];
$web = $_POST['chkWeb'] == 'true' ? true : false;
$tv = $_POST['chkTv'] == 'true' ? true : false;
$rrss = $_POST['chkRrss'] == 'true' ? true : false;
$amigo = $_POST['chkAmigo'] == 'true' ? true : false;

if (preg_match('/[-]/', $rut_recibido)) {
    $rut_recibido = explode("-", $rut_recibido)[0];
    $rut_recibido = (int) $rut_recibido;
} else {
    $rut_recibido = (int) $rut_recibido;
}

try {
    $conexion = conexion();
    $sql = "INSERT INTO voto (nombre_apellido, alias, rut, email, ind_web, ind_tv, ind_red_social, ind_amigo, id_comuna, id_candidato) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param(
        "ssisbbbbii",
        $nombre_recibido,
        $alias_recibido,
        $rut_recibido,
        $mail_recibido,
        $web,
        $tv,
        $rrss,
        $amigo,
        $comuna,
        $candidato
    );
    $stmt->execute();
    echo json_encode(array(
        'estado' => true,
        'mensaje' => 'Los datos han sido ingresados con éxito'
    ));
} catch (Exception $e) {
    $error = $e->getMessage();
    echo json_encode(array(
        'estado' => false,
        'mensaje' => 'Ha ocurrido un error en el proceso',
        'error' => $error
    ));
}
?>
