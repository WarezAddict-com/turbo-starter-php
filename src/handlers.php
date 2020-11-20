<?php

// Use Libs
use \Psr\Container\ContainerInterface as Container;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

/** Default 404 Not Found Handler **/
unset($app->getContainer()['notFoundHandler']);

/** 404 Not Found Handler **/
$app->getContainer()['notFoundHandler'] = function (Container $container) {
    return function (Request $request, Response $response) use ($container) {

        /** Get Info **/
        $whip = new \Vectorface\Whip\Whip();
        $whip->setSource($request);

        $ip = $whip->getValidIpAddress();
        $method = $request->getMethod();
        $path = $request->getUri()->getPath();
        $params = $request->getParams();

        $logData = [
            'Error' => '404',
            'IP' => $ip,
            'Method' => $method,
            'Path' => $path,
            'Params' => $params,
        ];

        $logger = $container->get('logger');
        $logger->debug('ERROR', $logData);

        /** Return JSON
         * $data = ['status' => 'error', 'code' => '404', 'message' => 'Not Found'];
         * return $response->withJson($data);
        **/

        /** Return Response **/
        $response = new \Slim\Http\Response(404);
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');

        return $container->view->render($response, 'error.twig', [
            'status' => 'ERROR',
            'code' => '404',
            'message' => 'Not Found! Go back and try again...',
        ]);
    };
};

/** Not Allowed Handler **/
unset($app->getContainer()['notAllowedHandler']);

$app->getContainer()['notAllowedHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $methods) use ($container) {

        /** Return Response **/
        $response = new \Slim\Http\Response(405);
        $response = $response->withHeader('Content-Type', 'text/html; charset=UTF-8');

        return $container->view->render($response, 'error.twig', [
            'status' => 'ERROR',
            'code' => '405',
            'message' => $response->withStatus(405)->getReasonPhrase() . ', Method must be one of: ' . implode(', ', $methods),
        ]);
    };
};

/** PHP Error Handler **/

unset($app->getContainer()['errorHandler']);

$app->getContainer()['errorHandler'] = function (Container $container) {
    return function (Request $request, Response $response, $exception) use ($container) {

        $response->getBody()->rewind();

        $tra = explode("\n", $exception->getTraceAsString());

        return $container->view->render($response, 'error.twig', [
            'status' => 'ERROR',
            'code' => $exception->getCode(),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'trace' => json_encode($tra),
        ]);
    };
};

unset($app->getContainer()['phpErrorHandler']);

$app->getContainer()['phpErrorHandler'] = function (Container $container) {
    return $container['errorHandler'];
};
