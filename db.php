<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'classicmodels';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("No connection: " . $e->getMessage());
}
?>
