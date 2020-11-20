<?php

// Routes
$app->group('', function () {
    $this->get('/', 'HomeController:index')->setName('home');
    $this->get('/search', 'SearchController:get')->setName('search.get');
    $this->post('/search', 'SearchController:post')->setName('search.post');
});

