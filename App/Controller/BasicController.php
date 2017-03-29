<?php
namespace App\Controller;

use App\Template\BasicTemplate as Template;
use App\View\Basic as View;

class BasicController extends AppController
{
    public function index($request, $response, $args)
    {
        $params = array_merge($request->getParams(),$args);

        return $response->getBody()->write(
            Template::get()->render(
                View\BasicView::get()->setVars([
                    'data' => json_encode($params)
                ])
            )
        );
    }

    public function secret($request, $response, $args)
    {
        return $response->getBody()->write(
            Template::get()->render(
                View\BasicView::get()->setVars([
                    'data' => json_encode(['secret'=>'oats'])
                ])
            )
        );
    }
}
