<?php
namespace App\Controller;

use App\Template\BasicTemplate as Template;
use App\View\Basic as View;

class UserController extends AppController
{
    public function login($request, $response, $args)
    {
        $params = $request->getParams();
        $Auth = $this->container->get('AuthComponent');

        if (!empty($params)) {
           $params = $this->loginArgs($params);
           if (!empty($params) && $Auth->login($params)) {
                $location = $Auth->sessionGetVar('location');
                if ($location) {
                    $Auth->sessionRemoveVar($location);
                    return $response->withStatus(302)->withHeader('Location', $location);
                }
                return $response->withStatus(302)->withHeader('Location', '/');
           }
        }

        if ($Auth->hasUser()) {
            return $response->withStatus(302)->withHeader('Location', '/');
        }

        // render login template and view
        return $response->getBody()->write(Template::get()->render(\App\View\User\Login::get()));
    }

    public function logout($request, $response, $args)
    {
        $auth = $this->container->get('AuthComponent');
        $auth->logout();
        return $response->withStatus(302)->withHeader('Location', '/login');
    }
/*
 *  Expected login args
 */
    protected function loginArgs($args)
    {
        $expected = [
            'email',
            'password',
            'token',
            'formName'
        ];

        foreach ($expected as $key) {
            if (empty($args[$key])) {
                return [];
            }
        }

        return $args;
    }
}
