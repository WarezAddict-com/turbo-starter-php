<?php

// Namespace
namespace Turbo\Controllers;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// HomeController
class HomeController extends \Turbo\Controllers\Controller
{
    // Main Route
    public function index(Request $request, Response $response, array $args)
    {

        // Debug Mode
        if (getenv('APP_DEBUG') == 'yes') {
            $debugMode = 'yes';
            $this->flash->addMessageNow('debug', 'Debug Mode Enabled!');
        } else {
            $debugMode = 'no';
        }

        // Page
        $pageParam = $request->getQueryParam('page');

        if (filter_var($pageParam, FILTER_VALIDATE_INT) && $pageParam >= 2 && $pageParam <= 99) {
            $page = $pageParam;
        } else {
            $page = 1;
        }

        // TMDB Client
        $client = $this->tmdb;

        // MovieRepo
        $movieRepo = new \Tmdb\Repository\MovieRepository($client);

        // Movie Repo
        $repo = $movieRepo->getApi();

        // Now Playing
        $nowPlay = $repo->getNowPlaying(array(
            'page' => $page,
            'language' => 'en-US',
        ));

        // Now Playing Results
        $res = $nowPlay['results'];
        $new = [];

        foreach ($res as $key => $val) {
            $new[] = $val;
        }

        // Render View
        return $this->view->render($response, 'home.twig', [
            'debugMode' => $debugMode,
            'results' => $new,
            'current_page' => $page,
            'total_pages' => $nowPlay['total_pages'],
            'total_results' => $nowPlay['total_results'],
        ]);
    }
}
