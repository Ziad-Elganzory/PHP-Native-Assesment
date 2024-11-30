<?php

namespace Src\Core;

class Router
{
    private $routes = [];

    public function get($route, $action)
    {
        $this->routes['GET'][$route] = $action;
    }

    public function post($route, $action)
    {
        $this->routes['POST'][$route] = $action;
    }

    public function dispatch($requestUri, $requestMethod)
    {
        $action = $this->matchRoute($requestUri, $requestMethod);

        if (!$action) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        if (is_callable($action)) {
            call_user_func($action);
        } elseif (is_string($action)) {
            $parts = explode('@', $action);
            $controller = "Src\\Controllers\\" . $parts[0];
            $method = $parts[1];

            if (class_exists($controller) && method_exists($controller, $method)) {
                $parameters = $this->extractParameters($requestUri);
                call_user_func_array([new $controller, $method], $parameters); 
            } else {
                http_response_code(500);
                echo "Controller or method not found";
            }
        }
    }

    private function matchRoute($requestUri, $requestMethod)
    {
        foreach ($this->routes[$requestMethod] as $route => $action) {
            $routePattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\w+)', $route);
            $routePattern = "#^$routePattern$#";

            if (preg_match($routePattern, $requestUri, $matches)) {
                return $action;
            }
        }

        return null;
    }

    private function extractParameters($requestUri)
    {
        foreach ($this->routes as $methodRoutes) {
            foreach ($methodRoutes as $route => $action) {
                $routePattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\w+)', $route);
                $routePattern = "#^$routePattern$#";

                if (preg_match($routePattern, $requestUri, $matches)) {
                    return array_values(array_slice($matches, 1));
                }
            }
        }

        return [];
    }
}
?>