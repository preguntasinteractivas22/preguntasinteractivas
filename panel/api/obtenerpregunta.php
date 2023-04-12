<?php

require('../config.php');
use Jajo\JSONDB;

$session = $auth0->getCredentials();

if (!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/aasana/panel/');
    exit;
}

$mensaje = array(
    'status' => false,
    'message' => 'Ocurrio un error',
    'datos' => false
);

if (isset($_GET['id'])) {
    $id = htmlspecialchars(strip_tags($_GET['id']));

    $json_db = new JSONDB(__DIR__);

    $datos = $json_db->select('id, pregunta, respuestas')
    ->from('../app/json/preguntas.json')
    ->where([ 'id' => $id ])
    ->get();

    unset($datos->file);

    if (!empty($datos)) {
        $mensaje = array(
        'status' => true,
        'mensaje' => 'Pregunta obtenida exitosamente',
        'datos' => $datos
        );
    }
}

echo json_encode($mensaje);
