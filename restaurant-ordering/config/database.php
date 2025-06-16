<?php
// Database configuration
$host = 'localhost';
$dbname = 'food_ordering';
$username = 'root';
$password = '';

// $host = 'localhost';
// $dbname = 'tracecodeadmin_food_ordering';
// $username = 'tracecodeadmin_food_ordering';
// $password = 'abWPC55GvX5VhUJC6X4h';

// Create database connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
