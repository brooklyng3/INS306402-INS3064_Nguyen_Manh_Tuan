<?php
// classes/ValidationException.php

class ValidationException extends Exception
{
    private array $errors;

    /**
     * @param array  $errors  An associative array of field-specific errors
     * @param string $message A generic fallback message
     */
    public function __construct(array $errors, string $message = "Validation failed.")
    {
        // Pass the generic message to the parent Exception class
        parent::__construct($message);
        
        // Store our specific field errors
        $this->errors = $errors;
    }

    /**
     * Retrieve the array of field-specific errors
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}