<?php
// include/db.php
// MySQL Connection 

$host = '127.0.0.1'; // or 'localhost'
$db   = 'task_dashboard';
$user = 'root';      // replace with your MySQL username
$pass = '';          // replace with your MySQL password
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

// Set PDO options for robust error handling and fetching data as associative arrays
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Instantiate the PDO object
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // If connection fails, output the error and stop execution
    die("Database connection failed: " . $e->getMessage());
}
?>