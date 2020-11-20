<?php

// Namespace
namespace Turbo\Middleware;

// Use Libs
use \Psr\Container\ContainerInterface as Container;

class Middleware
{
    // Protected
    protected $container;

    // Construct
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
}
