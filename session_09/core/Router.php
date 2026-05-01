<?php
// core/Router.php

class Router {
    
    protected array $routes = [];

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if (isset($this->routes[$method][$path])) {
            
            $callback = $this->routes[$method][$path];

            if (is_string($callback)) {
                
                [$ctrl, $act] = explode('@', $callback);

                // =========================================================
                // GLOBAL ERROR HANDLING BLOCK
                // =========================================================
                try {
                    $instance = new $ctrl();
                    $instance->$act();
                    
                } catch (Throwable $e) {                    
                    error_log("System Exception: " . $e->getMessage());
                    http_response_code(500);
                    
                    $errorView = __DIR__ . '/../app/Views/errors/500.php';
                    
                    if (file_exists($errorView)) {
                        require $errorView;
                    } else {
                        echo "<h1>500 - Internal Server Error</h1>";
                        echo "<p>Something went wrong on our end. Please try again later.</p>";
                    }
                }
                
            } 
            
        } else {
            http_response_code(404);
            echo "<h1>404 - Not Found</h1>";
            echo "<p>The page you are looking for does not exist.</p>";
        }
    }
}