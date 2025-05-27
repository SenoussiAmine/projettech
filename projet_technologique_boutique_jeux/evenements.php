<?php
require_once 'config.php';

$evenements = $pdo->query("SELECT * FROM evenement ORDER BY date DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Événements</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        .container { max-width: 1000px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 20px; }
        .event-card {
            background: #ecf0f1;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            margin-top: 10px;
            background: #2980b9;
            color: white;
            padding: 8px 12px;
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
    <h1>📅 Tous les événements</h1>

    <?php if (empty($evenements)): ?>
        <p>Aucun événement n’est encore enregistré.</p>
    <?php else: ?>
        <?php foreach ($evenements as $evt): ?>
            <div class="event-card">
                <h3><?= htmlspecialchars($evt['titre']) ?></h3>
                <p><strong>Date :</strong> <?= $evt['date'] ?></p>
                <p><strong>Durée :</strong> <?= $evt['duree'] ?> heures</p>
                <p><strong>Capacité :</strong> <?= $evt['capacite'] ?> personnes</p>
                <a href="evenement.php?id=<?= $evt['id'] ?>" class="btn">Voir plus</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
