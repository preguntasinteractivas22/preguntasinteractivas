<?php

require('config.php');

$hasAuthenticated = isset($_GET['state']) && isset($_GET['code']);
$hasAuthenticationFailure = isset($_GET['error']);

if ($hasAuthenticated) {
    try {
        $auth0->exchange();
    } catch (\Throwable $th) {
        printf('Autenticaci&oacute;n no completada: %s', $th->getMessage());
        exit;
    }
}

if ($hasAuthenticationFailure) {
    printf('Problemas de Autenticaci&oacute;n: %s', htmlspecialchars(strip_tags(filter_input(INPUT_GET, 'error'))));
    exit;
}

header('Location: https://' . $_SERVER['HTTP_HOST'] . '/panel/');