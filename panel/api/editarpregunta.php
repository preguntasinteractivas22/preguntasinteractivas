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

if(isset($_POST['pregunta']) and isset($_POST['respuesta1']) and isset($_POST['respuesta2']) and isset($_POST['respuesta3']) and isset($_POST['id'])) {

    $id = htmlspecialchars(strip_tags($_POST['id']));

    $pregunta = htmlspecialchars(strip_tags($_POST['pregunta']));

    $respuestas = array();

    $i = 0;

    $respuestas[0]['respuesta'] = htmlspecialchars(strip_tags($_POST['respuesta1']));
    $respuestas[1]['respuesta'] = htmlspecialchars(strip_tags($_POST['respuesta2']));
    $respuestas[2]['respuesta'] = htmlspecialchars(strip_tags($_POST['respuesta3']));

    $json_db = new JSONDB(__DIR__);

    $datos = $json_db->update(['pregunta' => $pregunta, 'respuestas' => $respuestas])
    ->from('../app/json/preguntas.json')
    ->where([ 'id' => $id ])
    ->trigger();

    unset($datos->file);

    if (!empty($datos)) {
        $mensaje = array(
        'status' => true,
        'mensaje' => 'Pregunta modificada exitosamente',
        'datos' => $datos//<-- Revisar
        );
    }
}

echo json_encode($mensaje);
