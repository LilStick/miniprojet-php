<?php
$host = 'localhost'; 
$db = 'phpdb'; 
$user = 'postgres'; 
$pass = 'noeleroux2'; 

try {
    $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
?>