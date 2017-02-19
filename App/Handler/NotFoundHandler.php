<?php
namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use App\Template\BasicTemplate as Template;
use App\View\System\FourOhFour as FourOhFour;

class NotFoundHandler extends \Slim\Handlers\NotFound
{
    /**
     * Invoke not found handler
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $path = $request->getUri()->getPath();

        // If request is for a file or image then just return and do no more
        if (preg_match('/^.*\.(jpg|jpeg|png|gif)$/i', $path)) {
            return $response->withStatus(404);
        }

        // Return status and template
        return parent::__invoke($request, $response);
    }

    /**
     * Return a response for text/html content not found - Overwrite Parent Method
     *
     * @param  ServerRequestInterface $request  The most recent Request object
     * @param  ResponseInterface      $response The most recent Response object
     *
     * @return ResponseInterface
     */
    protected function renderHtmlNotFoundOutput(ServerRequestInterface $request)
    {
        ob_start();
        Template::get()->render(FourOhFour::get());
        return ob_get_clean();
    }
}
