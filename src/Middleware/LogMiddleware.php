<?php

// Namespace
namespace Turbo\Middleware;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class LogMiddleware extends \Turbo\Middleware\Middleware
{
    // Invoke
    public function __invoke(Request $request, Response $response, $next)
    {
        $whip = new \Vectorface\Whip\Whip();
        $whip->setSource($request);
        $ipAdd = $whip->getValidIpAddress();

        // Method
        $method = $request->getMethod();

        // Path (URL)
        $path = $request->getUri()->getPath();

        // URL Params
        $params = $request->getParams();

        // User Agent
        if (!empty($_SERVER['HTTP_USER_AGENT'])) {
            $ua = filter_var($_SERVER['HTTP_USER_AGENT'], FILTER_SANITIZE_STRING);
        } else {
            $ua = 'Unknown';
        }

        // Data
        $data = [
            'IP' => $ipAdd,
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
            'UserAgent' => $ua,
        ];

        // Log Info
        $logger = $this->container->get('logger');
        $logger->debug('STATS', $data);

        // Return Next
        $response = $next($request, $response);
        return $response;
    }
}
