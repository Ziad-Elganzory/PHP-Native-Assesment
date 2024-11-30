<?php

use Src\Core\Router;

return function (Router $router) {
    // Categories routes
    $router->get('/categories', 'CategoryController@index');
    $router->get('/categories/([a-f0-9\-]+)', 'CategoryController@show');

    // Courses Routes
    $router->get('/courses', 'CourseController@index');
    $router->get('/courses/([a-zA-Z0-9]+)', 'CourseController@show');
};


?>