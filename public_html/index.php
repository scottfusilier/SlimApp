<?php

include dirname(dirname(__FILE__)).'/App/bootstrap.php';

session_start();

$app = new Slim\App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

include dirname(dirname(__FILE__)).'/App/Config/routes.php';

$app->run();
