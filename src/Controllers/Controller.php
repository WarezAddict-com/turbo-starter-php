<?php

// Namespace
namespace Turbo\Controllers;

// Use Libs
use \Psr\Container\ContainerInterface as Container;

// Controller
class Controller
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if ($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}
