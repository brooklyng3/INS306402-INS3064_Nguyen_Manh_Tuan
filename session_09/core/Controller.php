<?php
// core/Controller.php

class Controller {
    
    /**
     * Load a view file securely and pass data to it.
     * * @param string $view The path to the view file (e.g., 'products/index')
     * @param array $data Data to be extracted and used in the view
     */
    protected function render(string $view, array $data = []): void {
        extract($data);
        $safeView = str_replace('../', '', $view);
        
        $viewFile = __DIR__ . "/../app/Views/{$safeView}.php";
        $layoutFile = __DIR__ . "/../app/Views/layouts/main.php";

        if (file_exists($viewFile)) {
            $content = $viewFile;
            
            if (file_exists($layoutFile)) {
                require $layoutFile;
            } else {
                die("Configuration Error: Main layout file is missing.");
            }
        } else {
            http_response_code(404);
            die("View not found.");
        }
    }

    /**
     * Redirect the browser to a different URL.
     * * @param string $url The target path (e.g., '/products')
     */
    protected function redirect(string $url): void {
        header("Location: $url");
        exit; 
    }
}