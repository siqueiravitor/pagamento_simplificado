<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private string $currentGroup = '';
    private array $groupMiddlewares = [];

    public function get(string $path, callable|array $callback): void
    {
        $this->add('GET', $path, $callback);
    }

    public function post(string $path, callable|array $callback): void
    {
        $this->add('POST', $path, $callback);
    }

    public function put(string $path, callable|array $callback): void
    {
        $this->add('PUT', $path, $callback);
    }

    public function delete(string $path, callable|array $callback): void
    {
        $this->add('DELETE', $path, $callback);
    }

    private function add(string $method, string $pattern, callable|array $callback): void
    {
        $method = strtoupper($method);
        $pattern = rtrim($this->currentGroup . $pattern, '/');
        $this->routes[$method][$pattern] = [
            'callback' => $callback,
            'middlewares' => $this->middlewares + ($this->groupMiddlewares[$this->currentGroup] ?? [])
        ];
    }

    public function middleware(callable $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function group(string $prefix, callable $callback, callable $groupMiddleware = null): void
    {
        $oldGroup = $this->currentGroup;
        $this->currentGroup .= $prefix;
        if ($groupMiddleware) {
            $this->groupMiddlewares[$this->currentGroup][] = $groupMiddleware;
        }
        $callback($this);
        $this->currentGroup = $oldGroup;
    }

    public function dispatch(string $method, string $uri): bool
    {
        $method = strtoupper($method);
        $uri = rtrim(parse_url($uri, PHP_URL_PATH), '/');

        foreach ($this->routes[$method] ?? [] as $route => $routeData) {
            $pattern = preg_replace('#\{([^}]+)\}#', '(?P<$1>[^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                foreach ($routeData['middlewares'] as $middleware) {
                    $middleware($method, $uri, $params);
                }

                $callback = $routeData['callback'];
                if (is_array($callback)) {
                    [$controller, $action] = $callback;
                    if (class_exists($controller) && method_exists($controller, $action)) {
                        call_user_func_array([new $controller, $action], [$params]);
                        return true;
                    }
                }

                if (is_callable($callback)) {
                    call_user_func($callback, $params);
                    return true;
                }
            }
        }

        return false;
    }
}
