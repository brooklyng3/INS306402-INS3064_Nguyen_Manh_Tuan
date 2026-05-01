<?php

spl_autoload_register(function ($className) {
    $directories = [
        __DIR__ . '/../core/',
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Models/'
    ];

    // Search through each directory for the requested class
    foreach ($directories as $dir) {
        $file = $dir . $className . '.php';
        if (file_exists($file)) {
            require_once $file;
            return; // Stop searching once the file is found
        }
    }
});

/**
 * 2. INITIALIZE ROUTER
 */
$router = new Router();

/**
 * 3. REGISTER ROUTES (In-Class Exercise 2 Requirement)
 * Mapping the URLs to the specific Controller and Method.
 */

// Show the list of all products
$router->get('/products', 'ProductController@index');

// Show the blank form to create a new product
$router->get('/products/create', 'ProductController@create');

// Handle the form submission when the user clicks "Save"
$router->post('/products/create', 'ProductController@create');

$router->get('/products/edit', 'ProductController@edit');
$router->post('/products/edit', 'ProductController@edit');
$router->post('/products/delete', 'ProductController@delete');

/**
 * 4. DISPATCH THE REQUEST
 * This tells the router to evaluate the current URL and execute the matched route.
 */
$router->dispatch();