<?php

require_once('config.php');

$session = $auth0->getCredentials();

if($session !== null) {

    require('app/app.php');

} else {

    header(sprintf('Location: %s', $auth0->login()));

}