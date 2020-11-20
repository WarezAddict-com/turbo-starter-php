<?php

// Namespace
namespace Turbo\Controllers;

// Use Libs
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

// SearchController
class SearchController extends \Turbo\Controllers\Controller
{
    // POST
    public function post(Request $request, Response $response, array $args)
    {
        // Debug Mode
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('info', 'Debug Mode Enabled!');
            $debugMode = 'yes';
        } else {
            $debugMode = 'no';
        }

        // Query
        if ($_POST['search']) {
            $query = filter_var($_POST['search'], FILTER_SANITIZE_STRING);
        }

        if ($query) {

            /** TMDB Client
            $client = $this->tmdb;
            $data = $client->getSearchApi()->searchMovies($query);
            foreach ($data['results'] as $mov) {
                $results[] = $mov;
            }
            **/

            // Page
            $pageParam = $request->getQueryParam('page');

            if (filter_var($pageParam, FILTER_VALIDATE_INT) && $pageParam >= 2 && $pageParam <= 99) {
                $page = $pageParam;
            } else {
                $page = 1;
            }

            // TMDB Client
            $client = $this->tmdb;

            // Search Movies
            $data = $client->getSearchApi()->searchMovies($query);

            // Search Results
            $res = $data['results'];
            $new = [];

            foreach ($res as $key => $val) {
                $new[] = $val;
            }

        }

        // Render View
        return $this->view->render($response, 'results.twig', [
            'debugMode' => $debugMode,
            'query' => $query,
            'results' => $new,
            'current_page' => $page,
            'total_pages' => $data['total_pages'],
            'total_results' => $data['total_results'],
        ]);
    }

    public function get(Request $request, Response $response, array $args)
    {

        // Debug Mode
        if (getenv('APP_DEBUG') == 'yes') {
            $this->flash->addMessageNow('info', 'Debug Mode Enabled!');
            $debugMode = 'yes';
        } else {
            $debugMode = 'no';
        }

        // Return View
        return $this->view->render($response, 'error.twig', [
            'debugMode' => $debugMode,
            'status' => 'ERROR!',
            'code' => '405',
            'message' => 'Nothing to search...',
        ]);
    }
}
