<?php

require('../config.php');
use Jajo\JSONDB;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Component\HttpClient\Psr18Client;

$session = $auth0->getCredentials();

if(!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/panel/');
    exit;
}

$mensaje = array(
    'status' => false,
    'message' => 'Ocurrio un error'
);

if(isset($_POST['tipocontenido']) and isset($_POST['descripcion']) and isset($_POST['enlacecontenido'])) {

    $tipocontenido = htmlspecialchars(strip_tags($_POST['tipocontenido']));
    $descripcion = htmlspecialchars(strip_tags($_POST['descripcion']));
    $enlace = htmlspecialchars(strip_tags($_POST['enlacecontenido']));

    if(filter_var($enlace, FILTER_VALIDATE_URL) == true) {

        $cliente = new Psr18Client(new NativeHttpClient([ "headers" => [ "User-Agent" => "facebookexternalhit/1.1" ] ]));
        $consumer = new Fusonic\OpenGraph\Consumer($cliente, $cliente);
        $datos = $consumer->loadUrl($enlace);

    }

    $checksum = hash('md5', json_encode(array($tipocontenido,$descripcion)));

    $json_db = new JSONDB(__DIR__);

    $json_db->insert(
        '../app/json/contenido.json',
        [
        'id' => $checksum,
        'tipocontenido' => $tipocontenido,
        'descripcion' => $descripcion,
        'enlace' => $enlace,
        'opengraph' => array(
            'title' => (isset($datos->title) ? $datos->title : ''),
            'description' => (isset($datos->description) ? $datos->description : ''),
            'images' => (isset($datos->images[0]->url) ? $datos->images[0]->url : '')
        )
    ]
    );



    $mensaje = array(
        'status' => true,
        'mensaje' => 'Contenido agregado exitosamente',
        'id' => $checksum
    );

}

echo json_encode($mensaje);
