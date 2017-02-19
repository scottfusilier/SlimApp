<?php
/* autoloading and configuration */

$loader = include dirname(__DIR__).'/vendor/autoload.php';
$loader->add('App\\', dirname(__DIR__));

include __DIR__.'/Config/config.php';
