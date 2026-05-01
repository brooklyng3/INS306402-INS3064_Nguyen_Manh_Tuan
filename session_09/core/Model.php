<?php
// core/Model.php

abstract class Model {
    
    protected PDO $db;
    protected string $table;

    public function __construct() {
        $host = '127.0.0.1';
        $dbname = 'mvc_products'; 
        $user = 'root';
        $pass = '';

        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function all(): array {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool {
        // Grab the array keys to make the column names (e.g., "name, price")
        $columns = implode(', ', array_keys($data));
        
        // Add a colon to the keys for the prepared statement placeholders (e.g., ":name, :price")
        $placeholders = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);

        // Execute automatically binds the associative array to the placeholders
        return $stmt->execute($data);
    }

    public function update($id, array $data): bool {
        $fields = '';
        
        // Build the "column = :column" string
        foreach ($data as $key => $value) {
            $fields .= "$key = :$key, ";
        }
        
        // Remove the trailing comma and space from the loop
        $fields = rtrim($fields, ', '); 

        $sql = "UPDATE {$this->table} SET $fields WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        // Add the target ID to the data array so it binds to the WHERE clause
        $data['id'] = $id;

        return $stmt->execute($data);
    }


    public function delete($id): bool {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute(['id' => $id]);
    }

    
    abstract public function validate(array $data): array;
}