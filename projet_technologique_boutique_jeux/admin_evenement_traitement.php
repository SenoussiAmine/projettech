<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}

$titre = $_POST['titre'] ?? '';
$date = $_POST['date'] ?? '';
$duree = $_POST['duree'] ?? '';
$capacite = $_POST['capacite'] ?? 0;
$jeux_ids = $_POST['jeux_ids'] ?? [];

// 1. Ajouter l'événement
$sql = "INSERT INTO evenement (titre, date, duree, capacite) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$titre, $date, $duree, $capacite]);
$id_evenement = $pdo->lastInsertId();

// 2. Associer aux jeux
if (!empty($jeux_ids)) {
    $sql_link = "INSERT INTO evenement_jeu (evenement_id, jeu_id) VALUES (?, ?)";
    $stmt_link = $pdo->prepare($sql_link);
    foreach ($jeux_ids as $jeu_id) {
        $stmt_link->execute([$id_evenement, $jeu_id]);
    }
}

echo "✅ Événement ajouté avec succès ! <a href='admin_dashboard.php'>Retour</a>";
?>
