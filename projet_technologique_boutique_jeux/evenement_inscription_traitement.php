<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit;
}

// Récupération des données du formulaire
$nom = trim($_POST['nom'] ?? '');
$prenom = trim($_POST['prenom'] ?? '');
$email = trim($_POST['email'] ?? '');
$evenement_id = intval($_POST['evenement_id'] ?? 0);
$accompagnants = intval($_POST['accompagnants'] ?? 0);

// Validation rapide
if (!$nom || !$prenom || !$email || !$evenement_id) {
    die("⛔ Champs requis manquants.");
}

// Vérifie la capacité restante
$capacite_stmt = $pdo->prepare("SELECT capacite, titre FROM evenement WHERE id = ?");
$capacite_stmt->execute([$evenement_id]);
$event = $capacite_stmt->fetch();

if (!$event) {
    die("⛔ Événement non trouvé.");
}

$capacite_totale = $event['capacite'];
$titre_evenement = $event['titre'];

// Total actuel
$total_stmt = $pdo->prepare("SELECT COUNT(*) AS total FROM inscription WHERE evenement_id = ?");
$total_stmt->execute([$evenement_id]);
$total = $total_stmt->fetch()['total'] ?? 0;

if ($total + 1 > $capacite_totale) {
    die("⚠️ Capacité dépassée. Impossible d’ajouter cette inscription.");
}

// Enregistrement participant
$stmt_participant = $pdo->prepare("INSERT INTO participant (nom, prenom, email) VALUES (?, ?, ?)");
$stmt_participant->execute([$nom, $prenom, $email]);
$participant_id = $pdo->lastInsertId();

// Inscription
$stmt_inscription = $pdo->prepare("INSERT INTO inscription (participant_id, evenement_id, validee, date_inscription, accompagnants) VALUES (?, ?, 1, NOW(), ?)");
$stmt_inscription->execute([$participant_id, $evenement_id, $accompagnants]);

// ✅ ENVOI D’EMAIL DE CONFIRMATION (optionnel)
$to = $email;
$subject = "Confirmation d'inscription – " . $titre_evenement;
$message = "Bonjour $prenom $nom,\n\nMerci pour votre inscription à l'événement \"$titre_evenement\".\n\n📅 À bientôt à la Ludothèque !";
$headers = "From: inscription@ludotheque.local";

@mail($to, $subject, $message, $headers); // ✅ Envoi sans bloquer le code

// ✅ MESSAGE DE CONFIRMATION À L’ÉCRAN
echo "<h2>✅ Inscription réussie !</h2>";
echo "<p>Merci <strong>" . htmlspecialchars($prenom) . " " . htmlspecialchars($nom) . "</strong> pour votre inscription à <strong>" . htmlspecialchars($titre_evenement) . "</strong>.</p>";
echo "<p>📧 Un e-mail de confirmation a été envoyé à : <strong>" . htmlspecialchars($email) . "</strong></p>";
echo "<br><a href='index.php'>⬅️ Retour à l’accueil</a>";
?>
