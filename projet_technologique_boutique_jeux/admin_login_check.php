<?php
session_start();
require_once 'config.php';

$login = $_POST['login'] ?? '';
$password = $_POST['password'] ?? '';

// Requête : chercher l’admin par login
$sql = "SELECT * FROM admin WHERE login = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$login]);
$admin = $stmt->fetch();

// Vérifie que le mot de passe correspond
if ($admin && password_verify($password, $admin['password_hash'])) {
    $_SESSION['admin_id'] = $admin['id'];
    $_SESSION['admin'] = true; // ✅ utile pour afficher "Déconnexion"
    header('Location: admin_dashboard.php');
    exit;
} else {
    $_SESSION['login_erreur'] = "Identifiants incorrects.";
    header('Location: admin_login.php');
    exit;
}
