<?php
namespace App\Controller;

abstract class AppController
{
    protected $container;

    // constructor receives container instance
    public function __construct($container)
    {
       $this->container = $container;
    }

    /**
     * Show Page Not Found
     *
     * Returns status 404 Not Found and custom template
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     */
    protected function notFound($request, $response)
    {
        $notFound = $this->container->get('notFoundHandler');
        return $notFound($request, $response);
    }
}
