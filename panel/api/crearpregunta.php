<?php

require('../config.php');
use Jajo\JSONDB;

$session = $auth0->getCredentials();

if(!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/aasana/panel/');
    exit;
}

$mensaje = array(
    'status' => false,
    'message' => 'Ocurrio un error'
);

if(isset($_POST['pregunta']) and isset($_POST['respuesta1']) and isset($_POST['respuesta2']) and isset($_POST['respuesta3'])) {

    $pregunta = htmlspecialchars(strip_tags($_POST['pregunta']));

    $respuestas = array();

    $i = 0;

    $respuestas[0]['respuesta'] = htmlspecialchars(strip_tags($_POST['respuesta1']));
    $respuestas[1]['respuesta'] = htmlspecialchars(strip_tags($_POST['respuesta2']));
    $respuestas[2]['respuesta'] = htmlspecialchars(strip_tags($_POST['respuesta3']));

    $checksum = hash('md5', json_encode(array($pregunta,$respuestas)));

    $json_db = new JSONDB(__DIR__);

    $json_db->insert(
        '../app/json/preguntas.json',
        [
        'id' => $checksum,
        'pregunta' => $pregunta,
        'respuestas' => $respuestas
    ]
    );



    $mensaje = array(
        'status' => true,
        'mensaje' => 'Pregunta creada exitosamente',
        'id' => $checksum
    );

}

echo json_encode($mensaje);
