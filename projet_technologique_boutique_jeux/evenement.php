<?php
require_once 'config.php';

// Vérifie si l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    die("Événement non trouvé.");
}

$evenement_id = intval($_GET['id']);

// Récupérer les infos de l’événement
$stmt = $pdo->prepare("SELECT * FROM evenement WHERE id = ?");
$stmt->execute([$evenement_id]);
$evt = $stmt->fetch();

if (!$evt) {
    die("Cet événement n'existe pas.");
}

// Récupérer les jeux associés à l’événement (via table de liaison)
$jeux_stmt = $pdo->prepare("
    SELECT jeu.nom
    FROM jeu
    INNER JOIN evenement_jeu ON jeu.id = evenement_jeu.jeu_id
    WHERE evenement_jeu.evenement_id = ?
");
$jeux_stmt->execute([$evenement_id]);
$jeux_associes = $jeux_stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($evt['titre']) ?> – Événement</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 30px; }
        .container { max-width: 800px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 20px; }
        ul { margin-top: 10px; }
        .btn {
            display: inline-block;
            margin-top: 20px;
            background: #2980b9;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background: #1c6ea4;
        }
    </style>
</head>
<body>
<div class="container">
    <h1><?= htmlspecialchars($evt['titre']) ?></h1>
    <p><strong>Date :</strong> <?= htmlspecialchars($evt['date']) ?></p>
    <p><strong>Durée :</strong> <?= htmlspecialchars($evt['duree']) ?></p>
    <p><strong>Capacité :</strong> <?= htmlspecialchars($evt['capacite']) ?> participants</p>

    <h2>🎲 Jeux proposés</h2>
    <?php if (empty($jeux_associes)): ?>
        <p>Aucun jeu associé pour cet événement.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($jeux_associes as $jeu): ?>
                <li><?= htmlspecialchars($jeu['nom']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- 🔁 Lien dynamique vers inscription -->
    <a href="evenement_inscription.php?evenement_id=<?= $evenement_id ?>" class="btn">S'inscrire à cet événement</a>
</div>
</body>
</html>
