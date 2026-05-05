<?php

class ProductModel extends Model {
    
    protected string $table = 'products';
    public function validate(array $data): array {
        $errors = [];
        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'Product name is required.';
        }
        if (!isset($data['price']) || $data['price'] === '') {
            $errors['price'] = 'Product price is required.';
        } elseif (!is_numeric($data['price'])) {
            $errors['price'] = 'Price must be a valid number.';
        } elseif ((float)$data['price'] <= 0) {
            $errors['price'] = 'Price must be greater than zero.';
        }
        return $errors;
    }
}