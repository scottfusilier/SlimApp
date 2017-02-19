<?php
/**
 * Routes, Middleware, and registering a couple of handlers
 */
$container = $app->getContainer();

$container['notFoundHandler'] = function() {
    return new \App\Handler\NotFoundHandler();
};

$container['AuthComponent'] = function() {
    return new \App\Component\AuthComponent();
};

$authentication = new App\Middleware\Authentication($container);
$authorization = new App\Middleware\Authorization($container);

/* application routes */

$app->get('/[{id:\d+}]', '\App\Controller\BasicController:index');

$app->map(['GET','POST'], '/login', '\App\Controller\UserController:login');

$app->get('/logout', '\App\Controller\UserController:logout');

$app->map(['GET','POST'], '/protected[/{id:\d+}]', '\App\Controller\BasicController:secret')->add($authentication);

$app->get('/protected/permissioned', '\App\Controller\BasicController:secret')->add($authorization)->add($authentication);
