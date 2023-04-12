<?php

require('../config.php');
use Jajo\JSONDB;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Component\HttpClient\Psr18Client;

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

if(isset($_POST['tipocontenido']) and isset($_POST['descripcion']) and isset($_POST['enlace']) and isset($_POST['idcontenido'])) {

    $id = htmlspecialchars(strip_tags($_POST['idcontenido']));
    $tipocontenido = htmlspecialchars(strip_tags($_POST['tipocontenido']));
    $descripcion = htmlspecialchars(strip_tags($_POST['descripcion']));
    $enlace = htmlspecialchars(strip_tags($_POST['enlace']));

    if(filter_var($enlace, FILTER_VALIDATE_URL) == true) {

        $cliente = new Psr18Client(new NativeHttpClient([ "headers" => [ "User-Agent" => "facebookexternalhit/1.1" ] ]));
        $consumer = new Fusonic\OpenGraph\Consumer($cliente, $cliente);
        $datosurl = $consumer->loadUrl($enlace);

    }

    $opengraph = array(
        'title' => (isset($datosurl->title) ? $datosurl->title : ''),
        'description' => (isset($datosurl->description) ? $datosurl->description : ''),
        'images' => (isset($datosurl->images[0]->url) ? $datosurl->images[0]->url : '')
    );

    $json_db = new JSONDB(__DIR__);

    $checksum = hash('md5', json_encode(array($tipocontenido,$descripcion)));

    $datos = $json_db->update(['tipocontenido' => $tipocontenido, 'descripcion' => $descripcion, 'enlace' => $enlace, 'opengraph' => $opengraph])
    ->from('../app/json/contenido.json')
    ->where([ 'id' => $id ])
    ->trigger();

    unset($datos->file);

    if (!empty($datos)) {
        $mensaje = array(
        'status' => true,
        'mensaje' => 'Contenido modificado exitosamente',
        'datos' => $datos//<-- Revisar
        );
    }
}

echo json_encode($mensaje);
