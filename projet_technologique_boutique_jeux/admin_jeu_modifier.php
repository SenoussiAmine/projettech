<?php
require_once 'config.php';
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
$stmt = $pdo->prepare("SELECT * FROM jeu WHERE id = ?");
$stmt->execute([$id]);
$jeu = $stmt->fetch();

if (!$jeu) {
    echo "Jeu introuvable.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le jeu</title>
</head>
<body>
<h1>✏️ Modifier le jeu : <?= htmlspecialchars($jeu['nom']) ?></h1>

<form action="admin_jeu_traitement.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $jeu['id'] ?>">

    Nom : <input type="text" name="nom" value="<?= htmlspecialchars($jeu['nom']) ?>"><br><br>
    Type : <input type="text" name="type" value="<?= htmlspecialchars($jeu['type']) ?>"><br><br>
    Genre : <input type="text" name="genre" value="<?= htmlspecialchars($jeu['genre']) ?>"><br><br>
    Année : <input type="number" name="annee_sortie" value="<?= htmlspecialchars($jeu['annee_sortie']) ?>"><br><br>

    Image (laisser vide pour ne pas changer) :
    <input type="file" name="image"><br><br>

    <button type="submit" name="modifier">💾 Enregistrer les modifications</button>
</form>

<p><a href="admin_dashboard.php">⬅️ Retour</a></p>

</body>
</html>
