<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}


// Récupérer tous les jeux pour les afficher dans une liste à cocher
$jeux = $pdo->query("SELECT id, nom FROM jeu ORDER BY nom")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un événement</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px; }
        .form-container {
            background: white; padding: 30px;
            max-width: 700px; margin: auto;
            border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        label { display: block; margin-top: 15px; }
        input, select, textarea { width: 100%; padding: 8px; margin-top: 5px; }
        button {
            margin-top: 20px; padding: 10px 20px;
            background: #2c3e50; color: white;
            border: none; border-radius: 5px; cursor: pointer;
        }
        h2 { margin-bottom: 20px; }
        .checkboxes { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
        .checkboxes label { width: 48%; background: #f9f9f9; padding: 5px; border-radius: 5px; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>📅 Ajouter un nouvel événement</h2>

    <form action="admin_evenement_traitement.php" method="post">
        <label>Titre de l'événement :
            <input type="text" name="titre" required>
        </label>

        <label>Date :
            <input type="date" name="date" required>
        </label>

        <label>Durée :
            <select name="duree" required>
                <option value="demi-journee">Demi-journée</option>
                <option value="journee">Journée</option>
                <option value="weekend">Week-end</option>
            </select>
        </label>

        <label>Capacité maximale :
            <input type="number" name="capacite" min="1" required>
        </label>

        <label>Jeux associés à l'événement :</label>
        <div class="checkboxes">
            <?php foreach ($jeux as $jeu): ?>
                <label>
                    <input type="checkbox" name="jeux_ids[]" value="<?= $jeu['id'] ?>"> <?= htmlspecialchars($jeu['nom']) ?>
                </label>
            <?php endforeach; ?>
        </div>

        <button type="submit">✅ Créer l’événement</button>
    </form>
</div>

</body>
</html>
