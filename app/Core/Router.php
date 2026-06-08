<?php
namespace App\Core;

class Router {
    private array $routes = [];

    public function add(string $route, string $controller, string $action) {
        $routeRegex = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_]+)', $route);
        $this->routes['/^' . str_replace('/', '\/', $routeRegex) . '$/'] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch(string $url) {
        $url = rtrim($url, '/');
        foreach ($this->routes as $regex => $params) {
            if (preg_match($regex, $url, $matches)) {
                $controllerName = "App\\Controllers\\" . $params['controller'];
                $action = $params['action'];
                
                if (class_exists($controllerName)) {
                    $controller = new $controllerName();
                    $args = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                    call_user_func_array([$controller, $action], $args);
                    return;
                }
            }
        }
        throw new \App\Exceptions\EntityNotFoundException("La page demandée n'existe pas.");
    }
}