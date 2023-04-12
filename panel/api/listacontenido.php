<?php

require('../config.php');
use Jajo\JSONDB;

$session = $auth0->getCredentials();

if (!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/aasana/panel/');
    exit;
}

$json_db = new JSONDB(__DIR__);

$datos = $json_db->select('*')
->from('../app/json/contenido.json')
->get();

unset($datos->file);

if (!empty($datos)) {
    $mensaje = array(
    'status' => true,
    'datos' => $datos
    );
}


echo json_encode($mensaje);
