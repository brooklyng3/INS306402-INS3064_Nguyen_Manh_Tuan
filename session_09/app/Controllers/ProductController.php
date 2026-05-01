<?php
// app/Controllers/ProductController.php

class ProductController extends Controller {
    
    private ProductModel $productModel;

    public function __construct() {
        $this->productModel = new ProductModel();
    }

    // ==========================================
    // READ: Show all products
    // ==========================================
    public function index() {
        $products = $this->productModel->all();
        $this->render('products/index', [
            'products' => $products
        ]);
    }

    // ==========================================
    // CREATE: Show form & save new product
    // ==========================================
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'price' => trim($_POST['price'] ?? '')
            ];
            
            $errors = $this->productModel->validate($data);
            
            if (empty($errors)) {
                $this->productModel->create($data);
                $this->redirect('/products');
            }
            
            $this->render('products/create', [
                'errors' => $errors,
                'data' => $data 
            ]);
            
        } else {
            $this->render('products/create');
        }
    }

    // ==========================================
    // UPDATE: Show edit form & save changes
    // ==========================================
    public function edit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            $this->redirect('/products');
        }

        // 2. Fetch the existing product from the database
        $product = $this->productModel->find($id);
        
        // If the product doesn't exist in the database, kick them back
        if (!$product) {
            $this->redirect('/products');
        }

        // 3. Process the form submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'price' => trim($_POST['price'] ?? '')
            ];
            
            $errors = $this->productModel->validate($data);
            
            if (empty($errors)) {
                // Call the update method we wrote in the core Model.php!
                $this->productModel->update($id, $data);
                $this->redirect('/products');
            }
            
            // If validation fails, merge the newly typed data with the old product array 
            // so the form remembers what they typed, but still has the database ID.
            $this->render('products/edit', [
                'errors' => $errors,
                'product' => array_merge($product, $data) 
            ]);
            
        } else {
            // 4. Standard GET request: Show the edit form with the database values pre-filled
            $this->render('products/edit', [
                'product' => $product
            ]);
        }
    }

    // ==========================================
    // DELETE: Remove product from database
    // ==========================================
    public function delete() {
        // SECURITY: Only allow deletions via POST request. 
        // If you allow GET deletions, an attacker could trick a user into clicking 
        // a link like `yoursite.com/products/delete?id=5` and secretly delete data.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Grab the ID from a hidden input in the form
            $id = $_POST['id'] ?? null;
            
            if ($id) {
                // Call the delete method we wrote in the core Model.php!
                $this->productModel->delete($id);
            }
        }
        
        // Always redirect back to the product list after deleting
        $this->redirect('/products');
    }
}