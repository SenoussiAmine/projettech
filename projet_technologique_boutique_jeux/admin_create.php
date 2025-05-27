<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}


$login = 'admin'; // ton identifiant
$password = 'motdepasse123'; // ton mot de passe

$password_hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (login, password_hash) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$login, $password_hash]);

echo "✅ Administrateur créé avec succès.";
?>
