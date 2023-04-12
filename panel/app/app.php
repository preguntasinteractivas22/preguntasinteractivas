<?php

if(!isset($session) or $session === null) {
    header('Location: https://' . $_SERVER['HTTP_HOST'] . '/panel/');
    exit;
}

include('theme/head.php');
include('theme/sidebar.php');

include('main.php');

include('theme/footer.php');