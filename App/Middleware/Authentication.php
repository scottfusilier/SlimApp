<?php
namespace App\Middleware;

use Slim\Handlers\AbstractHandler as Handler;

class Authentication extends Handler
{
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Example middleware invokable class
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request  PSR7 request
     * @param  \Psr\Http\Message\ResponseInterface      $response PSR7 response
     * @param  callable                                 $next     Next middleware
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $Auth = $this->container->get('AuthComponent');
        if ($Auth->hasUser()) {
            return $response = $next($request, $response);
        }

        $contentType = $this->determineContentType($request);

        if ($contentType = 'text/html') {
            $location = $request->getUri()->getPath();
            $Auth->sessionSetVar('location', $location);
            return $response->withStatus(302)->withHeader('Location', '/login');
        }

        return $response->withStatus(401);
    }
}
