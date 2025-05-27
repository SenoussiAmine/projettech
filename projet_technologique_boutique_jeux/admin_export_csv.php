<?php
require_once 'config.php';
session_start();

// 🔐 Sécurité : accessible uniquement si l’admin est connecté
if (!isset($_SESSION['admin'])) {
    header('Location: login_admin.php');
    exit;
}

// ✅ Vérifie la présence de l’ID
if (!isset($_GET['evenement_id'])) {
    die("ID d’événement manquant.");
}

$evenement_id = intval($_GET['evenement_id']);

// 🎯 Récupération des participants
$stmt = $pdo->prepare("
    SELECT p.nom, p.prenom, p.email, p.accompagnants, i.date_inscription
    FROM inscription i
    JOIN participant p ON i.participant_id = p.id
    WHERE i.evenement_id = ?
    ORDER BY i.date_inscription DESC
");
$stmt->execute([$evenement_id]);
$participants = $stmt->fetchAll();

// 🧾 Prépare le fichier CSV
header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=participants_evenement_$evenement_id.csv");

$output = fopen('php://output', 'w');

// 🧩 Ligne d'en-tête
fputcsv($output, ['Nom', 'Prénom', 'Email', 'Accompagnants', 'Date d\'inscription']);

// 🧩 Données
foreach ($participants as $p) {
    fputcsv($output, [
        $p['nom'],
        $p['prenom'],
        $p['email'],
        $p['accompagnants'],
        $p['date_inscription']
    ]);
}

fclose($output);
exit;
