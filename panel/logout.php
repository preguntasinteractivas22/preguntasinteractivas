<?php
require_once('config.php');

header(sprintf('Location: %s', $auth0->logout()));
exit;