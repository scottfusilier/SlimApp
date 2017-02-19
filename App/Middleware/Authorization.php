<?php
namespace App\Middleware;

class Authorization
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
        $route = $request->getAttribute('route');

        // return NotFound for non existent route
        if (empty($route)) {
            throw new NotFoundException($request, $response);
        }

        $method = $route->getCallable();
        if ($Auth->userAuthorized($method)) {
            return $response = $next($request, $response);
        }

        return $response->withStatus(403);
    }
}
