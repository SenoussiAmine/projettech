<?php
// config.php

$host = 'localhost';
$dbname = 'projettech'; // ✅ c’est ton vrai nom
$username = 'root';     // par défaut dans XAMPP/MAMP
$password = 'root';


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connexion échouée : " . $e->getMessage());
}
?>
