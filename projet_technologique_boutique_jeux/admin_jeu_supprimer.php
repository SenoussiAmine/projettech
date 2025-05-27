<?php
require_once 'config.php';

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID manquant.";
    exit;
}

$id = $_GET['id'];

// Supprimer image si existe
$stmt = $pdo->prepare("SELECT image FROM jeu WHERE id = ?");
$stmt->execute([$id]);
$image = $stmt->fetchColumn();

if ($image && file_exists("uploads/$image")) {
    unlink("uploads/$image");
}

// Supprimer jeu
$stmt = $pdo->prepare("DELETE FROM jeu WHERE id = ?");
$stmt->execute([$id]);

header("Location: admin_dashboard.php");
exit;
?>
