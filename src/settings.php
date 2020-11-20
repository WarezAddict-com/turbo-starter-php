<?php

/** Debug Mode **/
if (getenv('APP_DEBUG') == 'yes') {
    $dmode = true;
} else {
    $dmode = false;
}

/** Slim Settings **/
return [
    'settings' => [
        'debug' => $dmode,
        'displayErrorDetails' => $dmode,
        'addContentLengthHeader' => false,
        'determineRouteBeforeAppMiddleware' => true,
        'routerCacheFile' => false,
        'whoops.editor' => 'sublime',
        'whoops.page_title' => 'ERROR!',
    ],

];
