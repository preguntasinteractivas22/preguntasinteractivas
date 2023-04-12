<?php

require('vendor/autoload.php');

(Dotenv\Dotenv::createImmutable(__DIR__ . '/vendor/'))->load();

use Auth0\SDK\Auth0;
use Auth0\SDK\Configuration\SdkConfiguration;

$auth0 = new \Auth0\SDK\Auth0([
    'domain' => $_ENV['AUTH0_DOMAIN'],
    'clientId' => $_ENV['AUTH0_CLIENT_ID'],
    'clientSecret' => $_ENV['AUTH0_CLIENT_SECRET'],
    'cookieSecret' => $_ENV['AUTH0_COOKIE_SECRET'],
    'redirectUri' => 'https://' . $_SERVER['HTTP_HOST'] . '/panel/callback.php'
]);